<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelians = Pembelian::orderBy('created_at', 'desc')->paginate(10);
        return view('maggot.pembelian.index', compact('pembelians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('maggot.pembelian.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no' => 'required|string|unique:pembelians,no',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'qty' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $total = $request->qty * $request->harga;

        Pembelian::create([
            'no' => $request->no,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'qty' => $request->qty,
            'harga' => $request->harga,
            'total' => $total,
        ]);

        return redirect()->route('maggot.pembelian.index')->with('success', 'Data pembelian berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembelian $pembelian)
    {
        return view('maggot.pembelian.show', compact('pembelian'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembelian $pembelian)
    {
        $pembelian->delete();
        return redirect()->route('maggot.pembelian.index')->with('success', 'Data pembelian berhasil dihapus!');
    }

    /**
     * Export pembelian data to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = Pembelian::orderBy('tanggal', 'desc');
        
        // Apply date filter if provided
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }
        
        $pembelians = $query->get();
        
        $pdf = Pdf::loadView('maggot.pembelian.pdf', compact('pembelians'));
        
        return $pdf->download('laporan-pembelian-maggot-' . date('Y-m-d') . '.pdf');
    }
}
