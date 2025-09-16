import { defineQuery } from "next-sanity";

// Query untuk mendapatkan statistik dashboard
const ADMIN_STATS_QUERY = defineQuery(`{
  "totalRevenue": *[_type == 'order' && status == 'paid'][0...100].totalPrice,
  "totalProducts": count(*[_type == 'product']),
  "totalOrders": count(*[_type == 'order']),
  "totalUsers": count(*[_type == 'order' && defined(clerkUserId)])
}`);

// Query untuk mendapatkan recent orders
const RECENT_ORDERS_QUERY = defineQuery(`*[_type == 'order'] | order(orderDate desc)[0...5]{
  _id,
  orderNumber,
  customerName,
  totalPrice,
  currency,
  status,
  orderDate,
  products[]{
    quantity,
    product->{
      name,
      price
    }
  }
}`);

// Query untuk mendapatkan top products berdasarkan penjualan
const TOP_PRODUCTS_QUERY = defineQuery(`*[_type == 'product']{
  _id,
  name,
  price,
  currency,
  images,
  "totalSold": count(*[_type == 'order' && references(^._id) && status == 'paid']),
  "revenue": ^.price * count(*[_type == 'order' && references(^._id) && status == 'paid'])
} | order(totalSold desc)[0...5]`);

// Query untuk mendapatkan semua orders dengan pagination
const ALL_ORDERS_QUERY = defineQuery(`*[_type == 'order'] | order(orderDate desc)[$start...$end]{
  _id,
  orderNumber,
  customerName,
  email,
  totalPrice,
  currency,
  status,
  orderDate,
  products[]{
    quantity,
    product->{
      name,
      price,
      images
    }
  }
}`);

// Query untuk mendapatkan semua products dengan pagination
const ALL_PRODUCTS_QUERY = defineQuery(`*[_type == 'product'] | order(name asc)[$start...$end]{
  _id,
  name,
  slug,
  price,
  currency,
  images,
  stock,
  status,
  categories[]->{
    title
  },
  brand->{
    title
  }
}`);

// Query untuk mendapatkan semua categories dengan pagination
const ALL_CATEGORIES_QUERY = defineQuery(`*[_type == 'category'] | order(title asc)[$start...$end]{
  _id,
  title,
  slug,
  description,
  range,
  featured,
  image,
  "productCount": count(*[_type == "product" && references(^._id)])
}`);

// Query untuk mendapatkan semua orders
const ALL_ORDERS_ADMIN_QUERY = defineQuery(`*[_type == "order"] | order(orderDate desc) {
  _id,
  orderNumber,
  customerName,
  email,
  totalPrice,
  currency,
  amountDiscount,
  status,
  orderDate,
  address,
  stripePaymentIntentId,
  stripeCustomerId,
  clerkUserId,
  products[] {
    quantity,
    product-> {
      _id,
      name,
      price,
      image,
      slug
    }
  }
}`);

// Query untuk mendapatkan semua brands
const ALL_BRANDS_ADMIN_QUERY = defineQuery(`*[_type == "brand"] | order(title asc) {
  _id,
  title,
  slug,
  description,
  image{
    asset->{
      url
    }
  },
  _createdAt,
  _updatedAt
}`);

// Query untuk mendapatkan semua blogs
const ALL_BLOGS_ADMIN_QUERY = defineQuery(`*[_type == "blog"] | order(publishedAt desc) {
  _id,
  title,
  slug,
  author->{
    _id,
    name
  },
  mainImage{
    asset->{
      url
    }
  },
  blogcategories[]->{
    _id,
    title
  },
  publishedAt,
  isLatest,
  _createdAt,
  _updatedAt
}`);

// Query untuk mendapatkan semua blog categories
const ALL_BLOG_CATEGORIES_ADMIN_QUERY = defineQuery(`*[_type == "blogcategory"] | order(_createdAt desc) {
  _id,
  title,
  slug,
  description,
  _createdAt,
  _updatedAt
}`);

// Authors Query
const ALL_AUTHORS_ADMIN_QUERY = defineQuery(`*[_type == "author"] | order(_createdAt desc) {
  _id,
  name,
  slug,
  image {
    asset -> {
      url
    }
  },
  bio,
  _createdAt,
  _updatedAt
}`);

// Addresses Query
const ALL_ADDRESSES_ADMIN_QUERY = defineQuery(`*[_type == "address"] | order(_createdAt desc) {
  _id,
  name,
  email,
  address,
  city,
  state,
  zip,
  default,
  createdAt,
  _createdAt,
  _updatedAt
}`);

// Query untuk mendapatkan semua admin users
const ALL_ADMINS_QUERY = defineQuery(`*[_type == "admin"] | order(_createdAt desc) {
  _id,
  name,
  email,
  role,
  isActive,
  image {
    asset -> {
      url
    }
  },
  _createdAt,
  _updatedAt
}`);

// Query untuk mendapatkan admin berdasarkan email
const ADMIN_BY_EMAIL_QUERY = defineQuery(`*[_type == "admin" && email == $email && isActive == true][0] {
  _id,
  name,
  email,
  role,
  isActive,
  image {
    asset -> {
      url
    }
  }
}`);

// Query untuk login dengan password (termasuk field password untuk verifikasi)
const ADMIN_LOGIN_QUERY = defineQuery(`*[_type == "admin" && email == $email && isActive == true][0] {
  _id,
  name,
  email,
  role,
  isActive,
  password,
  lastPasswordChange,
  image {
    asset -> {
      url
    }
  }
}`);

export {
  ADMIN_STATS_QUERY,
  RECENT_ORDERS_QUERY,
  TOP_PRODUCTS_QUERY,
  ALL_ORDERS_QUERY,
  ALL_PRODUCTS_QUERY,
  ALL_CATEGORIES_QUERY,
  ALL_ORDERS_ADMIN_QUERY,
  ALL_BRANDS_ADMIN_QUERY,
  ALL_BLOGS_ADMIN_QUERY,
  ALL_BLOG_CATEGORIES_ADMIN_QUERY,
  ALL_AUTHORS_ADMIN_QUERY,
  ALL_ADDRESSES_ADMIN_QUERY,
  ALL_ADMINS_QUERY,
  ADMIN_BY_EMAIL_QUERY,
  ADMIN_LOGIN_QUERY,
};