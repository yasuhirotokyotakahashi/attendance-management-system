<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;

    protected $fillable = ['breakIn', 'breakOut', 'rest_time', 'time_id'];

    public function time()
    {
        return $this->belongsTo(Time::class);
    }
}
