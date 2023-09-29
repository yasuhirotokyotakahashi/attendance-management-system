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

        if ($time->punchIn && !$time->punchOut) {
            if ($oldbreakin && !$oldbreakin->breakOut) {
                return redirect()->back()->with('message', '休憩中です')->content('');
            }
            $oldbreakin = Rest::create([
                'time_id' => $time->id,
                'breakIn' => Carbon::now(),
            ]);
            return redirect()->back()->with('message', 'ゆっくり休んでください')->content('');
        };

        if ($oldbreakin && !$oldbreakin->breakOut) {
            return redirect()->back()->with('message', '休憩中です')->content('');
        }
    }

    public function breakout()
    {
        $user = Auth::user();
        $time = Time::where('user_id', $user->id)->latest()->first();
        $oldbreakin = Rest::where('time_id', $time->id)->latest()->first();
        if ($oldbreakin && !$oldbreakin->breakOut) {
            $oldbreakin->update([
                'breakOut' => Carbon::now(),
            ]);
            return redirect()->back()->with('message', '頑張ってください')->content('');;
        }
        return redirect()->back();
    }
}
