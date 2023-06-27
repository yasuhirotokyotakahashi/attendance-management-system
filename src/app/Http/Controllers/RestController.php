<?php

namespace App\Http\Controllers;

use App\Models\Rest;
use App\Models\Time;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestController extends Controller
{
    //
    public function breakin()
    {
        $user = Auth::user();
        dd($user);
        $time=Time::all();
        $oldbreakin = Rest::where('time_id', $time->id)->latest()->first();
        $rest = Rest::create([
            'time_id' => $time->time_id,
            'breakIn' => Carbon::now(),
        ]);
        return redirect()->back();
    }
}
