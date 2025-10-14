<?php

namespace App\Imports;

use App\Models\Pegawai;
use App\Models\Indikator;
use App\Models\Nilai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PegawaiImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Lewati baris pertama (header Excel)
        $header = $rows->shift(); 

        foreach ($rows as $row) {
            // 1. Simpan Pegawai
            $pegawai = Pegawai::firstOrCreate([
                'nama'   => $row[0],   // kolom A
                'bidang' => $row[1],   // kolom B
            ]);

            // 2. Loop indikator mulai dari kolom ke-3 (C dst)
            foreach ($row as $key => $value) {
                if ($key < 2) continue; // skip kolom nama & bidang

                $indikatorName = $header[$key]; // nama indikator ambil dari header excel

                // 3. Pastikan indikator ada
                $indikator = Indikator::firstOrCreate([
                    'nama_indikator' => $indikatorName
                ]);

                // 4. Simpan Nilai
                Nilai::updateOrCreate(
                    [
                        'pegawai_id'   => $pegawai->id,
                        'indikator_id' => $indikator->indikator_id,
                    ],
                    [
                        'nilai' => $value ?? 0
                    ]
                );
            }
        }
    }
}
