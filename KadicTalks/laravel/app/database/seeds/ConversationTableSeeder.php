<?php

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
