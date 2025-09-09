<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Penjualan;
use App\Models\LogSheetHarian;
use App\Models\PenjualanMaggot;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get user role
        $userRole = Auth::user()->role;
        
        $data = [];
        
        // Bank Sampah data (for both admin and superadmin)
        if ($userRole == 'admin' || $userRole == 'superadmin') {
            $data['total_sampah'] = BarangMasuk::sum('qty');
            $data['total_penjualan_sampah'] = Penjualan::sum('total_penjualan');
            $data['total_transaksi_sampah'] = BarangMasuk::count() + Penjualan::count();
            
            // Recent activities for bank sampah
            $recentBarangMasuk = BarangMasuk::latest()->take(3)->get();
            $recentPenjualan = Penjualan::latest()->take(2)->get();
            
            $aktivitas = [];
            foreach ($recentBarangMasuk as $barang) {
                $aktivitas[] = [
                    'title' => 'Barang Masuk',
                    'description' => $barang->nama_barang . ' - ' . $barang->qty . ' kg',
                    'time' => $barang->created_at->diffForHumans(),
                    'icon' => 'fas fa-plus-circle',
                    'color' => 'success'
                ];
            }
            
            foreach ($recentPenjualan as $jual) {
                $aktivitas[] = [
                    'title' => 'Penjualan',
                    'description' => $jual->nama_barang . ' - Rp ' . number_format($jual->total_penjualan),
                    'time' => $jual->created_at->diffForHumans(),
                    'icon' => 'fas fa-shopping-cart',
                    'color' => 'info'
                ];
            }
            
            $data['aktivitas_terbaru'] = collect($aktivitas)->sortByDesc('time')->take(5)->values()->all();
        }
        
        // Maggot data (only for superadmin)
        if ($userRole == 'superadmin') {
            $data['total_produksi_maggot'] = PenjualanMaggot::sum('qty');
            $data['total_penjualan_maggot'] = PenjualanMaggot::sum('total');
            $data['total_log_sheet'] = LogSheetHarian::count();
            
            // Recent activities for maggot
            $recentMaggot = PenjualanMaggot::latest()->take(2)->get();
            $recentLogSheet = LogSheetHarian::latest()->take(2)->get();
            
            $aktivitasMaggot = [];
            foreach ($recentMaggot as $maggot) {
                $aktivitasMaggot[] = [
                    'title' => 'Penjualan Maggot',
                    'description' => $maggot->produk . ' - ' . $maggot->qty . ' kg',
                    'time' => $maggot->created_at->diffForHumans(),
                    'icon' => 'fas fa-bug',
                    'color' => 'success'
                ];
            }
            
            foreach ($recentLogSheet as $log) {
                $aktivitasMaggot[] = [
                    'title' => 'Log Sheet Harian',
                    'description' => 'Media: ' . $log->media . ' - Suhu: ' . $log->suhu . '°C',
                    'time' => $log->created_at->diffForHumans(),
                    'icon' => 'fas fa-clipboard-list',
                    'color' => 'warning'
                ];
            }
            
            // Merge with existing activities
            if (isset($data['aktivitas_terbaru'])) {
                $allActivities = array_merge($data['aktivitas_terbaru'], $aktivitasMaggot);
                $data['aktivitas_terbaru'] = collect($allActivities)->sortByDesc('time')->take(5)->values()->all();
            } else {
                $data['aktivitas_terbaru'] = $aktivitasMaggot;
            }
        }
        
        return view('home', compact('data'));
    }
}
