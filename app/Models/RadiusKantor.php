<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadiusKantor extends Model
{
    use HasFactory;

    protected $with = 'lokasiPenempatan';
    protected $guarded = [
        'id',
    ];

    public function lokasiPenempatan()
    {
        return $this->belongsTo(LokasiPenempatan::class);
    }
}
