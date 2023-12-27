@extends('layouts.app')
@section('content')
    <form class="form-horizontal validateForm" name="edit_individual" id="edit_individual" role="form" method="POST"
          action="{{url('/bill')}}/{{$bill->id}}" novalidate="novalidate">
        {!! csrf_field() !!}
        {!! method_field('patch') !!}
        <input name="redirect_url" type="hidden" value="{{ redirect()->getUrlGenerator()->previous() }}">
        <div class="block">
            @include('bill.common_input_fields', ['bill' => $bill, 'canEdit' => true])
        </div>
    </form>
@endsection
