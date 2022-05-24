<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'value',
        'description'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
