<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->optional()->lastName(),
            'last_name' => fake()->lastName(),
            'username' => fake()->unique()->userName(),
            'phone' => '09' . fake()->numberBetween(100000000, 999999999),
            'birthday' => fake()->date(),
            'gender' => fake()->randomElement(['male', 'female']),
            'nationality' => fake()->country(),
            'address' => fake()->address(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'tourist',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is a boat owner.
     */
    public function boatOwner(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'boat_owner',
        ]);
    }

    /**
     * Indicate that the user is a resort owner.
     */
    public function resortOwner(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'resort_owner',
        ]);
    }

    /**
     * Indicate that the user is a tourist.
     */
    public function tourist(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'tourist',
        ]);
    }
}
