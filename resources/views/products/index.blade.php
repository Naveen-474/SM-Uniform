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
        <h5 class="card-header">Product List</h5>
        <div class="m-2 text-end">
            <a class="btn btn-primary" href="{{url('product/create')}}">Create Product</a>
        </div>
        <div class="datatable table-responsive text-nowrap">
            <table class="table table-hover" id="list-datatable">
                <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Display Name</th>
                    <th>Rate</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->product_id}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->display_name}}</td>
                        <td>{{$product->price}}</td>
                        <td>
                            <a href="{{route('product.show', $product->id)}}" title="Show"><i class='bx bxs-show'></i></a>
                            <a href="{{route('product.edit', $product->id)}}" title="Edit"><i class='bx bx-edit'></i></a>
                            <form method="POST" action="{{route('product.destroy', $product->id)}}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete" class="button" style="color: #696cff;"><i class='bx bx-minus-circle'></i></button>
                            </form>
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
        jQuery('#list-datatable').dataTable({
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

