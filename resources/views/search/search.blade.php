@extends('general.headerFooter')
@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
        <link rel="stylesheet" href="{{ asset('css/content.css') }}">
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <section class="container mt-4">
        <form action="{{ route('search-content') }}" method="GET">
            <div class="input-group align-items-center">
                <label id="clear-input"><i class="fas fa-times p-2"></i></label>
                <input type="text" class="form-control" id="search-content" name="search" placeholder="{{trans('home.search_cinect')}}">
                <button class="btn btn-outline-light" type="submit" id="submitSearch"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </section>

    <section class="container py-4">
        @if (!empty($content['films']) || !empty($content['series']) || !empty($content['animes']))
            <p style="text-align:start; margin-bottom:20px; padding-left:5px; border-left:3px solid #5A3C97">{{ trans('warnings.found_results') }}: <strong>{{ $search }}</strong></p>
            <div class="content d-flex flex-wrap align-items-streach justify-content-center searchcontent">
                @for ($data = 0; $data < count($content); $data++)
                    @foreach ($content[array_keys($content)[$data]] as $key => $value)
                        <a href="/detail/detail{{ ucfirst(array_keys($content)[$data]) }}/{{ $value->id }}" class="image-link col-4 col-md-3 col-lg-2 p-2 search-content-info">
                            @if ($value->poster_path === null)
                                <img src="/img/NoImg.jpg" class="img-content col-12" alt="No image">
                            @else
                                <img src="{{ $value->poster_path }}" class="img-content col-12" alt="{{ array_keys($content)[$data] }}">
                            @endif
                        </a>
                    @endforeach
                @endfor
            </div>
        @else
            @if (isset($search))
                <h5 class="text-center">{{ trans('warnings.content_not_found') }} 
                    <span style="opacity:0.8;">{{ $search }}</span>
                </h5>
            @endif
        @endif
    </section>
    
    <script type="text/javascript">
        var searchInput = document.getElementById("search-content");
        var clearInput = document.getElementById("clear-input");

        $(clearInput).css("display", "none");
        $("#submitSearch").attr("disabled", true);

        searchInput.addEventListener("input", () => {
            let count = (searchInput.value).length;

            if (count == 0) {
                $(clearInput).fadeOut("slow");
            } else {
                $(clearInput).fadeIn("slow");
                $("#submitSearch").attr("disabled", false);
                deleteSearchWords();
            }
        });

        const deleteSearchWords = () => {
            clearInput.onclick = () => {
                searchInput.value = '';
                $("#submitSearch").attr("disabled", true);
                if (searchInput.value.length == 0) {
                    $(clearInput).fadeOut("slow");
                }
            }
        }
    </script>
@endsection
