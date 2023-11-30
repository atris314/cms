<div class="rightcolumn">
    <div class="cardblog">
        <form action="{{route('search')}}" method="get">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control input-costoming" name="title" placeholder="جستجوی مطالب..." aria-label="Username" value="{{old('title')}}" aria-describedby="basic-addon1">
                <div class="input-group-prepend">
                    <button type="submit" class="input-group-text input-costoming-btn" id="basic-addon1"><i class="icofont-search"></i></button>
                </div>
            </div>
        </form>

    </div>
    <div class="cardblog">
        <h3>دسته بندی مطالب</h3>
        @foreach($categories as $category)
        <div class="category-name"><a href="{{route('postcat',$category->slug)}}">{{$category->title}}</a> </div><br>
        @endforeach
    </div>
    <div class="cardblog">
        <h3>مقالات مرتبط</h3>
        @foreach($posts as $itempost)
        <div class="fakeimg">
            <div class="row">
                <div class="col-lg-8"> <a href="{{route('postdetail',$itempost->slug)}}">{{$itempost->title}}</a> <span>{{\Hekmatinasser\Verta\Verta::instance($itempost->created_at)->format('H:i , %d %B %Y ')}}</span> </div>
                <div class="col-lg-4"> <img src="{{$itempost->photo->path}}" class="sidebar-img"> </div>
            </div>


        </div>
            <br>
        @endforeach
    </div>
    <div class="cardblog">
        <h6>یابانه را در شبکه های اجتماعی دنبال کنید</h6>
        <div class="text-center social-links mt-3">

            <a href="{{$settings->instagram}}" class="instagram"><i class="bx bxl-instagram"></i></a>
            <a href="{{$settings->telegram}}" class="telegram"><i class="bx bxl-telegram"></i></a>
            <a href="{{$settings->whatsapp}}" class="whatsapp"><i class="bx bxl-whatsapp"></i></a>
            <a href="https://www.aparat.com/yabane.ir" class="aparat" style="position: absolute;"><img src="{{asset('front/assets/img/aparat.png')}}" width="30"></a>
        </div>
    </div>
</div>
