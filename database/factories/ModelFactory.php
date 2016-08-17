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
    $faker->addProvider(new Faker\Provider\nl_BE\Person($faker));
    $faker->addProvider(new Faker\Provider\nl_BE\Address($faker));
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt('wachtwoord'),
        'street' => $faker->streetName,
        'nr' => $faker->buildingNumber,
        'bus' => '',
        'zip' => $faker->postcode,
        'city' => $faker->city,
        'lat' => $faker->latitude,
        'lng' => $faker->longitude,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\nl_BE\Address($faker));
    $faker->addProvider(new Faker\Provider\nl_BE\Person($faker));
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\nl_BE\Address($faker));
    $faker->addProvider(new Faker\Provider\nl_BE\Person($faker));

    return [
        'title' => $faker->word,
        'summary' => $faker->text,
        'price' => $faker->randomFloat(2,5),
    ];
});
