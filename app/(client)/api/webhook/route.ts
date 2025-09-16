import { backendClient } from "@/sanity/lib/backendClient";
import { NextRequest, NextResponse } from "next/server";
import crypto from "crypto";

// Midtrans notification interface
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
  custom_field1?: string; // orderNumber
  custom_field2?: string; // customerName
  custom_field3?: string; // customerEmail
  custom_expiry?: string;
}

export async function POST(req: NextRequest) {
  try {
    const body = await req.text();
    const notification: MidtransNotification = JSON.parse(body);
    
    // Verify signature
    const serverKey = process.env.MIDTRANS_SERVER_KEY;
    if (!serverKey) {
      console.log("Midtrans server key is not set");
      return NextResponse.json(
        { error: "Midtrans server key is not set" },
        { status: 400 }
      );
    }

    const signatureKey = crypto
      .createHash("sha512")
      .update(
        `${notification.order_id}${notification.status_code}${notification.gross_amount}${serverKey}`
      )
      .digest("hex");

    if (signatureKey !== notification.signature_key) {
      console.error("Invalid signature");
      return NextResponse.json(
        { error: "Invalid signature" },
        { status: 400 }
      );
    }

    // Handle successful payment
    if (notification.transaction_status === "capture" || 
        notification.transaction_status === "settlement") {
      
      try {
        await createOrderInSanity(notification);
        console.log(`Order created for transaction: ${notification.transaction_id}`);
      } catch (error) {
        console.error("Error creating order in Sanity:", error);
        return NextResponse.json(
          { error: `Error creating order: ${error}` },
          { status: 500 }
        );
      }
    } else if (notification.transaction_status === "pending") {
      console.log(`Payment pending for transaction: ${notification.transaction_id}`);
    } else if (notification.transaction_status === "deny" || 
               notification.transaction_status === "cancel" || 
               notification.transaction_status === "expire") {
      console.log(`Payment failed/cancelled for transaction: ${notification.transaction_id}`);
    }

    return NextResponse.json({ status: "ok" });
  } catch (error) {
    console.error("Webhook error:", error);
    return NextResponse.json(
      { error: "Webhook processing failed" },
      { status: 500 }
    );
  }
}

async function createOrderInSanity(notification: MidtransNotification) {
  // Extract metadata from order_id (assuming format: orderNumber_timestamp)
  const orderNumber = notification.order_id.split('_')[0];
  
  // For now, we'll create a basic order. In a real implementation,
  // you might want to store additional metadata in a temporary storage
  // or include it in the order_id format
  const order = await backendClient.create({
    _type: "order",
    orderNumber: orderNumber,
    midtransTransactionId: notification.transaction_id,
    midtransOrderId: notification.order_id,
    customerName: "Customer", // This should come from your metadata storage
    email: "customer@example.com", // This should come from your metadata storage
    currency: notification.currency.toUpperCase(),
    totalPrice: parseFloat(notification.gross_amount),
    status: "paid",
    orderDate: notification.transaction_time,
    paymentType: notification.payment_type,
    fraudStatus: notification.fraud_status,
  });

  console.log("Order created in Sanity:", order._id);
  return order;
}
