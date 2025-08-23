@extends('layouts.app')
@section('title','Promotions')
@section('content')
<div class="container py-4">
    <h1>Promotions</h1>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Title</th><th>Discount %</th><th>Start</th><th>End</th></tr></thead>
        <tbody>
        @foreach($promotions as $p)
            <tr>
                <td>{{ $p->promotionID }}</td>
                <td>{{ $p->title ?? '' }}</td>
                <td>{{ $p->discountPercent ?? '' }}</td>
                <td>{{ $p->startDate ?? '' }}</td>
                <td>{{ $p->endDate ?? '' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $promotions->links() }}
</div>
@endsection
