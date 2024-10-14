<?php

namespace App\Http\Controllers;

// News adalah model yang kita buat
use App\Models\News;

class HomeController extends Controller
{
    // Menampilkan halaman utama aplikasi
    public function index()
    {
        // mengambil data berita terbaru 5 data
        $newNewss = News::latest()->take(5)->get();
        // mengirim data ke view home
        return view('home', compact('newNewss'));
    }
}

