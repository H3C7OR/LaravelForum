<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    
    use RefreshDatabase;
    
    /** @test */
    function unauthenticated_users_may_not_add_replies()
    {
                       
       $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
    }

    /** @test */
    function a_authenticated_user_may_participate_in_forum_threads()
    {
        
        //Given we have a authenticated user
        $this->be($user = factory('App\User')->create());
      
        
        //And an existing thread
        $thread = factory('App\Thread')->create();


        //When the user adds a reply to the thread
        $reply = factory('App\Reply')->make();

        
        // $this->post('/threads/'.$thread->id.'/replies', $reply->toArray());
        $this->post($thread->path().'/replies', $reply->toArray());


        //Then their reply should be visible on the page
        $this->get($thread->path())
            ->assertSee($reply->body);            

    }
}


