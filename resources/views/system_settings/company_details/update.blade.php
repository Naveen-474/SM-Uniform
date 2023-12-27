@section('title', 'SM Uniform - Company Details')
@extends('layouts.app')
@section('content')
    <form class="form-horizontal validateForm" name="edit_individual" id="edit_individual" role="form" method="POST"
          action="#" novalidate="novalidate">
        {!! csrf_field() !!}
        {!! method_field('patch') !!}
        <input name="redirect_url" type="hidden" value="{{ redirect()->getUrlGenerator()->previous() }}">
        <div class="block">
            @php
                $canEdit = $canEdit ?? true;
                $currentRoute = Illuminate\Support\Facades\Route::currentRouteName();
            @endphp
            <div class="card mb-4">
                <h5 class="card-header">Company Details</h5>
                <div class="card-body">
                    <div class="mb-3 row">
                        <label for="company-name" class="col-md-2 col-form-label">Company Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="company-name" name="company_name"
                                   placeholder="Enter Company Name"
                                   value="{{ old('name') ? old('name') : (!empty($companyDetail->name) ? $companyDetail->name : '') }}"
                                   @if(!$canEdit) readonly @endif/>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="owner-name" class="col-md-2 col-form-label">Owner Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="owner-name" name="company_owner_name"
                                   placeholder="Enter Owner Name"
                                   value="{{ old('owner_name') ? old('owner_name') : (!empty($companyDetail->owner_name) ? $companyDetail->owner_name : '') }}"
                                   @if(!$canEdit) readonly @endif/>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="company-address" class="col-md-2 form-label">Company Address</label>
                        <div class="col-md-10">
                            <textarea class="form-control text-content-editor" id="company-address" name="company_address"
                                      rows="3">{{ (!empty($companyDetail->address) ? $companyDetail->address : '') }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="mobile-number" class="col-md-2 col-form-label">Mobile Number</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="mobile-number" name="company_mobile_number"
                                   placeholder="Enter Company Mobile Number"
                                   value="{{ old('mobile_number') ? old('mobile_number') : (!empty($companyDetail->mobile_number) ? $companyDetail->mobile_number : '') }}"
                                   @if(!$canEdit) readonly @endif/>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="email" name="email"
                                   placeholder="Enter Company Email ID"
                                   value="{{ old('email') ? old('email') : (!empty($companyDetail->email) ? $companyDetail->email : '') }}"
                                   @if(!$canEdit) readonly @endif/>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="gstin" class="col-md-2 col-form-label">GSTIN</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="gstin" name="company_gstin"
                                   placeholder="Enter Company GSTIN"
                                   value="{{ old('gstin') ? old('gstin') : (!empty($companyDetail->gstin) ? $companyDetail->gstin : '') }}"
                                   @if(!$canEdit) readonly @endif/>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="owner-signature" class="col-md-2 form-label">Owner Signature</label>
                        <div class="col-md-10">
                            <input class="form-control" type="file" id="owner-signature"/>
                        </div>
                    </div>
                    <div style="margin-top: 20px;" class="text-end">
                        {{--                    <a href="{{ route($currentRoute) }}" class="btn rounded-pill btn-warning">Clear</a>--}}
                        <a href="{{ url('/customer-details') }}" class="btn rounded-pill btn-danger">Cancel</a>
                        <a class="btn rounded-pill btn-success" title="Save"
                           onclick="saveCompanyDetail()">Update</a>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <h5 class="card-header">Company Bank Details</h5>
                <div class="card-body">
                    <div class="mb-3 row">
                        <label for="account-holder-name" class="col-md-2 col-form-label">Account Holder Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="account-holder-name" name="bank_account_holder"
                                   placeholder="Enter Account Holder Name"
                                   value="{{ old('bank_account_holder') ? old('bank_account_holder') : (!empty($companyDetail->bank_account_holder) ? $companyDetail->bank_account_holder : '') }}"
                                   @if(!$canEdit) readonly @endif/>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="company-account-name" class="col-md-2 form-label">Company Account Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="company-account-name" name="bank_company_account_name"
                                   placeholder="Enter Company Account Name"
                                   value="{{ old('bank_company_account_name') ? old('bank_company_account_name') : (!empty($companyDetail->bank_company_account_name) ? $companyDetail->bank_company_account_name : '') }}"
                                   @if(!$canEdit) readonly @endif/>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="bank-name" class="col-md-2 col-form-label">Bank Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="bank-name" name="bank_name"
                                   placeholder="Enter Bank Name"
                                   value="{{ old('bank_name') ? old('bank_name') : (!empty($companyDetail->bank_name) ? $companyDetail->bank_name : '') }}"
                                   @if(!$canEdit) readonly @endif/>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="bank-branch-name" class="col-md-2 col-form-label">Branch Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="bank-branch-name" name="bank_branch_name"
                                   placeholder="Enter Bank Branch Name"
                                   value="{{ old('bank_branch_name') ? old('bank_branch_name') : (!empty($companyDetail->bank_branch_name) ? $companyDetail->bank_branch_name : '') }}"
                                   @if(!$canEdit) readonly @endif/>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="account-no" class="col-md-2 col-form-label">Account No</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="account-no" name="bank_account_no"
                                   placeholder="Enter Bank Account No."
                                   value="{{ old('bank_account_no') ? old('bank_account_no') : (!empty($companyDetail->bank_account_no) ? $companyDetail->bank_account_no : '') }}"
                                   @if(!$canEdit) readonly @endif/>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="ifsc-code" class="col-md-2 col-form-label">IFSC Code</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="ifsc-code" name="bank_ifsc_code"
                                   placeholder="Enter Bank IFSC Code"
                                   value="{{ old('bank_ifsc_code') ? old('bank_ifsc_code') : (!empty($companyDetail->bank_ifsc_code) ? $companyDetail->bank_ifsc_code : '') }}"
                                   @if(!$canEdit) readonly @endif/>
                        </div>
                    </div>
                    <div style="margin-top: 20px;" class="text-end">
                        {{--                    <a href="{{ route($currentRoute) }}" class="btn rounded-pill btn-warning">Clear</a>--}}
                        <a href="{{ url('/customer-details') }}" class="btn rounded-pill btn-danger">Cancel</a>
                        <a class="btn rounded-pill btn-success" title="Save"
                           onclick="saveCompanyDetail()">Update</a>
                    </div>
{{--                    {!! formButtons('Update') !!}--}}
                </div>

            </div>
        </div>
    </form>
    @include('script_helpers.text_area_size_adjustment_script')
    <script>

        function saveCompanyDetail(){
            var companyName = $('#company-name').val();
            var ownerName = $('#owner-name').val();
            var companyAddress = $('#company-address').val();
            var mobileNumber = $('#mobile-number').val();
            var email = $('#email').val();
            var gstin = $('#gstin').val();

            var accountHolderName = $('#account-holder-name').val();
            var companyAccountName = $('#company-account-name').val();
            var bankName = $('#bank-name').val();
            var branchName = $('#bank-branch-name').val();
            var accountNo = $('#account-no').val();
            var ifscCode = $('#ifsc-code').val();


            // Ajax call to create or update the records
            $.ajax({
                type: "POST",
                url: "/system-settings/company-details",
                data: {
                    company_name: companyName,
                    company_owner_name: ownerName,
                    company_address: companyAddress,
                    company_mobile_number: mobileNumber,
                    email: email,
                    company_gstin: gstin,
                    bank_account_holder: accountHolderName,
                    bank_company_account_name: companyAccountName,
                    bank_name: bankName,
                    bank_branch_name: branchName,
                    bank_account_no: accountNo,
                    bank_ifsc_code: ifscCode,
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    console.log(response);
                    alert('Success..!!');
                    // showSessionMessage(response['status'], 'growl-success', 'Success!');
                    window.location.replace('/system-settings/company-details');
                },
                error: function (error) {
                    console.log(error);
                    alert('Failure..!!');
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
@endsection

