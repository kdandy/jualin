"use client";

import { useState, useEffect } from "react";
import { getAllBrands } from "@/sanity/queries/adminQueries";
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
import { Plus, Edit, Trash2, Search, Tag } from "lucide-react";
import Image from "next/image";

interface Brand {
  _id: string;
  title: string;
  slug: {
    current: string;
  };
  description?: string;
  image?: {
    asset: {
      url: string;
    };
  };
  _createdAt: string;
  _updatedAt: string;
}

export default function BrandsPage() {
  const [brands, setBrands] = useState<Brand[]>([]);
  const [loading, setLoading] = useState(true);
  const [searchTerm, setSearchTerm] = useState("");
  const [isCreateDialogOpen, setIsCreateDialogOpen] = useState(false);
  const [isEditDialogOpen, setIsEditDialogOpen] = useState(false);
  const [selectedBrand, setSelectedBrand] = useState<Brand | null>(null);
  const [formData, setFormData] = useState({
    title: "",
    description: "",
    image: "",
  });

  // Load brands data
  useEffect(() => {
    const loadBrands = async () => {
      try {
        setLoading(true);
        const data = await getAllBrands();
        setBrands(data);
      } catch (error) {
        console.error("Error loading brands:", error);
        console.error("Gagal memuat data brand");
      } finally {
        setLoading(false);
      }
    };

    loadBrands();
  }, []);

  // Filter brands based on search term
  const filteredBrands = brands.filter((brand) =>
    brand.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
    (brand.description && brand.description.toLowerCase().includes(searchTerm.toLowerCase()))
  );

  // Handle form submission for create
  const handleCreate = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      // TODO: Implement create brand API call
      console.log("Brand berhasil dibuat");
      setIsCreateDialogOpen(false);
      setFormData({ title: "", description: "", image: "" });
      // Reload data
      const data = await getAllBrands();
      setBrands(data);
    } catch (error) {
      console.error("Error creating brand:", error);
      console.error("Gagal membuat brand");
    }
  };

  // Handle form submission for edit
  const handleEdit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!selectedBrand) return;

    try {
      // TODO: Implement update brand API call
      console.log("Brand berhasil diperbarui");
      setIsEditDialogOpen(false);
      setSelectedBrand(null);
      setFormData({ title: "", description: "", image: "" });
      // Reload data
      const data = await getAllBrands();
      setBrands(data);
    } catch (error) {
      console.error("Error updating brand:", error);
      console.error("Gagal memperbarui brand");
    }
  };

  // Handle delete
  const handleDelete = async () => {
    if (!confirm("Apakah Anda yakin ingin menghapus brand ini?")) return;

    try {
      // TODO: Implement delete brand API call
      console.log("Brand berhasil dihapus");
      // Reload data
      const data = await getAllBrands();
      setBrands(data);
    } catch (error) {
      console.error("Error deleting brand:", error);
      console.error("Gagal menghapus brand");
    }
  };

  // Open edit dialog
  const openEditDialog = (brand: Brand) => {
    setSelectedBrand(brand);
    setFormData({
      title: brand.title,
      description: brand.description || "",
      image: brand.image?.asset?.url || "",
    });
    setIsEditDialogOpen(true);
  };

  // Open create dialog
  const openCreateDialog = () => {
    setFormData({ title: "", description: "", image: "" });
    setIsCreateDialogOpen(true);
  };

  if (loading) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
          <p className="mt-4 text-gray-600">Memuat data brand...</p>
        </div>
      </div>
    );
  }

  return (
    <div className="container mx-auto p-6">
      <div className="flex justify-between items-center mb-6">
        <div>
          <h1 className="text-3xl font-bold text-gray-900">Manajemen Brand</h1>
          <p className="text-gray-600 mt-2">Kelola brand produk Anda</p>
        </div>
        <Button onClick={openCreateDialog} className="flex items-center gap-2">
          <Plus className="h-4 w-4" />
          Tambah Brand
        </Button>
      </div>

      {/* Stats Cards */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Total Brand</CardTitle>
            <Tag className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{brands.length}</div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Brand Aktif</CardTitle>
            <Tag className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{brands.length}</div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Brand dengan Gambar</CardTitle>
            <Tag className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">
              {brands.filter(brand => brand.image).length}
            </div>
          </CardContent>
        </Card>
      </div>

      {/* Search */}
      <div className="mb-6">
        <div className="relative">
          <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4" />
          <Input
            placeholder="Cari brand..."
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
            className="pl-10"
          />
        </div>
      </div>

      {/* Brands Table */}
      <Card>
        <CardHeader>
          <CardTitle>Daftar Brand</CardTitle>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Gambar</TableHead>
                <TableHead>Nama Brand</TableHead>
                <TableHead>Slug</TableHead>
                <TableHead>Deskripsi</TableHead>
                <TableHead>Tanggal Dibuat</TableHead>
                <TableHead>Aksi</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {filteredBrands.map((brand) => (
                <TableRow key={brand._id}>
                  <TableCell>
                    {brand.image?.asset?.url ? (
                      <Image
                        src={brand.image.asset.url}
                        alt={brand.title}
                        width={40}
                        height={40}
                        className="rounded-md object-cover"
                      />
                    ) : (
                      <div className="w-10 h-10 bg-gray-200 rounded-md flex items-center justify-center">
                        <Tag className="h-4 w-4 text-gray-400" />
                      </div>
                    )}
                  </TableCell>
                  <TableCell className="font-medium">{brand.title}</TableCell>
                  <TableCell>
                    <Badge variant="secondary">{brand.slug?.current}</Badge>
                  </TableCell>
                  <TableCell className="max-w-xs truncate">
                    {brand.description || "-"}
                  </TableCell>
                  <TableCell>
                    {new Date(brand._createdAt).toLocaleDateString("id-ID")}
                  </TableCell>
                  <TableCell>
                    <div className="flex items-center gap-2">
                      <Button
                        variant="outline"
                        size="sm"
                        onClick={() => openEditDialog(brand)}
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

          {filteredBrands.length === 0 && (
            <div className="text-center py-8">
              <Tag className="h-12 w-12 text-gray-400 mx-auto mb-4" />
              <p className="text-gray-500">
                {searchTerm ? "Tidak ada brand yang ditemukan" : "Belum ada brand"}
              </p>
            </div>
          )}
        </CardContent>
      </Card>

      {/* Create Brand Dialog */}
      <Dialog open={isCreateDialogOpen} onOpenChange={setIsCreateDialogOpen}>
        <DialogContent className="sm:max-w-[425px]">
          <DialogHeader>
            <DialogTitle>Tambah Brand Baru</DialogTitle>
          </DialogHeader>
          <form onSubmit={handleCreate} className="space-y-4">
            <div>
              <Label htmlFor="title">Nama Brand</Label>
              <Input
                id="title"
                value={formData.title}
                onChange={(e) => setFormData({ ...formData, title: e.target.value })}
                placeholder="Masukkan nama brand"
                required
              />
            </div>
            <div>
              <Label htmlFor="description">Deskripsi</Label>
              <Textarea
                id="description"
                value={formData.description}
                onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                placeholder="Masukkan deskripsi brand"
                rows={3}
              />
            </div>
            <div>
              <Label htmlFor="image">URL Gambar</Label>
              <Input
                id="image"
                value={formData.image}
                onChange={(e) => setFormData({ ...formData, image: e.target.value })}
                placeholder="Masukkan URL gambar brand"
                type="url"
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

      {/* Edit Brand Dialog */}
      <Dialog open={isEditDialogOpen} onOpenChange={setIsEditDialogOpen}>
        <DialogContent className="sm:max-w-[425px]">
          <DialogHeader>
            <DialogTitle>Edit Brand</DialogTitle>
          </DialogHeader>
          <form onSubmit={handleEdit} className="space-y-4">
            <div>
              <Label htmlFor="edit-title">Nama Brand</Label>
              <Input
                id="edit-title"
                value={formData.title}
                onChange={(e) => setFormData({ ...formData, title: e.target.value })}
                placeholder="Masukkan nama brand"
                required
              />
            </div>
            <div>
              <Label htmlFor="edit-description">Deskripsi</Label>
              <Textarea
                id="edit-description"
                value={formData.description}
                onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                placeholder="Masukkan deskripsi brand"
                rows={3}
              />
            </div>
            <div>
              <Label htmlFor="edit-image">URL Gambar</Label>
              <Input
                id="edit-image"
                value={formData.image}
                onChange={(e) => setFormData({ ...formData, image: e.target.value })}
                placeholder="Masukkan URL gambar brand"
                type="url"
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