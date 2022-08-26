@extends('/general/headerFooter')
@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    </head>


    <section class="container py-5">

        @if(!empty($series) && count($series) > 0)
            <div class="d-flex flex-row justify-content-between align-items-center">
                <h4 class="mt-2 mb-3">{{trans('titles.'.$genre.'')}}</h4>
                <div class="d-flex justify-content-center">
                    <a href="{{ url('/content/contentSeries') }}" class="btn button-purple my-4">{{ trans('titles.back') }}</a>
                </div>
            </div>

            <div class="content d-flex flex-wrap align-items-stretch justify-content-center">
                @foreach ($series as $serie)
                    <a href="{{route('serie.series', ['id' => $serie->id])}}" class="image-link col-3 col-sm-2 p-2">
                        @if ($serie->poster_path === null) 
                            <img src="/img/NoImg.jpg" class="img-content col-12" alt="No Image">
                        @else
                            <img src="{{$serie->poster_path}}" class="img-content col-12" alt="{{$serie->name}}">
                        @endif
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center">
                <h4 class="mt-2 mb-3">{{trans('titles.'.$genre.'')}}</h4>
                <a href="{{ url('/content/contentSeries') }}" class="btn button-purple my-4">{{trans('home.back')}}</a>
                <h5 class="text-center">{{trans('content.serie_genre_not_have_content')}}</h5>
            </div>
        @endif
    </section>

    <script></script>

@endsection
