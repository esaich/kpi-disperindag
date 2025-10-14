<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    
    protected $primaryKey = 'nilai_id';
    protected $fillable = ['pegawai_id', 'indikator_id', 'nilai'];

    // Relasi: Nilai belongsTo Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'pegawai_id');
    }

    // Relasi: Nilai belongsTo Indikator
    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'indikator_id', 'indikator_id');
    }
}
