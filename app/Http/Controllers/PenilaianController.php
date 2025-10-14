<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Indikator;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    /**
     * Menampilkan daftar pegawai yang siap untuk dinilai.
     * Kita akan menggunakan view index pegawais untuk kemudahan.
     */
    public function index()
    {
        // Untuk kesederhanaan, kita akan arahkan ke index Pegawai untuk memilih siapa yang akan dinilai
        return redirect()->route('pegawais.index');
    }

    /**
     * Menampilkan form penilaian (Input 30 Nilai) untuk pegawai tertentu.
     * * @param Pegawai $pegawai
     * @return \Illuminate\View\View
     */
    public function createAssessment(Pegawai $pegawai)
    {
        // 1. Ambil semua Indikator yang ada (ada 30, sesuai skenario)
        $indikators = Indikator::all();
        
        // 2. Ambil nilai yang sudah ada untuk pegawai ini
        // Menggunakan relasi many-to-many untuk mendapatkan nilai pivot
        $existingValues = $pegawai->indikators
                                  ->pluck('pivot.nilai', 'indikator_id')
                                  ->toArray();
                                  
        // Kirim data pegawai, indikator, dan nilai yang sudah ada ke view
        return view('penilaian.create', compact('pegawai', 'indikators', 'existingValues'));
    }

    /**
     * Menyimpan atau memperbarui nilai-nilai pegawai.
     * * @param Request $request
     * @param Pegawai $pegawai
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAssessment(Request $request, Pegawai $pegawai)
    {
        // Validasi input array nilai. 'nilai.*' memastikan setiap item di array nilai divalidasi.
        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|integer|min:0|max:100', // Asumsi nilai 0-100
        ]);

        $inputNilai = $request->input('nilai', []);
        
        DB::beginTransaction();
        try {
            foreach ($inputNilai as $indikatorId => $score) {
                // Hanya proses skor yang diisi dan valid
                if (!is_null($score)) {
                    // Logika: Cari Nilai yang sudah ada atau buat baru
                    // Kemudian update kolom 'nilai' di tabel 'nilais' (tabel pivot)
                    Nilai::updateOrCreate(
                        [
                            'pegawai_id' => $pegawai->pegawai_id,
                            'indikator_id' => $indikatorId,
                        ],
                        [
                            'nilai' => $score,
                        ]
                    );
                }
            }

            DB::commit();

            return redirect()->route('pegawais.index') // Arahkan kembali ke daftar pegawai
                             ->with('success', 'Penilaian untuk pegawai ' . $pegawai->nama . ' berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Anda dapat melakukan logging error di sini
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan penilaian: ' . $e->getMessage())
                             ->withInput();
        }
    }
}
