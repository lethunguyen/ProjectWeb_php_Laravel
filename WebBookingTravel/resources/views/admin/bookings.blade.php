@extends('layouts.app')
@section('title','Bookings')
@section('content')
<div class="container py-4">
    <h1>Bookings</h1>
    <table class="table table-striped">
        <thead><tr><th>ID</th><th>Tour</th><th>User</th><th>Quantity</th><th>Total</th></tr></thead>
        <tbody>
        @foreach($bookings as $b)
            <tr>
                <td>{{ $b->bookingID }}</td>
                <td>{{ $b->tour->tourName ?? '' }}</td>
                <td>{{ $b->user->userName ?? 'Guest' }}</td>
                <td>{{ $b->quantity }}</td>
                <td>{{ number_format($b->totalPrice,0,',','.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $bookings->links() }}
</div>
@endsection
