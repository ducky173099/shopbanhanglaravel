
@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                update sản phẩm
            </header>
            <div class="panel-body">

                <?php
                    $message = Session::get('message');
                    if ($message == true) {
                        echo '<span class="text-alert errr">'.$message.'</span>';
                        Session::put('message',null);
                    }
                ?>

                <div class="position-center">
                    @foreach($edit_product as $key => $edit_value)
                        <form role="form" action="{{URL::to('/update-product/'.$edit_value->product_id)}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên san pham</label>
                                <input value="{{$edit_value->product_name}}" type="text" name="product_name" class="form-control" id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá sản phẩm</label>
                                <input value="{{$edit_value->product_price}}" type="text" name="product_price" class="form-control" id="exampleInputEmail1" placeholder="Giá">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                                <input type="file" name="product_image" class="form-control" id="exampleInputEmail1">
                                <img src="{{URL::to('public/uploads/product/'.$edit_value->product_image)}}" width="100" height="100">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả san pham</label>
                                <textarea style="resize: none" rows="5" type="password" name="product_desc" class="form-control" id="exampleInputPassword1">
                                    {{$edit_value->product_desc}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung san pham</label>
                                <textarea style="resize: none" rows="5" type="password" name="product_content" class="form-control" id="exampleInputPassword1">
                                    {{$edit_value->product_content}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                                <select name="product_cate" class="form-control input-sm m-bot15">
                                    @foreach($cate_product as $key => $cate)
                                        @if($cate->category_id == $edit_value->category_id)
                                            <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                        @else
                                            <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                        @endif                                    
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Thương hiệu</label>
                                <select name="product_brand" class="form-control input-sm m-bot15">
                                    @foreach($brand_product as $key => $brand)
                                        @if($brand->brand_id == $edit_value->brand_id)
                                            <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                        @else
                                            <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                        @endif 
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select name="product_status" class="form-control input-sm m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiển thị</option>
                                </select>
                            </div>
                
                            <button type="submit" name="add_product" class="btn btn-info">update sản phẩm</button>
                        </form>
                    @endforeach

                </div>
            </div>
        </section>
    </div>
</div>

@endsection