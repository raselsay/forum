<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');

    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();
        $thread = make('App\Thread');
        $response = $this->post('/threads',$thread->toArray());
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel',2)->create();
        $this->publishThread(['channel_id'=>null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id'=>999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title'=>null])
            ->assertSessionHasErrors('title');
    }
    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body'=>null])
            ->assertSessionHasErrors('body');
    }

    public function publishThread($overwrite=[])
    {
        $this->withExceptionHandling()->signIn();
        $thread = make('App\Thread',$overwrite);
        return $this->post('/threads',$thread->toArray());
    }

    /** @test */
    function guest_cannot_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $responde = $this->delete($thread->path());

        $responde->assertRedirect('/login');
    }

    /** @test */
    function a_threads_can_be_delete()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply = create('App\Reply',['thread_id'=>$thread->id]);

        $response = $this->json('DELETE',$thread->path());
        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads',['id'=>$thread->id]);
        $this->assertDatabaseMissing('replies',['id'=>$reply->id]);
    }

}
