<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Education', 'Politics', 'Economy', 'Technology', 'Health', 'Sports', 'Environment', 'Crime-&-Law', 'International', 'Entertainment', 'Science', 'Security', 'Transportation', 'Religion', 'Social-Issues'];

        return [
            'title' => $this->faker->sentence(),
            'body' => implode("\n\n", $this->faker->paragraphs(rand(7, 10))),
            'slug' => $this->faker->unique()->slug(),
            'image_path' => $this->faker->imageUrl(800, 600),
            'author_id' => User::all()->random()->id,
            'views' => $this->faker->numberBetween(0, 10000),
            'category' => $this->faker->randomElement($categories),
        ];
    }
}

