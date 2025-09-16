import "./globals.css";
import { Toaster } from "react-hot-toast";
import { ClerkProvider } from '@clerk/nextjs';
import Script from 'next/script';
import type { Metadata } from 'next';

export const metadata: Metadata = {
  title: 'Jualin Mart',
  description: 'Your trusted online marketplace',
  icons: {
    icon: '/favicon.png',
    shortcut: '/favicon.png',
    apple: '/favicon.png',
  },
};

const RootLayout = ({ children }: { children: React.ReactNode }) => {
  return (
    <ClerkProvider
      signInUrl="/admin/login"
      signUpUrl="/admin/login"
      afterSignOutUrl="/"
    >
      <html lang="en">
        <body className="font-poppins antialiased">
          <Script
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key={process.env.NEXT_PUBLIC_MIDTRANS_CLIENT_KEY}
            strategy="beforeInteractive"
          />
          {children}
          <Toaster
            position="bottom-right"
            toastOptions={{
              style: {
                background: "#000000",
                color: "#fff",
              },
            }}
          />
        </body>
      </html>
    </ClerkProvider>
  );
};
export default RootLayout;
