'use client';

import Link from 'next/link';
import Image from 'next/image';
import { usePathname } from 'next/navigation';
import { useState } from 'react';
import { AdminUser } from '@/lib/admin-auth';
import { 
  Package, 
  ShoppingCart, 
  FileText,
  Tag,
  Shield,
  X,
  User,
  MapPin,
  Folder,
  Settings,
  LogOut,
  ChevronDown
} from 'lucide-react';

interface AdminSidebarProps {
  admin: AdminUser | null;
  isOpen?: boolean;
  onClose?: () => void;
  isDesktopOpen?: boolean;
}

const menuItems = [
  {
    title: 'Category',
    href: '/admin/categories',
    icon: Tag,
  },
  {
    title: 'Products',
    href: '/admin/products',
    icon: Package,
  },
  {
    title: 'Order',
    href: '/admin/orders',
    icon: ShoppingCart,
  },
  {
    title: 'Brand',
    href: '/admin/brands',
    icon: Shield,
  },
  {
    title: 'Blog',
    href: '/admin/blogs',
    icon: FileText,
  },
  {
    title: 'Blog Category',
    href: '/admin/blog-categories',
    icon: Folder,
  },
  {
    title: 'Author',
    href: '/admin/authors',
    icon: User,
  },
  {
    title: 'Addresses',
    href: '/admin/addresses',
    icon: MapPin,
  },
];

export default function AdminSidebar({ admin, isOpen = false, onClose, isDesktopOpen = true }: AdminSidebarProps) {
  const pathname = usePathname();
  const [isProfileDropdownOpen, setIsProfileDropdownOpen] = useState(false);

  // Return null or loading state if admin is not available
  if (!admin) {
    return null;
  }

  const handleLogout = () => {
    // Clear browser storage
    localStorage.clear();
    sessionStorage.clear();
    
    // Clear cookies
    document.cookie.split(";").forEach((c) => {
      const eqPos = c.indexOf("=");
      const name = eqPos > -1 ? c.substr(0, eqPos) : c;
      document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
    });

    // Redirect to login page
    window.location.replace('/admin/login');
  };

  return (
    <>
      {/* Mobile overlay - only show on mobile when sidebar is open */}
      {isOpen && (
        <div 
          className="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
          onClick={onClose}
        />
      )}
      
      {/* Sidebar */}
      <div className={`
        bg-white shadow-xl border-r-2 border-gray-300 transform transition-all duration-300 ease-in-out
        ${isOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'}
        ${isDesktopOpen ? 'lg:w-64' : 'lg:w-16'}
        fixed inset-y-0 left-0 z-50 w-64
        lg:fixed lg:z-40 flex flex-col overflow-hidden
      `}>
      {/* Logo */}
      <div className="flex items-center justify-between h-16 px-4 border-b-2 border-gray-300 bg-gradient-to-r from-blue-50 to-purple-50">
        <div className="flex items-center space-x-2">
          <div className="w-10 h-10 rounded-lg flex items-center justify-center shadow-lg overflow-hidden">
            <Image
              src="https://res.cloudinary.com/dfuv6e0od/image/upload/v1758055890/Screenshot_2025-09-17_at_03.51.08_ces7si.png"
              alt="Jualin Logo"
              width={40}
              height={40}
              className="object-contain"
            />
          </div>
          <div className={`${isDesktopOpen ? 'lg:block' : 'lg:hidden'}`}>
            <h1 className="text-xl font-bold text-gray-900">Jualin</h1>
            <p className="text-sm text-gray-600 font-medium">Admin Panel</p>
          </div>
        </div>
        
        {/* Mobile close button */}
        <button
          onClick={onClose}
          className="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100"
        >
          <X className="h-5 w-5" />
        </button>
      </div>

      {/* Admin Info */}
      <div className="p-4 border-b-2 border-gray-300 bg-gray-50">
        <div className="relative">
          <button
            onClick={() => setIsProfileDropdownOpen(!isProfileDropdownOpen)}
            className={`w-full flex items-center p-3 rounded-lg hover:bg-white hover:shadow-md transition-all duration-200 border border-gray-200 ${isDesktopOpen ? 'lg:space-x-3' : 'lg:justify-center lg:space-x-0'}`}
          >
            <div className="w-10 h-10 rounded-full overflow-hidden flex items-center justify-center bg-gradient-to-br from-blue-500 to-purple-500">
              {admin.imageUrl ? (
                <img 
                  src={admin.imageUrl} 
                  alt={admin.name}
                  className="w-full h-full object-cover"
                />
              ) : (
                <span className="text-white font-medium text-sm">
                  {admin.name.charAt(0).toUpperCase()}
                </span>
              )}
            </div>
            <div className={`flex-1 min-w-0 text-left ${isDesktopOpen ? 'lg:block' : 'lg:hidden'}`}>
              <p className="text-sm font-medium text-gray-900 truncate">
                {admin.name}
              </p>
              <p className="text-xs text-gray-500 truncate">
                {admin.email}
              </p>
              <span className="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                {admin.role === 'super_admin' ? 'Super Admin' : 'Admin'}
              </span>
            </div>
            <ChevronDown className={`h-4 w-4 text-gray-400 transition-transform ${isProfileDropdownOpen ? 'rotate-180' : ''} ${isDesktopOpen ? 'lg:block' : 'lg:hidden'}`} />
          </button>

          {/* Dropdown Menu */}
          {isProfileDropdownOpen && (
            <div className="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
              <div className="py-1">
                <Link
                  href="/admin/settings"
                  className="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                  onClick={() => setIsProfileDropdownOpen(false)}
                >
                  <Settings className="h-4 w-4 mr-3 text-gray-400" />
                  Pengaturan
                </Link>
                <button
                  onClick={handleLogout}
                  className="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                >
                  <LogOut className="h-4 w-4 mr-3 text-red-400" />
                  Logout
                </button>
              </div>
            </div>
          )}
        </div>
      </div>

      {/* Navigation */}
      <nav className="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        {menuItems.map((item) => {
          const isActive = pathname === item.href;
          const Icon = item.icon;

          return (
            <Link
              key={item.href}
              href={item.href}
              className={`
                flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-all duration-200 border
                ${isDesktopOpen ? 'lg:justify-start' : 'lg:justify-center'}
                ${isActive
                  ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-lg border-blue-500'
                  : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700 hover:shadow-md border-transparent hover:border-blue-200'
                }
              `}
              title={!isDesktopOpen ? item.title : undefined}
            >
              <Icon className={`h-5 w-5 ${isActive ? 'text-white' : 'text-gray-500'} ${isDesktopOpen ? 'lg:mr-3' : 'lg:mr-0'}`} />
              <span className={`${isDesktopOpen ? 'lg:block' : 'lg:hidden'}`}>
                {item.title}
              </span>
            </Link>
          );
        })}
      </nav>

      {/* Footer */}
      <div className="p-4 border-t border-gray-200">
        <p className={`text-xs text-gray-500 text-center ${isDesktopOpen ? 'lg:block' : 'lg:hidden'}`}>
          © 2024 Jualin Admin
        </p>
      </div>
    </div>
    </>
  );
}