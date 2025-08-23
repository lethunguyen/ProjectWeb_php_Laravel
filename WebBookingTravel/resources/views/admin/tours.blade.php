@extends('layouts.app')
@section('content')
<h1>Quản lý Tours</h1>
<table border="1" cellpadding="6" cellspacing="0" width="100%">
 <thead>
  <tr>
   <th>ID</th>
   <th>Tiêu đề</th>
   <th>Danh mục</th>
   <th>Số lượng</th>
   <th>Giá NL</th>
   <th>Hành động</th>
  </tr>
 </thead>
 <tbody>
  @foreach($tours as $t)
  <tr>
   <td>{{ $t->tourID }}</td>
   <td>{{ $t->title }}</td>
   <td>{{ $t->category->categoryName ?? '-' }}</td>
   <td>{{ $t->quantity }}</td>
   <td>{{ number_format($t->priceAdult) }}đ</td>
   <td>
    <a href="#">Sửa</a> |
    <a href="#" onclick="return confirm('Xóa?')">Xóa</a>
   </td>
  </tr>
  @endforeach
 </tbody>
</table>
<div style="margin-top:12px;">{{ $tours->links() }}</div>
@endsection
