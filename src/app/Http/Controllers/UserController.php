<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Time; // Timeモデルをインポート
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // public function show()
    // {
    //     // ユーザーの勤怠情報を取得
    //     $users = User::all();
    //     dd($users);



    //     // ユーザーごとの勤怠情報を取得
    //     $attendances = Time::with('rests')
    //         ->where('user_id', $user->id)
    //         ->orderBy('date')
    //         ->paginate(5);

    //     return view('users.attendance', compact('users', 'attendances'));
    // }

    public function showAttendance($id)
    {
        // ユーザーの勤怠情報を取得
        $user = User::findOrFail($id);

        // ユーザーごとの勤怠情報を取得
        $attendances = Time::with('rests')
            ->where('user_id', $user->id)
            ->orderBy('date')
            ->paginate(5);

        return view('users.attendance', compact('user', 'attendances'));
    }
}
