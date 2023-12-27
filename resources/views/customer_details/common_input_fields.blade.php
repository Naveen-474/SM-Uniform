@php
    $canEdit = $canEdit ?? true;
    $currentRoute = Illuminate\Support\Facades\Route::currentRouteName();
@endphp
<div class="col-md-12">
    <div class="m-2 text-start">
        <a href="{{url()->previous()}}" title="Back"><i class='bx bx-chevrons-left'></i></a>
    </div>
    <div class="card mb-4">
        <h5 class="card-header">Customer Details</h5>
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Customer/Company Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                       placeholder="Enter Customer Name"
                       value="{{ old('name') ? old('name') : (!empty($customer->name) ? $customer->name : '') }}"
                       @if(!$canEdit) readonly @endif/>
                    @error('name')
                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                @enderror
            </div>
            <div class="mb-3 row">
                <label for="address" class="col-md-2 form-label">Address</label>
                <label>
                    <div class="col-md-12">
                        <textarea class="form-control text-content-editor" id="address" name="address" rows="3">{{ old('address') ? old('address') : (!empty($customer->address) ? $customer->address : '') }}</textarea>
                    </div>
                </label>

                @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="pin-code" class="form-label">Pin Code</label>
                <input type="text" class="form-control @error('pin_code') is-invalid @enderror" id="pin-code" name="pin_code"
                       placeholder="Enter Customer Pin Code"
                       value="{{ old('pin_code') ? old('pin_code') : (!empty($customer->pin_code) ? $customer->pin_code : '') }}"
                       @if(!$canEdit) readonly @endif/>
                    @error('pin_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="mobile-number" class="form-label">Mobile Number</label>
                <input type="text" class="form-control @error('mobile_number') is-invalid @enderror" id="mobile-number" name="mobile_number"
                       placeholder="Enter Mobile Number"
                       value="{{ old('mobile_number') ? old('mobile_number') : (!empty($customer->mobile_number) ? $customer->mobile_number : '') }}"
                       @if(!$canEdit) readonly @endif/>
                    @error('mobile_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="gstin" class="form-label">GST IN</label>
                <input type="text" class="form-control @error('gstin') is-invalid @enderror" id="gstin" name="gstin"
                       placeholder="Enter Customer GSTIN"
                       value="{{ old('gstin') ? old('gstin') : (!empty($customer->gstin) ? $customer->gstin : '') }}"
                       @if(!$canEdit) readonly @endif/>
                    @error('gstin')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            @unless(!$canEdit)
{{--                {!! formButtons('Update') !!}--}}
                <div style="margin-top: 20px;" class="text-end">
{{--                    <a href="{{ route($currentRoute) }}" class="btn rounded-pill btn-warning">Clear</a>--}}
                    <a href="{{ url('/customer-details') }}" class="btn rounded-pill btn-danger">Cancel</a>
                    <button type="submit" class="btn rounded-pill btn-success">
                        @if(!empty($customer))
                            Update
                        @else
                            Create
                        @endif
                    </button>
                </div>
            @endunless
        </div>
    </div>
</div>
@include('script_helpers.text_area_size_adjustment_script')
