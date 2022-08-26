    <div class="d-flex flex-start mb-3" id="content_id-{{$comment->id}}">
        <div>
            @if(Auth::user()->image_id === null)
                <i class="fas fa-user-circle fs-4 pe-1"></i>
            @else
                @if($comment)
                    <img class="img-profile rounded-circle shadow-1-strong me-3" src="{{ $comment->user->image->path }}" alt="a">
                @endif
            @endif
        </div>
        <div class="flex-grow-1 flex-shrink-1">
            <div class="d-flex flex-wrap flex-column align-items-start">
                <div class="col-12">
                    <p class="mb-1">{{ $comment->user->nick }} <span class="text-muted ms-2">{{\DateTimeFormat::timeFilter($comment->created_at)}}</span></p>
                </div>
                <p class="text-break m-0">{{ $comment->description }}</p>
            </div>
            <div class="like-container">
                <!--CHECKING IF USER'S LIKE ALREADY EXISTS-->
                <?php $user_like = false; ?>
                @foreach($comment->like as $like)
                    @if($like->user->id == Auth::user()->id)
                        <?php $user_like = true;?>
                    @endif
                @endforeach

                @if($user_like)
                    <span class="fas fa-heart like-review btn-dislike" id="btn-dislike" style="color:red;" data-id="{{$comment->id}}"></span>
                @else
                    <span class="far fa-heart like-review btn-like" id="btn-like" data-id="{{$comment->id}}"></span>
                @endif
                    <span id="like-counter">{{count($comment->like)}} likes</span>
            </div>
            
            @if($comment->user_id == Auth::user()->id)
            <form class="mt-2" method="POST" action="{{ route('user.comment-delete',['id' => $comment->id]) }}">
                @csrf
                <input type="hidden" id="{{$comment->id}}" name="user-comment" value="{{$comment->id}}">
                <button class="btn btn-outline-danger" type="submit">{{trans('detail.delete_review')}}</button>
            </form>
            @endif
            
            {{--
            <!----START REPLY COMMENT---->
            <!-- <div class="d-flex flex-start mt-4">
                <a class="me-3" href="#"> <img class="rounded-circle shadow-1-strong me-3"
                        src="{{ $profile->path }}" alt="13" width="65" height="65" /></a>
                <div class="flex-grow-1 flex-shrink-1">
                    <div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-1">
                                Simona Disa <span class="text-muted">- 3 hours ago</span>
                            </p>
                        </div>
                        <p class="small mb-0">
                            letters, as opposed to using 'Content here, content here',
                            making it look like readable English.
                        </p>
                    </div>
                </div>
            </div> -->
            <!----END REPLY COMMENT---->
            ---}}
        </div>
    </div>
