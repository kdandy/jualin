"use server";

import { snap } from "@/lib/midtrans";
import { Address } from "@/sanity.types";
import { CartItem } from "@/store";

export interface Metadata {
  orderNumber: string;
  customerName: string;
  customerEmail: string;
  clerkUserId?: string;
  address?: Address | null;
}

export interface GroupedCartItems {
  product: CartItem["product"];
  quantity: number;
}

export async function createMidtransPayment(
  items: GroupedCartItems[],
  metadata: Metadata
) {
  try {
    // Calculate total amount
    const totalAmount = items.reduce(
      (total, item) => total + (item.product?.price || 0) * item.quantity,
      0
    );

    // Prepare item details for Midtrans
    const itemDetails = items.map((item) => ({
      id: item.product?._id || "unknown",
      price: Math.round(item.product?.price || 0),
      quantity: item.quantity,
      name: item.product?.name || "Unknown Product",
      brand: "Jualin",
      category: "Product",
      merchant_name: "Jualin Store",
    }));

    // Prepare customer details
    const customerDetails = {
      first_name: metadata.customerName.split(" ")[0] || metadata.customerName,
      last_name: metadata.customerName.split(" ").slice(1).join(" ") || "",
      email: metadata.customerEmail,
      phone: "+62812345678", // Default phone number, you might want to collect this
    };

    // Prepare shipping address if available
    const shippingAddress = metadata.address ? {
      first_name: metadata.address.name?.split(" ")[0] || metadata.customerName.split(" ")[0],
      last_name: metadata.address.name?.split(" ").slice(1).join(" ") || metadata.customerName.split(" ").slice(1).join(" "),
      email: metadata.customerEmail,
      phone: "+62812345678",
      address: metadata.address.address || "",
      city: metadata.address.city || "",
      postal_code: metadata.address.zip || "",
      country_code: "IDN",
    } : undefined;

    // Prepare transaction parameter
    const parameter = {
      transaction_details: {
        order_id: metadata.orderNumber,
        gross_amount: Math.round(totalAmount),
      },
      credit_card: {
        secure: true,
      },
      item_details: itemDetails,
      customer_details: {
        ...customerDetails,
        billing_address: shippingAddress,
        shipping_address: shippingAddress,
      },
      callbacks: {
        finish: `${process.env.NEXT_PUBLIC_BASE_URL}/api/midtrans/finish`,
        error: `${process.env.NEXT_PUBLIC_BASE_URL}/cart?error=payment_failed`,
        pending: `${process.env.NEXT_PUBLIC_BASE_URL}/cart?status=pending`,
      },
      notification_url: `${process.env.NEXT_PUBLIC_BASE_URL}/api/midtrans/notification`,
      custom_field1: metadata.clerkUserId || "",
      custom_field2: metadata.address?.city || "",
      custom_field3: metadata.customerEmail,
    };

    // Create transaction token
    const transaction = await snap.createTransaction(parameter);
    
    return {
      token: transaction.token,
      redirectUrl: transaction.redirect_url,
    };
  } catch (error) {
    console.error("Error creating Midtrans payment:", error);
    throw error;
  }
}