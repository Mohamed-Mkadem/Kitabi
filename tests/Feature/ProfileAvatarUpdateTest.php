<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileAvatarUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_his_profile_avatar()
    {
        Storage::fake('public');

        $user = $this->getUser();

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($user)
            ->postJson('/profile/avatar', ['avatar' => $file], [
                'X-Requested-With' => 'XMLHttpRequest',
            ]);


        $response->assertStatus(200)
            ->assertJsonStructure([
                'success', 'photo'
            ])->assertJsonMissingValidationErrors('avatar');


        $this->assertNotNull($user->photo);
        $this->assertStringContainsString('profiles_photos/', $user->photo);
    }


    public function test_bad_request_response_if_the_request_is_not_ajax()
    {
        Storage::fake('public');
        $user = $this->getUser();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($user)
            ->postJson('/profile/avatar', ['avatar' => $file], []);

        $response->assertBadRequest();
    }



    public function test_validation_fails_when_missing_the_avatar()
    {

        $user = $this->getUser();

        $response = $this->actingAs($user)
            ->postJson('/profile/avatar',  [], [
                'X-Requested-With' => 'XMLHttpRequest',
            ]);

        $response->assertJsonValidationErrorFor('avatar');
    }
    public function test_validation_fails_when_the_avatar_mime_type_is_not_jpg_or_png()
    {

        Storage::fake('public');
        $user = $this->getUser();
        $file = UploadedFile::fake()->image('avatar.pdf');

        $response = $this->actingAs($user)
            ->postJson('/profile/avatar',  ['avatar' => $file], [
                'X-Requested-With' => 'XMLHttpRequest',
            ]);
        $response->assertJsonValidationErrorFor('avatar');
    }

    private function getState()
    {
        $state = State::factory()->create();
        return $state;
    }
    private function getCityId($state)
    {

        $city = City::factory()->create([
            'state_id' => $state->id
        ]);
        return $city->id;
    }
    private function getUser(): User
    {

        $state = $this->getState();
        $user = User::factory()->create([
            'state_id' => $state->id,
            'city_id' => $this->getCityId($state),

        ]);
        return $user;
    }
}
