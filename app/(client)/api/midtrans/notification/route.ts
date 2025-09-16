import { backendClient } from "@/sanity/lib/backendClient";
import { NextRequest, NextResponse } from "next/server";
import crypto from "crypto";

// Interface untuk notifikasi Midtrans
interface MidtransNotification {
  transaction_time: string;
  transaction_status: string;
  transaction_id: string;
  status_message: string;
  status_code: string;
  signature_key: string;
  payment_type: string;
  order_id: string;
  merchant_id: string;
  gross_amount: string;
  fraud_status: string;
  currency: string;
  custom_field1?: string;
  custom_field2?: string;
  custom_field3?: string;
}

export async function POST(req: NextRequest) {
  try {
    const body = await req.text();
    const notification: MidtransNotification = JSON.parse(body);
    
    console.log("Received Midtrans notification:", notification);

    // Verifikasi signature untuk keamanan
    const serverKey = process.env.MIDTRANS_SERVER_KEY;
    if (!serverKey) {
      console.error("Midtrans server key is not set");
      return NextResponse.json(
        { error: "Server configuration error" },
        { status: 500 }
      );
    }

    // Generate signature untuk verifikasi
    const signatureKey = crypto
      .createHash("sha512")
      .update(
        `${notification.order_id}${notification.status_code}${notification.gross_amount}${serverKey}`
      )
      .digest("hex");

    if (signatureKey !== notification.signature_key) {
      console.error("Invalid signature from Midtrans");
      return NextResponse.json(
        { error: "Invalid signature" },
        { status: 401 }
      );
    }

    // Proses notifikasi berdasarkan status transaksi
    await processTransactionStatus(notification);

    // Respond dengan OK untuk memberitahu Midtrans bahwa notifikasi diterima
    return NextResponse.json({ status: "ok" });
  } catch (error) {
    console.error("Error processing Midtrans notification:", error);
    return NextResponse.json(
      { error: "Failed to process notification" },
      { status: 500 }
    );
  }
}

async function processTransactionStatus(notification: MidtransNotification) {
  const { transaction_status, order_id } = notification;

  try {
    switch (transaction_status) {
      case "capture":
      case "settlement":
        // Payment berhasil - buat atau update order di Sanity
        await handleSuccessfulPayment(notification);
        console.log(`Payment successful for order: ${order_id}`);
        break;

      case "pending":
        // Payment pending - log saja untuk sekarang
        console.log(`Payment pending for order: ${order_id}`);
        await updateOrderStatus(order_id, "pending");
        break;

      case "deny":
      case "cancel":
      case "expire":
        // Payment gagal - update status order
        console.log(`Payment failed/cancelled for order: ${order_id}`);
        await updateOrderStatus(order_id, "failed");
        break;

      default:
        console.log(`Unknown transaction status: ${transaction_status} for order: ${order_id}`);
    }
  } catch (error) {
    console.error(`Error processing transaction status for order ${order_id}:`, error);
    throw error;
  }
}

async function handleSuccessfulPayment(notification: MidtransNotification) {
  const orderNumber = notification.order_id.split('_')[0];
  
  try {
    // Cek apakah order sudah ada
    const existingOrder = await backendClient.fetch(
      `*[_type == "order" && orderNumber == $orderNumber][0]`,
      { orderNumber }
    );

    if (existingOrder) {
      // Update existing order
      await backendClient
        .patch(existingOrder._id)
        .set({
          status: "paid",
          midtransTransactionId: notification.transaction_id,
          midtransOrderId: notification.order_id,
          paymentType: notification.payment_type,
          fraudStatus: notification.fraud_status,
          paidAt: notification.transaction_time,
        })
        .commit();
      
      console.log(`Order updated: ${existingOrder._id}`);
    } else {
      // Buat order baru jika belum ada
      const newOrder = await backendClient.create({
        _type: "order",
        orderNumber: orderNumber,
        midtransTransactionId: notification.transaction_id,
        midtransOrderId: notification.order_id,
        customerName: "Customer", // Ini harus diambil dari metadata yang disimpan
        email: "customer@example.com", // Ini harus diambil dari metadata yang disimpan
        currency: notification.currency.toUpperCase(),
        totalPrice: parseFloat(notification.gross_amount),
        status: "paid",
        orderDate: notification.transaction_time,
        paymentType: notification.payment_type,
        fraudStatus: notification.fraud_status,
        paidAt: notification.transaction_time,
      });

      console.log(`New order created: ${newOrder._id}`);
    }
  } catch (error) {
    console.error("Error handling successful payment:", error);
    throw error;
  }
}

async function updateOrderStatus(orderId: string, status: string) {
  const orderNumber = orderId.split('_')[0];
  
  try {
    const existingOrder = await backendClient.fetch(
      `*[_type == "order" && orderNumber == $orderNumber][0]`,
      { orderNumber }
    );

    if (existingOrder) {
      await backendClient
        .patch(existingOrder._id)
        .set({ status })
        .commit();
      
      console.log(`Order status updated to ${status}: ${existingOrder._id}`);
    }
  } catch (error) {
    console.error(`Error updating order status to ${status}:`, error);
  }
}