@extends('/general/headerFooter')
@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    </head>


    <section class="container py-5">

        @if(!empty($films) && count($films) > 0)
            <div class="d-flex flex-row justify-content-between align-items-center">
                <h4 class="mt-2 mb-3">{{trans('titles.'.$genre.'')}}</h4>
                <div class="d-flex justify-content-center">
                    <a href="{{ url('/content/contentFilms') }}" class="btn button-purple my-4">{{ trans('titles.back') }}</a>
                </div>
            </div>

            <div class="content d-flex flex-wrap align-items-stretch justify-content-center">
                @foreach ($films as $film)
                    <a href="{{route('film.films', ['id' => $film->id])}}" class="image-link col-3 col-sm-2 p-2">
                        @if ($film->poster_path === null) 
                            <img src="/img/NoImg.jpg" class="img-content col-12" alt="No Image">
                        @else
                            <img src="{{$film->poster_path}}" class="img-content col-12" alt="{{$film->name}}">
                        @endif
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center">
                <h4 class="mt-2 mb-3">{{trans('titles.'.$genre.'')}}</h4>
                <a href="{{ url('/content/contentFilms') }}" class="btn button-purple my-4">{{trans('home.back')}}</a>
                <h5 class="text-center">{{trans('content.film_genre_not_have_content')}}</h5>
            </div>
        @endif
    </section>
    <div class="d-flex justify-content-center mb-4">
        {{$films->links()}}
    </div>
    <script></script>

@endsection
