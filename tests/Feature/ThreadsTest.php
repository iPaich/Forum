<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
use DatabaseMigrations;

public function setUp()
{
  parent::setUp();
  $this->thread = factory('App\Thread')->create();
}

/** @test */
    public function a_user_can_browse_threads()
    {


        $response = $this->get('/threads');


        $response->assertSee($this->thread->title);

    }
/** @test */
    public function a_user_can_view_a_single_thread()
    {

        $response = $this->get('/threads/' . $this->thread->channel->slug . '/' . $this->thread->id);

        $response->assertSee($this->thread->title);
    }


/** @test */
public function a_thread_can_make_a_string_path($value='')
{
  $thread = create('App\Thread');
  $this->assertEquals('/threads/' . $thread->channel->slug . '/' . $thread->id, $thread->path());
}

/** @test */

function a_user_can_read_replies()
{
      $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

      $response = $this->get('/threads/' . $this->thread->channel->slug . '/' . $this->thread->id);

      $response->assertSee($reply->body);



}

/** @test */
function a_thread_has_a_creator()
{
  $thread = factory('App\Thread')->create();

  $this->assertInstanceOf('App\User', $thread->creator);
}

/** @test */
function a_thread_can_add_a_reply()
{
  $this->thread->addReply([
    'body'=>'Foobar',
    'user_id'=>'1'
  ]);
  $this->assertCount(1, $this->thread->replies);
}

/** @test */
function a_thread_belongs_to_a_channel()
{
  $thread = create('App\Thread');
  $this->assertInstanceOf('App\Channel', $thread->channel);
}

}
