<?php
namespace Tests\Feature;

use Tests\TestCase;

class SubscriberApiTest extends TestCase
{

    public function test_can_user_subscribe()
    {
        $response = $this->postJson(env('APP_URL') . '/api/subscriber', [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Subscription successful.',
            ]);
    }

    public function test_cannot_create_duplicate_subscriber()
    {
        $this->postJson(env('APP_URL') . '/api/subscriber', [
            'email' => 'test@example.com',
        ]);

        $response = $this->postJson(env('APP_URL') . '/api/subscriber', [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Subscriber is already subscribed.',
            ]);
    }

    public function test_cannot_create_subscriber_with_invalid_email()
    {
        $response = $this->postJson(env('APP_URL') . '/api/subscriber', [
            'email' => 'invalid-email',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_can_unsubscribe()
    {
        $response = $this->patchJson(env('APP_URL') . '/api/subscriber/unsubscribe', [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Unsubscribed successfully.',
            ]);
    }

    public function test_cannot_unsubscribe_nonexistent_subscriber()
    {
        $response = $this->patchJson(env('APP_URL') . '/api/subscriber/unsubscribe', [
            'email' => 'nonexistent@example.com',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Subscriber is not currently subscribed.',
            ]);
    }
}
