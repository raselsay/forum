<?php

namespace Tests\Feature;

use App\Favorite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    function guest_can_not_favorites_anything()
    {
        $this->withExceptionHandling();
        $this->post('replies/1/favorites')
            ->assertRedirect('/login');
    }
    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->post('replies/'.$reply->id.'/favorites');
        $this->assertCount(1,$reply->favorites);
    }

    /** @test */
    function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();
        $reply = create('App\Reply');
        try{
            $this->post('replies/'.$reply->id.'/favorites');
            $this->post('replies/'.$reply->id.'/favorites');
        }catch (\Exception $e)
        {
            $this->fail('Did not expect to insert the same record set twice');
        }

        $this->assertCount(1,$reply->favorites);
    }
}