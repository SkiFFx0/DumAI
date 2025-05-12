<?php

namespace Database\Factories;

use App\Models\ChatHistory;
use App\Models\MessageHistory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MessageHistoryFactory extends Factory
{
    protected $model = MessageHistory::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'chat_history_id' => ChatHistory::factory(),
        ];
    }
}
