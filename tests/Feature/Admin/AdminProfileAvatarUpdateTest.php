<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminProfileAvatarUpdateTest extends TestCase
{
    use RefreshDatabase;

    private State $state;
    private City $city;
    private User $admin;

    public function setup(): void
    {
        parent::setup();
        $this->state = State::factory()->create();
        $this->city = City::factory()->create([
            'state_id' => $this->state->id
        ]);

        $this->admin = User::factory()->create([
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
            'role' => 'admin'
        ]);
    }

    public function test_admin_can_update_his_profile_avatar()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg', 500, 500);

        $response = $this->actingAs($this->admin)
            ->postJson('/dashboard/profile/avatar', ['avatar' => $file], [
                'X-Requested-With' => 'XMLHttpRequest',
            ]);


        $response->assertStatus(200)
            ->assertJsonStructure([
                'success', 'photo'
            ])->assertJsonMissingValidationErrors('avatar');


        $this->assertNotNull($this->admin->photo);
        $this->assertStringContainsString('profiles_photos/', $this->admin->photo);
    }


    public function test_bad_request_response_if_the_request_is_not_ajax()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($this->admin)
            ->postJson('/dashboard/profile/avatar', ['avatar' => $file], []);

        $response->assertBadRequest();
    }



    public function test_validation_fails_when_missing_the_avatar()
    {

        $response = $this->actingAs($this->admin)
            ->postJson('/dashboard/profile/avatar',  [], [
                'X-Requested-With' => 'XMLHttpRequest',
            ]);

        $response->assertJsonValidationErrorFor('avatar');
    }
    public function test_validation_fails_when_the_avatar_mime_type_is_not_jpg_or_png()
    {

        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.pdf');

        $response = $this->actingAs($this->admin)
            ->postJson('/dashboard/profile/avatar',  ['avatar' => $file], [
                'X-Requested-With' => 'XMLHttpRequest',
            ]);
        $response->assertJsonValidationErrorFor('avatar');
    }
}
