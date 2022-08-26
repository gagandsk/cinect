@extends('/general/headerFooter')
@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('css/top.css') }}">
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    </head>
    <section class="container top_content my-5">
        <div class="cinect-carousel">
            <div class="cinect-carousel--container">
                <div class="cinect-carousel--container--content">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <?php $contador = 1; ?>
                        @foreach ($films->take(3) as $film)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#flush-film_{{ $film->original_id }}" aria-expanded="false" aria-controls="flush-collapseOne">
                                        <div class="accordion-button--img">
                                            <img src="{{ $film->poster_path }}" alt="{{ $film->name }}">
                                            <span class="accordion-button--img__identifier"><?= $contador ?></span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="flush-film_{{ $film->original_id }}" class="accordion-collapse collapse content-detail" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <span><?= $contador++ ?></span>
                                        <a href="{{ route('film.films', ['id' => $film->id]) }}">{{ $film->name }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @foreach ($animes->take(3) as $anime)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#flush-film_{{ $anime->original_id }}" aria-expanded="false" aria-controls="flush-collapseOne">
                                        <div class="accordion-button--img">
                                            <img src="{{ $anime->poster_path }}" alt="{{ $anime->name }}">
                                            <span class="accordion-button--img__identifier"><?= $contador ?></span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="flush-film_{{ $anime->original_id }}" class="accordion-collapse collapse content-detail" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <span><?= $contador++ ?></span>
                                        <a href="{{ route('anime.animes', ['id' => $anime->id]) }}">{{ $anime->name }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @foreach ($series->take(4) as $serie)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#flush-film_{{ $serie->original_id }}" aria-expanded="false" aria-controls="flush-collapseOne">
                                        <div class="accordion-button--img">
                                            <img src="{{ $serie->poster_path }}" alt="{{ $serie->name }}">
                                            <span class="accordion-button--img__identifier"><?= $contador ?></span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="flush-film_{{ $serie->original_id }}" class="accordion-collapse collapse content-detail" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <span><?= $contador++ ?></span>
                                        <a href="{{ route('serie.series', ['id' => $serie->id]) }}">{{ $serie->name }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="cinect-banner my-5">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <?php $ariaCurrent = true; $slide_to=0; $aria_label =1;  ?>
                        @foreach(array_slice($contents, 0, 6) as $content)
                            @if($ariaCurrent)
                                <button data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?=$slide_to++?>"class="active" aria-current="true" aria-label="Slide <?=$aria_label++?>"></button>
                                <?= $ariaCurrent = false?>
                            @else
                                <button data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?=$slide_to++?>" aria-label="Slide <?=$aria_label++?>"></button>
                            @endif
                    @endforeach
                </div>
                <div class="carousel-inner">
                    <?php $first_active = true; ?>
                    @foreach(array_slice($contents, 0, 6) as $content)
                    @if($first_active)
                    <div class="carousel-item active">
                    <?= $first_active = false?>
                    @else
                    <div class="carousel-item">
                    @endif
                        <img src="{{$content->poster_path}}" class="d-block w-100" alt="{{$content->name}}">
                        <div class="carousel-caption d-md-block">
                            <h5>{{$content->name}}</h5>
                            <p>{{$content->release_date}}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <h3 class="mb-3 text-center content-title">Top {{ trans('titles.films') }}</h3>
        <section class="cinet_top--content">
            @foreach ($films->take(10) as $film)
                <a class="p-2" href="{{ route('film.films', ['id' => $film->id]) }}">
                    <div class="cinet_top--detail">
                        <img src="{{ $film->poster_path }}">
                        <p>{{ $film->name }}<span>{{ $film->puntuation }}</span></p>
                    </div>
                </a>
            @endforeach
        </section>
        <div class="d-flex justify-content-center mt-2">
            <a class="btn button-purple col-2" href="{{ route('film.all-films') }}">{{ trans('home.view_more') }}</a>
        </div>

        <h3 class="mt-5 text-center content-title">Top {{ trans('titles.series') }}</h3>
        <section class="cinet_top--content">
            @foreach ($series->take(10) as $serie)
                <a class="p-2" href="{{ route('serie.series', ['id' => $serie->id]) }}">
                    <div class="cinet_top--detail">
                        <img src="{{ $serie->poster_path }}">
                        <p>{{ $serie->name }}<span>{{ $serie->puntuation }}</span></p>
                    </div>
                </a>
            @endforeach
        </section>
        <div class="d-flex justify-content-center mt-2">
            <a class="btn button-purple col-2" href="{{ route('serie.all-series') }}">{{ trans('home.view_more') }}</a>
        </div>
        <h3 class="mt-5 text-center content-title">Top {{ trans('titles.animes') }}</h3>
        <section class="cinet_top--content">
            @foreach ($animes->take(10) as $anime)
                <a class="p-2" href="{{ route('anime.animes', ['id' => $anime->id]) }}">
                    <div class="cinet_top--detail">
                        <img src="{{ $anime->poster_path }}">
                        <p>{{ $anime->name }}<span>{{ $anime->puntuation }}</span></p>
                    </div>
                </a>
            @endforeach
        </section>
        <div class="d-flex justify-content-center mt-2">
            <a class="btn button-purple col-2"  href="{{ route('anime.all-animes') }}">{{ trans('home.view_more') }}</a>
        </div>
    </section>
    <script type="text/javascript"></script>
@endsection
