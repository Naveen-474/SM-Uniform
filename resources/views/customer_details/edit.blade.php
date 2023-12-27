@extends('layouts.app')
@section('content')
    <form class="form-horizontal validateForm" name="edit_individual" id="edit_individual" role="form" method="POST"
          action="{{url('/customer-details')}}/{{$customer->id}}" novalidate="novalidate">
        {!! csrf_field() !!}
        {!! method_field('patch') !!}
        <input name="redirect_url" type="hidden" value="{{ redirect()->getUrlGenerator()->previous() }}">
        <div class="block">
            @include('customer_details.common_input_fields', ['customer' => $customer, 'canEdit' => true])
        </div>
    </form>
@endsection
