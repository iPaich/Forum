<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
  use DatabaseMigrations;
  /** @test */
   function guests_may_not_create_threads()
   {
       $this->expectException('Illuminate\Auth\AuthenticationException');
       $thread = make('App\Thread');
       $this->post('/threads', $thread->toArray());
   }

   /** @test */
   function guests_may_not_see_the_create_threads_page()
 {
   $this->withExceptionHandling()
        ->get('/threads/create')
        ->assertRedirect('/login');
 }

    /** @test */
    function authenticated_users_can_create_threads()
    {
       $this->actingAs(create('App\User'));
       $thread = make('App\Thread');
       $this->post('/threads', $thread->toArray());
       $this->get($thread->path())
           ->assertSee($thread->title)
           ->assertSee($thread->body);

    }
}
