<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConversationTableSeeder
 *
 * @author ken
 */
class ConversationTableSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        DB::table('conversations')->delete();
  
        Conversation::create(array(
            'title' => 'an example conversation',
            'thread_id' => 1,
            'days_to_expiry'=>'2',
            'created_at' => $now,
            'updated_at' => $now
        ));
    }
}
