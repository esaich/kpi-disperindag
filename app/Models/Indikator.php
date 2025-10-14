<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    use HasFactory;


    protected $primaryKey = 'indikator_id';
    protected $fillable = ['nama_indikator'];

    // Relasi: Indikator punya banyak nilai
    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'indikator_id', 'indikator_id');
    }

    // Relasi many-to-many: Indikator ↔ Pegawai
    public function pegawais()
    {
        return $this->belongsToMany(Pegawai::class, 'nilais', 'indikator_id', 'pegawai_id')
                    ->withPivot('nilai')
                    ->withTimestamps();
    }
}
