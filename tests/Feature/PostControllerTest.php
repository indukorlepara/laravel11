<?php
namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test getting all posts (index).
     *
     * @return void
     */
    public function test_get_all_posts()
    {
        // Create multiple posts using factory
        Post::factory()->count(3)->create(); 

        // Send a GET request to /api/posts
        $response = $this->getJson('/api/posts');
        //dd($response->json());

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert the response contains the correct number of posts
       // $response->assertJsonCount(3, 'data');
    }

    /**
     * Test creating a new post (store).
     *
     * @return void
     */
    public function test_create_post()
    {
        $postData = [
            'title' => 'Test Post Title',
            'body' => 'This is the body of the test post.',
        ];

        // Send a POST request to create a new post
        $response = $this->postJson('/api/posts', $postData);

        // Assert the response status is 201 (created)
        $response->assertStatus(201);

        // Assert the post is in the database
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post Title',
            'body' => 'This is the body of the test post.',
        ]);
    }

    /**
     * Test getting a single post by ID (show).
     *
     * @return void
     */
    // public function test_get_single_post()
    // {
    //     // Create a post
    //     $post = Post::factory()->create();

    //     // Send a GET request to retrieve the post
    //     $response = $this->getJson("/api/posts/{$post->id}");

    //     // Assert the response status is 200 (OK)
    //     $response->assertStatus(200);

    //     // Assert the response contains the correct post data
    //     $response->assertJson([
    //         'data' => [
    //             'id' => $post->id,
    //             'title' => $post->title,
    //             'body' => $post->body,
    //             'image_path'      => $post->image,
    //             'created_at' => $createdAt,
    //             'updated_at' => $updatedAt,
                
    //         ],
    //     ]);
    // }

    /**
     * Test updating a post (update).
     *
     * @return void
     */
    public function test_update_post()
    {
        // Create a post
        $post = Post::factory()->create();

        // Data to update the post with
        $updatedData = [
            'title' => 'Updated Title',
            'body' => 'Updated body content.',
        ];

        // Send a PUT request to update the post
        $response = $this->putJson("/api/posts/{$post->id}", $updatedData);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the post data is updated in the database
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'body' => 'Updated body content.',
        ]);
    }

    /**
     * Test deleting a post (destroy).
     *
     * @return void
     */
    public function test_delete_post()
    {
        // Create a post
        $post = Post::factory()->create();

        // Send a DELETE request to delete the post
        $response = $this->deleteJson("/api/posts/{$post->id}");

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the post is deleted from the database
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    /**
     * Test validation on store (create).
     *
     * @return void
     */
    public function test_create_post_validation()
    {
        // Send a POST request with missing title
        $response = $this->postJson('/api/posts', ['body' => 'Body without title']);

        // Assert the response status is 422 (Unprocessable Entity) due to validation error
        $response->assertStatus(422);

        // Assert the response contains validation error for 'title'
        $response->assertJsonValidationErrors(['title']);
    }
}
