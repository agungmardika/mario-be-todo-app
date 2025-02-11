<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('todo_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('user_id'); // Tambahkan kolom user_id
            $table->integer('progress')->default(0);
            $table->enum('status', ['in progress', 'done'])->default('in progress');
            $table->timestamps();
    
            $table->foreign('todo_id')->references('id')->on('todos')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
