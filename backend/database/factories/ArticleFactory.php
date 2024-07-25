<?php

namespace Database\Factories;

use App\Traits\UploadFile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    use UploadFile;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'image' => $this->uploadFile(UploadedFile::fake()->image('image.jpg'), 'article'),
            'content' => $this->faker->paragraphs(10, true),
            'is_published' => $this->faker->boolean,
            'published_at' => $this->faker->dateTime,
        ];
    }
}
