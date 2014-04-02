<?php

class PostTableSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        DB::table('posts')->delete();
  
        Post::create(array(
            'content' => 'an example post',
            'user_id' => 1,
            'conversation_id' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ));
    }
}
