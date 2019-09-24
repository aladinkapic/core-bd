<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Organizacija::class, function (Faker $faker) {
    return [
        'naziv' => $faker->company,
        'pravilnik' => $faker->catchPhrase,
        'datum_od' => $faker->dateTimeThisYear,
        'datum_do' => $faker->dateTimeThisYear,
        'active' => rand(0,1),
        'oju_id' => 1
    ];
});

$factory->define(App\Models\OrganizacionaJedinica::class, function (Faker $faker) {
    return [
        'naziv' => $faker->company,
        'tip' => rand(1, 5),
        'parent_id' => rand(1,8),
        'opis' => $faker->text(250),
        'org_id' => rand(1,3)
    ];
});