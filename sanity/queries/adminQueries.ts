import { sanityFetch } from "../lib/live";
import {
  ADMIN_STATS_QUERY,
  RECENT_ORDERS_QUERY,
  TOP_PRODUCTS_QUERY,
  ALL_PRODUCTS_QUERY,
  ALL_CATEGORIES_QUERY,
  ALL_ORDERS_ADMIN_QUERY,
  ALL_BRANDS_ADMIN_QUERY,
  ALL_AUTHORS_ADMIN_QUERY,
  ALL_ADDRESSES_ADMIN_QUERY,
} from "./admin";

// Fungsi untuk mendapatkan statistik dashboard
export const getAdminStats = async () => {
  try {
    const { data } = await sanityFetch({ query: ADMIN_STATS_QUERY });
    
    // Calculate total revenue from array of prices
    const totalRevenue = Array.isArray(data?.totalRevenue) 
      ? data.totalRevenue.reduce((sum: number, price: number) => sum + (price || 0), 0)
      : 0;
    
    return {
      totalRevenue,
      totalProducts: data?.totalProducts || 0,
      totalOrders: data?.totalOrders || 0,
      totalUsers: data?.totalUsers || 0,
    };
  } catch (error) {
    console.error("Error fetching admin stats:", error);
    return {
      totalRevenue: 0,
      totalProducts: 0,
      totalOrders: 0,
      totalUsers: 0,
    };
  }
};

// Fungsi untuk mendapatkan recent orders
export const getRecentOrders = async () => {
  try {
    const { data } = await sanityFetch({ query: RECENT_ORDERS_QUERY });
    return data || [];
  } catch (error) {
    console.error("Error fetching recent orders:", error);
    return [];
  }
};

// Fungsi untuk mendapatkan top products
export const getTopProducts = async () => {
  try {
    const { data } = await sanityFetch({ query: TOP_PRODUCTS_QUERY });
    return data || [];
  } catch (error) {
    console.error("Error fetching top products:", error);
    return [];
  }
};

// Fungsi untuk mendapatkan semua orders dengan pagination
export const getAllOrders = async (start = 0, end = 50) => {
  try {
    const { data } = await sanityFetch({
      query: ALL_ORDERS_ADMIN_QUERY,
      params: { start, end },
    });
    return data || [];
  } catch (error) {
    console.error("Error fetching all orders:", error);
    return [];
  }
};

// Fungsi untuk mendapatkan semua products dengan pagination
export const getAllProducts = async (start = 0, end = 50) => {
  try {
    const { data } = await sanityFetch({ 
      query: ALL_PRODUCTS_QUERY,
      params: { start, end }
    });
    return data || [];
  } catch (error) {
    console.error("Error fetching all products:", error);
    return [];
  }
};

// Fungsi untuk mendapatkan semua categories dengan pagination
export const getAllCategories = async (start = 0, end = 50) => {
  try {
    const { data } = await sanityFetch({ 
      query: ALL_CATEGORIES_QUERY,
      params: { start, end }
    });
    return data || [];
  } catch (error) {
    console.error("Error fetching all categories:", error);
    return [];
  }
};

// Fungsi untuk mendapatkan semua brands dengan pagination
export const getAllBrands = async (start = 0, end = 50) => {
  try {
    const { data } = await sanityFetch({ 
      query: ALL_BRANDS_ADMIN_QUERY,
      params: { start, end }
    });
    return data || [];
  } catch (error) {
    console.error("Error fetching all brands:", error);
    return [];
  }
};



// Fungsi untuk mendapatkan semua authors dengan pagination
export const getAllAuthors = async (start = 0, end = 50) => {
  try {
    const { data } = await sanityFetch({
      query: ALL_AUTHORS_ADMIN_QUERY,
      params: { start, end },
    });
    return data;
  } catch (error) {
    console.error("Error fetching authors:", error);
    throw error;
  }
};

export const getAllAddresses = async (start = 0, end = 50) => {
  try {
    const { data } = await sanityFetch({
      query: ALL_ADDRESSES_ADMIN_QUERY,
      params: { start, end },
    });
    return data;
  } catch (error) {
    console.error("Error fetching addresses:", error);
    throw error;
  }
};

// Types untuk TypeScript
export interface AdminStats {
  totalRevenue: number;
  totalProducts: number;
  totalOrders: number;
  totalUsers: number;
}

export interface RecentOrder {
  _id: string;
  orderNumber: string;
  customerName: string;
  totalPrice: number;
  currency: string;
  status: string;
  orderDate: string;
  products: Array<{
    quantity: number;
    product: {
      name: string;
      price: number;
    };
  }>;
}

export interface TopProduct {
  _id: string;
  name: string;
  price: number;
  currency: string;
  images: Array<{
    asset: {
      _ref: string;
      _type: string;
    };
    _key: string;
    _type: string;
  }>;
  totalSold: number;
  revenue: number;
}