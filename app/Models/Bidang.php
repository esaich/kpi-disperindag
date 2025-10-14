<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $table = 'bidangs';
    protected $primaryKey = 'bidang_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['nama_bidang'];

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class, 'bidang_id', 'bidang_id');
    }
}
