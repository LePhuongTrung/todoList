<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class WorkSeeder extends AbstractSeed
{
	public function run(): void
	{
		$faker = Faker\Factory::create();

		$data = [];
		for ($i = 0; $i < 100; $i++) {
			$startDate = $faker->dateTime;
			$endDate = $faker->dateTimeBetween($startDate);

			$data[] = [
				'name'        => $faker->word,
				'start_date'  => $startDate->format('Y-m-d'),
				'end_date'    => $endDate->format('Y-m-d'),
				'status'      => $faker->randomElement(['Planning', 'Doing', 'Complete']),
				'created'     => $faker->dateTime->format('Y-m-d H:i:s'),
				'updated'     => $faker->dateTime->format('Y-m-d H:i:s'),
			];
		}

		$this->insert('works', $data);
	}
}
