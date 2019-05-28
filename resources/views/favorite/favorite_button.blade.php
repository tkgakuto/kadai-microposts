    <div>
        {{-- ログインしているユーザーが表示しようとしているmicropostのid
        は、すでにお気に入りされているか？--}}

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
        {{-- （いまログインしている人のID）自分のmicropostだったらdeleteボタンを表示する--}}
             @if(Auth::id() == $micropost->user->id)
                {!! Form::open(['route' => ['microposts.destroy',$micropost->id], 'method'=>'delete']) !!}
                  {!! Form::submit('Delete', ['class'=>'btn btn-danger btn-sm' ]) !!}
                {!! Form::close()  !!}
             @endif
         
     </div> 