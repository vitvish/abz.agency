<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * @var \Faker\Generator
     */
    private $faker;


    /**
     * EmployeeSeeder constructor.
     */
    function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 0;
        $count = 50000;
        while($i++ < $count) {
            Employee::create([
                'full_name' => $this->faker->name,
                'employeementDay' => $this->faker->date(),
                'salary' => $this->faker->numberBetween(43000, 70000),
                'position_id' => $this->faker->numberBetween(1, 5),
                'parent_id' => $this->faker->numberBetween(0, $count)
            ]);
        }
    }
}
