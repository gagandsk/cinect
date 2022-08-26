@extends('/general/headerFooter')
@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
    <link rel="stylesheet" href="{{ asset('css/like.css') }}">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
</head>

@if(!Auth::user())
    <h3>Para crear tu lista de favoritos necessitas estar logueado, <a href="{{route('register.user')}}">INICIA SESSIÓN</a></h3>
@else
    <p id="idList" style="display: none;">{{ $data['list']->id }}</p>
    <div class="container-fluid d-flex justify-content-between align-items-center px-5">
            <h1 class="text-uppercase">{{$data['list']->name}}</h1>
            <a href="{{ url('/user/list') }}" class="btn button-purple my-4">
            {{ trans('titles.lists') }}
            </a>
        </div>

    <section class="container top_content mb-4">
        <section class="cinet_top--content my-3">
            @foreach($data['animes'] as $anime)
                <a class="p-1" href="{{ route('anime.animes',  ['id' => $anime->id]) }}">
                    <div class="cinet_top--detail">
                        @if($anime->poster_path === NULL)
                        <img src="/img/NoImg.jpg" alt="">
                        @else
                        <img src="{{ $anime->poster_path }}" alt="">
                        @endif
                    </div>
                    <p>{{ $anime->name }}<span>{{ $anime->puntuation }}</span></p>
                </a>
            @endforeach
            @foreach($data['series'] as $serie)
                <a class="p-1" href="{{ route('serie.series',  ['id' => $serie->id]) }}">
                    <div class="cinet_top--detail">
                        <div>
                            @if($serie->poster_path === NULL)
                            <img src="/img/NoImg.jpg" alt="">
                            @else
                            <img src="{{ $serie->poster_path }}" alt="">
                            @endif
                        </div>
                    </div>
                    <p>{{ $serie->name }}<span>{{ $serie->puntuation }}</span></p>
                </a>
            @endforeach
            @foreach($data['films'] as $film)
                <a class="p-1" href="{{ route('film.films',  ['id' => $film->id]) }}">
                    <div class="cinet_top--detail">
                        <div>
                            @if($film->poster_path === NULL)
                            <img src="/img/NoImg.jpg" alt="">
                            @else
                            <img src="{{ $film->poster_path }}" alt="">
                            @endif
                        </div>
                    </div>
                    <p>{{ $film->name }}<span>{{ $film->puntuation }}</span></p>
                </a>
            @endforeach
        </section>
    </div>
    
    @if($data['list']->top_list == 1)
        <a href="{{$data['list']->id}}/unsetFavorite" class="btn button-purple" title="Home">
            Eliminar lista destacada
        </a>
    @else
        <a href="{{$data['list']->id}}/addFavorite" class="btn button-purple" title="Home">
            Guardar como lista destacada
        </a>
    @endif

    <a href="{{$data['list']->id}}/deleteFavorite" class="btn btn-outline-danger" title="Home">
        Eliminar lista
    </a>
@endif
<!-- END COMMENT SECTION -->
@endsection