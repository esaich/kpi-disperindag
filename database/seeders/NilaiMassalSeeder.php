<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bidang;
use App\Models\Pegawai;
use App\Models\Indikator;
use App\Models\Nilai;
use Illuminate\Support\Facades\DB;

class NilaiMassalSeeder extends Seeder
{
    public function run()
    {
        $file = database_path('seeders/data/nilai.csv');

        if (!file_exists($file)) {
            $this->command->error("❌ File CSV tidak ditemukan: {$file}");
            return;
        }

        // 1. Baca CSV dengan fgetcsv agar delimiter aman
        $rows = [];
        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $rows[] = $data;
            }
            fclose($handle);
        }

        if (count($rows) <= 1) {
            $this->command->error("❌ CSV kosong atau tidak terbaca.");
            return;
        }

        // 2. Ambil header (skip kolom No.)
        $header = array_map('trim', $rows[0]);
        $indicatorNames = array_slice($header, 3); // kolom 4 dst = indikator

        // Simpan indikator ke tabel
        $indikatorMap = collect($indicatorNames)->mapWithKeys(function ($name) {
            $indikator = Indikator::firstOrCreate(['nama_indikator' => $name]);
            return [$name => $indikator->indikator_id];
        });

        $dataRows = array_slice($rows, 1);

        DB::beginTransaction();
        try {
            foreach ($dataRows as $row) {
                // pastikan baris punya data minimal 3 kolom
                if (count($row) < 3) {
                    continue;
                }

                $namaPegawai = trim($row[1]); // kolom ke-2 = NAMA
                $namaBidang  = trim($row[2]); // kolom ke-3 = BIDANG
                $scores      = array_slice($row, 3);

                // Simpan bidang
                $bidang = Bidang::firstOrCreate(['nama_bidang' => $namaBidang]);

                // Simpan pegawai (pastikan bidang_id ikut diset)
                $pegawai = Pegawai::firstOrCreate(
                    ['nama' => $namaPegawai],
                    ['bidang_id' => $bidang->bidang_id]
                );

                // Simpan nilai indikator
                foreach ($scores as $i => $score) {
                    $indikatorName = $indicatorNames[$i] ?? null;
                    if (!$indikatorName) continue;

                    $indikatorId = $indikatorMap[$indikatorName];

                    if (is_numeric($score)) {
                        Nilai::updateOrCreate(
                            [
                                'pegawai_id'   => $pegawai->pegawai_id,
                                'indikator_id' => $indikatorId,
                            ],
                            [
                                'nilai' => (int) $score,
                            ]
                        );
                    }
                }

                $this->command->info("✔ Data {$namaPegawai} berhasil diinput.");
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("❌ Gagal import: " . $e->getMessage());
        }
    }
}
