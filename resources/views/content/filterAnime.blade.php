@extends('/general/headerFooter')
@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    </head>


    <section class="container py-5">

        @if(!empty($animes) && count($animes) > 0)
            <div class="d-flex flex-row justify-content-between align-items-center">
                @if($genre == 'sci-fi')
                <h4 class="mt-2 mb-3">{{trans('titles.scifi')}}</h4>
                @else
                <h4 class="mt-2 mb-3">{{trans('titles.'.$genre.'')}}</h4>
                @endif
                <div class="d-flex justify-content-center">
                    <a href="{{ url('/content/contentAnimes') }}" class="btn button-purple my-4">{{ trans('titles.back') }}</a>
                </div>
            </div>

            <div class="content d-flex flex-wrap align-items-stretch justify-content-center">
                @foreach ($animes as $anime)
                    <a href="{{route('anime.animes', ['id' => $anime->id])}}" class="image-link col-3 col-sm-2 p-2">
                        @if ($anime->poster_path === null) 
                            <img src="/img/NoImg.jpg" class="img-content col-12" alt="No Image">
                        @else
                            <img src="{{$anime->poster_path}}" class="img-content col-12" alt="{{$anime->name}}">
                        @endif
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center">
                @if($genre == 'sci-fi')
                <h4 class="mt-2 mb-3">{{trans('titles.scifi')}}</h4>
                @else
                <h4 class="mt-2 mb-3">{{trans('titles.'.$genre.'')}}</h4>
                @endif
                <a href="{{ url('/content/contentAnimes') }}" class="btn button-purple my-4">{{trans('home.back')}}</a>
                <h5 class="text-center">{{trans('content.anime_genre_not_have_content')}}</h5>
            </div>
        @endif
    </section>

    <script></script>

@endsection
