<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    $sex = $faker->randomElement(['male', 'female']);
    return [
        'login' => $faker->unique()->firstName($sex),
        'password' => bcrypt('parol123'),
        'sex' => $sex,
        'avatar' => !$faker->numberBetween(0, 4) ? 'default.png' :
            $faker->image(public_path(App\User::AVATARS_FOLDER), 50, 50, '', false),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
	return [
		'comment' => $faker->text($faker->numberBetween(5, 200)),
		'id_who' => App\User::inRandomOrder()->first()->id,
		'id_target' => App\User::inRandomOrder()->first()->id,
	];
});