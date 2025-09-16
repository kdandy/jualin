"use client";

import { useState, useEffect } from "react";
import { getAllAuthors } from "@/sanity/queries/adminQueries";
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
import { Plus, Edit, Trash2, Search, User, Eye } from "lucide-react";
import Image from "next/image";

interface BioBlock {
  _type: string;
  children?: Array<{
    _type: string;
    text: string;
  }>;
}

interface Author {
  _id: string;
  name: string;
  slug: {
    current: string;
  };
  image?: {
    asset: {
      url: string;
    };
  };
  bio?: BioBlock[];
  _createdAt: string;
  _updatedAt: string;
}

export default function AuthorsPage() {
  const [authors, setAuthors] = useState<Author[]>([]);
  const [loading, setLoading] = useState(true);
  const [searchTerm, setSearchTerm] = useState("");
  const [isCreateDialogOpen, setIsCreateDialogOpen] = useState(false);
  const [isEditDialogOpen, setIsEditDialogOpen] = useState(false);
  const [isViewDialogOpen, setIsViewDialogOpen] = useState(false);
  const [selectedAuthor, setSelectedAuthor] = useState<Author | null>(null);
  const [formData, setFormData] = useState({
    name: "",
    imageUrl: "",
    bio: "",
  });

  // Load authors data
  useEffect(() => {
    const loadAuthors = async () => {
      try {
        setLoading(true);
        const data = await getAllAuthors();
        setAuthors(data);
      } catch (error) {
        console.error("Error loading authors:", error);
        console.error("Gagal memuat data penulis");
      } finally {
        setLoading(false);
      }
    };

    loadAuthors();
  }, []);

  // Filter authors based on search term
  const filteredAuthors = authors.filter((author) =>
    author.name.toLowerCase().includes(searchTerm.toLowerCase())
  );

  // Handle form submission for create
  const handleCreate = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      // TODO: Implement create author API call
      console.log("Penulis berhasil dibuat");
      setIsCreateDialogOpen(false);
      setFormData({ name: "", imageUrl: "", bio: "" });
      // Reload data
      const data = await getAllAuthors();
      setAuthors(data);
    } catch (error) {
      console.error("Error creating author:", error);
      console.error("Gagal membuat penulis");
    }
  };

  // Handle form submission for edit
  const handleEdit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!selectedAuthor) return;

    try {
      // TODO: Implement update author API call
      console.log("Penulis berhasil diperbarui");
      setIsEditDialogOpen(false);
      setSelectedAuthor(null);
      setFormData({ name: "", imageUrl: "", bio: "" });
      // Reload data
      const data = await getAllAuthors();
      setAuthors(data);
    } catch (error) {
      console.error("Error updating author:", error);
      console.error("Gagal memperbarui penulis");
    }
  };

  // Handle delete
  const handleDelete = async () => {
    if (!confirm("Apakah Anda yakin ingin menghapus penulis ini?")) return;

    try {
      // TODO: Implement delete author API call
      console.log("Penulis berhasil dihapus");
      // Reload data
      const data = await getAllAuthors();
      setAuthors(data);
    } catch (error) {
      console.error("Error deleting author:", error);
      console.error("Gagal menghapus penulis");
    }
  };

  // Extract bio text from block content
  const extractBioText = (bio: BioBlock[]): string => {
    if (!bio || !Array.isArray(bio)) return "";
    
    return bio
      .filter(block => block._type === "block")
      .map(block => 
        block.children
          ?.filter((child) => child._type === "span")
          ?.map((child) => child.text)
          ?.join("") || ""
      )
      .join(" ")
      .trim();
  };

  // Open view dialog
  const openViewDialog = (author: Author) => {
    setSelectedAuthor(author);
    setIsViewDialogOpen(true);
  };

  // Open edit dialog
  const openEditDialog = (author: Author) => {
    setSelectedAuthor(author);
    setFormData({
      name: author.name,
      imageUrl: author.image?.asset?.url || "",
      bio: extractBioText(author.bio || []),
    });
    setIsEditDialogOpen(true);
  };

  // Open create dialog
  const openCreateDialog = () => {
    setFormData({ name: "", imageUrl: "", bio: "" });
    setIsCreateDialogOpen(true);
  };

  if (loading) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
          <p className="mt-4 text-gray-600">Memuat data penulis...</p>
        </div>
      </div>
    );
  }

  return (
    <div className="container mx-auto p-6">
      <div className="flex justify-between items-center mb-6">
        <div>
          <h1 className="text-3xl font-bold text-gray-900">Manajemen Penulis</h1>
          <p className="text-gray-600 mt-2">Kelola penulis artikel blog Anda</p>
        </div>
        <Button onClick={openCreateDialog} className="flex items-center gap-2">
          <Plus className="h-4 w-4" />
          Tambah Penulis
        </Button>
      </div>

      {/* Stats Cards */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Total Penulis</CardTitle>
            <User className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{authors.length}</div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Dengan Foto</CardTitle>
            <User className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">
              {authors.filter(author => author.image?.asset?.url).length}
            </div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Dengan Bio</CardTitle>
            <User className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">
              {authors.filter(author => author.bio && author.bio.length > 0).length}
            </div>
          </CardContent>
        </Card>
      </div>

      {/* Search */}
      <div className="mb-6">
        <div className="relative">
          <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4" />
          <Input
            placeholder="Cari penulis..."
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
            className="pl-10"
          />
        </div>
      </div>

      {/* Authors Table */}
      <Card>
        <CardHeader>
          <CardTitle>Daftar Penulis</CardTitle>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Foto</TableHead>
                <TableHead>Nama</TableHead>
                <TableHead>Slug</TableHead>
                <TableHead>Bio</TableHead>
                <TableHead>Tanggal Dibuat</TableHead>
                <TableHead>Aksi</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {filteredAuthors.map((author) => (
                <TableRow key={author._id}>
                  <TableCell>
                    {author.image?.asset?.url ? (
                      <Image
                        src={author.image.asset.url}
                        alt={author.name}
                        width={40}
                        height={40}
                        className="rounded-full object-cover"
                      />
                    ) : (
                      <div className="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                        <User className="h-4 w-4 text-gray-400" />
                      </div>
                    )}
                  </TableCell>
                  <TableCell className="font-medium">{author.name}</TableCell>
                  <TableCell>
                    <Badge variant="outline" className="font-mono text-xs">
                      {author.slug?.current || "-"}
                    </Badge>
                  </TableCell>
                  <TableCell className="max-w-xs">
                    {author.bio && author.bio.length > 0 ? (
                      <p className="truncate text-sm text-gray-600">
                        {extractBioText(author.bio)}
                      </p>
                    ) : (
                      <span className="text-gray-400 text-sm">Tidak ada bio</span>
                    )}
                  </TableCell>
                  <TableCell>
                    {new Date(author._createdAt).toLocaleDateString("id-ID")}
                  </TableCell>
                  <TableCell>
                    <div className="flex items-center gap-2">
                      <Button
                        variant="outline"
                        size="sm"
                        onClick={() => openViewDialog(author)}
                      >
                        <Eye className="h-4 w-4" />
                      </Button>
                      <Button
                        variant="outline"
                        size="sm"
                        onClick={() => openEditDialog(author)}
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

          {filteredAuthors.length === 0 && (
            <div className="text-center py-8">
              <User className="h-12 w-12 text-gray-400 mx-auto mb-4" />
              <p className="text-gray-500">
                {searchTerm ? "Tidak ada penulis yang ditemukan" : "Belum ada penulis"}
              </p>
            </div>
          )}
        </CardContent>
      </Card>

      {/* View Author Dialog */}
      <Dialog open={isViewDialogOpen} onOpenChange={setIsViewDialogOpen}>
        <DialogContent className="sm:max-w-[600px]">
          <DialogHeader>
            <DialogTitle>Detail Penulis</DialogTitle>
          </DialogHeader>
          {selectedAuthor && (
            <div className="space-y-4">
              <div className="flex items-center gap-4">
                {selectedAuthor.image?.asset?.url ? (
                  <Image
                    src={selectedAuthor.image.asset.url}
                    alt={selectedAuthor.name}
                    width={80}
                    height={80}
                    className="rounded-full object-cover"
                  />
                ) : (
                  <div className="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center">
                    <User className="h-8 w-8 text-gray-400" />
                  </div>
                )}
                <div>
                  <h3 className="text-lg font-semibold">{selectedAuthor.name}</h3>
                  <p className="text-sm text-gray-500 font-mono">
                    {selectedAuthor.slug?.current || "Belum ada slug"}
                  </p>
                </div>
              </div>
              <div>
                <Label className="text-sm font-medium">Bio</Label>
                <div className="mt-2 p-3 bg-gray-50 rounded-md">
                  <p className="text-sm text-gray-600">
                    {selectedAuthor.bio && selectedAuthor.bio.length > 0
                      ? extractBioText(selectedAuthor.bio)
                      : "Tidak ada bio"}
                  </p>
                </div>
              </div>
              <div>
                <Label className="text-sm font-medium">Tanggal Dibuat</Label>
                <p className="text-sm text-gray-600">
                  {new Date(selectedAuthor._createdAt).toLocaleDateString("id-ID", {
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
                  {new Date(selectedAuthor._updatedAt).toLocaleDateString("id-ID", {
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

      {/* Create Author Dialog */}
      <Dialog open={isCreateDialogOpen} onOpenChange={setIsCreateDialogOpen}>
        <DialogContent className="sm:max-w-[500px]">
          <DialogHeader>
            <DialogTitle>Tambah Penulis Baru</DialogTitle>
          </DialogHeader>
          <form onSubmit={handleCreate} className="space-y-4">
            <div>
              <Label htmlFor="name">Nama Penulis</Label>
              <Input
                id="name"
                value={formData.name}
                onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                placeholder="Masukkan nama penulis"
                required
              />
              <p className="text-xs text-gray-500 mt-1">
                Slug akan dibuat otomatis berdasarkan nama
              </p>
            </div>
            <div>
              <Label htmlFor="imageUrl">URL Foto</Label>
              <Input
                id="imageUrl"
                value={formData.imageUrl}
                onChange={(e) => setFormData({ ...formData, imageUrl: e.target.value })}
                placeholder="Masukkan URL foto penulis (opsional)"
                type="url"
              />
            </div>
            <div>
              <Label htmlFor="bio">Bio</Label>
              <Textarea
                id="bio"
                value={formData.bio}
                onChange={(e) => setFormData({ ...formData, bio: e.target.value })}
                placeholder="Masukkan bio penulis (opsional)"
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

      {/* Edit Author Dialog */}
      <Dialog open={isEditDialogOpen} onOpenChange={setIsEditDialogOpen}>
        <DialogContent className="sm:max-w-[500px]">
          <DialogHeader>
            <DialogTitle>Edit Penulis</DialogTitle>
          </DialogHeader>
          <form onSubmit={handleEdit} className="space-y-4">
            <div>
              <Label htmlFor="edit-name">Nama Penulis</Label>
              <Input
                id="edit-name"
                value={formData.name}
                onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                placeholder="Masukkan nama penulis"
                required
              />
            </div>
            <div>
              <Label htmlFor="edit-imageUrl">URL Foto</Label>
              <Input
                id="edit-imageUrl"
                value={formData.imageUrl}
                onChange={(e) => setFormData({ ...formData, imageUrl: e.target.value })}
                placeholder="Masukkan URL foto penulis (opsional)"
                type="url"
              />
            </div>
            <div>
              <Label htmlFor="edit-bio">Bio</Label>
              <Textarea
                id="edit-bio"
                value={formData.bio}
                onChange={(e) => setFormData({ ...formData, bio: e.target.value })}
                placeholder="Masukkan bio penulis (opsional)"
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