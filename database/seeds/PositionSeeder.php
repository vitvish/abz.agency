<?php

use App\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    private $faker;

    function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 0;
        while($i < 5) {
            Position::create([
                'name' => ['Manager','UI/UX Designer', 'Developer', 'QA', 'Architect'][$i++]
            ]);
        }
    }
}
