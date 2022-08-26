@extends('general.headerFooter')
@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('css/general.css') }}">
        <link rel="stylesheet" href="{{asset('css/profile.css')}}">
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    </head>

    <section class="container">
    <h1 class="mt-4 px-4">{{trans('profile.title_profile')}}</h1>
        @if (Session::has('profileImageUpdated'))
            <div class="alert cinect-custom-alert text-center" role="alert" id="profileImageUpdated">
                <strong>{{ Session::get('profileImageUpdated') }}!</strong>
            </div>
        @endif
        
        <div class="d-flex justify-content-center">
            <img class="img-profile col-6 col-sm-5 col-lg-4" src="{{ Auth::user()->image->path }}" alt="hola">
        </div>

        <div class="d-flex justify-content-center">
            <a href="{{ route('user.profile-img') }}" class="col-5">
                <button class="btn button-purple mt-3 col-12">{{trans('profile.change_img')}}</button>
            </a>
        </div>

        <form class="row g-3 my-2 mb-4" id="save" action="{{ route('user.update') }}" method="POST">
            @csrf
            <div class="col-12 col-sm-6 p-0 m-0 py-2 px-4 pe-sm-2">
                <label for="username" class="form-label">{{ trans('profile.username') }}</label>
                <input type="text" class="form-control" name="username" id="username" value="{{ Auth::user()->nick }}">
            </div>
            <div class="d-none col-12 col-sm-6 p-0 m-0 py-2 px-4 ps-sm-2">
                <label for="realName" class="form-label">{{ trans('profile.name') }}</label>
                <input type="text" class="form-control" name="realName" id="realName" value="{{ Auth::user()->name . ' ' . Auth::user()->surname }}" disabled>
            </div>
            <div class="col-12 col-sm-6 p-0 m-0 py-2 px-4 pe-sm-2">
                <label class="form-label">{{ trans('profile.language') }}</label>
                <p id="lang" style="display: none;">{{ Auth::user()->lang }}</p>
                <select class="form-select" name="language">
                    <option class="form-option" id="es" value="es">Castellano</option>
                    <option class="form-option" id="ca" value="ca">Català</option>
                    <option class="form-option" id="en" value="en">English</option>
                </select>
            </div>
            <div class="d-flex flex-wrap flex-row justify-content-center m-0">
                <a href="{{ route('change.password') }}" class="col-4 px-2 btn button-purple mt-3">
                    {{trans('profile.change_pass')}}
                </a>
                <button class="btn btn-outline-danger mt-3 col-4 px-2 ms-2" data-bs-toggle="modal" data-bs-target="#myModalDelete" type="button">
                    {{trans('profile.delete_profile')}}
                </button>
            </div>
            <div class="modal fade text-dark" id="myModalDelete">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ trans('profile.delete_profile') }}</h4>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            {{ trans('warnings.del_profile_conf') }}
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-info" data-bs-dismiss="modal" type="button">{{ trans('profile.cancel') }}</button>
                            <a href="{{ route('delete.account') }}" type="button" class="btn btn-outline-danger">{{ trans('profile.delete') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center m-0">
                <button type="submit" class="btn button-purple mt-3 col-4">{{ trans('profile.save') }}</button>
            </div>
        </form>
    </section>

    <script>
    
        let lang = document.getElementById('lang').innerHTML;
        console.log(lang);
        switch (lang) {
            case 'es':
                document.getElementById('es').selected = true;
                break;
            case 'ca':
                document.getElementById('ca').selected = true;
                break;
            case 'en':
                document.getElementById('en').selected = true;
                break;
        }
        console.log(lang);
        

        if(document.getElementById('profileImageUpdated')){
            setTimeout( () => {
                $( "#profileImageUpdated" ).fadeOut( "slow");
            },5000);
        }
    </script>
@endsection