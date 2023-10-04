<?php

namespace App\Http\Controllers;

use App\Models\Time;
use App\Models\User;
use App\Models\Rest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimeController extends Controller
{
    //
    public function index()
    {
        return view('time.index');
    }

    public function timein()
    {
        $user = Auth::user();
        $lastTimeIn = Time::where('user_id', $user->id)->latest()->first();

        $today = Carbon::today();
        $lastDay = $lastTimeIn ? Carbon::parse($lastTimeIn->punchIn)->startOfDay() : null;

        if ($lastDay == $today && empty($lastTimeIn->punchOut)) {
            return redirect()->back()->with('message', '出勤打刻済みです');
        }

        if ($lastTimeIn) {
            $lastDay = Carbon::parse($lastTimeIn->punchOut)->startOfDay();
        }

        if ($lastDay == $today) {
            return redirect()->back()->with('message', '退勤打刻済みです');
        }

        Time::create([
            'user_id' => $user->id,
            'punchIn' => Carbon::now(),
            'date' => $today,
        ]);

        return redirect()->back();
    }

    public function timeout()
    {
        $user = Auth::user();
        $timeOut = Time::where('user_id', $user->id)->latest()->first();

        if ($timeOut) {
            if (empty($timeOut->punchOut)) {
                $timeOut->update([
                    'punchOut' => Carbon::now(),
                ]);

                return redirect()->back()->with('message', 'お疲れ様でした');
            } else {
                $today = Carbon::today();
                $date = $today->day;
                $oldPunchOutDay = Carbon::parse($timeOut->punchOut)->day;

                if ($date == $oldPunchOutDay) {
                    return redirect()->back()->with('message', '退勤済みです');
                } else {
                    return redirect()->back()->with('message', '出勤打刻がされていません');
                }
            }
        }
    }

    public function performance(Request $request)
    {
        $selectedDate = $request->input('date') ? Carbon::parse($request->input('date')) : Carbon::today();

        $items = Time::with('rests')->with('user')->whereDate('date', $selectedDate)->orderBy('date')->paginate(5);

        $processedItems = $items->map(function ($item) {
            $workStart = Carbon::parse($item->punchIn);
            $workEnd = Carbon::parse($item->punchOut);

            $rests = Rest::where('time_id', $item->id)->get();
            $totalRestDifference = $rests->sum(function ($rest) {
                $restStart = Carbon::parse($rest->breakIn);
                $restEnd = Carbon::parse($rest->breakOut);
                return $restEnd->diffInMinutes($restStart);
            });

            $workDifference = $workEnd->diffInMinutes($workStart);
            $actualWorkingMinutes = $workDifference - $totalRestDifference;

            return [
                'item' => $item,
                'workDifference' => $workDifference,
                'totalRestDifference' => sprintf('%02d:%02d:%02d', intdiv($totalRestDifference, 60), $totalRestDifference % 60, 0),
                'actualWorkingTime' => sprintf('%02d:%02d:%02d', intdiv($actualWorkingMinutes, 60), $actualWorkingMinutes % 60, 0),
                'restDifferences' => $rests->map(function ($rest) {
                    $restStart = Carbon::parse($rest->breakIn);
                    $restEnd = Carbon::parse($rest->breakOut);
                    return $restEnd->diffInMinutes($restStart);
                }),
            ];
        });

        $previousDate = $selectedDate->copy()->subDay();
        $nextDate = $selectedDate->copy()->addDay();

        return view('daily', compact('items', 'processedItems', 'selectedDate', 'previousDate', 'nextDate'));
    }
}
