<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawais';
    protected $primaryKey = 'pegawai_id';
    protected $fillable = ['nama', 'bidang_id'];

    // Relasi: Pegawai belongsTo Bidang
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id', 'bidang_id');
    }

    // Relasi: Pegawai punya banyak nilai
    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'pegawai_id', 'pegawai_id');
    }

    // Relasi many-to-many: Pegawai ↔ Indikator
    public function indikators()
    {
        return $this->belongsToMany(Indikator::class, 'nilais', 'pegawai_id', 'indikator_id')
                    ->withPivot('nilai')
                    ->withTimestamps();
    }
}
