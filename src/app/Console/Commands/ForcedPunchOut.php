<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use App\Models\Time;
use App\Models\Rest;
use Carbon\Carbon;

class ForcedPunchOut extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forcedPunchOut';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '00:00時になると強制的に退勤';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // 現在の日時を取得
        $now = Carbon::now();

        // 現在の日付を取得
        $currentDate = $now->toDateString();

        // 今日の午後11時59分の時刻を設定
        $closingTime = $now->copy()->setHour(23)->setMinute(59)->setSecond(59);

        // 勤務中の最新の打刻レコードを取得
        $latestTimeRecord = Time::where('punchIn', '<=', $closingTime)
            ->where('punchOut', '=', null)
            ->latest()
            ->first();

        // 勤務中の場合、強制的に退勤し、休憩中であれば休憩終了時刻を設定
        if ($latestTimeRecord) {
            // 退勤時刻を設定
            $latestTimeRecord->update([
                'punchOut' => $now,
            ]);

            // 休憩中の最新のレコードを取得
            $latestRestRecord = Rest::where('time_id', $latestTimeRecord->id)
                ->where('breakOut', '=', null)
                ->latest()
                ->first();

            // 休憩中の場合、休憩終了時刻を設定
            if ($latestRestRecord) {
                $latestRestRecord->update([
                    'breakOut' => $now,
                ]);
            }

            // 翌日の勤務を開始
            Time::create([
                'user_id' => $latestTimeRecord->user_id,
                'punchIn' => $now,
                'date' => $now->copy()->addDay()->toDateString(),
            ]);
        }

        return 0;
    }
}
