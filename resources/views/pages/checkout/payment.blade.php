
@extends('layout')
@section('content')


<section id="cart_items">
    <div class="container" style="width: 100% !important;">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
                <li class="active">Thanh toán giỏ hàng</li>
            </ol>
        </div><!--/breadcrums-->

        <div class="review-payment">
            <h2>Xem lại giỏ hàng</h2>
        </div>

        <div class="table-responsive cart_info" >
            <?php
                $content = Cart::content();
                // echo $content;
            ?>
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Mô tả</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Tổng tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($content as $key => $v_content)
                        <tr>
                            <td class="cart_product">
                                <a href=""><img src="{{URL::to('public/uploads/product/'.$v_content->options->image)}}" width="50" alt=""></a>
                            </td>
                            <td class="cart_description">
                                <h4><a href="">{{$v_content->name}}</a></h4>
                                <p>Web ID: 1089772</p>
                            </td>
                            <td class="cart_price">
                                <p>{{number_format($v_content->price)}} VNĐ</p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <form action="{{URL::to('/update-cart-quantity')}}" method="post">
                                        {{ csrf_field() }}
                                         {{-- <a class="cart_quantity_up" href=""> + </a> --}}
                                        <input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content->qty}}">
                                        {{-- <a class="cart_quantity_down" href=""> - </a> --}}
                                        <input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class="form-controll">
                                        <input type="submit" value="Cập nhật" name="update_qty" class="btn btn-default btn-sm">
                                    </form>
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">
                                    <?php 
                                        $subtotal = $v_content->price * $v_content->qty;
                                        echo number_format($subtotal).' '.'vnđ';
                                    ?>
                                </p>
                            </td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
 
                </tbody>
            </table>
        </div>

        <h4 style="margin-bottom: 40px">Chọn hành thức thanh toán</h4>

        <form action="{{URL::to('/order-place')}}" method="post">
            {{ csrf_field() }}
            <div class="payment-options">
                <span>
                    <label><input name="payment_option" value="1" type="checkbox"> Trả bằng thử ATM</label>
                </span>
                <span>
                    <label><input name="payment_option" value="2" type="checkbox"> Nhận tiền mặt</label>
                </span>
                <span>
                    <label><input name="payment_option" value="3" type="checkbox"> Thanh toán thẻ ghi nợ</label>
                </span>
                <input type="submit" value="Đặt hàng" name="send_order_place" class="btn btn-primary btn-sm">
            </div>
        </form>

    </div>
</section> <!--/#cart_items-->



@endsection