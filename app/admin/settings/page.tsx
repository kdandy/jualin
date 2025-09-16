"use client"

import { useState, useEffect } from "react"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Switch } from "@/components/ui/switch"
import { Badge } from "@/components/ui/badge"
import { Separator } from "@/components/ui/separator"
import { 
  User, 
  Shield, 
  Key,
  Loader2
} from "lucide-react"
import { AdminUser } from "@/lib/admin-auth"

interface SecuritySettings {
  enableTwoFactor: boolean
  emailNotifications: boolean
  loginAlerts: boolean
  sessionTimeout: string
}

export default function AdminSettingsPage() {
  const [isLoading, setIsLoading] = useState(false)
  const [isEditing, setIsEditing] = useState(false)
  const [adminProfile, setAdminProfile] = useState<AdminUser | null>(null)
  
  const [securitySettings, setSecuritySettings] = useState<SecuritySettings>({
    enableTwoFactor: false,
    emailNotifications: true,
    loginAlerts: true,
    sessionTimeout: "24"
  })

  const [passwordChange, setPasswordChange] = useState({
    currentPassword: "",
    newPassword: "",
    confirmPassword: ""
  })

  // Load admin profile from API
  useEffect(() => {
    const fetchAdminProfile = async () => {
      setIsLoading(true)
      try {
        const response = await fetch('/api/admin/me', {
          method: 'GET',
          credentials: 'include',
        })

        if (response.ok) {
           const data = await response.json()
           setAdminProfile(data.admin)
         } else {
          console.error('Failed to fetch admin profile')
        }
      } catch (error) {
        console.error('Error fetching admin profile:', error)
      } finally {
        setIsLoading(false)
      }
    }

    fetchAdminProfile()
  }, [])

  const handleProfileChange = (field: keyof AdminUser, value: string) => {
    if (!adminProfile) return
    setAdminProfile(prev => prev ? ({
      ...prev,
      [field]: value
    }) : null)
  }

  const handleSecurityChange = (field: string, value: string | boolean) => {
    setSecuritySettings(prev => ({
      ...prev,
      [field]: value
    }))
  }

  const handlePasswordChange = (field: string, value: string) => {
    setPasswordChange(prev => ({
      ...prev,
      [field]: value
    }))
  }

  const handleSaveProfile = async () => {
    if (!adminProfile) return
    
    setIsLoading(true)
    try {
      // Note: In a real implementation, you would need an API endpoint to update admin profile
      // For now, we'll just save security settings to localStorage
      localStorage.setItem('admin_security', JSON.stringify(securitySettings))
      
      console.log('Settings saved successfully!')
      setIsEditing(false)
    } catch (error) {
      console.error('Error saving settings:', error)
    } finally {
      setIsLoading(false)
    }
  }

  const handleChangePassword = async () => {
    // Validate inputs
    if (!passwordChange.currentPassword) {
      alert('Password saat ini harus diisi')
      return
    }

    if (!passwordChange.newPassword) {
      alert('Password baru harus diisi')
      return
    }

    if (passwordChange.newPassword !== passwordChange.confirmPassword) {
      alert('Konfirmasi password tidak cocok')
      return
    }

    // Validate password strength (client-side basic validation)
    const errors = []
    if (passwordChange.newPassword.length < 12) errors.push('minimal 12 karakter')
    if (!/[A-Z]/.test(passwordChange.newPassword)) errors.push('huruf besar')
    if (!/[a-z]/.test(passwordChange.newPassword)) errors.push('huruf kecil')
    if (!/[0-9]/.test(passwordChange.newPassword)) errors.push('angka')
    if (!/[!@#$%^&*(),.?":{}|<>]/.test(passwordChange.newPassword)) errors.push('karakter khusus')
    
    if (errors.length > 0) {
      alert(`Password tidak memenuhi persyaratan: ${errors.join(', ')}`)
      return
    }

    setIsLoading(true)
    try {
      const response = await fetch('/api/admin/change-password', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        credentials: 'include',
        body: JSON.stringify({
          currentPassword: passwordChange.currentPassword,
          newPassword: passwordChange.newPassword
        }),
      })

      const data = await response.json()

      if (response.ok) {
        alert('Password berhasil diubah!')
        setPasswordChange({
          currentPassword: "",
          newPassword: "",
          confirmPassword: ""
        })
      } else {
        alert(data.error || 'Gagal mengubah password')
      }
    } catch (error) {
      console.error('Error changing password:', error)
      alert('Terjadi kesalahan server. Silakan coba lagi.')
    } finally {
      setIsLoading(false)
    }
  }

  if (isLoading && !adminProfile) {
    return (
      <div className="flex items-center justify-center min-h-[400px]">
        <Loader2 className="h-8 w-8 animate-spin text-blue-600" />
      </div>
    )
  }

  if (!adminProfile) {
    return (
      <div className="text-center py-8">
        <p className="text-gray-600">Gagal memuat data admin</p>
      </div>
    )
  }

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-bold tracking-tight">Pengaturan Admin</h1>
          <p className="text-muted-foreground">
            Kelola profil dan pengaturan keamanan akun admin Anda
          </p>
        </div>
        <div className="flex gap-2">
          {isEditing ? (
            <>
              <Button variant="outline" onClick={() => setIsEditing(false)}>
                Batal
              </Button>
              <Button onClick={handleSaveProfile} disabled={isLoading}>
                {isLoading ? "Menyimpan..." : "Simpan"}
              </Button>
            </>
          ) : (
            <Button onClick={() => setIsEditing(true)}>
              Edit Profil
            </Button>
          )}
        </div>
      </div>

      <div className="grid gap-6 lg:grid-cols-2">
        {/* Profile Information */}
        <Card>
          <CardHeader>
            <CardTitle className="flex items-center gap-2">
              <User className="h-5 w-5" />
              Informasi Profil
            </CardTitle>
            <CardDescription>
              Informasi dasar akun administrator
            </CardDescription>
          </CardHeader>
          <CardContent className="space-y-4">
            {/* Avatar */}
            <div className="flex items-center gap-4">
              <div className="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                <span className="text-white font-medium text-xl">
                  {adminProfile.name.charAt(0).toUpperCase()}
                </span>
              </div>
              <div className="flex-1">
                <p className="font-medium">{adminProfile.name}</p>
                <p className="text-sm text-muted-foreground">{adminProfile.email}</p>
                <Badge variant={adminProfile.role === 'super_admin' ? 'default' : 'secondary'} className="mt-1">
                  {adminProfile.role === 'super_admin' ? 'Super Admin' : 'Admin'}
                </Badge>
              </div>

            </div>

            <Separator />

            <div className="space-y-4">
              <div className="space-y-2">
                <Label htmlFor="name">Nama Lengkap</Label>
                <Input
                  id="name"
                  value={adminProfile.name}
                  onChange={(e) => handleProfileChange('name', e.target.value)}
                  disabled={!isEditing}
                />
              </div>

              <div className="space-y-2">
                <Label htmlFor="email">Email</Label>
                <Input
                  id="email"
                  type="email"
                  value={adminProfile.email}
                  onChange={(e) => handleProfileChange('email', e.target.value)}
                  disabled={!isEditing}
                />
              </div>

              <div className="space-y-2">
                <Label htmlFor="role">Role</Label>
                <Input
                  id="role"
                  value={adminProfile.role}
                  disabled
                  className="bg-gray-100"
                />
              </div>

              <div className="space-y-2">
                <Label>Status</Label>
                <div className="flex items-center space-x-2">
                  <div className={`w-3 h-3 rounded-full ${adminProfile.id ? 'bg-green-500' : 'bg-red-500'}`}></div>
                  <span className="text-sm text-gray-600">
                    {adminProfile.id ? 'Aktif' : 'Tidak Aktif'}
                  </span>
                </div>
              </div>
            </div>

            {/* Account Info */}
            <Separator />
            <div className="space-y-2 text-sm text-muted-foreground">
              <p>ID Admin: <span className="font-mono">{adminProfile.id}</span></p>
              <p>Akun dibuat: {adminProfile.createdAt ? new Date(adminProfile.createdAt).toLocaleString('id-ID') : 'Tidak diketahui'}</p>
            </div>
          </CardContent>
        </Card>

        {/* Security Settings */}
        <div className="space-y-6">
          <Card>
            <CardHeader>
              <CardTitle className="flex items-center gap-2">
                <Shield className="h-5 w-5" />
                Pengaturan Keamanan
              </CardTitle>
              <CardDescription>
                Kelola pengaturan keamanan akun Anda
              </CardDescription>
            </CardHeader>
            <CardContent className="space-y-4">
              <div className="flex items-center justify-between">
                <div className="space-y-0.5">
                  <Label>Autentikasi Dua Faktor</Label>
                  <p className="text-sm text-muted-foreground">
                    Tambahkan lapisan keamanan ekstra
                  </p>
                </div>
                <Switch
                  checked={securitySettings.enableTwoFactor}
                  onCheckedChange={(checked) => handleSecurityChange('enableTwoFactor', checked)}
                />
              </div>

              <Separator />

              <div className="flex items-center justify-between">
                <div className="space-y-0.5">
                  <Label>Notifikasi Email</Label>
                  <p className="text-sm text-muted-foreground">
                    Terima notifikasi melalui email
                  </p>
                </div>
                <Switch
                  checked={securitySettings.emailNotifications}
                  onCheckedChange={(checked) => handleSecurityChange('emailNotifications', checked)}
                />
              </div>

              <Separator />

              <div className="flex items-center justify-between">
                <div className="space-y-0.5">
                  <Label>Alert Login</Label>
                  <p className="text-sm text-muted-foreground">
                    Notifikasi saat ada login baru
                  </p>
                </div>
                <Switch
                  checked={securitySettings.loginAlerts}
                  onCheckedChange={(checked) => handleSecurityChange('loginAlerts', checked)}
                />
              </div>

              <Separator />

              <div className="space-y-2">
                <Label htmlFor="sessionTimeout">Timeout Sesi (jam)</Label>
                <Input
                  id="sessionTimeout"
                  type="number"
                  value={securitySettings.sessionTimeout}
                  onChange={(e) => handleSecurityChange('sessionTimeout', e.target.value)}
                  min="1"
                  max="168"
                />
              </div>
            </CardContent>
          </Card>

          {/* Change Password */}
          <Card>
            <CardHeader>
              <CardTitle className="flex items-center gap-2">
                <Key className="h-5 w-5" />
                Ubah Password
              </CardTitle>
              <CardDescription>
                Perbarui password untuk keamanan yang lebih baik
              </CardDescription>
            </CardHeader>
            <CardContent className="space-y-4">
              <div className="space-y-2">
                <Label htmlFor="currentPassword">Password Saat Ini</Label>
                <Input
                  id="currentPassword"
                  type="password"
                  value={passwordChange.currentPassword}
                  onChange={(e) => handlePasswordChange('currentPassword', e.target.value)}
                />
              </div>

              <div className="space-y-2">
                <Label htmlFor="newPassword">Password Baru</Label>
                <Input
                  id="newPassword"
                  type="password"
                  value={passwordChange.newPassword}
                  onChange={(e) => handlePasswordChange('newPassword', e.target.value)}
                />
                {passwordChange.newPassword && (
                  <div className="text-xs space-y-1 mt-2">
                    <p className="font-medium text-gray-700">Persyaratan Password:</p>
                    <div className="space-y-1">
                      <div className={`flex items-center gap-2 ${passwordChange.newPassword.length >= 12 ? 'text-green-600' : 'text-red-500'}`}>
                        <span className="w-1 h-1 rounded-full bg-current"></span>
                        Minimal 12 karakter
                      </div>
                      <div className={`flex items-center gap-2 ${/[A-Z]/.test(passwordChange.newPassword) ? 'text-green-600' : 'text-red-500'}`}>
                        <span className="w-1 h-1 rounded-full bg-current"></span>
                        Huruf besar (A-Z)
                      </div>
                      <div className={`flex items-center gap-2 ${/[a-z]/.test(passwordChange.newPassword) ? 'text-green-600' : 'text-red-500'}`}>
                        <span className="w-1 h-1 rounded-full bg-current"></span>
                        Huruf kecil (a-z)
                      </div>
                      <div className={`flex items-center gap-2 ${/[0-9]/.test(passwordChange.newPassword) ? 'text-green-600' : 'text-red-500'}`}>
                        <span className="w-1 h-1 rounded-full bg-current"></span>
                        Angka (0-9)
                      </div>
                      <div className={`flex items-center gap-2 ${/[!@#$%^&*(),.?":{}|<>]/.test(passwordChange.newPassword) ? 'text-green-600' : 'text-red-500'}`}>
                        <span className="w-1 h-1 rounded-full bg-current"></span>
                        Karakter khusus (!@#$%^&*)
                      </div>
                    </div>
                  </div>
                )}
              </div>

              <div className="space-y-2">
                <Label htmlFor="confirmPassword">Konfirmasi Password Baru</Label>
                <Input
                  id="confirmPassword"
                  type="password"
                  value={passwordChange.confirmPassword}
                  onChange={(e) => handlePasswordChange('confirmPassword', e.target.value)}
                />
              </div>

              <Button 
                onClick={handleChangePassword} 
                disabled={isLoading || !passwordChange.currentPassword || !passwordChange.newPassword}
                className="w-full"
              >
                {isLoading ? "Mengubah..." : "Ubah Password"}
              </Button>
            </CardContent>
          </Card>
        </div>
      </div>
    </div>
  )
}