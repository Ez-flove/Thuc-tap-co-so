@extends('admin-layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông tin khách hàng 
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên khách hàng</th>
            <th>SDT</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          
          <tr>
            <td>{{$order_byid->customer_name}}</td>
            <td>{{$order_byid->customer_phone}}</td>            
          </tr>
       
        </tbody>
      </table>
    </div>
  </div>
</div>

<br><br>

<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông tin vận chuyển 
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên người nhận</th>
            <th>Địa chỉ</th>
            <th>SDT</th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          
          <tr>
            <td>{{$order_byid->shipping_name}}</td>
            <td>{{$order_byid->shipping_addres}}</td>  
            <td>{{$order_byid->shipping_phone}}</td>            
          </tr>

        </tbody>
      </table>
    </div>
  </div>
</div>


<br><br>

<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê chi tiết đơn hàng 
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Tổng tiền</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          
          <tr>
            <td>{{$order_byid->product_name}}</td>
            <td>{{$order_byid->product_sales_quantity}}</td>  
            <td>{{$order_byid->product_price}}</td>    
            <td>{{$order_byid->order_total}}</td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection