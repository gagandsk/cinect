@extends('/general/noHeaderFooter')
@section('content')
<div class="card text-center bg-dark session-card">
    <div class="card-body p-3 vh-100">
        <img class="rounded-circle shadow-1-strong me-3 my-3" src="{{ Auth::user()->image->path }}" alt="a" width="110"height="110">
        <p class="card-text">{{ trans('warnings.hi') }}<strong> {{ Auth::user()->name }} </strong>{{ trans('warnings.open_session') }}</p>
        <div class="d-flex flex-column align-items-center">
            <a href="{{ route('home') }}" class="btn btn-violet mb-2 col-4 text-light"><i class="fas fa-arrow-left mx-2"></i>{{ trans('warnings.back') }}</a>
            <a href="{{ route('signout.user') }}" class="btn btn-violet col-4 text-light"><i class="fas fa-sign-out-alt mx-2"></i>{{ trans('warnings.close_session') }}</a>
        </div>
    </div>
</div>
@endsection