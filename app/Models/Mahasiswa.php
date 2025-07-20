<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'nim',
        'nama',
        'alamat'
    ];

    // Accessor untuk format nama lengkap dengan NIM
    public function getNamaLengkapAttribute()
    {
        return $this->nama . ' (' . $this->nim . ')';
    }

    // Scope untuk pencarian berdasarkan nama atau NIM
    public function scopeSearch($query, $search)
    {
        return $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%");
    }
}