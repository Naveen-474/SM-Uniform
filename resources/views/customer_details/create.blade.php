@section('title', 'SM Uniform - Customer Create')
@extends('layouts.app')
@section('content')
    <form class="form-horizontal validateForm" name="edit_individual" id="edit_individual" role="form" method="POST"
          action="{{ url('/customer-details') }}" novalidate="novalidate">
        {!! csrf_field() !!}
        <input name="redirect_url" type="hidden" value="{{ redirect()->getUrlGenerator()->previous() }}">
        <div class="block">
            @include('customer_details.common_input_fields')
        </div>
    </form>
@endsection
