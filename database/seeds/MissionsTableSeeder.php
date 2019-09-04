<?php

use App\Mission;
use Illuminate\Database\Seeder;

class MissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('zh_TW');
        $en_faker = Faker\Factory::create('en_US');
        $item_count = 0;

        while ($item_count < 8) {
            $data = [
                'name' => sprintf("關卡 %s", $item_count + 1),
                'name_e' => sprintf("Mission %s", $item_count + 1),
                'description' => $faker->realtext(20),
                'description_e' => $en_faker->text,
                'image' => $faker->imageUrl('640', '480', 'technics', true, 'Faker'),
                'open' => 1,
            ];

            Mission::create($data);

            $item_count++;
        }
    }
}
