@extends('layouts.app')
@section('content')
    <div class="block">
        @include('customer_details.common_input_fields', ['customer' => $customer, 'canEdit' => false])
    </div>
@endsection
