<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Add default user ( That's me! XD )
        DB::table('users')->insert([
            'name' => 'qtgye',
            'email' => 'buquia.jace@gmail.com',
            'password' => bcrypt('psalm2326'),
        ]);
    }
}
