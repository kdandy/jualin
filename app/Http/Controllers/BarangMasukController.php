<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\StokBarang;
use App\Traits\CloudinaryUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangMasukController extends Controller
{
    use CloudinaryUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangMasuks = BarangMasuk::orderBy('tanggal', 'desc')->paginate(10);
        return view('bank-sampah.barang-masuk.index', compact('barangMasuks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bank-sampah.barang-masuk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'pemasok' => 'required|string|max:255',
            'barang' => 'required|array|min:1',
            'barang.*.nama_barang' => 'required|string|max:255',
            'barang.*.qty' => 'required|numeric|min:0',
            'barang.*.satuan' => 'required|in:kg,pcs,liter',
            'barang.*.harga_beli' => 'required|numeric|min:0',
            'dokumentasi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $dokumentasiData = [];
        
        // Handle file upload to Cloudinary
        if ($request->hasFile('dokumentasi')) {
            try {
                $uploadResult = $this->handleFileUpload($request, 'dokumentasi', 'barang-masuk');
                if ($uploadResult) {
                    $dokumentasiData['dokumentasi'] = $uploadResult['url'];
                    $dokumentasiData['dokumentasi_public_id'] = $uploadResult['public_id'];
                }
            } catch (Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['dokumentasi' => 'Gagal mengupload file: ' . $e->getMessage()]);
            }
        }

        $createdItems = [];
        
        // Loop through each barang item and create separate records
        foreach ($request->barang as $barangData) {
            $data = [
                'tanggal' => $request->tanggal,
                'pemasok' => $request->pemasok,
                'nama_barang' => $barangData['nama_barang'],
                'qty' => $barangData['qty'],
                'satuan' => $barangData['satuan'],
                'harga_beli' => $barangData['harga_beli'],
                'total_pembelian' => $barangData['qty'] * $barangData['harga_beli']
            ];
            
            // Add dokumentasi data to each item
            $data = array_merge($data, $dokumentasiData);
            
            $barangMasuk = BarangMasuk::create($data);
            $createdItems[] = $barangMasuk;
            
            // Tambah stok barang setelah barang masuk dibuat
            $this->tambahStokBarang($barangMasuk->nama_barang, $barangMasuk->satuan, $barangMasuk->qty);
        }

        $itemCount = count($createdItems);
        return redirect()->route('bank-sampah.barang-masuk.index')
                        ->with('success', "Berhasil menambahkan {$itemCount} item barang masuk dan stok telah diperbarui.");
    }

    /**
     * Display the specified resource.
     */
    public function show(BarangMasuk $barangMasuk)
    {
        return view('bank-sampah.barang-masuk.show', compact('barangMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarangMasuk $barangMasuk)
    {
        return view('bank-sampah.barang-masuk.edit', compact('barangMasuk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'pemasok' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'qty' => 'required|numeric|min:0',
            'satuan' => 'required|in:kg,pcs,liter',
            'harga_beli' => 'required|numeric|min:0',
            'dokumentasi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Store old values for stock adjustment
        $oldQty = $barangMasuk->qty;
        $oldNamaBarang = $barangMasuk->nama_barang;
        $oldSatuan = $barangMasuk->satuan;

        $data = [
            'tanggal' => $request->tanggal,
            'pemasok' => $request->pemasok,
            'nama_barang' => $request->nama_barang,
            'qty' => $request->qty,
            'satuan' => $request->satuan,
            'harga_beli' => $request->harga_beli,
            'total_pembelian' => $request->qty * $request->harga_beli
        ];

        // Handle file upload to Cloudinary
        if ($request->hasFile('dokumentasi')) {
            try {
                // Delete old file if exists
                if ($barangMasuk->dokumentasi_public_id) {
                    $this->deleteFromCloudinary($barangMasuk->dokumentasi_public_id);
                }
                
                $uploadResult = $this->handleFileUpload($request, 'dokumentasi', 'barang-masuk');
                if ($uploadResult) {
                    $data['dokumentasi'] = $uploadResult['url'];
                    $data['dokumentasi_public_id'] = $uploadResult['public_id'];
                }
            } catch (Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['dokumentasi' => 'Gagal mengupload file: ' . $e->getMessage()]);
            }
        }

        // Adjust stock: remove old quantity and add new quantity
        $this->kurangiStokBarang($oldNamaBarang, $oldSatuan, $oldQty);
        $this->tambahStokBarang($request->nama_barang, $request->satuan, $request->qty);

        $barangMasuk->update($data);

        return redirect()->route('bank-sampah.barang-masuk.index')
                        ->with('success', 'Data barang masuk berhasil diperbarui dan stok telah disesuaikan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangMasuk $barangMasuk)
    {
        // Delete file from Cloudinary if exists
        if ($barangMasuk->dokumentasi_public_id) {
            try {
                $this->deleteFromCloudinary($barangMasuk->dokumentasi_public_id);
            } catch (Exception $e) {
                // Log error but don't stop deletion process
                Log::error('Failed to delete file from Cloudinary: ' . $e->getMessage());
            }
        }
        
        // Kurangi stok barang sebelum menghapus barang masuk
        $this->kurangiStokBarang($barangMasuk->nama_barang, $barangMasuk->satuan, $barangMasuk->qty);
        
        $barangMasuk->delete();

        return redirect()->route('bank-sampah.barang-masuk.index')
                        ->with('success', 'Data barang masuk berhasil dihapus dan stok telah diperbarui.');
    }
    
    /**
     * Kurangi stok dari tabel stok_barangs ketika barang masuk dihapus
     */
    private function kurangiStokBarang($namaBarang, $satuan, $qtyKurang)
    {
        $stokBarang = StokBarang::where('nama_barang', $namaBarang)
            ->where('satuan', $satuan)
            ->first();
            
        if ($stokBarang) {
            // Kurangi qty dari record yang ada
            $stokBarang->qty -= $qtyKurang;
            
            // Jika qty menjadi 0 atau negatif, hapus record
            if ($stokBarang->qty <= 0) {
                $stokBarang->delete();
            } else {
                $stokBarang->save();
            }
        }
     }
     
     /**
      * Tambah stok ke tabel stok_barangs ketika barang masuk dibuat
      */
     private function tambahStokBarang($namaBarang, $satuan, $qtyTambah)
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
     * Export barang masuk data to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = BarangMasuk::orderBy('tanggal', 'desc');
        
        // Apply date filter if provided
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }
        
        $barangMasuks = $query->get();
        
        $pdf = Pdf::loadView('bank-sampah.barang-masuk.pdf', compact('barangMasuks'));
        
        return $pdf->download('laporan-barang-masuk-' . date('Y-m-d') . '.pdf');
    }
}
