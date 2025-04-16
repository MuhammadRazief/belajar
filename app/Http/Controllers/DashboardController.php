<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Sales;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua produk (jika perlu ditampilkan di view)
        $products = Products::all();

        // Hitung jumlah transaksi penjualan hari ini
        $today = Carbon::now()->toDateString();
        $totalSalesToday = Sales::whereDate('created_at', $today)->count();

        // Buat array untuk 7 hari ke depan dari hari ini
        $salesData = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->addDays($i)->toDateString();
            $salesCount = Sales::whereDate('created_at', $date)->count();
            $salesData[] = $salesCount;
        }

        return view('views.module.dashboard.index', compact(
            'salesData',
            'products',
            'totalSalesToday'
        ));
    }
}
