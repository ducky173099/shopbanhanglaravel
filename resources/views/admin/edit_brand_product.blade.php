
@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm thương hiệu sản phẩm
            </header>
            <div class="panel-body">

                <?php
                    $message = Session::get('message');
                    if ($message == true) {
                        echo '<span class="text-alert errr">'.$message.'</span>';
                        Session::put('message',null);
                    }
                ?>

                @foreach($edit_brand_product as $key => $edit_value)
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/update-brand-product/'.$edit_value->brand_id)}}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên thương hiệu</label>
                                <input value="{{$edit_value->brand_name}}" type="text" name="brand_product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả thương hiệu</label>
                                <textarea style="resize: none" rows="5" type="password" name="brand_product_desc" class="form-control" id="exampleInputPassword1" placeholder="Mô tả danh mục">
                                    {{$edit_value->brand_desc}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select value="{{$edit_value->brand_status}}" name="brand_product_status" class="form-control input-sm m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiển thị</option>
                                </select>
                            </div>
                
                            <button type="submit" name="add_brand_product" class="btn btn-info">update thương hiệu</button>
                        </form>
                    </div>

                @endforeach
            </div>
        </section>
    </div>
</div>

@endsection