@extends('layout')
@section('content')
<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Thanh toán</li>
				</ol>
			</div><!--/breadcrums-->

			<div class="register-req">
				<p>Sử dụng chức năng đăng kí hoặc đăng nhập để thanh toán giỏ hàng và xem lịch sử mua hàng</p>
			</div><!--/register-req-->

			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-15 clearfix">
						<div class="bill-to">
							<p>Thông tin gửi hàng</p>
							<div class="form-one">
								<form action="{{URL::to('/save-checkout-customer')}}" method="POST">
								{{csrf_field()}}
									<input type="text" name="shipping_email" placeholder="Email*">
									<input type="text" name="shipping_name" placeholder="Họ tên*">
									<input type="text" name="shipping_add" placeholder="Địa chỉ*">
									<input type="text" name="shipping_phone" placeholder="Số điện thoại*">
									<textarea name="shipping_note"  placeholder="Ghi chú cần thiết cho đơn hàng của bạn" rows="7"></textarea>
									<input class="btn btn-primary btn" type="submit" name="send_order" value="Gửi">
								</form>
							</div>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</section> 
@endsection
