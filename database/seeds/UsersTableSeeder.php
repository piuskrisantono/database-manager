<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
                'username' => 'pius.wiatmojo',
                'role_id' => '1',
                'avatar' => '1',
            ]);
        User::create([
            'username' => 'nur.avendi',
            'role_id' => '1',
            'avatar' => '2',
        ]);
        User::create([
            'username' => 'leo.hamonangan',
            'role_id' => '1',
            'avatar' => '2',
        ]);


    }
}
