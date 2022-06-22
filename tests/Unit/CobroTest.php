<?php

namespace Tests\Unit;

use App\Models\Cobro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CobroTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_residents_charges()
    {
        // Arrange
        $user = User::factory()->create()->first();
        Cobro::create([
            "user_id" => $user->id,
            "value" => 1000,
            "description" => "Test Charge"
        ]);

        // Act
        $response = $this->actingAs($user, "sanctum")
            ->getJson('/api/cobros');

        // Assert
        $response->assertOk();
    }

    public function test_can_create_new_charge()
    {
        $user = User::factory()->create()->first();
        $data = [
            "user_id" => $user->id,
            "value" => 1000,
            "description" => 'Test Charge'
        ];

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/cobros', $data);
        
        $response->assertCreated();
        $response->assertJsonFragment([
            "user_id" => $user->id,
            "value" => 1000,
        ]);
    }

    public function test_resident_can_have_multiple_charges()
    {
        $user = User::factory()->create()->first();
        Cobro::create([
            "user_id" => $user->id,
            "value" => 1000,
            "description" => "Test Charge"
        ]);
        $newChargeData = [
            "user_id" => $user->id,
            "value" => 1000,
            "description" => 'Multiple Charges'
        ];

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/cobros', $newChargeData);

        $response->assertCreated();
        $response->assertJsonFragment([
            "user_id" => $user->id,
            "description" => "Multiple Charges"
        ]);
    }

    public function test_can_read_specific_charges()
    {
        $user = User::factory()->create()->first();
        $charge = Cobro::create([
            "user_id" => $user->id,
            "value" => 1000,
            "description" => "Test Charge"
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/cobros/{$charge->id}");

        $response->assertOk();
    }

    public function test_can_update_charge()
    {
        $user = User::factory()->create()->first();
        $charge = Cobro::create([
            "user_id" => $user->id,
            "value" => 1000,
            "description" => "Test Charge"
        ]);

        $data = [
            "description" => "New Description",
            "value" => 2000
        ];

        $response = $this->actingAs($user, "sanctum")
            ->patchJson("/api/cobros/{$charge->id}", $data);

        $response->assertOk();
        $response->assertJsonFragment([
            "description" => "New Description",
            "value" => 2000
        ]);
    }

    public function test_can_delete_charges()
    {
        $user = User::factory()->create()->first();
        $charge = Cobro::create([
            "user_id" => $user->id,
            "value" => 1000,
            "description" => "Test Charge"
        ]);

        $response = $this->actingAs($user, "sanctum")
            ->deleteJson("/api/cobros/{$charge->id}");
        
        $response->assertOk();
    }
    
}
