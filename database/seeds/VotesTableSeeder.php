<?php

use Illuminate\Database\Seeder;

class VotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $users = App\User::select('id', 'karma')->get();
        foreach ($users as $user_who) {
        	$id_who = $user_who->id;
        	foreach ($users as $user_target) {
        		$id_target = $user_target->id;
        		if ($user_who != $user_target && $faker->numberBetween(0, 3)) {
        			$vote = $faker->randomElement(['plus', 'minus']);
        			App\Vote::create([
        				'vote' => $vote,
        				'id_who' => $id_who,
        				'id_target' => $id_target,
        			]);
        			if ($vote == 'plus') {
        				$user_target->karma++;
        			} else {
        				$user_target->karma--;
        			}
        			$user_target->save();
        		}
        	}
        }
    }
}
