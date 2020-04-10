<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Concert::class, function (\Faker\Generator $faker) {
    return [
        'title' => 'Example band',
        'subtitle' => 'with the Fake Openers',
        'date' => Carbon::parse('+2 weeks'),
        'ticket_price' =>  2000,
        'venue' => 'The Example Theatre',
        'venue_address' => '123 Example Lane',
        'city' => 'Fakeville',
        'state' => 'ON',
        'zip' => '1488',
        'additional_information' => 'Some simple additional information',
        'available_ticket_quantity' => 50
    ];
});

$factory->state(\App\Concert::class, 'published', function (\Faker\Generator $faker) {
    return [
        'published_at' => Carbon::parse('-1 week')
    ];
});

$factory->state(\App\Concert::class, 'unpublished', function (\Faker\Generator $faker) {
    return [
        'published_at' => null
    ];
});
