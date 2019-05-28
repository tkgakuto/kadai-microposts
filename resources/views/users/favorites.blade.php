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
                @foreach($favorites as $favorite)
                  <li class="media">
                     <img class="mr-2 rounded" src="{{ Gravatar::src($user->email,50) }}" alt="">
                     <div class="media-body">
                          <div>
                                  {!! link_to_route('users.show', $micropost->user->name, [ 'id'=> $micropost->user->id]) !!}<span class="text-muted">posted at {{ $micropost->created_at }}</span>
                          </div>
                          <div>
                                 <p class="mb-0"> {!! nl2br(e($micropost->content)) !!}</p>
                          </div>
                        <div class="flex">
                         <div>
                            {{-- ログインしてるユーザが表示しようとしてるmicropostがすでに登録されてるかfavoriteの処理をよぶ--}
                                   @if(Auth::user()->is_favorites($micropost->id))
                                   {!! Form::open(['route'=> ['micropost.unfavorite',$micropost->id], 'method'=>'delete']) !!}
                                      {!! Form::submit('Unfavorite',['class'=> 'btn btn-secondary btn-sm' ]) !!}
                                   {!! Form::close() !!}
                                  @else
                                    {!! Form::open(['route'=>['micropost.favorite',$micropost->id]]) !!}
                                       {!! Form::submit('Favorite',['class'=> 'btn btn-primary btn-sm' ]) !!}
                                    {!! Form::close() !!}
                                  @endif
                          </div>
                          <div>
                            {{-- 自分のmicropostだったらdeleteボタンを表示する--}}
                                  @if(Auth::id() == $favorite->micropost->id)
                                    {!! Form::open(['route' => ['microposts.destroy',$micropost->id], 'method'=>'delete']) !!}
                                       {!! Form::submit('Delete', ['class'=>'btn btn-danger btn-sm' ]) !!}
                                    {!! Form::close()  !!}
                                   @endif
                             
                          </div> 
                         </div>
                      </div>
                 </li>
                 @endforeach 
              </ul>
            @endif

       </div>
    </div>
@endsection

  
