@extends('layouts.app')
@section('content')
    <form class="form-horizontal validateForm" name="edit_individual" id="edit_individual" role="form" method="POST"
          action="{{url('/product')}}/{{$product->id}}" novalidate="novalidate">
        {!! csrf_field() !!}
        {!! method_field('PATCH') !!}
        <input name="redirect_url" type="hidden" value="{{ redirect()->getUrlGenerator()->previous() }}">
        <div class="block">
            @include('products.common_input_fields', ['product' => $product, 'canEdit' => true])
        </div>
    </form>
@endsection
