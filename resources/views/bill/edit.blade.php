@section('title', 'SM Uniform - Bill Edit')
@extends('layouts.app')
@section('content')
    <div class="block">
        @php
            $canEdit = $canEdit ?? true;
            $currentRoute = Illuminate\Support\Facades\Route::currentRouteName();
            info($bill);
            $billProducts = App\Models\BillProduct::with('product')->where('bill_id', $bill->id)->get();
            info($billProducts);
        $products = App\Models\Product::get();
        @endphp
        <div class="col-md-12">
            <div class="m-2 text-start">
                <a href="{{url()->previous()}}" title="Back"><i class='bx bx-chevrons-left'></i></a>
            </div>
            <div class="card mb-4">
                <h5 class="card-header">Bill Details</h5>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="customer" class="form-label col-md-4">Choose Customer</label>
                                <label>
                                    <select class="form-select col-md-8 select2" name="customer" id="customer" aria-label="Default select example">
{{--                                        @foreach ($bill as $customer )--}}
                                            <option value="{{ $bill->customer->id }}">{{ $bill->customer->name }}</option>
{{--                                        @endforeach--}}
                                    </select>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label for="billed-at" class="col-md-2 col-form-label">Bill Date</label>
                                <label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="date" id="billed-at"  name="billed_at" value="{{ $bill->billed_at }}"/>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2" style="margin-left: -6px">
                        <button class="btn btn-default text-center" id="add-field">
                            <i class="icon-plus-circle text-primary icon-position bx bx-plus-circle"></i>
                        </button>
                    </div>

                    @foreach ($billProducts as $product )
                        <div class="mb-3">
                            <div id="product-container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <select class="form-select col-md-10 select2" id="product-1" name="product_1"
                                                aria-label="Default select example">
                                                <option value="{{ $product->id }}">{{ $product->product->name }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control @error('address') is-invalid @enderror" type="text" id="product-count-1" name="product_count_1"
                                               placeholder="Enter No of Product"
                                               value="{{ old('product_count_1') ? old('product_count_1') : (!empty($product->product_count) ? $product->product_count : '') }}"/>
                                    </div>
                                    <div class="col-md-2" style="margin-left: -6px">
                                        <button class="btn btn-default text-center remove-field">
                                            <i class="icon-plus-circle text-primary icon-position bx bx-minus-circle" onclick="removeElement(' + counter +')"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @unless(!$canEdit)
                        <div style="margin-top: 20px;" class="text-end">
                            <a href="{{ url('/customer-details') }}" class="btn rounded-pill btn-danger">Cancel</a>
                            <a class="btn rounded-pill btn-success tip" title="Save"
                               onclick="saveBillDetails()">Save</a>
                        </div>
                    @endunless
                </div>
            </div>
        </div>

        <script>
            let counter = 1;
            $(document).ready(function () {
                const removedIds = [];

                function initializeSelect2() {
                    $("select").select2({
                        width: '100%'
                    });
                }

                // Initial Select2 setup
                initializeSelect2();

                $("#add-field").on("click", function (event) {
                    event.preventDefault();

                    // Fetch product data using AJAX
                    $.ajax({
                        url: '/get-products',
                        method: 'GET',
                        success: function (data) {

                            var clonedRow = $(".row:eq(1)").clone();

                            clonedRow.find('.col-md-2').html('' +
                                '<button class="btn btn-default text-center remove-field"><i class="icon-plus-circle text-primary icon-position bx bx-minus-circle" onclick="removeElement(' + counter +')"></i></button>'
                            );

                            clonedRow.find('input[type="text"]').each(function (index, element) {
                                var currentName = $(element).attr('name');
                                var currentId = $(element).attr('id');

                                let newName = currentName.replace("1", "");
                                let newId = currentId.replace("1", "");

                                $(element).attr('name', newName + (counter + 1));
                                $(element).attr('id', newId + (counter + 1));
                                $(element).val('');
                            });

                            clonedRow.find('select').each(function (index, element) {
                                var currentName = $(element).attr('name');
                                var currentId = $(element).attr('id');

                                let newName = currentName.replace("1", "");
                                let newId = currentId.replace("1", "");

                                $(element).attr('name', newName + (counter + 1));
                                $(element).attr('id', newId + (counter + 1));

                                // Remove the Select2 container span element
                                $(element).next('.select2-container').remove();

                                // Set values from fetched product data
                                var selectOptions = '';
                                data.forEach(function(product) {
                                    selectOptions += '<option value="' + product.id + '">' + product.name + '</option>';
                                });

                                $(element).html(selectOptions);
                            });

                            counter++;
                            console.log('counter');
                            console.log(counter);
                            clonedRow.addClass('cloned-row');

                            // Append below the last row
                            $("#product-container").append(clonedRow);

                            // Reapply Select2 to all select elements
                            initializeSelect2();

                        },
                        error: function (error) {
                            console.log('Error fetching product data:', error);
                        }
                    });

                });


                $(document).on("click", ".remove-field", function (event) {
                    event.preventDefault();
                    // Get the IDs of the text input fields
                    var textField = $(this).closest(".row").find("input[type='text']:eq(0)").attr("id");
                    var selectField = $(this).closest(".row").find("select").attr("id");
                    console.log(textField);
                    console.log(selectField);
                    var match = selectField.match(/\d+/);
                    if (match) {
                        var number = parseInt(match[0]);
                        removedIds.push(number);
                        console.log(number); // Output: 2
                    } else {
                        console.log("No number found in the string");
                    }
                    $(this).closest(".row").remove();
                });
            });

            var products = [];
            var productCounts = [];
            var removedIds = [];

            function saveBillDetails() {

                var customer = $('#customer').val();
                var billedAt = $('#billed-at').val();
                console.log('Counterrdffd');
                console.log(counter);

                // To get all the data and format it
                for (var index = 1; index <= counter; index++) {
                    // This is to omit the removed field
                    if (removedIds.includes(index)) {
                        continue;
                    }
                    var product = $("#product-" + index).val();
                    var productCount = $("#product-count-" + index).val();
                    console.log(product);
                    console.log(productCount);
                    products.push(product);
                    productCounts.push(productCount);
                }

                console.log(products);
                console.log(productCounts);

                // Ajax call to create or update the records
                $.ajax({
                    type: "POST",
                    url: "/bill",
                    data: {
                        customer: customer,
                        billed_at: billedAt,
                        products: products,
                        product_count: productCounts,
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log(response);
                        alert('Success..!!');
                        // showSessionMessage(response['status'], 'growl-success', 'Success!');
                        window.location.replace('/bill');
                    },
                    error: function (error) {
                        console.log(error);
                        alert('Failure..!!');
                        products = [];
                        productCounts = [];
                        removedIds = [];
                        // showSessionMessage(errorMessage, 'growl-error', 'Error!');
                        // if (error['status'] === 422) {
                        //     var errorFieldIds = [];
                        //     var errorMessageFromResponse = error['responseJSON']['error'];
                        //     for (const key in errorMessageFromResponse) {
                        //         const matches = key.match(/reasons\.(\d+)/);
                        //         if (matches) {
                        //             const index = parseInt(matches[1], 10);
                        //             let message = errorMessageFromResponse[key][0];
                        //             const spanValue = index + 1;
                        //             if (message.endsWith("has already been taken.")) {
                        //                 message = 'This reason has already been taken.'
                        //             }
                        //             $('#user_app_booking_cancel_reason_error_' + spanValue).removeClass('hide');
                        //             $('#user_app_booking_cancel_reason_error_' + spanValue).html(message);
                        //             setAndUnsetAsErrorField(true, '#user_app_booking_cancel_reason_' + spanValue);
                        //             errorFieldIds.push(spanValue);
                        //         }
                        //         if (key.match(/reasons/)) {
                        //             swal({
                        //                 title: 'Max Limit Exceed',
                        //                 html: true,
                        //                 text: 'You have reached the maximum limit for creating booking condition reasons. The system allows a maximum of 7 reasons.',
                        //                 type: 'error',
                        //                 showConfirmButton: true
                        //             });
                        //             return;
                        //         }
                        //     }
                        //     for (var correctIndex = 1; correctIndex <= cancelReasonTextBoxCount; correctIndex++) {
                        //         if(!errorFieldIds.includes(correctIndex )) {
                        //             setAndUnsetAsErrorField(false, '#user_app_booking_cancel_reason_' + correctIndex);
                        //         }
                        //     }
                        // }
                    }
                });
            }


        </script>

        <style>
            .cloned-row {
                margin-top: 10px; /* Adjust the margin-bottom as needed */
            }
        </style>
    </div>
@endsection

