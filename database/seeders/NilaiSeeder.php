<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use App\Models\Indikator;
use App\Models\Nilai;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = database_path('seeders/data/data_fix.csv');

        if (!file_exists($filePath)) {
            $this->command->error("❌ File tidak ditemukan di: {$filePath}");
            return;
        }

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            $this->command->error("❌ Gagal membuka file CSV.");
            return;
        }

        $header = fgetcsv($handle, 0, ','); // Baca baris pertama (header)
        if (!$header) {
            $this->command->error("❌ CSV kosong atau header tidak valid.");
            return;
        }

        // Pastikan kolom pertama dan kedua adalah Nama & Bidang
        if (count($header) < 3) {
            $this->command->error("❌ CSV minimal harus punya kolom: Nama, Bidang, dan Indikator.");
            return;
        }

        $indikatorColumns = array_slice($header, 2); // kolom setelah Bidang

        $rowCount = 0;
        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            $nama   = trim($row[0]);
            $bidang = trim($row[1]);

            if (empty($nama)) continue;

            // Simpan atau ambil Pegawai
            $pegawai = Pegawai::firstOrCreate(
                ['nama' => $nama],
                ['bidang' => $bidang]
            );

            // Loop semua indikator (kolom ke-3 dst)
            foreach ($indikatorColumns as $index => $indikatorName) {
                $nilai = isset($row[$index + 2]) ? trim($row[$index + 2]) : null;
                if ($nilai === '' || is_null($nilai)) continue;

                // Simpan atau ambil indikator
                $indikator = Indikator::firstOrCreate([
                    'nama_indikator' => $indikatorName
                ]);

                // Simpan nilai
                Nilai::updateOrCreate(
                    [
                        'pegawai_id'   => $pegawai->id,
                        'indikator_id' => $indikator->id,
                    ],
                    ['nilai' => $nilai]
                );
            }

            $rowCount++;
        }

        fclose($handle);
        $this->command->info("✅ Berhasil import {$rowCount} baris data dari CSV!");
    }
}
