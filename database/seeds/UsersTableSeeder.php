<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        User::updateOrCreate( [
            'name'              => 'Mr Admin',
            'slug'              => 'mr-admin',
            'type'              => 'admin',
            'email'             => 'admin@mail.com',
            'email_verified_at' => Carbon::now(),
            'password'          => Hash::make( 'password' ),
            'status'            => true,
        ] );
    }
}
