@extends('/general/headerFooter')
@section('content')

<head>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>

@if (Session::has('welcomeUser'))
<div class="alert cinect-custom-alert" role="alert" id="welcomeMessage">
    <strong>{{ Session::get('welcomeUser') }}!</strong>
</div>
@endif

<section class="slider">
    <div id="carouselExampleIndicators" class="carousel slide carousel-fade " data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item full text-center active">
                <a href="/detail/detailFilms/37" class="link-img-carousel">
                    <img src="{{$film[36]->poster_path}}" class="full-img px-2 px-sm-1" alt="Img {{$film[36]->name}}">
                </a>
                <a href="/detail/detailFilms/38" class="link-img-carousel">
                    <img src="{{$film[37]->poster_path}}" class="full-img px-2 px-sm-1" alt="Img {{$film[37]->name}}">
                </a>
                <a href="/detail/detailFilms/39" class="link-img-carousel">
                    <img src="{{$film[38]->poster_path}}" class="full-img px-2 px-sm-1" alt="Img {{$film[38]->name}}">
                </a>
            </div>
            <div class="carousel-item full text-center">
                <a href="/detail/detailSeries/37" class="link-img-carousel">
                    <img src="{{$serie[36]->poster_path}}" class="full-img px-2 px-sm-1" alt="Img {{$serie[36]->name}}">
                </a>
                <a href="/detail/detailSeries/38" class="link-img-carousel">
                    <img src="{{$serie[37]->poster_path}}" class="full-img px-2 px-sm-1" alt="Img {{$serie[37]->name}}">
                </a>
                <a href="/detail/detailSeries/39" class="link-img-carousel">
                    <img src="{{$serie[38]->poster_path}}" class="full-img px-2 px-sm-1" alt="Img {{$serie[38]->name}}">
                </a>
            </div>
            <div class="carousel-item full text-center">
                <a href="/detail/detailAnimes/37" class="link-img-carousel">
                    <img src="{{$anime[36]->poster_path}}" class="full-img px-2 px-sm-1" alt="Img {{$anime[36]->name}}">
                </a>
                <a href="/detail/detailAnimes/38" class="link-img-carousel">
                    <img src="{{$anime[37]->poster_path}}" class="full-img px-2 px-sm-1" alt="Img {{$anime[37]->name}}">
                </a>
                <a href="/detail/detailAnimes/39" class="link-img-carousel">
                    <img src="{{$anime[38]->poster_path}}" class="full-img px-2 px-sm-1" alt="Img {{$anime[38]->name}}">
                </a>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</section>
<section class="section-content container-fluid">

