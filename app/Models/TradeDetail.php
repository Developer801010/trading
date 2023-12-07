<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeDetail extends Model
{
    use HasFactory;

    public function trade()
    {
        return $this->belongsTo(Trade::class);
    }
}
