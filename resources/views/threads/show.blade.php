@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <a href='#'> {{ $thread->creator->name }} </a> posted: {{ $thread->title }}
                  </div>

                <div class="panel-body">
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          @foreach ($thread->replies as $reply)
          @include ('threads.reply')
              @endforeach
        </div>
    </div>
    @if (auth()->check())
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <form action="{{ $thread->path() . '/replies' }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="body"> Body: </label>
              <textarea name="body" id="body" class="form-control" placeholder="Something on your mind?" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
        </div>
        @else
        <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> </p>
    </div>
    @endif

</div>
@endsection
