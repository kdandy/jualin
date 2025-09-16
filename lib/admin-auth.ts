import { NextRequest } from 'next/server';
import { cookies } from 'next/headers';
import { SignJWT, jwtVerify } from 'jose';
import { sanityFetch } from '@/sanity/lib/live';
import { ADMIN_BY_EMAIL_QUERY, ADMIN_LOGIN_QUERY } from '@/sanity/queries/admin';
import { verifyPassword } from '@/lib/password';

// Admin user interface
export interface AdminUser {
  id: string;
  email: string;
  role: 'admin' | 'super_admin';
  name: string;
  createdAt: Date;
  imageUrl?: string;
}



// JWT secret key
const JWT_SECRET = new TextEncoder().encode(
  process.env.ADMIN_JWT_SECRET || 'your-super-secret-admin-jwt-key-change-in-production'
);

// Token expiration time (24 hours)
const TOKEN_EXPIRATION = '24h';

/**
 * Check if email is registered as admin in Sanity
 */
export async function isAdminEmail(email: string): Promise<AdminUser | null> {
  try {
    const { data: admin } = await sanityFetch({
      query: ADMIN_BY_EMAIL_QUERY,
      params: { email }
    });

    if (!admin || !admin.isActive) {
      return null;
    }

    return {
      id: admin._id,
      email: admin.email,
      role: admin.role,
      name: admin.name,
      createdAt: new Date(),
      imageUrl: admin.image?.asset?.url
    };
  } catch (error) {
    console.error('Error checking admin email:', error);
    return null;
  }
}

/**
 * Authenticate admin user with email (using Clerk for actual authentication)
 */
export async function authenticateAdmin(email: string): Promise<AdminUser | null> {
  return await isAdminEmail(email);
}

/**
 * Authenticate admin user with email and password
 */
export async function authenticateAdminWithPassword(email: string, password: string): Promise<AdminUser | null> {
  try {
    const { data: admin } = await sanityFetch({
      query: ADMIN_LOGIN_QUERY,
      params: { email }
    });

    if (!admin || !admin.isActive) {
      return null;
    }

    // Verify password
    if (!admin.password) {
      // Admin doesn't have password set yet
      return null;
    }

    const isPasswordValid = await verifyPassword(password, admin.password);
    if (!isPasswordValid) {
      return null;
    }

    return {
      id: admin._id,
      email: admin.email,
      role: admin.role,
      name: admin.name,
      createdAt: new Date(),
      imageUrl: admin.image?.asset?.url
    };
  } catch (error) {
    console.error('Error authenticating admin with password:', error);
    return null;
  }
}

/**
 * Create JWT token for admin user
 */
export async function createAdminToken(admin: AdminUser): Promise<string> {
  const token = await new SignJWT({
    id: admin.id,
    email: admin.email,
    role: admin.role,
    name: admin.name
  })
    .setProtectedHeader({ alg: 'HS256' })
    .setIssuedAt()
    .setExpirationTime(TOKEN_EXPIRATION)
    .sign(JWT_SECRET);

  return token;
}

/**
 * Verify JWT token and return admin user
 */
export async function verifyAdminToken(token: string): Promise<AdminUser | null> {
  try {
    const { payload } = await jwtVerify(token, JWT_SECRET);
    
    // Get fresh admin data from Sanity to include imageUrl and other updated fields
    const adminEmail = payload.email as string;
    const freshAdminData = await isAdminEmail(adminEmail);
    
    if (!freshAdminData) {
      return null;
    }
    
    return freshAdminData;
  } catch (error) {
    console.error('Token verification failed:', error);
    return null;
  }
}

/**
 * Get admin user from request cookies
 */
export async function getAdminFromRequest(request: NextRequest): Promise<AdminUser | null> {
  const token = request.cookies.get('admin-token')?.value;
  
  if (!token) {
    return null;
  }

  return await verifyAdminToken(token);
}

/**
 * Get admin user from server-side cookies
 */
export async function getAdminFromCookies(): Promise<AdminUser | null> {
  const cookieStore = await cookies();
  const token = cookieStore.get('admin-token')?.value;
  
  if (!token) {
    return null;
  }

  return await verifyAdminToken(token);
}

/**
 * Set admin token in cookies
 */
export async function setAdminTokenCookie(token: string) {
  const cookieStore = await cookies();
  cookieStore.set('admin-token', token, {
    httpOnly: true,
    secure: process.env.NODE_ENV === 'production',
    sameSite: 'lax',
    maxAge: 24 * 60 * 60 // 24 hours
  });
}

/**
 * Remove admin token from cookies
 */
export async function removeAdminTokenCookie() {
  const cookieStore = await cookies();
  cookieStore.delete('admin-token');
}

/**
 * Check if user has required admin role
 */
export function hasAdminRole(user: AdminUser | null, requiredRole: 'admin' | 'super_admin' = 'admin'): boolean {
  if (!user) return false;
  
  if (requiredRole === 'admin') {
    return user.role === 'admin' || user.role === 'super_admin';
  }
  
  return user.role === requiredRole;
}