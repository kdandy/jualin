import { NextRequest, NextResponse } from "next/server";

export async function GET(req: NextRequest) {
  try {
    const { searchParams } = new URL(req.url);
    const order_id = searchParams.get("order_id");
    const status_code = searchParams.get("status_code");
    const transaction_status = searchParams.get("transaction_status");

    // Log untuk debugging
    console.log("Finish redirect params:", {
      order_id,
      status_code,
      transaction_status,
    });

    // Extract order number dari order_id (format: orderNumber_timestamp)
    const orderNumber = order_id?.split('_')[0];

    // Redirect berdasarkan status transaksi
    if (status_code === "200" && 
        (transaction_status === "capture" || transaction_status === "settlement")) {
      // Payment berhasil - redirect ke success page
      return NextResponse.redirect(
        new URL(`/success?orderNumber=${orderNumber}&order_id=${order_id}`, req.url)
      );
    } else if (transaction_status === "pending") {
      // Payment pending - redirect ke pending page atau success dengan status pending
      return NextResponse.redirect(
        new URL(`/success?orderNumber=${orderNumber}&order_id=${order_id}&status=pending`, req.url)
      );
    } else {
      // Payment gagal - redirect ke cart dengan error message
      return NextResponse.redirect(
        new URL(`/cart?error=payment_failed&order_id=${order_id}`, req.url)
      );
    }
  } catch (error) {
    console.error("Error in finish redirect:", error);
    // Jika ada error, redirect ke cart
    return NextResponse.redirect(new URL("/cart?error=system_error", req.url));
  }
}

export async function POST(req: NextRequest) {
  // Handle POST request juga untuk kompatibilitas
  return GET(req);
}