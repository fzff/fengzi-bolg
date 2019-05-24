<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Tags;
use Faker\Generator as Faker;

$factory->define(Tags::class, function (Faker $faker) {
    $images = ['22c22314c8d7d1a0a48a767acea81265.jpg', '179aac853aa1a6426b22bdcbe4c295e1.jpg',
        '814d9c32768ca73b7aef7492b78895d3.jpg', '5151116236e1581e1e75e2ae772245f3.jpg'
    ];
    $word = $faker->word;
    return [
        'tag' => $word,
        'title' => ucfirst($word),
        'subtitle' => $faker->sentence,
        'page_image' => $images[mt_rand(0, 3)],
        'meta_description' => "Meta for $word",
        'reverse_direction' => false,
    ];
});
