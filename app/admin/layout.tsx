'use client';

import { useState, useEffect } from 'react';
import { usePathname, useRouter } from 'next/navigation';
import AdminSidebar from '@/components/admin/AdminSidebar';
import AdminHeader from '@/components/admin/AdminHeader';
import { AdminUser } from '@/lib/admin-auth';

export default function AdminLayout({ children }: { children: React.ReactNode }) {
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const [isSidebarOpen, setIsSidebarOpen] = useState(true);
  const [adminUser, setAdminUser] = useState<AdminUser | null>(null);
  const [isCheckingAdmin, setIsCheckingAdmin] = useState(true);
  const pathname = usePathname();
  const router = useRouter();
  
  // Check admin authentication
  useEffect(() => {
    const checkAdminAccess = async () => {
      // Skip auth check for login page
      if (pathname.startsWith('/admin/login')) {
        setIsCheckingAdmin(false);
        return;
      }

      try {
        // Add a small delay to ensure cookies are properly set after login redirect
        await new Promise(resolve => setTimeout(resolve, 50));
        
        const response = await fetch('/api/admin/me', {
          method: 'GET',
          credentials: 'include',
        });

        if (!response.ok) {
          // No valid admin token, redirect to login
          router.replace('/admin/login?error=unauthorized');
          return;
        }

        const data = await response.json();
        setAdminUser(data.admin);
      } catch (error) {
        console.error('Error checking admin access:', error);
        router.replace('/admin/login?error=server_error');
      } finally {
        setIsCheckingAdmin(false);
      }
    };

    checkAdminAccess();
  }, [pathname, router]);

  // Show loading while checking authentication
  if (isCheckingAdmin) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
          <p className="mt-4 text-gray-600">Memverifikasi akses admin...</p>
        </div>
      </div>
    );
  }

  // Show login page without layout
  if (pathname.startsWith('/admin/login')) {
    return <>{children}</>;
  }

  // Show unauthorized message if no admin user AND not checking anymore
  if (!adminUser && !isCheckingAdmin) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50">
        <div className="text-center">
          <div className="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-red-100">
            <svg className="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
          </div>
          <h2 className="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Loading..
          </h2>
          <p className="mt-2 text-center text-sm text-gray-600">
            Anda tidak memiliki akses ke panel admin.
          </p>
          <div className="mt-6">
            <button
              onClick={() => router.push('/admin/login')}
              className="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              Kembali ke Login
            </button>
          </div>
        </div>
      </div>
    );
  }

  // Show loading if still checking or no admin user yet
  if (isCheckingAdmin || !adminUser) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
          <p className="mt-4 text-gray-600">Memverifikasi akses admin...</p>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen">
      {/* Sidebar */}
      <AdminSidebar 
        admin={adminUser}
        isOpen={isMobileMenuOpen}
        onClose={() => setIsMobileMenuOpen(false)}
        isDesktopOpen={isSidebarOpen}
      />

      {/* Main content */}
      <div className={`min-h-screen transition-all duration-300 ${isSidebarOpen ? 'lg:ml-64' : 'lg:ml-16'} ${isMobileMenuOpen ? 'lg:ml-64' : ''}`}>
        {/* Header */}
        <AdminHeader 
          onToggleSidebar={() => setIsSidebarOpen(!isSidebarOpen)}
          onToggleMobileMenu={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
          adminUser={adminUser}
        />

        {/* Page content */}
        <main>
          {children}
        </main>
      </div>
    </div>
  );
}