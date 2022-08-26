<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- FONT FAMILY ROBOTO -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/1f7457abdb.js"></script>
    <title>Cinect</title>
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>
<body>
    <!-- START HEADER -->
    <header class="navbar-dark sticky-top" id="navbar_top">
        <!-- START NAVBAR -->
        <nav class="navbar navbar-expand-xs">
            <div class="container-fluid">
                <div class="d-flex flex-row justify-content-between">
                    <button class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand me-0 d-flex align-items-center align-items-md-start ms-2 ms-sm-3" href="{{ url('home') }}">
                        <img src="/img/CinectLogo.svg" class="logo">
                    </a>
                </div>
                <div class="d-flex flex-direction-row flex-nowrap justify-content-end align-items-center col-3">
                    @if(Request::url() !== url('/search/search'))
                        <button class="btn cinect-searchBtn-modal" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <i class="fas fa-search text-light p-0 pt-1"></i>
                        </button>
                    @endif        
                    <div class="dropdown">
                        <button class="btn text-light dropdown-toggle d-flex flex-direction-row flex-nowrap justify-content-end align-items-center p-0 px-sm-2" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="true">
                            @if(Auth::user()->image_id === null)
                            <i class="fas fa-user-circle fs-4 pe-1"></i>
                            @else
                            <img class="img-profile-navbar me-sm-2" src="{{ Auth::user()->image->path }}" alt="{{Auth::user()->image->id}}">
                            @endif

                            @if (Auth::check())
                                <p class="d-none d-sm-flex m-0">{{ Auth::user()->nick }}</p>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <a class="dropdown-item" href="{{ route('user.profile') }}">
                                    <i class="fas fa-user-circle px-1"></i>
                                    {{trans('titles.profile')}}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{route('user.favorite.list')}}">
                                    <i class="fas fa-list px-1"></i>
                                    {{trans('titles.lists')}}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{route('user.activity')}}">
                                    <i class="fas fa-bell px-1"></i>
                                    {{trans('titles.activity')}}
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="/">
                                    <i class="fas fa-sign-out-alt px-1"></i>{{trans('titles.logout')}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
                    <div class="offcanvas-header p-4">
                        <h1 class="menu-title text-uppercase m-0" id="offcanvasWithBothOptionsLabel">{{trans('titles.menu')}}</h1>
                        <button class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body px-4">
                        <ul class="list-unstyled">
                            <li>
                                <a href="{{ url('home') }}" class="menu-links text-light text-uppercase">
                                    <i class="fas fa-home iconos"></i>{{trans('titles.home')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/content/contentFilms') }}" class="menu-links text-light text-uppercase">
                                    <i class="fas fa-film iconos"></i>{{trans('titles.films')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/content/contentSeries') }}" class="menu-links text-light text-uppercase">
                                    <i class="fas fa-tv iconos"></i>{{trans('titles.series')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/content/contentAnimes') }}" class="menu-links text-light text-uppercase">
                                    <i class="fas fa-dragon iconos"></i>{{trans('titles.animes')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('top.top-content') }}" class="menu-links text-light text-uppercase">
                                    <i class="fas fa-sort-amount-up-alt iconos"></i>{{trans('titles.top')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('search.view') }}" class="menu-links text-light text-uppercase">
                                    <i class="fas fa-search iconos"></i>{{trans('titles.search')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.favorite.list') }}" class="menu-links text-light text-uppercase">
                                    <i class="fas fa-th-list iconos"></i>{{trans('titles.lists')}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- END NAVBAR -->
    </header>
    <!-- SEARCH MODAL -->
    <div class="modal fade cinect-custom-search-modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <form action="{{ route('search-content') }}" method="GET">
                <div class="input-group align-items-center">
                    <label style="visibility: hidden;" id="clear-input"><i class="fas fa-times p-2"></i></label>
                    <input type="text" class="form-control" id="search-content" name="search" placeholder="{{trans('home.search_cinect')}}">
                    <button class="btn" style="color: #5A3C97;" type="submit" id="submitSearch"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <button class="cinect-modal-btn" data-bs-dismiss="modal" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                    <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                </svg>
            </button>
          </div>
        </div>
      </div>
    <!-- END HEADER -->
    <!-- START MAIN -->
    <main>
        @yield('content')
    </main>
    <!-- END MAIN -->
    <button class="btn btn-floating btn-lg" id="btn-back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>
    <!-- START FOOTER -->
    <footer class="footer text-center text-white">
        <div class="container-fluid">
            <!-- SECTION: LINKS -->
            <section class="pt-4 pb-1">
                <h3 class="text-uppercase">Links</h3>
                <div class="d-flex flex-row flex-wrap justify-content-center">
                    <a href="{{ url('/home') }}" class="footer-links text-white px-md-1">{{trans('titles.home')}}</a>
                    <a href="{{ url('/content/contentFilms') }}" class="footer-links text-white px-md-1">{{trans('titles.films')}}</a>
                    <a href="{{ url('/content/contentSeries') }}" class="footer-links text-white px-md-1">{{trans('titles.series')}}</a>
                    <a href="{{ url('/content/contentAnimes') }}" class="footer-links text-white px-md-1">{{trans('titles.animes')}}</a>
                    <a href="{{ route('top.top-content') }}" class="footer-links text-white px-md-1">{{trans('titles.top')}}</a>
                    <a href="{{ route('search.view') }}" class="footer-links text-white px-md-1">{{trans('titles.search')}}</a>
                    <a href="{{ url('/user/list') }}" class="footer-links text-white px-md-1">{{trans('titles.lists')}}</a>
                </div>
            </section>
            <!-- SECTION: LINKS -->
            <!-- SECTION: SOCIAL MEDIA -->
            <section class="py-2 d-flex flex-row flex-wrap justify-content-center">
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-twitter"></i></a>
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-google"></i></a>
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-instagram"></i></a>
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-github"></i></a>
            </section>
            <!-- SECTION: SOCIAL MEDIA -->
        </div>
        <!-- COPYRIGHT -->
        <div class="copyright text-center p-3">
            <p class="m-0">© 2022 Copyright:
            <a class="text-white" href="/home">Cinect</a></p>
        </div>
        <!-- COPYRIGHT -->
    </footer>
    <!-- END FOOTER -->
</body>
<script>
    let mybutton = document.getElementById("btn-back-to-top");
    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function () {
        scrollFunction();
    };

    function scrollFunction() {
    if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
    ) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
    }
    // When the user clicks on the button, scroll to the top of the document
    mybutton.addEventListener("click", backToTop);

    function backToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
    }
</script>
</html>