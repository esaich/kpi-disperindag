<?php 
// Baris 1: Tag pembuka PHP

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Menampilkan halaman Beranda (Home).
     */
    public function home()
    {
        // Memuat view dari resources/views/pages/home.blade.php
        return view('pages.home');
    }

    /**
     * Menampilkan halaman Profil.
     */
    public function profil()
    {
        // Memuat view dari resources/views/pages/profil.blade.php
        return view('pages.profil');
    }

    /**
     * Menampilkan halaman Lorem.
     */
    public function struktur()
    {
        // Memuat view dari resources/views/pages.lorem.blade.php
        return view('pages.struktur');
    }

    /**
     * Menampilkan halaman Rekomendasi.
     */
   
}