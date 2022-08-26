@extends('/general/headerFooter')
@section('content')

<section class="container">
    <p class="d-none">{{$cont = 0}}</p>
    <div class="container-fluid d-flex justify-content-between align-items-center">
            <h2>{{ trans('titles.lists') }}</h2>
            <a href="{{ url('/home') }}" class="btn button-purple my-4">
            {{ trans('titles.home') }}
            </a>
        </div>
    @foreach($userFavs as $favList)
        <div>
            @if($favList->top_list == 1)
                <a href="lista-fav/{{$favList->id}}" class="image-link col-4 col-md-3 col-lg-2 p-2 search-content-info">
                    <div class="mt-4 p-2 w-100 h-100 text-white rounded button-purple cursor">
                        <h4 class="ms-2 mb-0">{{$favList->name}}</h4>
                    </div>  
                </a>
            @else
                <a href="lista-fav/{{$favList->id}}">
                    <div class="mt-4 p-2 w-100 h-100 text-white rounded button-purple cursor">
                        <h4 class="ms-2 mb-0">{{$favList->name}}</h4>
                    </div>
                </a>
            @endif
            <br>
        </div>
        <p class="d-none">{{$cont++}}</p>
    @endforeach
</section>
<!-- END COMMENT SECTION -->
@endsection