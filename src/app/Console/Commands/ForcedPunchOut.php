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
        $user = Auth::user();
        $timeOut = Time::where('user_id', $user->id)->latest()->first();

        if (!$timeOut) {
            $time = Time::create([
                'user_id' => $user->id,
                'punchIn' => Carbon::now(),
            ]);

            return;
        }

        if (empty($timeOut->punchOut) && $timeOut->beakIn) {
            $restOut = Rest::where('time_id', $timeOut->id)->latest()->first();

            $timeOut->update([
                'punchOut' => Carbon::now(),
            ]);

            $restOut->update([
                'breakOut' => Carbon::now(),
            ]);

            $time = Time::create([
                'user_id' => $user->id,
                'punchIn' => Carbon::now(),
            ]);
        }
    }
}
