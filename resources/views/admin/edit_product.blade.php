@extends('admin-layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                        Cập nhật sản phẩm
                        </header>
                        <div class="panel-body">
                        <?php
                                use Illuminate\Support\Facades\Session;
                                $message = Session::get('message');
                                if($message){
                                    echo '<span class="text-alert-1">',$message.'</span>';
		                            Session::put('message',null);
                                }
                        ?>
                            <div class="position-center">
                            @foreach($edit_product as $key => $pro)
                            <form role="form" action="{{URL::to('/update-product/' .$pro->product_id)}}" method="post" enctype="multipart/form-data">
		                            {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" name="product_name" class="form-control" id="exampleInputEmail1" value="{{$pro -> product_name}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá sản phẩm</label>
                                    <input type="text" name="product_price" class="form-control" id="exampleInputEmail1" value="{{$pro -> product_price}}" placeholder="Giá sản phẩm">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                                    <input type="file" name="product_image" class="form-control" id="exampleInputEmail1">
                                    <img src="{{URL::to('public/uploads/product/'.$pro -> product_image)}}" height="100" width="100">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung chi tiết sản phẩm</label>
                                    <textarea style="resize: none;" rows="8" class="form-control" name="product_desc" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{$pro -> product_desc}}</textarea> 
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                    <textarea style="resize: none;" rows="8" class="form-control" name="product_content" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{$pro -> product_content}}</textarea> 
                                </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                                    <select name="cate_product" class="form-control  m-bot15">
                                    @foreach($cate_product as $key => $cate)
                                        @if($cate -> category_id == $pro ->category_id)
                                        <option selected value="{{$cate -> category_id}}">
                                            {{$cate -> category_name}}           
                                        </option>
                                        @else
                                        <option value="{{$cate -> category_id}}">
                                            {{$cate -> category_name}}           
                                        </option>
                                        @endif
                                    @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">Thương hiệu sản phẩm</label>
                                    <select name="brand_product" class="form-control  m-bot15">
                                        @foreach($brand_product as $key => $brand)
                                        @if($brand -> brand_id == $pro ->brand_id)
                                        <option selected value="{{$brand -> brand_id}}">
                                            {{$brand -> brand_name}}           
                                        </option>
                                        @else
                                        <option value="{{$brand -> brand_id}}">{{$brand -> brand_name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <!-- <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                    <select name="product_status" class="form-control  m-bot15">
                                        <option value="0">Ẩn</option>
                                        <option value="1">Hiển thị</option>
                                    </select>
                                </div> -->
                        
                                <button type="submit" name="add_product" class="btn btn-info">Cập nhật sản phẩm</button>
                            </form>
                            @endforeach
                            </div>

                        </div>
                    </section>

            </div>
@endsection