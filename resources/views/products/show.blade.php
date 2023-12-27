@section('title', 'SM Uniform - Product Show')
@extends('layouts.app')
@section('content')
    <div class="block">
        @include('products.common_input_fields', ['product' => $product, 'canEdit' => false])
    </div>
@endsection
