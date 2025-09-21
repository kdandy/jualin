"use client";

import { useState, useEffect } from "react";
import { getAllCategories } from "@/sanity/queries/adminQueries";
import { urlFor } from "@/sanity/lib/image";
import Image from "next/image";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
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
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { Switch } from "@/components/ui/switch";
import { Plus, Search, Edit, Trash2, Eye } from "lucide-react";

interface Category {
  _id: string;
  title: string;
  slug: { current: string };
  description?: string;
  range?: number;
  featured: boolean;
  image?: { asset: { _ref: string; _type: string }; _key: string; _type: string };
  productCount: number;
}

export default function CategoriesPage() {
  const [categories, setCategories] = useState<Category[]>([]);
  const [loading, setLoading] = useState(true);
  const [searchTerm, setSearchTerm] = useState("");
  const [isCreateDialogOpen, setIsCreateDialogOpen] = useState(false);
  const [isEditDialogOpen, setIsEditDialogOpen] = useState(false);
  const [selectedCategory, setSelectedCategory] = useState<Category | null>(null);

  // Form state
  const [formData, setFormData] = useState({
    title: "",
    description: "",
    range: 0,
    featured: false,
  });

  useEffect(() => {
    const fetchCategories = async () => {
      try {
        const data = await getAllCategories(0, 100);
        setCategories(data);
      } catch (error) {
        console.error("Error fetching categories:", error);
      } finally {
        setLoading(false);
      }
    };
    fetchCategories();
  }, []);

  const filteredCategories = categories.filter((category) =>
    category.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
    category.description?.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const handleCreateCategory = async () => {
    // TODO: Implement create category functionality
    console.log("Create category:", formData);
    setIsCreateDialogOpen(false);
    resetForm();
  };

  const handleEditCategory = async () => {
    // TODO: Implement edit category functionality
    console.log("Edit category:", selectedCategory?._id, formData);
    setIsEditDialogOpen(false);
    resetForm();
  };

  const handleDeleteCategory = async (categoryId: string) => {
    // TODO: Implement delete category functionality
    console.log("Delete category:", categoryId);
  };

  const resetForm = () => {
    setFormData({
      title: "",
      description: "",
      range: 0,
      featured: false,
    });
    setSelectedCategory(null);
  };

  const openEditDialog = (category: Category) => {
    setSelectedCategory(category);
    setFormData({
      title: category.title,
      description: category.description || "",
      range: category.range || 0,
      featured: category.featured,
    });
    setIsEditDialogOpen(true);
  };

  if (loading) {
    return (
      <div className="flex items-center justify-center h-64">
        <div className="text-lg">Loading categories...</div>
      </div>
    );
  }

  return (
    <div className="p-4 md:p-6 space-y-6">
      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
          <h1 className="text-2xl md:text-3xl font-bold tracking-tight">Categories</h1>
          <p className="text-muted-foreground">
            Manage your product categories
          </p>
        </div>
        <Dialog open={isCreateDialogOpen} onOpenChange={setIsCreateDialogOpen}>
          <DialogTrigger asChild>
            <Button className="w-full sm:w-auto">
              <Plus className="mr-2 h-4 w-4" />
              Add Category
            </Button>
          </DialogTrigger>
          <DialogContent className="sm:max-w-[425px] mx-4">
            <DialogHeader>
              <DialogTitle>Create New Category</DialogTitle>
              <DialogDescription>
                Add a new category to organize your products.
              </DialogDescription>
            </DialogHeader>
            <div className="grid gap-4 py-4">
              <div className="space-y-2">
                <Label htmlFor="title">Title</Label>
                <Input
                  id="title"
                  value={formData.title}
                  onChange={(e) => setFormData({ ...formData, title: e.target.value })}
                  placeholder="Enter category title"
                />
              </div>
              <div className="space-y-2">
                <Label htmlFor="description">Description</Label>
                <Textarea
                  id="description"
                  value={formData.description}
                  onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                  placeholder="Enter category description"
                />
              </div>
              <div className="space-y-2">
                <Label htmlFor="range">Range</Label>
                <Input
                  id="range"
                  type="number"
                  value={formData.range}
                  onChange={(e) => setFormData({ ...formData, range: parseInt(e.target.value) || 0 })}
                  placeholder="Enter range value"
                />
              </div>
              <div className="flex items-center justify-between">
                <Label htmlFor="featured">Featured Category</Label>
                <Switch
                  id="featured"
                  checked={formData.featured}
                  onCheckedChange={(checked) => setFormData({ ...formData, featured: checked })}
                />
              </div>
            </div>
            <DialogFooter>
              <Button type="submit" onClick={handleCreateCategory}>
                Create Category
              </Button>
            </DialogFooter>
          </DialogContent>
        </Dialog>
      </div>

      {/* Stats Cards */}
      <div className="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Total Categories</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{categories.length}</div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Featured Categories</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">
              {categories.filter(cat => cat.featured).length}
            </div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Total Products</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">
              {categories.reduce((sum, cat) => sum + cat.productCount, 0)}
            </div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Avg Products/Category</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">
              {categories.length > 0 
                ? Math.round(categories.reduce((sum, cat) => sum + cat.productCount, 0) / categories.length)
                : 0
              }
            </div>
          </CardContent>
        </Card>
      </div>

      {/* Search and Filters */}
      <Card>
        <CardContent className="pt-6">
          <div className="flex items-center space-x-2 w-full">
            <Search className="h-4 w-4 text-muted-foreground flex-shrink-0" />
            <Input
              placeholder="Search categories..."
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
              className="flex-1"
            />
          </div>
        </CardContent>
      </Card>

      {/* Categories Table */}
      <Card>
        <CardHeader>
          <CardTitle>Categories List</CardTitle>
        </CardHeader>
        <CardContent className="p-0">
          <div className="overflow-x-auto">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead className="min-w-[80px]">Image</TableHead>
                  <TableHead className="min-w-[150px]">Title</TableHead>
                  <TableHead className="min-w-[200px]">Description</TableHead>
                  <TableHead className="min-w-[100px]">Products</TableHead>
                  <TableHead className="min-w-[80px]">Range</TableHead>
                  <TableHead className="min-w-[100px]">Status</TableHead>
                  <TableHead className="min-w-[120px]">Actions</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {filteredCategories.map((category) => (
                  <TableRow key={category._id}>
                    <TableCell>
                      {category.image ? (
                        <Image
                          src={urlFor(category.image).width(60).height(60).url()}
                          alt={category.title}
                          width={60}
                          height={60}
                          className="rounded-md object-cover flex-shrink-0"
                        />
                      ) : (
                        <div className="w-[60px] h-[60px] bg-gray-200 rounded-md flex items-center justify-center flex-shrink-0">
                          <span className="text-xs text-gray-500">No Image</span>
                        </div>
                      )}
                    </TableCell>
                    <TableCell className="font-medium">{category.title}</TableCell>
                    <TableCell className="max-w-xs truncate">
                      {category.description || "No description"}
                    </TableCell>
                    <TableCell>
                      <Badge variant="secondary">{category.productCount}</Badge>
                    </TableCell>
                    <TableCell>{category.range || "-"}</TableCell>
                    <TableCell>
                      {category.featured ? (
                        <Badge>Featured</Badge>
                      ) : (
                        <Badge variant="outline">Regular</Badge>
                      )}
                    </TableCell>
                    <TableCell>
                      <div className="flex items-center space-x-2">
                        <Button
                          variant="ghost"
                          size="sm"
                          onClick={() => window.open(`/category/${category.slug.current}`, '_blank')}
                        >
                          <Eye className="h-4 w-4" />
                        </Button>
                        <Button
                          variant="ghost"
                          size="sm"
                          onClick={() => openEditDialog(category)}
                        >
                          <Edit className="h-4 w-4" />
                        </Button>
                        <Button
                          variant="ghost"
                          size="sm"
                          onClick={() => handleDeleteCategory(category._id)}
                        >
                          <Trash2 className="h-4 w-4" />
                        </Button>
                      </div>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </div>
          {filteredCategories.length === 0 && (
            <div className="text-center py-8 text-muted-foreground">
              No categories found.
            </div>
          )}
        </CardContent>
      </Card>

      {/* Edit Dialog */}
      <Dialog open={isEditDialogOpen} onOpenChange={setIsEditDialogOpen}>
        <DialogContent className="sm:max-w-[425px]">
          <DialogHeader>
            <DialogTitle>Edit Category</DialogTitle>
            <DialogDescription>
              Make changes to the category information.
            </DialogDescription>
          </DialogHeader>
          <div className="grid gap-4 py-4">
            <div className="grid grid-cols-4 items-center gap-4">
              <Label htmlFor="edit-title" className="text-right">
                Title
              </Label>
              <Input
                id="edit-title"
                value={formData.title}
                onChange={(e) => setFormData({ ...formData, title: e.target.value })}
                className="col-span-3"
              />
            </div>
            <div className="grid grid-cols-4 items-center gap-4">
              <Label htmlFor="edit-description" className="text-right">
                Description
              </Label>
              <Textarea
                id="edit-description"
                value={formData.description}
                onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                className="col-span-3"
              />
            </div>
            <div className="grid grid-cols-4 items-center gap-4">
              <Label htmlFor="edit-range" className="text-right">
                Range
              </Label>
              <Input
                id="edit-range"
                type="number"
                value={formData.range}
                onChange={(e) => setFormData({ ...formData, range: parseInt(e.target.value) || 0 })}
                className="col-span-3"
              />
            </div>
            <div className="grid grid-cols-4 items-center gap-4">
              <Label htmlFor="edit-featured" className="text-right">
                Featured
              </Label>
              <Switch
                id="edit-featured"
                checked={formData.featured}
                onCheckedChange={(checked) => setFormData({ ...formData, featured: checked })}
              />
            </div>
          </div>
          <DialogFooter>
            <Button type="submit" onClick={handleEditCategory}>
              Save Changes
            </Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>
    </div>
  );
}