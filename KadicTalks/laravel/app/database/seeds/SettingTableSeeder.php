<?php

class SettingTableSeeder extends Seeder
{

  public function run()
  {
    $now = date('Y-m-d H:i:s');
    DB::table('settings')->delete();

    Setting::create(array(
        'name'       => 'appearance',
        'value'      => 'Light',
        'created_at' => $now,
        'updated_at' => $now
    ));

    Setting::create(array(
        'name'       => 'forum_title',
        'value'      => 'KadicTalks',
        'created_at' => $now,
        'updated_at' => $now
    ));

    Setting::create(array(
        'name'       => 'payment_duration',
        'value'      => 1,
        'created_at' => $now,
        'updated_at' => $now
    ));

    Setting::create(array(
        'name'       => 'approval',
        'value'      => 'Yes',
        'created_at' => $now,
        'updated_at' => $now
    ));

    Setting::create(array(
        'name'       => 'suspension_duration',
        'value'      => 3,
        'created_at' => $now,
        'updated_at' => $now
    ));

    Setting::create(array(
        'name'       => 'registration',
        'value'      => 'Yes',
        'created_at' => $now,
        'updated_at' => $now
    ));

    Setting::create(array(
        'name'       => 'send_email',
        'value'      => 'Yes',
        'created_at' => $now,
        'updated_at' => $now
    ));
    
    Setting::create(array(
        'name'       => 'user_attachment',
        'value'      => 'Yes',
        'created_at' => $now,
        'updated_at' => $now
    ));
  }

}
