<?php

namespace Tests\Feature\Admin;

use App\Imports\BookImport;
use Tests\TestCase;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Admin\Book;
use App\Models\Admin\Author;
use App\Models\Admin\Category;
use App\Models\Admin\Publisher;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{

    use RefreshDatabase;
    private Author $author;
    private Publisher $publisher;
    private Category $category;
    private User $admin;
    private User $user;
    private $books;
    private Book $book;
    private City $city;
    private State $state;

    public function setup(): void
    {
        parent::setUp();
        $this->state = State::factory()->create();
        $this->city = City::factory()->create([
            'state_id' => $this->state->id
        ]);
        $this->books = Book::factory(5)->create();
        $this->book = Book::factory()->create([
            'name' => 'Book 1'
        ]);
        $this->author = Author::factory()->create();
        $this->publisher = Publisher::factory()->create();
        $this->category = Category::factory()->create();
        $this->admin = User::factory()->create([
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
            'role' => 'admin'
        ]);
        $this->user = User::factory()->create([
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
        ]);
    }

    public function test_books_index_page_rendered_successfully()
    {
        $response = $this->actingAs($this->admin)->get('/dashboard/books');

        $response->assertStatus(200);
    }

    public function test_book_page_rendered_successfully()
    {
        $response = $this->actingAs($this->admin)->get('/dashboard/books/' . $this->book->id);

        $response->assertStatus(200);
        $response->assertSeeText($this->book->name);
    }
    public function test_edit_book_page_rendered_successfully()
    {
        $response = $this->actingAs($this->admin)->get('/dashboard/books/' . $this->book->id . '/edit');

        $response->assertStatus(200);
    }
    public function test_book_can_be_edited()
    {
        $data = [
            'name' => 'Updated Book Name',
            'status' => 'published',
            'category_id' => $this->category->id,
            'publisher_id' => $this->publisher->id,
            'author_id' => $this->author->id,
            'price' => 15000,
            'quantity' => 10000,
            'stock_alert' => 250,
            'cost_price' => 300,
            'description' => 'This is a description',

        ];
        $response = $this->actingAs($this->admin)->patch('/dashboard/books/' . $this->book->id, $data);

        $response->assertRedirect()->assertSessionHas('success');
    }
    public function test_book_can_be_created()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg');
        $data = [
            'name' => 'Updated Book Name',
            'status' => 'published',
            'image' => $file,
            'category_id' => $this->category->id,
            'publisher_id' => $this->publisher->id,
            'author_id' => $this->author->id,
            'price' => 15000,
            'quantity' => 10000,
            'stock_alert' => 250,
            'cost_price' => 300,
            'description' => 'This is a description',

        ];
        $response = $this->actingAs($this->admin)->post('/dashboard/books/', $data);

        $response->assertRedirect()->assertSessionHas('success');
    }
    public function test_book_can_be_deleted()
    {
        $response = $this->actingAs($this->admin)->delete('/dashboard/books/' . $this->book->id);

        $response->assertRedirect()->assertSessionHas('success');
        $this->assertModelMissing($this->book);
    }
}
