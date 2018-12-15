<?php

namespace Tests\Feature;

use Tests\TestCase;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_can_user_browse_threads()
    {
        $thread = factory('App\Thread')->create();

        $response = $this->get('/threads');

        $response->assertSee($thread->title);

        $response = $this->get('/threads/'.$thread->id);

        $response->assertSee($thread->title);
    }
}
