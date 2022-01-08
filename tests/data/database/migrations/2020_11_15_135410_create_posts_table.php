<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create(
            'posts',
            function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('title', 64);
                $table->text('text');
                $table->integer('user_id');
            }
        );
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
