@php
    $canEdit = $canEdit ?? true;
    $currentRoute = Illuminate\Support\Facades\Route::currentRouteName();
@endphp
<div class="col-md-12">
    <div class="m-2 text-start">
        <a href="{{url()->previous()}}" title="Back"><i class='bx bx-chevrons-left'></i></a>
    </div>
    <div class="card mb-4">
        <h5 class="card-header">Product Details</h5>
        <div class="card-body">
            <div class="mb-3">
                <label for="product-name" class="form-label">Product Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="product-name" name="name" placeholder="Enter Product Name"
                       value="{{ old('name') ? old('name') : (!empty($product->name) ? $product->name : '') }}"
                       @if(!$canEdit) readonly @endif/>
                @error('name')
                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="product-display-name" class="form-label">Product Display Name</label>
                <input class="form-control @error('display_name') is-invalid @enderror"
                       type="text" id="product-display-name" name="display_name"
                       placeholder="Enter Product Display Name"
                       value="{{ old('display_name') ? old('display_name') : (!empty($product->display_name) ? $product->display_name : '') }}"
                       @if(!$canEdit) readonly @endif/>
                @error('display_name')
                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="hsn" class="form-label">HSN</label>
                <input type="text" class="form-control @error('hsn') is-invalid @enderror"
                       id="hsn" name="hsn" placeholder="Enter Product HSN Code"
                       value="{{ old('hsn') ? old('hsn') : (!empty($product->hsn) ? $product->hsn : '') }}"
                       @if(!$canEdit) readonly @endif/>
                @error('hsn')
                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Rate Per Item</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror"
                       id="price" name="price" placeholder="Enter Product Rate in (INR)"
                       value="{{ old('price') ? old('price') : (!empty($product->price) ? $product->price : '') }}"
                       @if(!$canEdit) readonly @endif/>
                @error('price')
                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                @enderror
            </div>
            @unless(!$canEdit)
                <div style="margin-top: 20px;" class="text-end">
                    {{--                    <a href="{{ route($currentRoute) }}" class="btn rounded-pill btn-warning">Clear</a>--}}
                    <a href="{{ url('/product') }}" class="btn rounded-pill btn-danger">Cancel</a>
                    <button type="submit" class="btn rounded-pill btn-success">
                        @if(!empty($product))
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
