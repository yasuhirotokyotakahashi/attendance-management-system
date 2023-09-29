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

        $oldtimein = Time::where('user_id', $user->id)->latest()->first(); //一番最初のレコードを取得

        $oldDay = '';
        if ($oldtimein) {
            $oldTimePunchIn = new Carbon($oldtimein->punchIn);
            $oldDay = $oldTimePunchIn->startOfDay(); //最後に登録したpunchInの時刻を00:00:00で代入
        }
        $today = Carbon::today(); //当日の日時を00:00:00で代入

        if (($oldDay == $today) && (empty($oldtimein->punchOut))) {
            return redirect()->back()->with('message', '出勤打刻済みです');
        }

        //退勤後に再度出勤を押せない
        if ($oldtimein) {
            $oldTimePunchOut = new Carbon($oldtimein->punchOut);
            $oldDay = $oldTimePunchOut->startOfDay(); //最後に登録したpunchInの時刻を00:00:00で代入
        }

        if (($oldDay == $today)) {
            return redirect()->back()->with('message', '退勤打刻済みです');
        }

        Time::create([
            'user_id' => $user->id,
            'punchIn' => Carbon::now(),
            'date' => Carbon::today(),
        ]);

        return redirect()->back();
    }

    public function timeout()
    {
        $user = Auth::user();
        $timeOut = Time::where('user_id', $user->id)->latest()->first();

        $now = new Carbon();
        $punchIn = new Carbon($timeOut->punchIn);
        //実労働時間(Minute)
        $stayTime = $punchIn->diffInMinutes($now);

        //退勤処理がされていない場合のみ退勤処理を実行
        if ($timeOut) {
            if (empty($timeOut->punchOut)) {
                $timeOut->update([
                    'punchOut' => Carbon::now(),
                ]);

                return redirect()->back()->with('message', 'お疲れ様でした');
            } else {
                $today = new Carbon();
                $date = $today->day;
                $oldPunchOut = new Carbon();
                $oldPunchOutDay = $oldPunchOut->day;
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
        $processedItems = []; //加工したデータを格納する配列

        foreach ($items as $item) {
            $workStart = Carbon::parse($item->punchIn); // 出勤時間
            $workEnd = Carbon::parse($item->punchOut); // 退勤時間
            $workDifference = $workEnd->diffInMinutes($workStart); // 出勤時間の差（分単位）

            $restDifferences = []; // 休憩時間の差の配列

            $rests = Rest::where('time_id', $item->id)->get(); // Restモデルを利用して関連する休憩データを取得

            foreach ($rests as $rest) {
                $restStart = Carbon::parse($rest->breakIn); // 休憩開始時間
                $restEnd = Carbon::parse($rest->breakOut); // 休憩終了時間
                $restDifference = $restEnd->diffInMinutes($restStart); // 休憩時間の差（分単位）
                $restDifferences[] = $restDifference; // 休憩時間の差を配列に追加
            }

            $totalRestDifference = array_sum($restDifferences); // 休憩時間の合計差（分単位）

            $actualWorkingMinutes = $workDifference - $totalRestDifference;

            $actualWorkingTime =
                sprintf('%02d:%02d:%02d', intdiv($actualWorkingMinutes, 60), $actualWorkingMinutes % 60, 0);

            $processedItems[] = [
                'item' => $item,
                'workDifference' => $workDifference,
                'totalRestDifference' =>
                sprintf('%02d:%02d:%02d', intdiv($totalRestDifference, 60), $totalRestDifference % 60, 0),
                'actualWorkingTime' => $actualWorkingTime,
                'restDifferences' => $restDifferences,
            ];
        }

        $previousDate = $selectedDate->copy()->subDay();
        $nextDate = $selectedDate->copy()->addDay();

        return view('daily', compact('items', 'processedItems', 'selectedDate', 'previousDate', 'nextDate'));
    }
}
