<?php

namespace App\Http\Controllers;

use App\Models\PenjualanMaggot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanMaggotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualans = PenjualanMaggot::orderBy('created_at', 'desc')->paginate(10);
        return view('maggot.penjualan.index', compact('penjualans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('maggot.penjualan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no' => 'required|string|unique:penjualans_maggot,no',
            'tanggal' => 'required|date',
            'produk' => 'required|string',
            'qty' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $total = $request->qty * $request->harga;

        PenjualanMaggot::create([
            'no' => $request->no,
            'tanggal' => $request->tanggal,
            'produk' => $request->produk,
            'qty' => $request->qty,
            'harga' => $request->harga,
            'total' => $total,
        ]);

        return redirect()->route('maggot.penjualan.index')->with('success', 'Data penjualan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PenjualanMaggot $penjualan)
    {
        return view('maggot.penjualan.show', compact('penjualan'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenjualanMaggot $penjualan)
    {
        $penjualan->delete();
        return redirect()->route('maggot.penjualan.index')->with('success', 'Data penjualan berhasil dihapus!');
    }

    /**
     * Export penjualan data to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = PenjualanMaggot::orderBy('tanggal', 'desc');
        
        // Apply date filter if provided
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }
        
        $penjualans = $query->get();
        
        $pdf = Pdf::loadView('maggot.penjualan.pdf', compact('penjualans'));
        
        return $pdf->download('laporan-penjualan-maggot-' . date('Y-m-d') . '.pdf');
    }
}
