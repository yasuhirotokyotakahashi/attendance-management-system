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
        $lastBreakIn = Rest::where('time_id', $time->id)->latest()->first();

        if ($time->punchIn && !$time->punchOut) {
            if ($lastBreakIn && !$lastBreakIn->breakOut) {
                return redirect()->back()->with('message', '休憩中です');
            }

            Rest::create([
                'time_id' => $time->id,
                'breakIn' => Carbon::now(),
            ]);

            return redirect()->back()->with('message', 'ゆっくり休んでください');
        }

        if ($lastBreakIn && !$lastBreakIn->breakOut) {
            return redirect()->back()->with('message', '休憩中です');
        }

        return redirect()->back();
    }

    public function breakout()
    {
        $user = Auth::user();
        $time = Time::where('user_id', $user->id)->latest()->first();
        $lastBreakIn = Rest::where('time_id', $time->id)->latest()->first();

        if ($lastBreakIn && !$lastBreakIn->breakOut) {
            $lastBreakIn->update([
                'breakOut' => Carbon::now(),
            ]);

            return redirect()->back()->with('message', '頑張ってください');
        }

        return redirect()->back();
    }
}
