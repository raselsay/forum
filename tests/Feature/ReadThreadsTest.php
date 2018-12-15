<?php

namespace Tests\Feature;

use Tests\TestCase;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }
    /** @test */
    public function a_can_user_vie_all_threads()
    {
        $response = $this->get('/threads')
                    ->assertSee($this->thread->title);
    }
    /** @test */
    public function a_can_user_read_a_single_thread()
    {
        $response = $this->get($this->thread->path())
                    ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_can_user_read_replies_that_are_associated_with_a_thread()
    {
        $reply= factory('App\Reply')->create(['thread_id'=>$this->thread->id]);
        $this->get($this->thread->path())
              ->assertSee($reply->body);
    }
}
