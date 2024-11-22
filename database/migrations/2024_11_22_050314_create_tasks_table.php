<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();; // Foreign Key, Linked to users
            $table->string('title'); // String, Required
            $table->text('description')->nullable(); // Text, Optional
            $table->date('due_date'); // Date, Required
            $table->enum('priority', ['High', 'Medium', 'Low']); // Enum: High, Medium, Low
            $table->boolean('is_completed')->default(false); // Boolean, Default false
            $table->boolean('is_paid')->default(false); // Boolean, Default false
            $table->timestamps(); // Created_at and Updated_at

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
