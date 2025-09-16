"use client";

import { useState, useEffect } from "react";
import { getAllBlogs } from "@/sanity/queries/adminQueries";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog";
import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Label } from "@/components/ui/label";
import { Plus, Edit, Trash2, Search, FileText, Eye } from "lucide-react";
import Image from "next/image";

interface BlogCategory {
  _id: string;
  title: string;
}

interface Author {
  _id: string;
  name: string;
}

interface Blog {
  _id: string;
  title: string;
  slug: {
    current: string;
  };
  author: Author;
  mainImage?: {
    asset: {
      url: string;
    };
  };
  blogcategories: BlogCategory[];
  publishedAt: string;
  isLatest: boolean;
  _createdAt: string;
  _updatedAt: string;
}

export default function BlogsPage() {
  const [blogs, setBlogs] = useState<Blog[]>([]);
  const [loading, setLoading] = useState(true);
  const [searchTerm, setSearchTerm] = useState("");
  const [isCreateDialogOpen, setIsCreateDialogOpen] = useState(false);
  const [isEditDialogOpen, setIsEditDialogOpen] = useState(false);
  const [isViewDialogOpen, setIsViewDialogOpen] = useState(false);
  const [selectedBlog, setSelectedBlog] = useState<Blog | null>(null);
  const [formData, setFormData] = useState({
    title: "",
    author: "",
    mainImage: "",
    categories: "",
    publishedAt: "",
    isLatest: false,
    body: "",
  });

  // Load blogs data
  useEffect(() => {
    const loadBlogs = async () => {
      try {
        setLoading(true);
        const data = await getAllBlogs();
        setBlogs(data);
      } catch (error) {
        console.error("Error loading blogs:", error);
        console.error("Gagal memuat data blog");
      } finally {
        setLoading(false);
      }
    };

    loadBlogs();
  }, []);

  // Filter blogs based on search term
  const filteredBlogs = blogs.filter((blog) =>
    blog.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
    blog.author.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
    blog.blogcategories.some(cat => 
      cat.title.toLowerCase().includes(searchTerm.toLowerCase())
    )
  );

  // Handle form submission for create
  const handleCreate = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      // TODO: Implement create blog API call
      console.log("Blog berhasil dibuat");
      setIsCreateDialogOpen(false);
      setFormData({ 
        title: "", 
        author: "", 
        mainImage: "", 
        categories: "", 
        publishedAt: "", 
        isLatest: false, 
        body: "" 
      });
      // Reload data
      const data = await getAllBlogs();
      setBlogs(data);
    } catch (error) {
      console.error("Error creating blog:", error);
      console.error("Gagal membuat blog");
    }
  };

  // Handle form submission for edit
  const handleEdit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!selectedBlog) return;

    try {
      // TODO: Implement update blog API call
      console.log("Blog berhasil diperbarui");
      setIsEditDialogOpen(false);
      setSelectedBlog(null);
      setFormData({ 
        title: "", 
        author: "", 
        mainImage: "", 
        categories: "", 
        publishedAt: "", 
        isLatest: false, 
        body: "" 
      });
      // Reload data
      const data = await getAllBlogs();
      setBlogs(data);
    } catch (error) {
      console.error("Error updating blog:", error);
      console.error("Gagal memperbarui blog");
    }
  };

  // Handle delete
  const handleDelete = async () => {
    if (!confirm("Apakah Anda yakin ingin menghapus blog ini?")) return;

    try {
      // TODO: Implement delete blog API call
      console.log("Blog berhasil dihapus");
      // Reload data
      const data = await getAllBlogs();
      setBlogs(data);
    } catch (error) {
      console.error("Error deleting blog:", error);
      console.error("Gagal menghapus blog");
    }
  };

  // Open view dialog
  const openViewDialog = (blog: Blog) => {
    setSelectedBlog(blog);
    setIsViewDialogOpen(true);
  };

  // Open edit dialog
  const openEditDialog = (blog: Blog) => {
    setSelectedBlog(blog);
    setFormData({
      title: blog.title,
      author: blog.author.name,
      mainImage: blog.mainImage?.asset?.url || "",
      categories: blog.blogcategories.map(cat => cat.title).join(", "),
      publishedAt: blog.publishedAt ? new Date(blog.publishedAt).toISOString().split('T')[0] : "",
      isLatest: blog.isLatest,
      body: "", // TODO: Get body content
    });
    setIsEditDialogOpen(true);
  };

  // Open create dialog
  const openCreateDialog = () => {
    setFormData({ 
      title: "", 
      author: "", 
      mainImage: "", 
      categories: "", 
      publishedAt: "", 
      isLatest: false, 
      body: "" 
    });
    setIsCreateDialogOpen(true);
  };

  if (loading) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
          <p className="mt-4 text-gray-600">Memuat data blog...</p>
        </div>
      </div>
    );
  }

  return (
    <div className="container mx-auto p-6">
      <div className="flex justify-between items-center mb-6">
        <div>
          <h1 className="text-3xl font-bold text-gray-900">Manajemen Blog</h1>
          <p className="text-gray-600 mt-2">Kelola artikel blog Anda</p>
        </div>
        <Button onClick={openCreateDialog} className="flex items-center gap-2">
          <Plus className="h-4 w-4" />
          Tambah Blog
        </Button>
      </div>

      {/* Stats Cards */}
      <div className="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Total Blog</CardTitle>
            <FileText className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{blogs.length}</div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Blog Terbaru</CardTitle>
            <FileText className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">
              {blogs.filter(blog => blog.isLatest).length}
            </div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Blog dengan Gambar</CardTitle>
            <FileText className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">
              {blogs.filter(blog => blog.mainImage).length}
            </div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Blog Bulan Ini</CardTitle>
            <FileText className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">
              {blogs.filter(blog => {
                const publishedDate = new Date(blog.publishedAt);
                const currentDate = new Date();
                return publishedDate.getMonth() === currentDate.getMonth() &&
                       publishedDate.getFullYear() === currentDate.getFullYear();
              }).length}
            </div>
          </CardContent>
        </Card>
      </div>

      {/* Search */}
      <div className="mb-6">
        <div className="relative">
          <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4" />
          <Input
            placeholder="Cari blog..."
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
            className="pl-10"
          />
        </div>
      </div>

      {/* Blogs Table */}
      <Card>
        <CardHeader>
          <CardTitle>Daftar Blog</CardTitle>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Gambar</TableHead>
                <TableHead>Judul</TableHead>
                <TableHead>Penulis</TableHead>
                <TableHead>Kategori</TableHead>
                <TableHead>Status</TableHead>
                <TableHead>Tanggal Publish</TableHead>
                <TableHead>Aksi</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {filteredBlogs.map((blog) => (
                <TableRow key={blog._id}>
                  <TableCell>
                    {blog.mainImage?.asset?.url ? (
                      <Image
                        src={blog.mainImage.asset.url}
                        alt={blog.title}
                        width={40}
                        height={40}
                        className="rounded-md object-cover"
                      />
                    ) : (
                      <div className="w-10 h-10 bg-gray-200 rounded-md flex items-center justify-center">
                        <FileText className="h-4 w-4 text-gray-400" />
                      </div>
                    )}
                  </TableCell>
                  <TableCell className="font-medium max-w-xs truncate">
                    {blog.title}
                  </TableCell>
                  <TableCell>{blog.author.name}</TableCell>
                  <TableCell>
                    <div className="flex flex-wrap gap-1">
                      {blog.blogcategories.slice(0, 2).map((category) => (
                        <Badge key={category._id} variant="secondary" className="text-xs">
                          {category.title}
                        </Badge>
                      ))}
                      {blog.blogcategories.length > 2 && (
                        <Badge variant="secondary" className="text-xs">
                          +{blog.blogcategories.length - 2}
                        </Badge>
                      )}
                    </div>
                  </TableCell>
                  <TableCell>
                    {blog.isLatest ? (
                      <Badge className="bg-green-100 text-green-800">Terbaru</Badge>
                    ) : (
                      <Badge variant="secondary">Normal</Badge>
                    )}
                  </TableCell>
                  <TableCell>
                    {blog.publishedAt ? 
                      new Date(blog.publishedAt).toLocaleDateString("id-ID") : 
                      "-"
                    }
                  </TableCell>
                  <TableCell>
                    <div className="flex items-center gap-2">
                      <Button
                        variant="outline"
                        size="sm"
                        onClick={() => openViewDialog(blog)}
                      >
                        <Eye className="h-4 w-4" />
                      </Button>
                      <Button
                        variant="outline"
                        size="sm"
                        onClick={() => openEditDialog(blog)}
                      >
                        <Edit className="h-4 w-4" />
                      </Button>
                      <Button
                        variant="outline"
                        size="sm"
                        onClick={() => handleDelete()}
                        className="text-red-600 hover:text-red-700"
                      >
                        <Trash2 className="h-4 w-4" />
                      </Button>
                    </div>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>

          {filteredBlogs.length === 0 && (
            <div className="text-center py-8">
              <FileText className="h-12 w-12 text-gray-400 mx-auto mb-4" />
              <p className="text-gray-500">
                {searchTerm ? "Tidak ada blog yang ditemukan" : "Belum ada blog"}
              </p>
            </div>
          )}
        </CardContent>
      </Card>

      {/* View Blog Dialog */}
      <Dialog open={isViewDialogOpen} onOpenChange={setIsViewDialogOpen}>
        <DialogContent className="sm:max-w-[600px]">
          <DialogHeader>
            <DialogTitle>Detail Blog</DialogTitle>
          </DialogHeader>
          {selectedBlog && (
            <div className="space-y-4">
              <div>
                <Label className="text-sm font-medium">Judul</Label>
                <p className="text-sm text-gray-600">{selectedBlog.title}</p>
              </div>
              <div>
                <Label className="text-sm font-medium">Penulis</Label>
                <p className="text-sm text-gray-600">{selectedBlog.author.name}</p>
              </div>
              <div>
                <Label className="text-sm font-medium">Kategori</Label>
                <div className="flex flex-wrap gap-1 mt-1">
                  {selectedBlog.blogcategories.map((category) => (
                    <Badge key={category._id} variant="secondary">
                      {category.title}
                    </Badge>
                  ))}
                </div>
              </div>
              <div>
                <Label className="text-sm font-medium">Status</Label>
                <p className="text-sm text-gray-600">
                  {selectedBlog.isLatest ? "Blog Terbaru" : "Blog Normal"}
                </p>
              </div>
              <div>
                <Label className="text-sm font-medium">Tanggal Publish</Label>
                <p className="text-sm text-gray-600">
                  {selectedBlog.publishedAt ? 
                    new Date(selectedBlog.publishedAt).toLocaleDateString("id-ID") : 
                    "Belum dipublish"
                  }
                </p>
              </div>
              {selectedBlog.mainImage && (
                <div>
                  <Label className="text-sm font-medium">Gambar Utama</Label>
                  <div className="mt-2">
                    <Image
                      src={selectedBlog.mainImage.asset.url}
                      alt={selectedBlog.title}
                      width={200}
                      height={150}
                      className="rounded-md object-cover"
                    />
                  </div>
                </div>
              )}
            </div>
          )}
        </DialogContent>
      </Dialog>

      {/* Create Blog Dialog */}
      <Dialog open={isCreateDialogOpen} onOpenChange={setIsCreateDialogOpen}>
        <DialogContent className="sm:max-w-[500px]">
          <DialogHeader>
            <DialogTitle>Tambah Blog Baru</DialogTitle>
          </DialogHeader>
          <form onSubmit={handleCreate} className="space-y-4">
            <div>
              <Label htmlFor="title">Judul Blog</Label>
              <Input
                id="title"
                value={formData.title}
                onChange={(e) => setFormData({ ...formData, title: e.target.value })}
                placeholder="Masukkan judul blog"
                required
              />
            </div>
            <div>
              <Label htmlFor="author">Penulis</Label>
              <Input
                id="author"
                value={formData.author}
                onChange={(e) => setFormData({ ...formData, author: e.target.value })}
                placeholder="Masukkan nama penulis"
                required
              />
            </div>
            <div>
              <Label htmlFor="categories">Kategori</Label>
              <Input
                id="categories"
                value={formData.categories}
                onChange={(e) => setFormData({ ...formData, categories: e.target.value })}
                placeholder="Masukkan kategori (pisahkan dengan koma)"
              />
            </div>
            <div>
              <Label htmlFor="mainImage">URL Gambar Utama</Label>
              <Input
                id="mainImage"
                value={formData.mainImage}
                onChange={(e) => setFormData({ ...formData, mainImage: e.target.value })}
                placeholder="Masukkan URL gambar"
                type="url"
              />
            </div>
            <div>
              <Label htmlFor="publishedAt">Tanggal Publish</Label>
              <Input
                id="publishedAt"
                value={formData.publishedAt}
                onChange={(e) => setFormData({ ...formData, publishedAt: e.target.value })}
                type="date"
              />
            </div>
            <div className="flex items-center space-x-2">
              <input
                type="checkbox"
                id="isLatest"
                checked={formData.isLatest}
                onChange={(e) => setFormData({ ...formData, isLatest: e.target.checked })}
                className="rounded"
              />
              <Label htmlFor="isLatest">Tandai sebagai blog terbaru</Label>
            </div>
            <div>
              <Label htmlFor="body">Konten Blog</Label>
              <Textarea
                id="body"
                value={formData.body}
                onChange={(e) => setFormData({ ...formData, body: e.target.value })}
                placeholder="Masukkan konten blog"
                rows={4}
              />
            </div>
            <div className="flex justify-end gap-2">
              <Button
                type="button"
                variant="outline"
                onClick={() => setIsCreateDialogOpen(false)}
              >
                Batal
              </Button>
              <Button type="submit">Simpan</Button>
            </div>
          </form>
        </DialogContent>
      </Dialog>

      {/* Edit Blog Dialog */}
      <Dialog open={isEditDialogOpen} onOpenChange={setIsEditDialogOpen}>
        <DialogContent className="sm:max-w-[500px]">
          <DialogHeader>
            <DialogTitle>Edit Blog</DialogTitle>
          </DialogHeader>
          <form onSubmit={handleEdit} className="space-y-4">
            <div>
              <Label htmlFor="edit-title">Judul Blog</Label>
              <Input
                id="edit-title"
                value={formData.title}
                onChange={(e) => setFormData({ ...formData, title: e.target.value })}
                placeholder="Masukkan judul blog"
                required
              />
            </div>
            <div>
              <Label htmlFor="edit-author">Penulis</Label>
              <Input
                id="edit-author"
                value={formData.author}
                onChange={(e) => setFormData({ ...formData, author: e.target.value })}
                placeholder="Masukkan nama penulis"
                required
              />
            </div>
            <div>
              <Label htmlFor="edit-categories">Kategori</Label>
              <Input
                id="edit-categories"
                value={formData.categories}
                onChange={(e) => setFormData({ ...formData, categories: e.target.value })}
                placeholder="Masukkan kategori (pisahkan dengan koma)"
              />
            </div>
            <div>
              <Label htmlFor="edit-mainImage">URL Gambar Utama</Label>
              <Input
                id="edit-mainImage"
                value={formData.mainImage}
                onChange={(e) => setFormData({ ...formData, mainImage: e.target.value })}
                placeholder="Masukkan URL gambar"
                type="url"
              />
            </div>
            <div>
              <Label htmlFor="edit-publishedAt">Tanggal Publish</Label>
              <Input
                id="edit-publishedAt"
                value={formData.publishedAt}
                onChange={(e) => setFormData({ ...formData, publishedAt: e.target.value })}
                type="date"
              />
            </div>
            <div className="flex items-center space-x-2">
              <input
                type="checkbox"
                id="edit-isLatest"
                checked={formData.isLatest}
                onChange={(e) => setFormData({ ...formData, isLatest: e.target.checked })}
                className="rounded"
              />
              <Label htmlFor="edit-isLatest">Tandai sebagai blog terbaru</Label>
            </div>
            <div>
              <Label htmlFor="edit-body">Konten Blog</Label>
              <Textarea
                id="edit-body"
                value={formData.body}
                onChange={(e) => setFormData({ ...formData, body: e.target.value })}
                placeholder="Masukkan konten blog"
                rows={4}
              />
            </div>
            <div className="flex justify-end gap-2">
              <Button
                type="button"
                variant="outline"
                onClick={() => setIsEditDialogOpen(false)}
              >
                Batal
              </Button>
              <Button type="submit">Perbarui</Button>
            </div>
          </form>
        </DialogContent>
      </Dialog>
    </div>
  );
}