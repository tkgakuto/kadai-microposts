@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4">
          @include('users.card')
        </aside>
        <div class="col-sm-8">
           @include('users.navtabs')
           
           @if (count($favorites) > 0)
           
            <ul class="list-unstyled">
                @foreach($favorites as $micropost)
                  <li class="media">
                     <img class="mr-2 rounded" src="{{ Gravatar::src($user->email,50) }}" alt="">
                     <div class="media-body">
                          <div>
                                  {!! link_to_route('users.show', $micropost->user->name, [ 'id'=> $micropost->user->id]) !!}<span class="text-muted">posted at {{ $micropost->created_at }}</span>
                          </div>
                          <div>
                                 <p class="mb-0"> {!! nl2br(e($micropost->content)) !!}</p>
                          </div>
                          @include('favorite.favorite_button')
                      </div>
                 </li>
                 @endforeach 
              </ul>
            @endif

       </div>
    </div>
@endsection

  
