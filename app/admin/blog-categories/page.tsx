"use client";

import { useState, useEffect } from "react";
import { getAllBlogCategories } from "@/sanity/queries/adminQueries";
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
import { Plus, Edit, Trash2, Search, Tag, Eye } from "lucide-react";

interface BlogCategory {
  _id: string;
  title: string;
  slug: {
    current: string;
  };
  description?: string;
  _createdAt: string;
  _updatedAt: string;
}

export default function BlogCategoriesPage() {
  const [blogCategories, setBlogCategories] = useState<BlogCategory[]>([]);
  const [loading, setLoading] = useState(true);
  const [searchTerm, setSearchTerm] = useState("");
  const [isCreateDialogOpen, setIsCreateDialogOpen] = useState(false);
  const [isEditDialogOpen, setIsEditDialogOpen] = useState(false);
  const [isViewDialogOpen, setIsViewDialogOpen] = useState(false);
  const [selectedCategory, setSelectedCategory] = useState<BlogCategory | null>(null);
  const [formData, setFormData] = useState({
    title: "",
    description: "",
  });

  // Load blog categories data
  useEffect(() => {
    const loadBlogCategories = async () => {
      try {
        setLoading(true);
        const data = await getAllBlogCategories();
        setBlogCategories(data);
      } catch (error) {
        console.error("Error loading blog categories:", error);
        console.error("Gagal memuat data kategori blog");
      } finally {
        setLoading(false);
      }
    };

    loadBlogCategories();
  }, []);

  // Filter blog categories based on search term
  const filteredCategories = blogCategories.filter((category) =>
    category.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
    (category.description && category.description.toLowerCase().includes(searchTerm.toLowerCase()))
  );

  // Handle form submission for create
  const handleCreate = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      // TODO: Implement create blog category API call
      console.log("Kategori blog berhasil dibuat");
      setIsCreateDialogOpen(false);
      setFormData({ title: "", description: "" });
      // Reload data
      const data = await getAllBlogCategories();
      setBlogCategories(data);
    } catch (error) {
      console.error("Error creating blog category:", error);
      console.error("Gagal membuat kategori blog");
    }
  };

  // Handle form submission for edit
  const handleEdit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!selectedCategory) return;

    try {
      // TODO: Implement update blog category API call
      console.log("Kategori blog berhasil diperbarui");
      setIsEditDialogOpen(false);
      setSelectedCategory(null);
      setFormData({ title: "", description: "" });
      // Reload data
      const data = await getAllBlogCategories();
      setBlogCategories(data);
    } catch (error) {
      console.error("Error updating blog category:", error);
      console.error("Gagal memperbarui kategori blog");
    }
  };

  // Handle delete
  const handleDelete = async () => {
    if (!confirm("Apakah Anda yakin ingin menghapus kategori blog ini?")) return;

    try {
      // TODO: Implement delete blog category API call
      console.log("Kategori blog berhasil dihapus");
      // Reload data
      const data = await getAllBlogCategories();
      setBlogCategories(data);
    } catch (error) {
      console.error("Error deleting blog category:", error);
      console.error("Gagal menghapus kategori blog");
    }
  };

  // Open view dialog
  const openViewDialog = (category: BlogCategory) => {
    setSelectedCategory(category);
    setIsViewDialogOpen(true);
  };

  // Open edit dialog
  const openEditDialog = (category: BlogCategory) => {
    setSelectedCategory(category);
    setFormData({
      title: category.title,
      description: category.description || "",
    });
    setIsEditDialogOpen(true);
  };

  // Open create dialog
  const openCreateDialog = () => {
    setFormData({ title: "", description: "" });
    setIsCreateDialogOpen(true);
  };

  if (loading) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
          <p className="mt-4 text-gray-600">Memuat data kategori blog...</p>
        </div>
      </div>
    );
  }

  return (
    <div className="container mx-auto p-6">
      <div className="flex justify-between items-center mb-6">
        <div>
          <h1 className="text-3xl font-bold text-gray-900">Manajemen Kategori Blog</h1>
          <p className="text-gray-600 mt-2">Kelola kategori untuk artikel blog Anda</p>
        </div>
        <Button onClick={openCreateDialog} className="flex items-center gap-2">
          <Plus className="h-4 w-4" />
          Tambah Kategori
        </Button>
      </div>

      {/* Stats Cards */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Total Kategori</CardTitle>
            <Tag className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{blogCategories.length}</div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Dengan Deskripsi</CardTitle>
            <Tag className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">
              {blogCategories.filter(cat => cat.description && cat.description.trim() !== "").length}
            </div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Bulan Ini</CardTitle>
            <Tag className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">
              {blogCategories.filter(cat => {
                const createdDate = new Date(cat._createdAt);
                const currentDate = new Date();
                return createdDate.getMonth() === currentDate.getMonth() &&
                       createdDate.getFullYear() === currentDate.getFullYear();
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
            placeholder="Cari kategori blog..."
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
            className="pl-10"
          />
        </div>
      </div>

      {/* Blog Categories Table */}
      <Card>
        <CardHeader>
          <CardTitle>Daftar Kategori Blog</CardTitle>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Nama Kategori</TableHead>
                <TableHead>Slug</TableHead>
                <TableHead>Deskripsi</TableHead>
                <TableHead>Tanggal Dibuat</TableHead>
                <TableHead>Aksi</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {filteredCategories.map((category) => (
                <TableRow key={category._id}>
                  <TableCell className="font-medium">
                    <div className="flex items-center gap-2">
                      <Tag className="h-4 w-4 text-blue-600" />
                      {category.title}
                    </div>
                  </TableCell>
                  <TableCell>
                    <Badge variant="outline" className="font-mono text-xs">
                      {category.slug?.current || "-"}
                    </Badge>
                  </TableCell>
                  <TableCell className="max-w-xs">
                    {category.description ? (
                      <p className="truncate text-sm text-gray-600">
                        {category.description}
                      </p>
                    ) : (
                      <span className="text-gray-400 text-sm">Tidak ada deskripsi</span>
                    )}
                  </TableCell>
                  <TableCell>
                    {new Date(category._createdAt).toLocaleDateString("id-ID")}
                  </TableCell>
                  <TableCell>
                    <div className="flex items-center gap-2">
                      <Button
                        variant="outline"
                        size="sm"
                        onClick={() => openViewDialog(category)}
                      >
                        <Eye className="h-4 w-4" />
                      </Button>
                      <Button
                        variant="outline"
                        size="sm"
                        onClick={() => openEditDialog(category)}
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

          {filteredCategories.length === 0 && (
            <div className="text-center py-8">
              <Tag className="h-12 w-12 text-gray-400 mx-auto mb-4" />
              <p className="text-gray-500">
                {searchTerm ? "Tidak ada kategori yang ditemukan" : "Belum ada kategori blog"}
              </p>
            </div>
          )}
        </CardContent>
      </Card>

      {/* View Blog Category Dialog */}
      <Dialog open={isViewDialogOpen} onOpenChange={setIsViewDialogOpen}>
        <DialogContent className="sm:max-w-[500px]">
          <DialogHeader>
            <DialogTitle>Detail Kategori Blog</DialogTitle>
          </DialogHeader>
          {selectedCategory && (
            <div className="space-y-4">
              <div>
                <Label className="text-sm font-medium">Nama Kategori</Label>
                <p className="text-sm text-gray-600">{selectedCategory.title}</p>
              </div>
              <div>
                <Label className="text-sm font-medium">Slug</Label>
                <p className="text-sm text-gray-600 font-mono">
                  {selectedCategory.slug?.current || "Belum ada slug"}
                </p>
              </div>
              <div>
                <Label className="text-sm font-medium">Deskripsi</Label>
                <p className="text-sm text-gray-600">
                  {selectedCategory.description || "Tidak ada deskripsi"}
                </p>
              </div>
              <div>
                <Label className="text-sm font-medium">Tanggal Dibuat</Label>
                <p className="text-sm text-gray-600">
                  {new Date(selectedCategory._createdAt).toLocaleDateString("id-ID", {
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                    hour: "2-digit",
                    minute: "2-digit",
                  })}
                </p>
              </div>
              <div>
                <Label className="text-sm font-medium">Terakhir Diperbarui</Label>
                <p className="text-sm text-gray-600">
                  {new Date(selectedCategory._updatedAt).toLocaleDateString("id-ID", {
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                    hour: "2-digit",
                    minute: "2-digit",
                  })}
                </p>
              </div>
            </div>
          )}
        </DialogContent>
      </Dialog>

      {/* Create Blog Category Dialog */}
      <Dialog open={isCreateDialogOpen} onOpenChange={setIsCreateDialogOpen}>
        <DialogContent className="sm:max-w-[500px]">
          <DialogHeader>
            <DialogTitle>Tambah Kategori Blog Baru</DialogTitle>
          </DialogHeader>
          <form onSubmit={handleCreate} className="space-y-4">
            <div>
              <Label htmlFor="title">Nama Kategori</Label>
              <Input
                id="title"
                value={formData.title}
                onChange={(e) => setFormData({ ...formData, title: e.target.value })}
                placeholder="Masukkan nama kategori"
                required
              />
              <p className="text-xs text-gray-500 mt-1">
                Slug akan dibuat otomatis berdasarkan nama kategori
              </p>
            </div>
            <div>
              <Label htmlFor="description">Deskripsi</Label>
              <Textarea
                id="description"
                value={formData.description}
                onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                placeholder="Masukkan deskripsi kategori (opsional)"
                rows={3}
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

      {/* Edit Blog Category Dialog */}
      <Dialog open={isEditDialogOpen} onOpenChange={setIsEditDialogOpen}>
        <DialogContent className="sm:max-w-[500px]">
          <DialogHeader>
            <DialogTitle>Edit Kategori Blog</DialogTitle>
          </DialogHeader>
          <form onSubmit={handleEdit} className="space-y-4">
            <div>
              <Label htmlFor="edit-title">Nama Kategori</Label>
              <Input
                id="edit-title"
                value={formData.title}
                onChange={(e) => setFormData({ ...formData, title: e.target.value })}
                placeholder="Masukkan nama kategori"
                required
              />
            </div>
            <div>
              <Label htmlFor="edit-description">Deskripsi</Label>
              <Textarea
                id="edit-description"
                value={formData.description}
                onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                placeholder="Masukkan deskripsi kategori (opsional)"
                rows={3}
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