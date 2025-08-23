@extends('client.layouts.app')
@section('title', $tour->tourName ?? 'Tour Detail')
@section('content')
<div class="container py-4">
    <h1>{{ $tour->tourName }}</h1>
    <p><strong>Category:</strong> {{ $tour->category->categoryName ?? 'N/A' }}</p>
    <p><strong>Price:</strong> {{ number_format($tour->price,0,',','.') }} VND</p>
    <div class="row g-3 mb-3">
        @foreach($tour->images as $img)
            <div class="col-md-3"><img src="{{ $img->imageUrl }}" class="img-fluid rounded" alt="image"></div>
        @endforeach
    </div>
    <a href="{{ route('client.tours.index') }}" class="btn btn-secondary">Back to list</a>
</div>
@endsection
