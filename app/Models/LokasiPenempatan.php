<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiPenempatan extends Model
{
    use HasFactory;
    protected $guarded = 'id';

    public function RadiusKantor()
    {
        return $this->hasMany(RadiusKantor::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
