<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Sluzbenik::class, function (Faker $faker) {
    return [
        'ime' => $faker->name,
        'prezime' => $faker->lastName,
        'korisnicko_ime' => $faker->userName,
        'email' => $faker->companyEmail,
        'sifra' => $faker->password,
        'pin' => '1234',
        'jmbg' => $faker->bankAccountNumber,
        'ime_roditelja' => $faker->name,
        'djevojacko_prezime' => $faker->lastName,
        'pol' => 0,
        'kategorija' => '123',
        'drzavljanstvo_1' => $faker->languageCode,
        'drzavljanstvo_2' => $faker->languageCode,
        'nacionalnost' => 0,
        'datum_rodjenja' => $faker->dateTimeThisDecade(),
        'mjesto_rodjenja' => $faker->city,
        'bracni_status' => 0,
        'licna_karta' => $faker->randomDigit,
        'mjesto_izdavanja_lk' => $faker->city,
        'PIO' => 'asd',
        'radno_mjesto' => 1,
        'trenutno_radi' => 1,
    ];
});
