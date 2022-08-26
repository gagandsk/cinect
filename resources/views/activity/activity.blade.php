@extends('/general/headerFooter')
@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('css/activity.css') }}">
    </head>

    @if (count($likes) === 0)
    <div class="container d-flex justify-content-between align-items-center">
        <h2 class="text-center text-uppercase p-3 mb-4 mt-2">{{ trans('titles.activity') }}</h2>
        <a href="{{ url('/home') }}" class="btn button-purple my-4">
        {{ trans('titles.home') }}
        </a>
    </div>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="text-center notification-alert px-3 col-10">
            <h4>{{trans('profile.recent_activity')}}</h4>
            <div><i class="fab fa-gratipay"></i></div>
            <p>{{trans('profile.no_activity')}}</p>
        </div>
        </div>
    @else
    <div class="container d-flex justify-content-between align-items-center">
        <h2 class="text-center text-uppercase p-3 mb-4 mt-2">{{ trans('titles.activity') }}</h2>
        <a href="{{ url('/home') }}" class="btn button-purple my-4">
        {{ trans('titles.home') }}
        </a>
    </div>
    @foreach ($likes as $like)
        <div class="user-activity mb-2">
            @if ($like->review->film)
            <a href="{{ route('film.films', ['id' => $like->review->film->id]) }}#content_id-{{$like->review->id}}">
            @elseif($like->review->serie)
            <a href="{{ route('serie.series', ['id' => $like->review->serie->id]) }}#content_id-{{$like->review->id}}">
            @else
            <a href="{{ route('anime.animes', ['id' => $like->review->anime->id]) }}#content_id-{{$like->review->id}}">
            @endif
                <div class="d-flex align-items-center mb-2">
                    <div class="d-flex flex-row align-items-center">
                        @if(Auth::user()->image_id === null)
                        <i class="fas fa-user-circle fs-4 pe-1"></i>
                        @else
                        <img class="img-profile-activity rounded-circle shadow-1-strong me-2 mx-sm-3" src="{{ $like->user->image->path }}" alt="{{Auth::user()->image->id}}"/>
                        @endif
                        <div class="user-activity__information p-0">
                            <p class="mb-1">
                                <strong>{{ $like->user->nick }}</strong> {{ trans('profile.comment_like') }}: 
                                <span class="text-secondary">{{ $like->review->description }}</span>
                            </p>
                        </div>
                        @if ($like->review->film)
                            @if ($like->review->film->poster_path == null)
                                <img src="/img/NoImg.jpg" class="review-content-img" alt="Img">
                            @else
                                <img src="{{ $like->review->film->poster_path }}" class="review-content-img" alt="{{$like->review->film->name}}">
                            @endif
                        @elseif($like->review->serie)
                            @if ($like->review->serie->poster_path == null)
                                <img src="/img/NoImg.jpg" class="review-content-img" alt="Img">
                            @else
                                <img src="{{ $like->review->serie->poster_path }}" class="review-content-img" alt="{{$like->review->serie->name}}">
                            @endif
                        @else
                            @if ($like->review->anime->poster_path == null)
                                <img src="/img/NoImg.jpg" class="review-content-img" alt="Img">
                            @else
                                <img src="{{ $like->review->anime->poster_path }}" class="review-content-img" alt="{{$like->review->anime->name}}">
                            @endif
                        @endif
                    </div>
                </div>
            </a>
        </div>
        </div>
    @endforeach
    {{-- Pagination --}}
    <div class="d-flex justify-content-center my-4">
        {{ $likes->links() }}
    </div>
    @endif
@endsection
