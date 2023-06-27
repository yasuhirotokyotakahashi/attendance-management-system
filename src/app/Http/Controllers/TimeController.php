<?php

namespace App\Http\Controllers;

use App\Models\Time;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $oldtimein=Time::where('user_id',$user->id)->latest()->first();//一番最初のレコードを取得

        $oldDay='';
        // if($oldtimein){
        //     $oldTimePunchIn=new Carbon($oldtimein->punchOut);
        //     $oldDay=$oldTimePunchIn->startOfDay();//最後に登録したpunchInの時刻を00:00:00で代入
        // }
        // $today=Carbon::today();//当日の日時を00:00:00で代入

        // if(($oldDay ==$today)&&(empty($oldtimein->punchOut))){
        //     return redirect()->back()->with('message','出勤打刻済みです');
        // }

        //     //退勤後に再度出勤を押せない
        //     if($oldtimein){
        //         $oldTimePunchOut=new Carbon($oldtimein->punchOut);
        //         $oldDay=$oldTimePunchOut->startOfDay();//最後に登録したpunchInの時刻を00:00:00で代入
        //     }

        //     if(($oldDay==$today)){
        //         return redirect()->back()->with('message','退勤打刻済みです');
        //     }

           

        $time = Time::create([
            'user_id' => $user->id,
            'punchIn' => Carbon::now(),
            'date'=>Carbon::today(),
            


        ]);
        return view('index');
    }

    public function timeout(){
        $user=Auth::user();
        $timeOut=Time::where('user_id',$user->id)->latest()->first();

        $now =new Carbon();
        $punchIn=new Carbon($timeOut->punchIn);
        //実労働時間(Minute)
        $stayTime=$punchIn->diffInMinutes($now);

        //退勤処理がされていない場合のみ退勤処理を実行
        if($timeOut){
            if(empty($timeOut->punchOut)){
                $timeOut->update([
                    'punchOut' =>Carbon::now(),
                ]);
                return redirect()->back()->with('message','お疲れ様でした');
            }
            else{
                $today=new Carbon();
                $date=$today->day;
                $oldPunchOut=new Carbon();
                $oldPunchOutDay=$oldPunchOut->day;
                if($date==$oldPunchOutDay){
                    return redirect()->back()->with('message','退勤済みです');
                }else{
                    return redirect()->back()->with('message','出勤打刻がされていません');
                }
                
        }
    }

    }
}