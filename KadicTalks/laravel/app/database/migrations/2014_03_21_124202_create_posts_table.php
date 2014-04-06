<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function($table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('content');
            $table->string('name_of_attachment');
            $table->string('link_to_video');
            $table->integer('conversation_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
            Schema::dropIfExists('posts');
       
    }

}
