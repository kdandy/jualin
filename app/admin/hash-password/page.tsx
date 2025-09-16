'use client';

import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';

export default function HashPasswordPage() {
  const [isLoading, setIsLoading] = useState(false);
  const [result, setResult] = useState<string | null>(null);
  const [error, setError] = useState<string | null>(null);

  const testLogin = async () => {
    setIsLoading(true);
    setResult(null);
    setError(null);

    try {
      const response = await fetch('/api/admin/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          email: 'admin@jualin.com',
          password: 'Jualinyuk2025#'
        }),
      });

      const data = await response.json();
      
      if (response.ok) {
        setResult('✅ Login berhasil! Password sudah benar. Redirecting...');
        // Redirect ke dashboard
        setTimeout(() => {
          window.location.href = '/admin/dashboard';
        }, 2000);
      } else {
        setError(`❌ Login gagal: ${data.error}`);
      }
    } catch {
      setError('❌ Terjadi kesalahan saat test login');
    } finally {
      setIsLoading(false);
    }
  };

  const copyHash = () => {
    const hash = '$2b$12$VKXBhfCfsyMZMkxFsZADreaIRIhFt2yV7Q8KsyP8cGfg2KKxV5/yq';
    navigator.clipboard.writeText(hash);
    setResult('📋 Hash password berhasil di-copy!');
  };

  const openStudio = () => {
    window.open('/studio', '_blank');
  };

  return (
    <div className="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
      <div className="max-w-2xl mx-auto">
        <div className="bg-white rounded-lg shadow-md p-6">
          <h1 className="text-2xl font-bold text-gray-900 mb-6 text-center">
            Admin Password Setup
          </h1>
          
          <div className="space-y-6">
            {/* Instructions */}
            <div className="bg-blue-50 border border-blue-200 rounded-md p-4">
              <h3 className="text-lg font-medium text-blue-800 mb-3">📋 Langkah Manual Update Password:</h3>
              <ol className="text-sm text-blue-700 space-y-2 list-decimal list-inside">
                <li>Klik tombol &quot;Buka Sanity Studio&quot; di bawah</li>
                <li>Cari dan edit admin user dengan email: <strong>admin@jualin.com</strong></li>
                <li>Klik tombol &quot;Copy Hash&quot; untuk copy password hash</li>
                <li>Ganti field password dengan hash yang sudah di-copy</li>
                <li>Save perubahan di Sanity Studio</li>
                <li>Kembali ke halaman ini dan klik &quot;Test Login&quot;</li>
              </ol>
            </div>

            {/* Hash Display */}
            <div className="bg-gray-50 border border-gray-200 rounded-md p-4">
              <Label className="text-sm font-medium text-gray-700 mb-2 block">Password Hash:</Label>
              <div className="bg-white border rounded p-3 font-mono text-xs break-all">
                $2b$12$VKXBhfCfsyMZMkxFsZADreaIRIhFt2yV7Q8KsyP8cGfg2KKxV5/yq
              </div>
            </div>

            {/* Action Buttons */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-3">
              <Button
                onClick={openStudio}
                variant="outline"
                className="w-full"
              >
                🎨 Buka Sanity Studio
              </Button>

              <Button
                onClick={copyHash}
                variant="outline"
                className="w-full"
              >
                📋 Copy Hash
              </Button>

              <Button
                onClick={testLogin}
                disabled={isLoading}
                className="w-full"
              >
                {isLoading ? '🔄 Testing...' : '🧪 Test Login'}
              </Button>
            </div>

            {/* Results */}
            {result && (
              <div className="p-4 bg-green-50 border border-green-200 rounded-md">
                <p className="text-green-800 text-sm">{result}</p>
              </div>
            )}

            {error && (
              <div className="p-4 bg-red-50 border border-red-200 rounded-md">
                <p className="text-red-800 text-sm">{error}</p>
              </div>
            )}

            {/* Additional Info */}
            <div className="bg-yellow-50 border border-yellow-200 rounded-md p-4">
              <h3 className="text-sm font-medium text-yellow-800 mb-2">ℹ️ Informasi Login:</h3>
              <ul className="text-xs text-yellow-700 space-y-1">
                <li><strong>Email:</strong> admin@jualin.com</li>
                <li><strong>Password:</strong> Jualinyuk2025#</li>
                <li><strong>Admin ID:</strong> 8195eb9c-b82d-4bcb-ada6-ece611d48afe</li>
              </ul>
            </div>

            {/* Troubleshooting */}
            <div className="bg-gray-50 border border-gray-200 rounded-md p-4">
              <h3 className="text-sm font-medium text-gray-800 mb-2">🔧 Troubleshooting:</h3>
              <ul className="text-xs text-gray-600 space-y-1">
                <li>• Pastikan hash password sudah di-copy dengan benar (tanpa spasi tambahan)</li>
                <li>• Pastikan field password di Sanity Studio sudah di-save</li>
                <li>• Jika masih error, coba refresh browser dan test login lagi</li>
                <li>• Password harus persis: Jualinyuk2025# (case sensitive)</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}