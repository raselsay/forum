<?php
namespace Tests\Feature;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
class ParticipateInThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling();
        $this->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user =create('App\User'));
        $thread = create('App\Thread');
        $reply = make('App\Reply');
        $this->post($thread->path() . '/replies', $reply->toArray());
//        $this->get($thread->path())->assertSee($reply->body);
        $this->assertDatabaseHas('replies',['body'=>$reply->body]);
    }

    /** @test */
    function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply',['body'=>null]);
        $this->post($thread->path() . '/replies', $reply->toArray())
             ->assertSessionHasErrors('body');

    }

    /** @test */
    function unauthenticated_user_cannot_delete_replies()
    {
        $this->withExceptionHandling();
        $reply = create('App\Reply');
        $this->delete("replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn();
        $this->delete("replies/{$reply->id}")
             ->assertStatus(403);

    }

    /** @test */
    function authenticated_users_can_delete_replies()
    {
        $this->signIn();
        $reply = create('App\Reply',['user_id'=>auth()->id()]);
        $this->delete("/replies/{$reply->id}")
            ->assertStatus(302);
        $this->assertDatabaseMissing('replies',['id'=>$reply->id]);
    }
    /** @test */
    function unauthenticated_user_cannot_update_replies()
    {
        $this->withExceptionHandling();
        $reply = create('App\Reply');
        $this->patch("replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn();
        $this->patch("replies/{$reply->id}")
            ->assertStatus(403);

    }

    /** @test */
    function authenticated_users_can_update_replies()
    {
        $this->signIn();
        $reply = create('App\Reply',['user_id'=>auth()->id()]);
        $updateReply = "Update Reply";
        $this->patch("replies/{$reply->id}",['body'=>$updateReply]);
        $this->assertDatabaseHas('replies',['id'=>$reply->id,'body'=>$updateReply]);
    }
}