import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Button } from "@/components/ui/button"
import { 
  ShoppingBag, 
  Users, 
  Package, 
  DollarSign,
  Eye,
  Plus,
  BarChart3,
  FileText
} from "lucide-react"
import Link from "next/link"
import { Suspense } from "react"
import { 
  getAdminStats, 
  getRecentOrders, 
  getTopProducts,
  type AdminStats,
  type RecentOrder,
  type TopProduct
} from "@/sanity/queries/adminQueries"

// Loading components
function StatsLoading() {
  return (
    <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
      {[...Array(4)].map((_, i) => (
        <Card key={i} className="animate-pulse">
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <div className="h-4 bg-gray-200 rounded w-20"></div>
            <div className="h-4 w-4 bg-gray-200 rounded"></div>
          </CardHeader>
          <CardContent>
            <div className="h-8 bg-gray-200 rounded w-24 mb-2"></div>
            <div className="h-3 bg-gray-200 rounded w-32"></div>
          </CardContent>
        </Card>
      ))}
    </div>
  )
}

function OrdersLoading() {
  return (
    <Card>
      <CardHeader>
        <div className="h-6 bg-gray-200 rounded w-32 mb-2"></div>
        <div className="h-4 bg-gray-200 rounded w-48"></div>
      </CardHeader>
      <CardContent>
        <div className="space-y-4">
          {[...Array(3)].map((_, i) => (
            <div key={i} className="flex items-center justify-between animate-pulse">
              <div className="space-y-2">
                <div className="h-4 bg-gray-200 rounded w-20"></div>
                <div className="h-3 bg-gray-200 rounded w-24"></div>
              </div>
              <div className="text-right space-y-2">
                <div className="h-4 bg-gray-200 rounded w-16"></div>
                <div className="h-3 bg-gray-200 rounded w-12"></div>
              </div>
            </div>
          ))}
        </div>
      </CardContent>
    </Card>
  )
}

function ProductsLoading() {
  return (
    <Card>
      <CardHeader>
        <div className="h-6 bg-gray-200 rounded w-32 mb-2"></div>
        <div className="h-4 bg-gray-200 rounded w-48"></div>
      </CardHeader>
      <CardContent>
        <div className="space-y-4">
          {[...Array(3)].map((_, i) => (
            <div key={i} className="flex items-center justify-between animate-pulse">
              <div className="flex items-center space-x-3">
                <div className="h-6 w-6 bg-gray-200 rounded-full"></div>
                <div className="space-y-2">
                  <div className="h-4 bg-gray-200 rounded w-32"></div>
                  <div className="h-3 bg-gray-200 rounded w-20"></div>
                </div>
              </div>
              <div className="h-4 bg-gray-200 rounded w-16"></div>
            </div>
          ))}
        </div>
      </CardContent>
    </Card>
  )
}

// Data fetching components
async function StatsCards() {
  const stats: AdminStats = await getAdminStats()
  
  return (
    <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
      <Card className="bg-gradient-to-br from-emerald-50 to-emerald-100 border-emerald-200 shadow-lg hover:shadow-xl transition-all duration-300">
        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
          <CardTitle className="text-sm font-semibold text-emerald-800">Total Revenue</CardTitle>
          <div className="p-2 bg-emerald-500/20 rounded-lg">
            <DollarSign className="h-4 w-4 text-emerald-600" />
          </div>
        </CardHeader>
        <CardContent>
          <div className="text-2xl font-bold text-emerald-900">Rp {stats.totalRevenue?.toLocaleString('id-ID') || 0}</div>
          <p className="text-xs text-emerald-700 font-medium">+20.1% from last month</p>
        </CardContent>
      </Card>

      <Card className="bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200 shadow-lg hover:shadow-xl transition-all duration-300">
        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
          <CardTitle className="text-sm font-semibold text-blue-800">Products</CardTitle>
          <div className="p-2 bg-blue-500/20 rounded-lg">
            <Package className="h-4 w-4 text-blue-600" />
          </div>
        </CardHeader>
        <CardContent>
          <div className="text-2xl font-bold text-blue-900">{stats.totalProducts || 0}</div>
          <p className="text-xs text-blue-700 font-medium">+2 new this month</p>
        </CardContent>
      </Card>

      <Card className="bg-gradient-to-br from-orange-50 to-orange-100 border-orange-200 shadow-lg hover:shadow-xl transition-all duration-300">
        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
          <CardTitle className="text-sm font-semibold text-orange-800">Orders</CardTitle>
          <div className="p-2 bg-orange-500/20 rounded-lg">
            <ShoppingBag className="h-4 w-4 text-orange-600" />
          </div>
        </CardHeader>
        <CardContent>
          <div className="text-2xl font-bold text-orange-900">{stats.totalOrders || 0}</div>
          <p className="text-xs text-orange-700 font-medium">+12 since yesterday</p>
        </CardContent>
      </Card>

      <Card className="bg-gradient-to-br from-purple-50 to-purple-100 border-purple-200 shadow-lg hover:shadow-xl transition-all duration-300">
        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
          <CardTitle className="text-sm font-semibold text-purple-800">Users</CardTitle>
          <div className="p-2 bg-purple-500/20 rounded-lg">
            <Users className="h-4 w-4 text-purple-600" />
          </div>
        </CardHeader>
        <CardContent>
          <div className="text-2xl font-bold text-purple-900">{stats.totalUsers || 0}</div>
          <p className="text-xs text-purple-700 font-medium">+5 new this week</p>
        </CardContent>
      </Card>
    </div>
  )
}

