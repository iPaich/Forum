<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{
  use DatabaseMigrations;
  /** @test */
  function it_has_an_owner()
  {
    $reply = factory('App\Reply')->create();
    $this-> assertInstanceOf('App\User', $reply->owner);
  }

  /** @test */
  function a_reply_requires_a_body()
  {
      $this->withExceptionHandling()->signIn();
      $thread=create('App\Thread');
      $reply=make('App\Reply', ['body' => null]);
      $this->post($thread->path() . '/replies', $reply->toArray())
           ->assertSessionHasErrors('body');
  }
}
