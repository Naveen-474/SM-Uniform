@php
    $canEdit = $canEdit ?? true;
    $currentRoute = Illuminate\Support\Facades\Route::currentRouteName();
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
                    <div class="col-md-4">
                        <label for="customer" class="form-label col-md-4">Choose Customer</label>
                        <label>
                            <select class="form-select col-md-8 select2" name="customer" id="customer" aria-label="Default select example">
                                @foreach ($customers as $customer )
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label for="billed-at" class="col-md-4 col-form-label">Bill No.</label>
                        <label>
                            <div class="col-md-10">
                                <input class="form-control date" type="text" id="bill-no" name="bill_no"/>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label for="billed-at" class="col-md-2 col-form-label">Bill Date</label>
                        <label>
                        <div class="col-md-10">
{{--                            <input type="text" id="myDateInput">--}}
                            <input class="form-control date" type="text" id="billed-at" name="billed_at"/>
                        </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="product" class="form-label col-md-2">Choose Products</label>
                <div id="product-container">
                    <div class="row">
                        <div class="col-md-4">
                            <select class="form-select col-md-10 select2" id="product-1" name="product_1"
                                    aria-label="Default select example">
                                @foreach ($products as $product )
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control @error('address') is-invalid @enderror" type="text" id="product-count-1" name="product_count_1"
                                   placeholder="Enter No of Product"
                                   value="{{ old('product_count_1') ? old('product_count_1') : ''}}"/>
                        </div>
                        <div class="col-md-2" style="margin-left: -6px">
                            <button class="btn btn-default text-center" id="add-field">
                                <i class="icon-plus-circle text-primary icon-position bx bx-plus-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @unless(!$canEdit)
{{--                {!! formButtons('Update') !!}--}}
                <div style="margin-top: 20px;" class="text-end">
{{--                    <a href="{{ route($currentRoute) }}" class="btn rounded-pill btn-warning">Clear</a>--}}
                    <a href="{{ url('/customer-details') }}" class="btn rounded-pill btn-danger">Cancel</a>
                        <a class="btn rounded-pill btn-success tip" title="Save"
                           onclick="saveBillDetails()">Save</a>
{{--                        {!! cancelButton(['onclick' => "window.location='" . url('/user-app-booking-cancel-reason') . "'"]) !!}--}}
{{--                    <button type="submit" class="btn rounded-pill btn-success">--}}
{{--                        @if(!empty($customer))--}}
{{--                            Update--}}
{{--                        @else--}}
{{--                            Create--}}
{{--                        @endif--}}
{{--                    </button>--}}
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

                // Optionally, you may clear the selected value in the cloned dropdown
                // $(element).val('');

                // Remove the Select2 container span element
                $(element).next('.select2-container').remove();
            });

            counter++;
            console.log('counter');
            console.log(counter);
            clonedRow.addClass('cloned-row');

            $("#product-container").append(clonedRow);

            // Reapply Select2 to all select elements
            initializeSelect2();
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
        var billNo = $('#bill-no').val();
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
                bill_no : billNo,
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (response) {
                showSessionMessage(response['success'], 'growl-success', 'Success!');
                window.location.replace('/bill');
            },
            error: function (error) {
                products = [];
                productCounts = [];
                removedIds = [];
                if (error['status'] === 422) {
                    var mainMessage = error['responseJSON']['message'];
                    console.log(mainMessage);
                }
                showSessionMessage(mainMessage, 'growl-error', 'Error!');
            }
        });
    }

    function showSessionMessage(message, theme, header) {
        $.jGrowl(message, {
            sticky: false,
            theme: theme,
            header: header,
            life: 3000
        });
    }

    if ('{{ session('success') }}') {
        showSessionMessage('{{ session('success') }}', 'growl-success', 'Success!');
    } else if ('{{ session('error') }}') {
        showSessionMessage('{{ session('error') }}', 'growl-warning', 'Warning!');
    }

    var disabledDates = [];

    $(document).ready(function () {
        $.ajax({
            url: "{{ route('get_holiday_dates') }}",
            dataType: "json",
            success: function (data) {
                disabledDates = data['disabledDates'];
                $("#billed-at").datepicker("refresh");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error fetching disabled dates:", textStatus, errorThrown);
            }
        });
    });

    $(function() {
        $("#billed-at").datepicker({
            beforeShowDay: function(date) {
                var day = date.getDay();
                var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                return [(day != 0 && day != 6) && disabledDates.indexOf(string) == -1];
            },
            showButtonPanel: true
        });
    });
</script>

<style>
    .cloned-row {
        margin-top: 10px; /* Adjust the margin-bottom as needed */
    }

</style>
