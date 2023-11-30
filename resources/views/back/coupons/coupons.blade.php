@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
          کوپن های تخفیف

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="{{route('back.coupons')}}">کوپن های تخفیف</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست کوپن ها</h3>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{route('back.coupons.create')}}" type="button" class="btn btn-block btn-default btn-lg">ایجاد<i class="fa fa-plus-square"></i></a>
                    </div>
                </div>
                <hr>

        <!-- /.box-header -->
        <div class="box-body">
            <form action="{{route('back.coupons.delete.all')}}" method="post" class="form-inline">
                {{csrf_field()}}
                {{@method_field('delete')}}
                <div class="form-group">
                    <select name="checkBoxArray" class="form-control">
                        <option value="delete">حذف گروهی</option>
                    </select>
                    <input class="btn btn-sm btn-primary" type="submit" name="submit" value="اعمال">
                </div>

            @include('back.massages')
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6"></div>
                </div><div class="row">
                    <div class="col-sm-12">
                        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    شناسه
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                   عنوان کوپن
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                  کد تخفیف
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                  درصد تخفیف
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    وضعیت
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    تاریخ ایجاد
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    تاریخ بروزرسانی
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    تاریخ انقضای کوپن
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  مديريت
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($coupons as $coupon)
                                <tr role="row" class="odd">
                                    <td><input type="checkbox" id="options" name="checkBoxArray[]" value="{{$coupon->id}}"></td>
                                    <td>{{$coupon->id}}</td>
                                    <td class="sorting_1"><a href="{{route('back.coupons.edit',$coupon->id)}}">{!! mb_substr($coupon->title,0,10).'..'!!} </a></td>
                                    <td>{{$coupon->code}}</td>
                                    <td>{{$coupon->price}}</td>
                                    <td class="text-center">
                                        <?php
                                        $url = route('back.coupons.status',$coupon->id);
                                        if ($coupon['status']==1){
                                            echo '<a href="'.$url.'" class="label pull-center bg-green">منقضی نشده </a>';
                                        }
                                        else{
                                            echo '<a href="'.$url.'" class=" label pull-center bg-red">منقضی شده  </a>';
                                        }
                                        ?>
                                    </td>
                                    <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($coupon->created_at)}}</td>
                                    <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($coupon->updated_at)}}</td>

                                    <td style="font-size:10px;">
                                        @if(isset($coupon->expiry_date))
                                        {{\Hekmatinasser\Verta\Verta::instance($coupon->expiry_date)->format('H:i , %d %B %Y ')}}
                                        @elseif($coupon->expiry_date== null)

                                        @endif
                                    </td>

                                    <td>
                                        <a class=" label pull-center bg-green" href="{{route('back.coupons.show',$coupon->id)}}" >نمایش</a>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.coupons.edit',$coupon->id)}}">ويرايش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.coupons.destroy',$coupon->id)}}" onclick="return confirm('کوپن مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>
                        </table>
                    </div>
                </div>
                {{$coupons->links()}}
            </div>
            </form>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
