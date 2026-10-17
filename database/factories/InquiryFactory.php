<?php

namespace Database\Factories;

use App\Enums\InquiryTopic;
use App\Models\Inquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inquiry>
 */
class InquiryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'company' => null,
            'topic' => fake()->randomElement(InquiryTopic::cases()),
            'message' => fake()->paragraph(),
        ];
    }
}
