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
        $time = Time::where('user_id', $user->id)->latest()->first();
        $oldbreakin = Rest::where('time_id', $time->id)->latest()->first();
        if ($time->punchIn && !$time->punchOut && !$oldbreakin->breakIn) {
            $oldbreakin = Rest::create([
                'time_id' => $oldbreakin->time_id,
                'breakIn' => Carbon::now(),
            ]);
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function breakout()
    {
        $user = Auth::user();
        $time = Time::where('user_id', $user->id)->latest()->first();
        $oldbreakin = Rest::where('time_id', $time->id)->latest()->first();
        if ($oldbreakin->breakIn && !$oldbreakin->breakOut) {
            $oldbreakin->update([
                'breakOut' => Carbon::now(),
            ]);
            return redirect()->back();
        }
        return redirect()->back();
    }
}
