<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\BarangMasuk;
use App\Models\StokBarang;
use App\Traits\CloudinaryUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanController extends Controller
{
    use CloudinaryUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualans = Penjualan::orderBy('tanggal', 'desc')->paginate(10);
        return view('bank-sampah.penjualan.index', compact('penjualans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get available stock items from stok_barangs table
        $stokBarangs = StokBarang::where('qty', '>', 0)
            ->orderBy('nama_barang')
            ->orderBy('satuan')
            ->get()
            ->map(function($item) {
                $item->total_qty = $item->qty;
                // Combine nama_barang with satuan to make it unique
                $item->display_name = $item->nama_barang . ' (' . $item->satuan . ')';
                return $item;
            });
            
        return view('bank-sampah.penjualan.create', compact('stokBarangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'qty' => 'required|numeric|min:0.01',
            'satuan' => 'required|string|max:50',
            'harga_jual' => 'required|numeric|min:0',
            'total_penjualan' => 'required|numeric|min:0',
            'laba' => 'required|numeric',
            'stok_awal' => 'required|numeric|min:0',
            'stok_akhir' => 'required|numeric|min:0',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        // Cek stok tersedia sebelum penjualan
        $stokTersedia = $this->getStokTersedia($request->nama_barang, $request->satuan);
        if ($stokTersedia < $request->qty) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['qty' => 'Stok tidak mencukupi. Stok tersedia: ' . $stokTersedia]);
        }

        $data = $request->all();

        // Handle file upload to Cloudinary
        if ($request->hasFile('dokumen')) {
            try {
                $uploadResult = $this->handleFileUpload($request, 'dokumen', 'penjualan');
                if ($uploadResult) {
                    $data['dokumentasi'] = $uploadResult['url'];
                    $data['dokumen_public_id'] = $uploadResult['public_id'];
                }
            } catch (Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['dokumen' => 'Gagal mengupload file: ' . $e->getMessage()]);
            }
        }

        // Kurangi stok dari barang_masuk
        $this->kurangiStok($request->nama_barang, $request->satuan, $request->qty);

        Penjualan::create($data);

        return redirect()->route('bank-sampah.penjualan.index')
                        ->with('success', 'Data penjualan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        return view('bank-sampah.penjualan.show', compact('penjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        // Get available stock items from stok_barangs table
        $stokBarangs = StokBarang::where('qty', '>', 0)
            ->orderBy('nama_barang')
            ->orderBy('satuan')
            ->get()
            ->map(function($item) {
                $item->total_qty = $item->qty;
                // Combine nama_barang with satuan to make it unique
                $item->display_name = $item->nama_barang . ' (' . $item->satuan . ')';
                return $item;
            });

        return view('bank-sampah.penjualan.edit', compact('penjualan', 'stokBarangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'qty' => 'required|numeric|min:0.01',
            'satuan' => 'required|string|max:50',
            'harga_jual' => 'required|numeric|min:0.01',
            'total_penjualan' => 'required|numeric|min:0',
            'laba' => 'required|numeric',
            'stok_awal' => 'required|numeric|min:0',
            'stok_akhir' => 'required|numeric|min:0',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Kembalikan stok lama terlebih dahulu
        $this->tambahStok($penjualan->nama_barang, $penjualan->satuan, $penjualan->qty);
        
        // Cek stok tersedia untuk qty baru
        $stokTersedia = $this->getStokTersedia($request->nama_barang, $request->satuan);
        if ($stokTersedia < $request->qty) {
            // Kembalikan ke kondisi semula jika stok tidak cukup
            $this->kurangiStok($penjualan->nama_barang, $penjualan->satuan, $penjualan->qty);
            return redirect()->back()
                ->withInput()
                ->withErrors(['qty' => 'Stok tidak mencukupi. Stok tersedia: ' . $stokTersedia]);
        }

        $data = $request->except(['dokumen']);

        // Handle file upload to Cloudinary
        if ($request->hasFile('dokumen')) {
            try {
                // Delete old file from Cloudinary if exists
                if ($penjualan->dokumen_public_id) {
                    $this->deleteFromCloudinary($penjualan->dokumen_public_id);
                }
                
                $uploadResult = $this->handleFileUpload($request, 'dokumen', 'penjualan');
                if ($uploadResult) {
                    $data['dokumentasi'] = $uploadResult['url'];
                    $data['dokumen_public_id'] = $uploadResult['public_id'];
                }
            } catch (Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['dokumen' => 'Gagal mengupload file: ' . $e->getMessage()]);
            }
        }
        
        // Kurangi stok baru
        $this->kurangiStok($request->nama_barang, $request->satuan, $request->qty);

        $penjualan->update($data);

        return redirect()->route('bank-sampah.penjualan.show', $penjualan->id)
                        ->with('success', 'Data penjualan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        // Delete file from Cloudinary if exists
        if ($penjualan->dokumen_public_id) {
            try {
                $this->deleteFromCloudinary($penjualan->dokumen_public_id);
            } catch (Exception $e) {
                // Log error but don't stop deletion process
                Log::error('Failed to delete file from Cloudinary: ' . $e->getMessage());
            }
        }

        // Kembalikan stok ketika penjualan dihapus
        $this->tambahStok($penjualan->nama_barang, $penjualan->satuan, $penjualan->qty);

        $penjualan->delete();

        return redirect()->route('bank-sampah.penjualan.index')
                        ->with('success', 'Data penjualan berhasil dihapus.');
    }

    /**
      * Kurangi stok dari tabel stok_barangs
      */
     private function kurangiStok($namaBarang, $satuan, $qtyJual)
     {
         $stokBarang = StokBarang::where('nama_barang', $namaBarang)
             ->where('satuan', $satuan)
             ->first();
             
         if (!$stokBarang || $stokBarang->qty < $qtyJual) {
             throw new \Exception('Stok tidak mencukupi untuk penjualan ini.');
         }
         
         $stokBarang->qty -= $qtyJual;
         $stokBarang->save();
         
         // Jangan hapus record, biarkan qty = 0 untuk tracking
         // Record akan tetap ada dengan qty 0
     }
    
    /**
      * Tambah stok kembali ke tabel stok_barangs (untuk update/delete)
      */
     private function tambahStok($namaBarang, $satuan, $qtyTambah)
     {
         $stokBarang = StokBarang::where('nama_barang', $namaBarang)
             ->where('satuan', $satuan)
             ->first();
             
         if ($stokBarang) {
             // Tambahkan qty ke record yang sudah ada
             $stokBarang->qty += $qtyTambah;
             $stokBarang->save();
         } else {
             // Buat record baru jika belum ada
             StokBarang::create([
                 'nama_barang' => $namaBarang,
                 'satuan' => $satuan,
                 'qty' => $qtyTambah
             ]);
         }
     }
     
     /**
       * Hitung total stok tersedia untuk barang tertentu
       */
      private function getStokTersedia($namaBarang, $satuan)
      {
          $stokBarang = StokBarang::where('nama_barang', $namaBarang)
              ->where('satuan', $satuan)
              ->first();
              
          return $stokBarang ? $stokBarang->qty : 0;
      }

    /**
     * Export penjualan data to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = Penjualan::orderBy('tanggal', 'desc');
        
        // Apply date filter if provided
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }
        
        $penjualans = $query->get();
        
        $pdf = Pdf::loadView('bank-sampah.penjualan.pdf', compact('penjualans'));
        
        return $pdf->download('laporan-penjualan-' . date('Y-m-d') . '.pdf');
    }

}
