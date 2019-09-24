<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
//        $faker = Faker::create();
//        foreach(range(1, 30) as $index){
//            DB::table('radna_mjesta')->insert([
//                'naziv_rm' => $faker->name,
//                'sifra_rm' => $faker->numerify('A###'),
//                'opis_rm' => $faker->sentence,
//                'broj_izvrsilaca' => $faker->numberBetween(1, 15),
//                'platni_razred' => $faker->numerify('AEE###'),
//                'tip_rm' => $faker->$faker->numberBetween(1, 15),
//                'kategorija_rm' => $faker->$faker->numberBetween(1, 15),
//                'id_oju' => $faker->$faker->numberBetween(1, 15),
//                'id_oj' => $faker->$faker->numberBetween(1, 15),
//                'id_tuoap' => $faker->$faker->numberBetween(1, 15),
//                'strucna_sprema' => 'VSS',
//                'tip_pm' => null,
//            ]);
//        }



        // factory(App\Models\Organizacija::class, 100)->create();
        factory(\App\Models\Sluzbenik::class, 3000)->create();
        // factory(\App\Models\RadnoMjesto::class, 1000)->create();
        // factory(App\Models\OrganizacionaJedinica::class, 20)->create();
    }
}
