@section('title', 'SM Uniform - Bills')
@extends('layouts.app')
@section('content')
    <style>
        .button {
            border: none;
            background: none;
            padding: 0;
            margin: 0;
            outline: none;
        }
    </style>
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{session('success')}}
        </div>
    @endif
    @if(session('failure'))
        <div class="alert alert-danger" role="alert">
            {{session('failure')}}
        </div>
    @endif
    <div class="card">
        <h5 class="card-header">Bill Details</h5>
        <div class="m-2 text-end">
            <a class="btn btn-primary"  href="{{url('bill/create')}}">Generate New Bill</a>
        </div>
        <div class="datatable table-responsive text-nowrap">
            <table class="table table-hover" id="list-datatable">
                <thead>
                <tr>
                    <th>Bill No</th>
                    <th>Customer/Company Name</th>
                    <th>Billed Date</th>
                    <th>Created At</th>
                    <th>Last Updated At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($bills as $bill)
                    <tr>
                        <td>{{$bill->bill_no}}</td>
                        <td>{{$bill->customer->name}}</td>
                        <td>{{getDateString($bill->billed_at)}}</td>
                        <td>{{getDateString($bill->created_at)}}</td>
                        <td>{{getDateString($bill->updated_at)}}</td>
                        <td>
                            <a href="{{route('bill.show', $bill->id)}}" title="Show"><i class='bx bxs-show'></i></a>
                            <a href="{{route('bill.edit', $bill->id)}}" title="Edit"><i class='bx bx-edit'></i></a>
                            <a href="{{route('bill_download', $bill->id)}}" title="Download"><i class='bx bx-download'></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        //For start datatables
        jQuery('#list-datatable').DataTable({
            "oLanguage": {
                "sEmptyTable": "No contents to display"
            },
            order: [],
            aoColumnDefs: [
                {
                    bSortable: false,
                    aTargets: [-1, 'no-sort']
                }
            ]
        });
    </script>
@endsection

