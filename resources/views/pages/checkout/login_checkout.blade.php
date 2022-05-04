@extends('layout')
@section('content')
<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Đăng nhập vào tài khoản của bạn</h2>
						<form action="{{URL::to('/login-customer')}}" method="POST">
						{{csrf_field()}}
							<input type="text" name="email_acc" placeholder="Tài khoản" />
							<input type="password" name="pass_acc" placeholder="Mật khẩu" />
							<span>
								<input type="checkbox" class="checkbox"> 
								Ghi nhớ đăng nhập
							</span>
							<button type="submit" class="btn btn-default">Đăng nhập</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">Hoặc</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Tài khoản mới</h2>
						<form action="{{URL::to('/add-customer')}}" method="POST">
								    {{csrf_field()}}
							<input type="text" name="customer_name" placeholder="Tài khoản"/>
							<input type="email" name="customer_email" placeholder="Địa chỉ Email"/>
							<input type="text" name="customer_phone" placeholder="Điện thoại"/>
							<input type="password" name="customer_pass" placeholder="Mật khẩu"/>
							<button type="submit" class="btn btn-default">Tạo tài khoản</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
@endsection