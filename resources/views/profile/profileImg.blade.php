@extends('/general/headerFooter')
@section('content')
<head>
	<link rel="stylesheet" href="{{asset('css/general.css')}}">
</head>
<section class="container">
    <div class="container my-5">
        <h2>{{ trans('profile.change_img') }}</h2>
        <p>{{ trans('profile.profile_icon') }}</p>
    </div>
    <div class="profile-images">
        @foreach ($images as $image)
        <div>
            <a href="{{route('user.save-profile-img', ['id' => $image->id])}}">
                <img src="{{$image->path}}" alt="img_{{$image->id}}">
            </a>
        </div>  
        @endforeach
    </div>
</section>
@endsection