@extends('layouts.app')
@section('content')

        <form class="form-horizontal validateForm" role="form" method="POST"
              action="{{ url('/product') }}" novalidate="novalidate">
        {!! csrf_field() !!}
        <div class="block">
            @include('products.common_input_fields')
        </div>
    </form>
@endsection
