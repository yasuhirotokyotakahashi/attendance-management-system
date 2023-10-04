<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        // 10回ユーザーを作成し、各ユーザーに関連するデータを生成する
        for ($i = 0; $i < 10; $i++) {
            $user = \App\Models\User::factory()->create();
            // 各ユーザーに関連するTimeレコードを生成
            \App\Models\Time::factory(10)->create(['user_id' => $user->id]);
            // 各Timeレコードに関連するRestレコードを生成
            \App\Models\Rest::factory(10)->create(['time_id' => $user->times->random()->id]);
        }
    }
}
