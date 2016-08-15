<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('login')->unique();
            $table->string('password', 60);
            $table->enum('sex', ['male', 'female']);
            $table->integer('karma')->default(0);
            $table->string('avatar')->default('default.png');
            $table->rememberToken();
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
        Schema::drop('users');

        $disk = Storage::disk('public');
        $avatar_folder = User::AVATARS_FOLDER;
        foreach($disk->files($avatar_folder) as $file) {
            if ($file != $avatar_folder . 'default.png') {
                $disk->delete($file);
            }
        }
    }
}
