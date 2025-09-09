<?php

namespace App\Http\Controllers;

use App\Models\StokBarang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class StokBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get stock data from stok_barangs table
        $stokBarangs = StokBarang::where('qty', '>', 0)
            ->orderBy('nama_barang')
            ->paginate(10)
            ->through(function($item) {
                $item->total_qty = $item->qty;
                return $item;
            });
            
        return view('bank-sampah.stok-barang.index', compact('stokBarangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StokBarang $stokBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StokBarang $stokBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StokBarang $stokBarang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StokBarang $stokBarang)
    {
        //
    }
}
