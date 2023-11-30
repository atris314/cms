
<div class="comments-area">
    <div class="display-comment">
        @foreach($comments as $comment)
            <img src="{{asset('front/assets/img/unnamed.png')}}">
            <strong>{{ $comment->name }}</strong>
            <p>{{ $comment->description }}</p>
            @endforeach
    </div>
</div>


    <div class="cardblog">
    @include('front.massages')
    <h4>دیدگاه خود را بنویسید</h4>
    <form method="post" action="{{ route('comment.store',$post->slug) }}">
        @csrf
        <div class="form-group">
            @auth
                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group">
                            <input class="form-control-customize " name="name" id="name" type="text" value="{{Auth::user()->name}}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input class="form-control-customize " name="email" id="email" type="email" value="{{Auth::user()->email}}" readonly>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input class="form-control-customize " name="name" id="name" type="text" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input class="form-control-customize " name="email" id="email" type="email" placeholder="Email">
                        </div>
                    </div>
                </div>
            @endauth
            <textarea type="text" name="description" class="form-control-customize " placeholder="دیدگاه خود را بنویسید.."></textarea>
            <input type="hidden" name="post_id" value="{{ $post->id }}" />
                <div class="form-group mt-5">
                    @arcaptchaWidget
                    <div class="validate"></div>
                </div>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-sm blog-btn" value="ثبت دیدگاه" />
        </div>
    </form>
</div>