async function RecentOrdersCard() {
  const recentOrders: RecentOrder[] = await getRecentOrders()
  
  return (
    <Card className="shadow-lg hover:shadow-xl transition-all duration-300">
      <CardHeader>
        <CardTitle className="text-xl font-bold text-gray-900">Recent Orders</CardTitle>
        <CardDescription className="text-gray-600 font-medium">Latest orders from your customers</CardDescription>
      </CardHeader>
      <CardContent>
        <div className="space-y-4">
          {recentOrders.length > 0 ? recentOrders.map((order) => (
            <div key={order._id} className="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
              <div className="space-y-1">
                <p className="text-sm font-semibold text-gray-900">{order.orderNumber}</p>
                <p className="text-xs text-gray-600 font-medium">{order.customerName}</p>
              </div>
              <div className="text-right space-y-1">
                <p className="text-sm font-bold text-gray-900">Rp {order.totalPrice?.toLocaleString('id-ID')}</p>
                <Badge 
                  variant={order.status === 'paid' ? 'default' : order.status === 'pending' ? 'secondary' : 'outline'}
                  className="text-xs font-medium"
                >
                  {order.status}
                </Badge>
              </div>
            </div>
          )) : (
            <p className="text-gray-500 text-center py-4">No recent orders found</p>
          )}
        </div>
        <div className="mt-6 pt-4 border-t border-gray-200">
          <Link href="/admin/orders">
            <Button variant="outline" className="w-full hover:bg-gray-50 transition-colors duration-200">
              <Eye className="mr-2 h-4 w-4" />
              View All Orders
            </Button>
          </Link>
        </div>
      </CardContent>
    </Card>
  )
}

async function TopProductsCard() {
  const topProducts: TopProduct[] = await getTopProducts()
  
  return (
    <Card className="shadow-lg hover:shadow-xl transition-all duration-300">
      <CardHeader>
        <CardTitle className="text-xl font-bold text-gray-900">Top Products</CardTitle>
        <CardDescription className="text-gray-600 font-medium">Best performing products this month</CardDescription>
      </CardHeader>
      <CardContent>
        <div className="space-y-4">
          {topProducts.length > 0 ? topProducts.map((product, index) => (
            <div key={product._id} className="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
              <div className="flex items-center space-x-3">
                <div className="flex items-center justify-center w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-full text-sm font-bold">
                  {index + 1}
                </div>
                <div className="space-y-1">
                  <p className="text-sm font-semibold text-gray-900">{product.name}</p>
                  <p className="text-xs text-gray-600 font-medium">{product.totalSold} sold</p>
                </div>
              </div>
              <p className="text-sm font-bold text-gray-900">Rp {product.revenue?.toLocaleString('id-ID') || 0}</p>
            </div>
          )) : (
            <p className="text-gray-500 text-center py-4">No product data found</p>
          )}
        </div>
        <div className="mt-6 pt-4 border-t border-gray-200">
          <Link href="/admin/products">
            <Button variant="outline" className="w-full hover:bg-gray-50 transition-colors duration-200">
              <BarChart3 className="mr-2 h-4 w-4" />
              View All Products
            </Button>
          </Link>
        </div>
      </CardContent>
    </Card>
  )
}

export default function AdminDashboard() {

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
      <div className="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6 py-6 space-y-6">
        {/* Header */}
        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-0">
          <div className="space-y-1">
            <h1 className="text-2xl sm:text-3xl font-bold tracking-tight bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
              Dashboard
            </h1>
            <p className="text-sm sm:text-base text-gray-600 font-medium">Welcome back! Here&apos;s what&apos;s happening with your store</p>
          </div>
          <Button className="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white shadow-lg hover:shadow-xl transition-all duration-300 px-4 py-2 text-sm font-semibold">
            <Plus className="mr-2 h-4 w-4" />
            Add Product
          </Button>
        </div>

        {/* Stats Cards */}
        <Suspense fallback={<StatsLoading />}>
          <StatsCards />
        </Suspense>

        {/* Recent Orders & Top Products */}
        <div className="grid gap-3 sm:gap-4 md:grid-cols-2">
          <Suspense fallback={<OrdersLoading />}>
            <RecentOrdersCard />
          </Suspense>
          
          <Suspense fallback={<ProductsLoading />}>
            <TopProductsCard />
          </Suspense>
        </div>

        {/* Quick Actions */}
        <Card className="shadow-lg hover:shadow-xl transition-all duration-300">
          <CardHeader className="pb-4">
            <CardTitle className="text-lg font-bold text-gray-900">Quick Actions</CardTitle>
            <CardDescription className="text-gray-600 font-medium">Common tasks and shortcuts</CardDescription>
          </CardHeader>
          <CardContent className="pt-0">
            <div className="grid gap-2 sm:gap-3 grid-cols-1 sm:grid-cols-3">
              <Button 
                className="h-24 flex-col gap-3 bg-gradient-to-br from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white border-0 shadow-lg hover:shadow-xl transition-all duration-300" 
                asChild
              >
                <Link href="/admin/products/new">
                  <div className="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                    <Plus className="h-6 w-6" />
                  </div>
                  <span className="font-medium">Add New Product</span>
                </Link>
              </Button>
              <Button 
                className="h-24 flex-col gap-3 bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white border-0 shadow-lg hover:shadow-xl transition-all duration-300" 
                asChild
              >
                <Link href="/admin/orders">
                  <div className="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                    <FileText className="h-6 w-6" />
                  </div>
                  <span className="font-medium">Manage Orders</span>
                </Link>
              </Button>
              <Button 
                className="h-24 flex-col gap-3 bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white border-0 shadow-lg hover:shadow-xl transition-all duration-300" 
                asChild
              >
                <Link href="/admin/analytics">
                  <div className="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                    <BarChart3 className="h-6 w-6" />
                  </div>
                  <span className="font-medium">View Analytics</span>
                </Link>
              </Button>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  )
}