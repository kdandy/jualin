'use client';

import { Button } from '@/components/ui/button';
import { 
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { 
  Bell, 
  Search, 
  Menu, 
  PanelLeftClose,
  LogOut,
  User
} from 'lucide-react';
import { useRouter } from 'next/navigation';
import { AdminUser } from '@/lib/admin-auth';

interface AdminHeaderProps {
  onToggleSidebar?: () => void;
  onToggleMobileMenu?: () => void;
  adminUser?: AdminUser | null;
}

export default function AdminHeader({ onToggleSidebar, onToggleMobileMenu, adminUser }: AdminHeaderProps) {
  const router = useRouter();

  const handleLogout = async () => {
    try {
      await fetch('/api/admin/logout', {
        method: 'POST',
        credentials: 'include',
      });
      router.push('/admin/login');
    } catch (error) {
      console.error('Logout error:', error);
    }
  };

  return (
    <header className="bg-white shadow-lg border-b-2 border-gray-300 h-16 sm:h-18 sticky top-0 z-30">
      <div className="flex items-center justify-between h-full px-4 sm:px-8">
        {/* Left side */}
        <div className="flex items-center space-x-4">
          {/* Mobile menu button */}
          <Button
            variant="outline"
            size="sm"
            className="lg:hidden border-gray-300 hover:bg-blue-50 hover:border-blue-300"
            onClick={onToggleMobileMenu}
          >
            <Menu className="h-5 w-5 text-gray-700" />
          </Button>

          {/* Desktop sidebar toggle */}
          <Button
            variant="outline"
            size="sm"
            className="hidden lg:flex border-gray-300 hover:bg-blue-50 hover:border-blue-300"
            onClick={onToggleSidebar}
            title="Toggle Sidebar"
          >
            <PanelLeftClose className="h-5 w-5 text-gray-700" />
          </Button>

          {/* Search */}
          <div className="hidden md:flex items-center space-x-2">
            <div className="relative">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 h-5 w-5" />
              <input
                type="text"
                placeholder="Cari produk, pesanan..."
                className="pl-11 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-56 lg:w-72 shadow-sm hover:shadow-md transition-shadow"
              />
            </div>
          </div>
        </div>

        {/* Right side */}
        <div className="flex items-center space-x-4">
          {/* Notifications */}
          <Button variant="outline" size="sm" className="relative border-gray-300 hover:bg-blue-50 hover:border-blue-300 shadow-sm">
            <Bell className="h-5 w-5 text-gray-700" />
            <span className="absolute -top-1 -right-1 h-5 w-5 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-lg">
              3
            </span>
          </Button>

          {/* Admin Profile Dropdown */}
          {adminUser && (
            <DropdownMenu>
              <DropdownMenuTrigger asChild>
                <Button variant="ghost" className="relative h-8 w-8 rounded-full">
                  <Avatar className="h-8 w-8">
                    <AvatarImage src={adminUser.imageUrl} alt={adminUser.name} />
                    <AvatarFallback>
                      {adminUser.name.split(' ').map(n => n[0]).join('').toUpperCase()}
                    </AvatarFallback>
                  </Avatar>
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent className="w-56" align="end" forceMount>
                <DropdownMenuLabel className="font-normal">
                  <div className="flex flex-col space-y-1">
                    <p className="text-sm font-medium leading-none">{adminUser.name}</p>
                    <p className="text-xs leading-none text-muted-foreground">
                      {adminUser.email}
                    </p>
                  </div>
                </DropdownMenuLabel>
                <DropdownMenuSeparator />
                <DropdownMenuItem>
                  <User className="mr-2 h-4 w-4" />
                  <span>Profile</span>
                </DropdownMenuItem>
                <DropdownMenuSeparator />
                <DropdownMenuItem onClick={handleLogout}>
                  <LogOut className="mr-2 h-4 w-4" />
                  <span>Log out</span>
                </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          )}
        </div>
      </div>
    </header>
  );
}