<?php

namespace App\Http\Controllers;

use App\Models\LogSheetHarian;
use App\Traits\CloudinaryUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class LogSheetHarianController extends Controller
{
    use CloudinaryUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logSheets = LogSheetHarian::orderBy('tanggal', 'desc')->paginate(10);
        return view('maggot.log-sheet-harian.index', compact('logSheets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faseKehidupan = LogSheetHarian::getFaseKehidupan();
        return view('maggot.log-sheet-harian.create', compact('faseKehidupan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'media' => 'nullable|string|max:255',
            'suhu' => 'required|numeric|min:0|max:100',
            'kelembapan' => 'required|numeric|min:0|max:100',
            'berat_limbah' => 'required|numeric|min:0',
            'fase_kehidupan' => 'required|string',
            'jenis_sampah' => 'nullable|string|max:255',
            'berat_kasgot' => 'required|numeric|min:0',
            'dokumentasi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();

        // Handle file upload to Cloudinary
        if ($request->hasFile('dokumentasi')) {
            try {
                $uploadResult = $this->handleFileUpload($request, 'dokumentasi', 'maggot/log-sheet');
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

        LogSheetHarian::create($data);

        return redirect()->route('maggot.log-sheet-harian.index')
                        ->with('success', 'Data log sheet harian berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LogSheetHarian $logSheetHarian)
    {
        return view('maggot.log-sheet-harian.show', compact('logSheetHarian'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LogSheetHarian $logSheetHarian)
    {
        // Delete file from Cloudinary if exists
        if ($logSheetHarian->dokumentasi_public_id) {
            try {
                $this->deleteFromCloudinary($logSheetHarian->dokumentasi_public_id);
            } catch (Exception $e) {
                // Log error but don't stop deletion process
                Log::error('Failed to delete file from Cloudinary: ' . $e->getMessage());
            }
        }
        
        $logSheetHarian->delete();

        return redirect()->route('maggot.log-sheet-harian.index')
                        ->with('success', 'Data log sheet harian berhasil dihapus.');
    }
}