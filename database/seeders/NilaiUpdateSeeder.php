<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use App\Models\Indikator;
use App\Models\Nilai;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

class NilaiUpdateSeeder extends Seeder
{
    public function run()
    {
        $filePath = database_path('seeders/data/DATA FIX MANSOSKUL (1).xlsx');

        if (!file_exists($filePath)) {
            $this->command->error("❌ File Excel tidak ditemukan: {$filePath}");
            return;
        }

        // Baca file Excel
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        // Baris pertama = header
        $header = array_values($rows[1]); 
        $indikatorNames = array_slice($header, 2); // Kolom ke-3 dst adalah indikator

        // Simpan indikator baru jika belum ada
        $indikatorMap = collect($indikatorNames)->mapWithKeys(function ($name) {
            $indikator = Indikator::firstOrCreate(['nama_indikator' => trim($name)]);
            return [$name => $indikator->indikator_id];
        });

        DB::beginTransaction();

        try {
            // Mulai dari baris ke-2 (data pegawai)
            foreach (array_slice($rows, 1) as $row) {
                $namaPegawai = trim($row['A']);
                $namaBidang  = trim($row['B']);
                $scores      = array_slice(array_values($row), 2);

                // Cari pegawai berdasarkan nama dan bidang
                $pegawai = Pegawai::where('nama', $namaPegawai)
                    ->whereHas('bidang', function ($q) use ($namaBidang) {
                        $q->where('nama_bidang', $namaBidang);
                    })
                    ->first();

                if (!$pegawai) {
                    $this->command->warn("⚠ Pegawai {$namaPegawai} ({$namaBidang}) tidak ditemukan, dilewati.");
                    continue;
                }

                // Simpan nilai indikator
                foreach ($scores as $i => $score) {
                    $indikatorName = $indikatorNames[$i];
                    $indikatorId = $indikatorMap[$indikatorName];

                    if (is_numeric($score)) {
                        Nilai::updateOrCreate(
                            [
                                'pegawai_id' => $pegawai->pegawai_id,
                                'indikator_id' => $indikatorId,
                            ],
                            [
                                'nilai' => (int) $score,
                            ]
                        );
                    }
                }

                $this->command->info("✔ Nilai baru untuk {$namaPegawai} berhasil ditambahkan.");
            }

            DB::commit();
            $this->command->info("✅ Semua nilai indikator baru berhasil diimpor!");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("❌ Gagal import: " . $e->getMessage());
        }
    }
}
