@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
         فایل ها | رسانه ها

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">فایل ها | رسانه ها</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست فایل ها | رسانه ها</h3>
                        </div>

                    </div>
                    <div class="col-lg-3">
                        <a href="{{route('back.photos.create')}}" type="button" class="btn btn-block btn-default btn-lg">آپلود<i class="fa fa-plus-square"></i></a>
                    </div>
                </div>
                <hr>

        <!-- /.box-header -->
        <div class="box-body">
            <form action="{{route('back.photos.delete.all')}}" method="post" class="form-inline">
                {{csrf_field()}}
                {{@method_field('delete')}}
                <div class="form-group">
                    <select name="checkBoxArray" class="form-control">
                        <option value="delete">حذف گروهی</option>
                    </select>
                    <input class="btn btn-sm btn-primary" type="submit" name="submit" value="اعمال">
                </div>

            @include('back.massages')
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap mt-5"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >
                                   <input type="checkbox" id="options">
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >
                                   ردیف
                                </th>

                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >
                                    تصویر
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >
                                    نام فایل
                                </th>

                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >
                                    نام کاربر
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >
                                    تاریخ ایجاد
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >
                                  مديريت
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" >
                                    شناسه
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1; ?>
                            @foreach($photos as $photo)

                                <tr role="row" class="odd">

                                    <td><input type="checkbox" id="options" name="checkBoxArray[]" value="{{$photo->id}}"></td>
                                    <td>{{$i++}}</td>

                                    <td><img src="{{$photo->path}}" style="width: 130px; height: 100px;"></td>
                                    <td>{{route('home')}}{{$photo->path}}</td>
                                    <td>
                                        @if($photo->user)
                                        {{$photo->user->name}}
                                        @endif
                                    </td>
                                    <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($photo->created_at)}}</td>
                                    <td>
                                        <a class=" label pull-center bg-red" href="{{route('back.photos.destroy',$photo->id)}}" onclick="return confirm('فایل مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                    <td>{{$photo->id}}</td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>

                    </div>
                </div>

                {{$photos->links()}}
            </div>
            </form>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
