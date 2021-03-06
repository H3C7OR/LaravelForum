<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    
    use RefreshDatabase;

    /** @test */
    function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');
       
        $this->post('/threads')
            ->assertRedirect('/login');     
    }

    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {
        // Given we  have a signed user
        // $this->actingAs(create('App\User')); // Usuada antes de crear la funcion signIn en TestCase
        $this->signIn();

        // When we hit  the endpoint to create a new thread
        
        $thread = create('App\Thread');
        $this->post('/threads', $thread->toArray());

        // Then,  when  we visit  the thread page.
        $this->get($thread->path())
        // We should see the new thread
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