<!-- PELÍCULAS -->
<div class="container-fluid d-flex justify-content-between align-items-center" id="title-button">
        <h3 class="title text-uppercase">{{trans('home.films')}}</h3>
        <a href="{{asset('/content/contentFilms')}}"><button type="button" class="btn button-purple btn-sm">{{trans('home.view_more')}}</button></a>
    </div>
    <div class="container-fluid d-flex flex-row align-items-center p-0" id="container">
        <a class="btn-floating me-0" href="#films" data-bs-slide="prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
        <div id="films" class="carousel slide carousel-fade carousel-equal-heights my-4" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner" role="listbox">
                <?php            
                    $k=0;
                    echo '<div class="carousel-item active">
                    <div class="row">';
                    for($j=0; $j < 3; $j++) {
                        echo '<div class="col d-flex justify-content-center p-1">
                        <a href="/detail/detailFilms/'.$film[$k]->id.'" class="link-img-detail">';
                            if($film[$k]->poster_path == NULL)
                            echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                            else
                            echo '<img src="'.$film[$k]->poster_path.'" class="img-carousel"  alt="Img {{$film[$k]->name}}">';
                            $k++;
                            echo'</a>
                        </div>';
                    }
                    for($j=$j; $j < 5; $j++) {
                        echo '<div class="col d-none d-sm-flex justify-content-center p-1">
                                <a href="/detail/detailFilms/'.$film[$k]->id.'" class="link-img-detail">';
                                if($film[$k]->poster_path == NULL)
                                echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                                else
                                echo '<img src="'.$film[$k]->poster_path.'" class="img-carousel"  alt="Img {{$film[$k]->name}}">';
                                $k++;
                                echo'</a>
                            </div>';
                    }
                    for($j=$j; $j < 7; $j++) {
                        echo '<div class="col d-none d-md-flex justify-content-center p-1">
                            <a href="/detail/detailFilms/'.$film[$k]->id.'" class="link-img-detail">';
                            if($film[$k]->poster_path == NULL)
                            echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                            else
                            echo '<img src="'.$film[$k]->poster_path.'" class="img-carousel"  alt="Img {{$film[$k]->name}}">';
                            $k++;
                            echo'</a>
                        </div>';
                    }
                        echo '</div>
                    </div>';
                    for($i=2; $i < 8; $i++) {
                        echo '<div class="carousel-item">
                        <div class="row">';
                        for($j=0; $j < 3; $j++) {
                            echo '<div class="col d-flex justify-content-center p-1">
                                <a href="/detail/detailFilms/'.$film[$k]->id.'" class="link-img-detail">';
                                if($film[$k]->poster_path == NULL)
                                echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                                else
                                echo '<img src="'.$film[$k]->poster_path.'" class="img-carousel"  alt="Img {{$film[$k]->name}}">';
                                $k++;
                                echo'</a>
                            </div>';
                        }
                        for($j=$j; $j < 5; $j++) {
                            echo '<div class="col d-none d-sm-flex justify-content-center p-1">
                                <a href="/detail/detailFilms/'.$film[$k]->id.'" class="link-img-detail">';
                                if($film[$k]->poster_path == NULL)
                                echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                                else
                                echo '<img src="'.$film[$k]->poster_path.'" class="img-carousel"  alt="Img {{$film[$k]->name}}">';
                                $k++;
                                echo'</a>
                            </div>';
                        }
                        for($j=$j; $j < 7; $j++) {
                            echo '<div class="col d-none d-md-flex justify-content-center p-1">
                                <a href="/detail/detailFilms/'.$film[$k]->id.'" class="link-img-detail">';
                                if($film[$k]->poster_path == NULL)
                                echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                                else
                                echo '<img src="'.$film[$k]->poster_path.'" class="img-carousel"  alt="Img {{$film[$k]->name}}">';
                                $k++;
                                echo'</a>
                            </div>';
                        }   
                        echo '</div>
                    </div>';
                    }
                ?>
            </div>
        </div>
        <a class="btn-floating" href="#films" data-bs-slide="next">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </a>
    </div>

    <!-- SERIES -->
    <div class="container-fluid d-flex justify-content-between align-items-center" id="title-button">
        <h3 class="title text-uppercase">{{trans('home.series')}}</h3>
        <a href="{{asset('/content/contentSeries')}}">
            <button class="btn button-purple btn-sm">{{trans('home.view_more')}}</button>
        </a>
    </div>
    <div class="container-fluid d-flex flex-row align-items-center p-0" id="container">
        <a class="btn-floating me-0" href="#series" data-bs-slide="prev">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
        </a>
        <div id="series" class="carousel slide carousel-fade carousel-equal-heights my-4" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner" role="listbox">
                <?php            
                        
                    $k=0;
                    echo '<div class="carousel-item active">
                    <div class="row">';
                    for($j=0; $j < 3; $j++) {
                        echo '<div class="col d-flex justify-content-center p-1">
                            <a href="/detail/detailSeries/'.$serie[$k]->id.'" class="link-img-detail">';
                            if($serie[$k]->poster_path == NULL)
                            echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                            else
                            echo '<img src="'.$serie[$k]->poster_path.'" class="img-carousel"  alt="Img {{$serie[$k]->name}}">';
                            $k++;
                            echo'</a>
                        </div>';
                    }
                    for($j=$j; $j < 5; $j++) {
                        echo '<div class="col d-none d-sm-flex justify-content-center p-1">
                            <a href="/detail/detailSeries/'.$serie[$k]->id.'" class="link-img-detail">';
                            if($serie[$k]->poster_path == NULL)
                            echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                            else
                            echo '<img src="'.$serie[$k]->poster_path.'" class="img-carousel"  alt="Img {{$serie[$k]->name}}">';
                            $k++;
                            echo'</a>
                        </div>';
                    }
                    for($j=$j; $j < 7; $j++) {
                        echo '<div class="col d-none d-md-flex justify-content-center p-1">
                            <a href="/detail/detailSeries/'.$serie[$k]->id.'" class="link-img-detail">';
                            if($serie[$k]->poster_path == NULL)
                            echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                            else
                            echo '<img src="'.$serie[$k]->poster_path.'" class="img-carousel"  alt="Img {{$serie[$k]->name}}">';
                            $k++;
                            echo'</a>
                        </div>';
                    }
                        echo '</div>
                    </div>';
                    for($i=2; $i < 8; $i++) {
                        echo '<div class="carousel-item">
                        <div class="row">';
                        for($j=0; $j < 3; $j++) {
                            echo '<div class="col d-flex justify-content-center p-1">
                                <a href="/detail/detailSeries/'.$serie[$k]->id.'" class="link-img-detail">';
                                if($serie[$k]->poster_path == NULL)
                                echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                                else
                                echo '<img src="'.$serie[$k]->poster_path.'" class="img-carousel"  alt="Img {{$serie[$k]->name}}">';
                                $k++;
                                echo'</a>
                            </div>';
                        }
                        for($j=$j; $j < 5; $j++) {
                            echo '<div class="col d-none d-sm-flex justify-content-center p-1">
                                <a href="/detail/detailSeries/'.$serie[$k]->id.'" class="link-img-detail">';
                                if($serie[$k]->poster_path == NULL)
                                echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                                else
                                echo '<img src="'.$serie[$k]->poster_path.'" class="img-carousel"  alt="Img {{$serie[$k]->name}}">';
                                $k++;
                                echo'</a>
                            </div>';
                        }
                        for($j=$j; $j < 7; $j++) {
                            echo '<div class="col d-none d-md-flex justify-content-center p-1">
                                <a href="/detail/detailSeries/'.$serie[$k]->id.'" class="link-img-detail">';
                                if($serie[$k]->poster_path == NULL)
                                echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                                else
                                echo '<img src="'.$serie[$k]->poster_path.'" class="img-carousel"  alt="Img {{$serie[$k]->name}}">';
                                $k++;
                                echo'</a>
                            </div>';
                        }
                            
                        echo '</div>
                    </div>';
                    }
                ?>
            </div>
        </div>
        <a class="btn-floating" href="#series" data-bs-slide="next">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </a>
    </div>
    
    <!-- ANIME -->
    <div class="container-fluid d-flex justify-content-between align-items-center" id="title-button">
        <h3 class="title text-uppercase">{{trans('home.animes')}}</h3>
        <a href="{{asset('/content/contentAnimes')}}">
            <button type="button" class="btn button-purple btn-sm">{{trans('home.view_more')}}</button>
        </a>
    </div>
    <div class="container-fluid d-flex flex-row align-items-center p-0" id="container">
        <a class="btn-floating me-0" href="#animes" data-bs-slide="prev">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
        </a>
        <div id="animes" class="carousel slide carousel-fade carousel-equal-heights my-4" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner" role="listbox">
                <?php                 
                    $k=0;
                    echo '<div class="carousel-item active">
                    <div class="row">';
                    for($j=0; $j < 3; $j++) {
                        echo '<div class="col d-flex justify-content-center p-1">
                            <a href="/detail/detailAnimes/'.$anime[$k]->id.'" class="link-img-detail">';
                            if($anime[$k]->poster_path == NULL)
                            echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                            else
                            echo '<img src="'.$anime[$k]->poster_path.'" class="img-carousel"  alt="Img {{$anime[$k]->name}}">';
                            $k++;
                            echo'</a>
                        </div>';
                    }
                    for($j=$j; $j < 5; $j++) {
                        echo '<div class="col d-none d-sm-flex justify-content-center p-1">
                            <a href="/detail/detailAnimes/'.$anime[$k]->id.'" class="link-img-detail">';
                            if($anime[$k]->poster_path == NULL)
                            echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                            else
                            echo '<img src="'.$anime[$k]->poster_path.'" class="img-carousel"  alt="Img {{$anime[$k]->name}}">';
                            $k++;
                            echo'</a>
                        </div>';
                    }
                    for($j=$j; $j < 7; $j++) {
                        echo '<div class="col d-none d-md-flex justify-content-center p-1">
                            <a href="/detail/detailAnimes/'.$anime[$k]->id.'" class="link-img-detail">';
                            if($anime[$k]->poster_path == NULL)
                            echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                            else
                            echo '<img src="'.$anime[$k]->poster_path.'" class="img-carousel"  alt="Img {{$anime[$k]->name}}">';
                            $k++;
                            echo'</a>
                        </div>';
                    }
                    echo '</div>
                    </div>';
                    for($i=2; $i < 8; $i++) {
                        echo '<div class="carousel-item">
                        <div class="row">';
                        for($j=0; $j < 3; $j++) {
                            echo '<div class="col d-flex justify-content-center p-1">
                                <a href="/detail/detailAnimes/'.$anime[$k]->id.'" class="link-img-detail">';
                                if($anime[$k]->poster_path == NULL)
                                echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                                else
                                echo '<img src="'.$anime[$k]->poster_path.'" class="img-carousel"  alt="Img {{$anime[$k]->name}}">';
                                $k++;
                                echo'</a>
                            </div>';
                        }
                        for($j=$j; $j < 5; $j++) {
                            echo '<div class="col d-none d-sm-flex justify-content-center p-1">
                                <a href="/detail/detailAnimes/'.$anime[$k]->id.'" class="link-img-detail">';
                                if($anime[$k]->poster_path == NULL)
                                echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                                else
                                echo '<img src="'.$anime[$k]->poster_path.'" class="img-carousel"  alt="Img {{$anime[$k]->name}}">';
                                $k++;
                                echo'</a>
                            </div>';
                        }
                        for($j=$j; $j < 7; $j++) {
                            echo '<div class="col d-none d-md-flex justify-content-center p-1">
                                <a href="/detail/detailAnimes/'.$anime[$k]->id.'" class="link-img-detail">';
                                if($anime[$k]->poster_path == NULL)
                                echo '<img src="/img/NoImg.jpg"class="img-carousel" alt="">';
                                else
                                echo '<img src="'.$anime[$k]->poster_path.'" class="img-carousel"  alt="Img {{$anime[$k]->name}}">';
                                $k++;
                                echo'</a>
                            </div>';
                        }
                            
                    echo '</div>
                    </div>';
                    }
                ?>
            </div>
        </div>
        <a class="btn-floating" href="#animes" data-bs-slide="next">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </a>
    </div>
</section>
<script>
    if(document.getElementById('welcomeMessage')){
        setTimeout( () => {
            document.getElementById('welcomeMessage').style.display = "none";
        },5000);
    }
</script>
@endsection