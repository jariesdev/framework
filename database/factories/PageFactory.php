<?php
use Faker\Generator as Faker;
use AvoRed\Framework\Database\Models\Page;
use Illuminate\Support\Str;

$factory->define(Page::class, function (Faker $faker) {
    $name = $faker->word;
    $slug = Str::slug($name);
    return [
        'name' => $name,
        'slug' => $slug,
        'content' => $faker->text(rand(50, 60))
    ];
});
