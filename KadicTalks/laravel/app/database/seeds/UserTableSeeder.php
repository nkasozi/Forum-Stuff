<?php

class UserTableSeeder extends Seeder
{

    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $admin_email='nsubugak@yahoo.com';
        $admin_username='nsubugak';
        $admin_password='@llison';
        
        DB::table('users')->delete();

        User::create(array(
            'email' => $admin_email,
            'username' => $admin_username,
            'password' => Hash::make($admin_password),
            'account_type' => 'Administrator',
            'Location' => 'kampala',
            'about_me' => 'Imagine me',
            'name_of_pic'=>'guest.png',
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now
        ));
        
        User::create(array(
            'email' => 'Peter@KadicBlahBlahBlah.com',
            'username' => 'peter',
            'password' => Hash::make('peter'),
            'account_type' => 'Administrator',
            'Location' => 'kampala',
            'about_me' => 'Imagine me',
            'name_of_pic'=>'guest.png',
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now
        ));
        
        User::create(array(
            'email' => 'Dr.Emma@KadicBlahBlah.com',
            'username' => 'emma',
            'password' => Hash::make('emma'),
            'account_type' => 'Administrator',
            'Location' => 'kampala',
            'about_me' => 'Imagine me',
            'name_of_pic'=>'guest.png',
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now
        ));
    }

}
