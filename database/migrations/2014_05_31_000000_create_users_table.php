<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname')->nullable();
            $table->string('DNI')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('email')->unique();
            $table->string('license')->nullable();
            $table->string('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            // $table->foreignId('current_team_id')->nullable()->constrained('teams');
            $table->string('profile_photo_path')->nullable();
            $table->foreignId('usertype_id')->nullable()->constrained('usertypes');
            $table->foreignId('zone_id')->nullable()->constrained('zones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}

