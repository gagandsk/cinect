@extends('/general/headerFooter')
@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('css/general.css') }}">
        <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    @if (Session::has('AnimeAdded'))
        <div class="alert alert-success" role="alert">
            <strong>{{ Session::get('AnimeAdded') }}!</strong>
        </div>
    @endif

    @if (Session::has('AnimeDeleted'))
        <div class="alert alert-success" role="alert">
            <strong>{{ Session::get('AnimeDeleted') }}!</strong>
        </div>
    @endif

    @if (Session::has('review_deleted'))
        <div class="alert cinect-custom-alert text-center" role="alert" id="review_deleted">
            <strong>{{ Session::get('review_deleted') }}!</strong>
        </div>
    @endif

    <section class="container">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h2 class="detail-title">{{ $anime->name }}</h2>
            <a href="{{ url('/content/contentAnimes') }}" class="btn button-purple my-4">
            {{ trans('titles.back') }}
            </a>
        </div>

        <article class="d-flex flex-row flex-sm-wrap justify-content-between">
            @if ($anime->poster_path == null)
                <img src="/img/NoImg.jpg" class="img-thumbnail col-6 col-md-5 col-lg-4 mb-md-0">
            @else
                <img src="{{ $anime->poster_path }}" class="img-thumbnail col-6 col-md-5 col-lg-4 mb-md-0" alt="Img {{ $anime->name }}">
            @endif
            <article class="col-6 more-info bg-dark p-3 ms-1 ms-sm-0" id="datasheet">
                <div class="d-none align-content-center flex-wrap d-sm-flex">
                    <h5 class="pe-2 fw-bold">{{ trans('detail.genre') }}:</h5>
                    <h5 class="fw-normal">{{ \ContentGenre::TranslateGenre($anime->genre->name) }}</h5>
                </div>
                <div class="d-none align-content-center flex-wrap d-sm-flex">
                    <h5 class="pe-2 fw-bold">{{ trans('detail.release') }}:</h5>
                    <h5 class="fw-normal">{{ $anime->release_date }}</h5>
                </div>
                <div class="d-none align-content-center flex-wrap d-sm-flex">
                    <h5 class="pe-2 fw-bold">{{ trans('detail.duration') }}:</h5>
                    <h5 class="fw-normal">{{ $anime->duration }} min</h5>
                </div>
                <div class="d-none align-content-center flex-wrap d-sm-flex">
                    <h5 class="pe-2 fw-bold">{{ trans('detail.total_episodes') }}:</h5>
                    <h5 class="fw-normal">{{ $anime->total_episodes }}</h5>
                </div>
                <div class="d-none align-content-center flex-wrap d-sm-flex">
                    @if(empty($contentRate) || $contentRate == '')
                        <i class="fas fa-star mb-1 me-1 "></i>
                        <i>{{ trans('detail.no_votes_yet') }}</i>
                    @else
                        <h5 class="pe-2 fw-bold">{{ trans('detail.rating') }}:</h5>
                        <i class="fas fa-star mb-1 me-1 "></i>
                        <h5 class="fw-normal">{{ $contentRate }}/10 <i>( {{ $totalVotes }} {{ trans('detail.people_voted') }}</i></h5>
                    @endif
                </div>
                @if($userVoteExists)
                    <h5 class="fw-bold text-center my-4">{{ trans('detail.voted') }}</h5>
                @else
                    <div class="d-flex flex-column align-items-start mt-2">
                        <h5 class="fw-bold">{{ trans('detail.how_much') }}</h5>
                        <form method="POST" class="d-flex flex-column align-items-center col-12 mb-xl-2" action="{{ route('user.add_rating_anime', ['idAnime' => $anime->id]) }}">
                        @csrf
                        <div class="rating col-12 d-flex flex-row-reverse justify-content-center">
                                <input name="stars" id="e1" type="radio" value="10"><label for="e1">☆</label>
                                <input name="stars" id="e2" type="radio" value="9"><label for="e2">☆</label>
                                <input name="stars" id="e3" type="radio" value="8"><label for="e3">☆</label>
                                <input name="stars" id="e4" type="radio" value="7"><label for="e4">☆</label>
                                <input name="stars" id="e5" type="radio" value="6"><label for="e5">☆</label>
                                <input name="stars" id="e6" type="radio" value="5"><label for="e6">☆</label>
                                <input name="stars" id="e7" type="radio" value="4"><label for="e7">☆</label>
                                <input name="stars" id="e8" type="radio" value="3"><label for="e8">☆</label>
                                <input name="stars" id="e9" type="radio" value="2"><label for="e9">☆</label>
                                <input name="stars" id="e10" type="radio" value="1"><label for="e10">☆</label>
                            </div>
                            <button type="submit" class="btn button-purple col-6 mb-2 mb-xl-0">{{ trans('detail.send') }}</button>
                        </form>
                    </div>
                @endif
                @if (Session::has('RateAdded'))
                    <div class="alert alert-success" role="alert">
                        <strong>{{ Session::get('RateAdded') }}!</strong>
                    </div>
                @endif
                <div class="d-flex flex-row flex-wrap justify-content-center">
                    <div class="dropdown my-sm-2">
                        <button type="button" class="btn button-purple dropdown-toggle" data-bs-toggle="dropdown">
                            {{trans('detail.add_favs')}}
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#myModal">{{trans('detail.new_list')}}</a>
                            </li>
                            @foreach ($userLists as $list)
                                <li>
                                    <a class="dropdown-item" href="/detail/detailAnimes/{{$anime->id}}/{{$list->id}}/addFav">{{ $list->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Modal new list -->
                    <div class="modal fade" id="myModal">
                        <div class="modal-dialog text-dark">
                            <div class="modal-content">
                                <form method="POST" action="/detail/detailAnimes/{{ $anime->id }}/addNewList">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input type="text" id="newListName" name="newListName" class="form-control" placeholder="{{trans('detail.list_name')}}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-violet">{{ trans('detail.new_list') }}</button>
                                        <button class="btn btn-outline-danger" data-bs-dismiss="modal">{{ trans('titles.close') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if (isset($userTopList[0]->name))
                        <a class="btn button-purple m-2" href="/detail/detailAnimes/{{ $anime->id }}/{{ $userTopList[0]->id }}/addFav">
                            {{ trans('detail.add_to') }} {{ $userTopList[0]->name }}
                        </a>
                    @endif
                    @if(!empty($userListsWhereAnime))
                        <div class="dropdown mx-2 mt-sm-2">
                            <button type="button" class="btn btn-outline-danger dropdown-toggle my-2 my-sm-0 mb-2" data-bs-toggle="dropdown">
                                {{ trans('detail.delete_favourite') }}
                            </button>
                            <ul class="dropdown-menu">
                                @foreach ($userListsWhereAnime as $list)
                                    <li>
                                        <a class="dropdown-item" href="/detail/detailAnimes/{{$anime->id}}/{{$list->id}}/delFav">{{ $list->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (empty($userListsWhereAnime))
                    <div class="social-media-links mx-2 mt-sm-2">
                    @else
                    <div class="social-media-links">
                    @endif
                    <a class="btn button-purple m-2 m-sm-0" data-bs-toggle="collapse" href="#shareComponent" role="button" aria-expanded="false" aria-controls="shareComponent">
                            <i class="fas fa-share-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="collapse text-center my-3" id="shareComponent">
                    {!! $shareComponent !!}
                </div>
            </article>
        </article>

        <div class="px-2">
            <h5 class="pt-4"><b>{{ trans('detail.summary') }}</b></h5>
            <h5 class="description col-12 d-flex fw-normal">{{ $anime->description }}<h5>

            <article class="d-sm-none">
                <div class="d-flex flex-column">
                    <h5 class="pe-2 fw-bold">{{ trans('detail.genre') }}:</h5>
                    <h5 class="fw-normal">{{ $anime->genre->name }}<h5>
                </div>
                <div class="d-flex flex-column">
                    <h5 class="pe-2 fw-bold">{{ trans('detail.release') }}:</h5>
                    <h5 class="fw-normal">{{ $anime->release_date }}<h5>
                </div>
                <div class="d-flex flex-column">
                    <h5 class="pe-2 fw-bold">{{ trans('detail.duration') }}:</h5>
                    <h5 class="fw-normal">{{ $anime->duration }} min</h5>
                </div>
                <div class="d-flex flex-column">
                    <h5 class="pe-2 fw-bold">{{ trans('detail.total_episodes') }}:</h5>
                    <h5 class="fw-normal">{{ $anime->total_episodes }}<h5>
                </div>
                <div class="d-flex flex-column">
                    <h5 class="pe-2 fw-bold">{{ trans('detail.rating') }}:</h5>
                    <h5 class="fw-normal"><i class="fas fa-star mb-1 me-1 "></i>
                    {{ $contentRate }}/10<h5>
                </div>
            </article>
        </div>
        <!-- START TRAILER SECTION -->
        <article class="d-flex flex-column flex wrap align-items-center p-3">
            <h3 class="text-uppercase pb-3">{{ trans('detail.trailer') }}</h3>
            @if ($anime->trailer_link != null)
                <iframe src="https://www.youtube.com/embed/{{ $anime->trailer_link }}" allowfullscreen></iframe>
                <div class="alert alert-dark w-75 my-3" role="alert">
                    {{ trans('warnings.video_error') }}
                    <a href="https://www.youtube.com/results?search_query={{ $anime->name }} trailer">Youtube</a>.
                </div>
            @endif
        </article>
        <!-- END TRAILER SECTION -->

        <article class="m-0 pb-3">
            <div class="text-center pt-3 "><span id="character-counter"></span></div>
            <form method="POST" action="" id="create-comment" class="create_comment">
                @csrf
                <textarea name="description" id="description" cols="50" rows="3" placeholder="{{trans('detail.write_comment')}}"></textarea>
                <button class="btn button-purple mt-3" type="submit" id="commentSubmit">{{ trans('detail.publish') }}</button>
            </form>
            <div id="notify_user"></div>
            @if ($errors->has('description'))
                <div class="mt-2 alert alert-danger">
                    {{ trans('warnings.empty_msg') }}
                </div>
            @endif
        </article>
    </section>

    <!-- START COMMMENT SECTION -->
    <section class="gradient-custom">
        <div class="container my-0 py-0 py-sm-3">
            <div class="row d-flex justify-content-center">
                <div class="col-12 p-0 p-sm-2">
                    <div class="card card-comment bg-dark">
                        <div class="card-body card-body-comment p-4">
                            <h4 class="text-center mb-4 pb-2">{{ trans('detail.commentSection') }}</h4>

                            <div class="row">
                                <div class="col" id="comment-container">
                                    @foreach ($comments as $comment)
                                        @if ($comment->anime_id == $anime->id && !empty($comment->description))
                                            @include('includes.review', ['comment' => $comment])
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="alert alert-success d-none" id="msg_div" role="alert"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- END COMMENT SECTION -->
    <script type="text/javascript">
        $("#notify_user").css("display", "none");

        jQuery('#create-comment').submit(function(e) {
            e.preventDefault();
            $("#commentSubmit").attr("disabled", true);
            var url = '{{ route('comment.save.anime', ['id' => $anime->id]) }}';
            var data = jQuery('#create-comment')
                .serialize();
            jQuery('#commentSubmit').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
            );

            $('#commentSubmit').addClass('loagindEffect');

            jQuery.ajax({
                url: url,
                data: data,
                type: 'POST',
                success: function(response) {
                    jQuery("#commentSubmit").removeClass("loagindEffect");
                    jQuery('#notify_user').html(
                        `<div class="alert alert-success" role="alert"><i class="fas fa-check-circle"></i>${response.msg}</div>`
                    );
                    jQuery('#notify_user').fadeIn("slow");
                    jQuery('#create-comment')[0]
                        .reset();
                    jQuery('.spinner-border')
                        .remove();
                    jQuery('#commentSubmit').html('Publicar');
                    jQuery('#notify_user').fadeOut(3000);
                    setTimeout(() => {
                            jQuery('#commentSubmit').attr('disabled', false);
                        },
                        3900
                    );

                    let commentID = response.comment['id'];
                    let commentDescription = response.comment['description'];
                    let commentHtml =
                        `<div class="d-flex flex-start mb-4" id="content_id-${commentID}">
                        <div><img class="img-profile rounded-circle shadow-1-strong me-3" src="{{ Auth::user()->image->path }}"></div>
                        <div class="flex-grow-1 flex-shrink-1"><div>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-1">{{ Auth::user()->nick }} <span class="text-muted" id="last-comment"></span></p> 
                            </div>
                            <p class="small mb-0 comment">${ commentDescription }</p>
                            </div>
                            <div class="like-container">
                                <span class="far fa-heart like-review btn-like" id="btn-like" data-id="${ commentID }"></span>
                                <span id="like-counter">0 likes</span>
                                <form class="mt-2" method="POST" action="/review/delete/${commentID}">
                                    @csrf
                                    <input type="hidden" id="${ commentID }" name="user-comment" value="${ commentID }">
                                    <button class="btn btn-outline-danger" type="submit">{{ trans('detail.delete_review') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>`

                    jQuery('#comment-container').append(commentHtml);
                    jQuery('#character-counter').css("display", "none");

                    setTimeout(() => {
                        jQuery('body,html').animate({
                            scrollTop: $(document).height()
                        }, 5);
                    }, 500);

                },
                error: function(response) {
                    jQuery("#commentSubmit").removeClass("loagindEffect");
                    showInputErrors();
                    jQuery('#notify_user').fadeIn("slow");
                    jQuery('.spinner-border').remove();
                    jQuery('#commentSubmit').html('Publicar');
                    jQuery('#notify_user').fadeOut(4000);
                    setTimeout(() => {
                        jQuery('#commentSubmit').attr('disabled', false);
                    }, 4900);
                }
            })

        });


        const showInputErrors = () => {

            const description = $('#description').val();


            if (description == '') {
                jQuery('#notify_user').html(
                    `<div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-circle"></i>{{ trans('warnings.empty_msg') }}</div>`
                );
            } else if (description.length > 255) {
                jQuery('#notify_user').html(
                    `<div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-circle"></i>{{ trans('warnings.too_long_msg') }}</div>`
                );
            } else {
                jQuery('#notify_user').html(
                    `<div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-circle"></i>{{ trans('warnings.error_ocurred') }}</div>`
                );

                //location.reload();
            }

        }

        const characterLiveCount = () => {
            const description = document.getElementById('description');
            const characterCounter = document.getElementById('character-counter');

            description.addEventListener("input", () => {
                let count = (description.value).length;
                document.getElementById("character-counter").textContent = `Caracteres: ${count}/255`;
                if (count >= 0 && count < 165) {
                    characterCounter.style.color = "white";
                } else if (count >= 165 && count <= 255) {
                    characterCounter.style.color = "yellow";
                } else {
                    characterCounter.style.color = "red";
                }

                if (count == 0) {
                    characterCounter.style.display = "none";
                } else {
                    characterCounter.style.display = "inline";
                }
            });

        }

        characterLiveCount();

        function like() {
            jQuery('.btn-like').unbind('click').click(function() {
                $(this).addClass('btn-dislike').removeClass('btn-like');
                $(this).addClass('fas').removeClass('far');
                $(this).css("color", "red");
                let comment_id = $(this).data('id');
                let ruta = `/like/${comment_id}`;
                //console.log(ruta);
                $.ajax({
                    type: "POST",
                    url: ruta,
                    data: {
                        '_token': $('input[name=_token]').val(),
                        review_id: comment_id,
                    },
                    success: function(data) {
                        //console.log(data.message);
                        if (data.like) {
                            console.log("Has dado like de forma correcta");
                        } else {
                            console.log("Error al dar like");
                        }
                    }
                });
                dislike();
            })
        }
        like();

        function dislike() {
            jQuery('.btn-dislike').unbind('click').click(function() {
                $(this).addClass('btn-like').removeClass('btn-dislike');
                $(this).addClass('far').removeClass('fas');
                $(this).css("color", "#FFFFFF");
                let comment_id = $(this).data('id');
                let ruta = `/dislike/${comment_id}`;
                $.ajax({
                    type: "POST",
                    url: ruta,
                    data: {
                        '_token': $('input[name=_token]').val(),
                        review_id: comment_id,
                    },
                    success: function(data) {
                        if (data.like) {
                            console.log("Has dado dislike de forma correcta");
                        } else {
                            console.log("Error al dar dislike");
                        }
                    }
                });
                like();
            })
        }
        dislike();
    </script>
@endsection