import { CoreApi, Snap } from 'midtrans-client';

// Validate environment variables
const serverKey = process.env.MIDTRANS_SERVER_KEY;
const clientKey = process.env.MIDTRANS_CLIENT_KEY;
const merchantId = process.env.MIDTRANS_MERCHANT_ID;
const baseUrl = process.env.MIDTRANS_BASE_URL;

if (!serverKey) {
  throw new Error('MIDTRANS_SERVER_KEY is not set in environment variables');
}

if (!clientKey) {
  throw new Error('MIDTRANS_CLIENT_KEY is not set in environment variables');
}

if (!merchantId) {
  throw new Error('MIDTRANS_MERCHANT_ID is not set in environment variables');
}

// Determine if we're in sandbox mode
const isProduction = baseUrl !== 'sandbox';

// Initialize Snap API for creating payment tokens
export const snap = new Snap({
  isProduction,
  serverKey,
  clientKey,
});

// Initialize Core API for transaction status and other operations
export const coreApi = new CoreApi({
  isProduction,
  serverKey,
  clientKey,
});

// Export configuration for use in other parts of the application
export const midtransConfig = {
  serverKey,
  clientKey,
  merchantId,
  isProduction,
  baseUrl: isProduction ? 'https://app.midtrans.com' : 'https://app.sandbox.midtrans.com',
  snapUrl: isProduction ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js',
};

export default { snap, coreApi, midtransConfig };