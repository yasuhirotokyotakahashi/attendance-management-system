<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    use HasFactory;

    protected $fillable = ['punchIn', 'punchOut', 'date', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rests()
    {
        return $this->hasMany(Rest::class);
    }

    // totalRestTime メソッドを修正
    public function getTotalRestTimeAttribute()
    {
        return $this->rests->sum(function ($rest) {
            $restStart = Carbon::parse($rest->breakIn);
            $restEnd = Carbon::parse($rest->breakOut);
            return $restEnd->diffInMinutes($restStart);
        });
    }
}
