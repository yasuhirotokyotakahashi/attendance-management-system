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
        if ($oldbreakin)
            if ($time->punchIn && !$time->punchOut) {
                $oldbreakin = Rest::create([
                    'time_id' => $time->id,
                    'breakIn' => Carbon::now(),
                ]);
                return redirect()->back();
            }
        $oldbreakin = Rest::create([
            'time_id' => $time->id,
            'breakIn' => Carbon::now(),
        ]);

        return redirect()->back();
    }

    public function breakout()
    {
        $user = Auth::user();
        $time = Time::where('user_id', $user->id)->latest()->first();
        $oldbreakin = Rest::where('time_id', $time->id)->latest()->first();
        $breakIn = new Carbon($oldbreakin->breakIn);
        $breakOut = new Carbon($oldbreakin->breakOut);
        $rest_time = $breakIn->diffInMinutes($breakOut);
        if ($oldbreakin->breakIn && !$oldbreakin->breakOut) {
            $oldbreakin->update([
                'breakOut' => Carbon::now(),
                'rest_time' => $rest_time,
            ]);
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function performance()
    {
        // $items = Rest::with('time.user')->paginate(5);

        $items = Rest::with('time')->with('time.user')->get();


        $items = $items->sortBy('time.date')->values();








        return view('daily', compact('items'));
    }
}
