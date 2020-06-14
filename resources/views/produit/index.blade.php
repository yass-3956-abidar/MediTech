@extends('admin.include.default')
@section('style')
<style>
</style>
@endsection
@section('content')
<div class="col-md-12">
    @if(session()->has('success'))
    <center>
    <div class="alert alert-success col-md-12 justify-content-center">
        {{session()->get('success')}}
    </div>
    </center>
    @endif
    @if(!count($produits)>0)
    <div class="alert alert-warning" role="alert">No item found</div>
    @else
    <div class="row">
        <div class="col-md-6">
            <a data-toggle="modal" data-target="#AddProduct" class="btn btn-success">
                <i class="fas fa-plus fa-1x mr-1"></i>Add new Product
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-primary text-white">All products</div>
        <div class="card-body">
            <table id="table_produit" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Reference Produit</th>
                        <th>libelle</th>
                        <th>Prix Unitaire</th>
                        <th>Quantity en stock</th>
                        <th>Cree le</th>
                        <th class="text-center">Action</th>
                    </tr>
                <tbody>
                    @foreach($produits as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->ref_produit}}</td>
                        <td>{{$product->libelle}}</td>
                        <td>{{$product->prix_unitaire." "."DH"}}</td>
                        <td>{{$product->quantity_stock}}</td>
                        <td>{{$product->created_at}}</td>
                        <td>
                            <a class="btn btn-info btn-sm" href="#">edit</a>
                            <a class="btn_delete btn btn-danger btn-sm" href="{{route('produit.delete',$product->id)}}">delete</a>
                            <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#EditProduct" data-id="{{$product->id}}" data-ref="{{$product->ref_produit}}" data-libelle="{{$product->libelle}}" data-prix="{{$product->prix_unitaire}}" data-qty="{{$product->quantity_stock}}">edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </thead>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
@include('produit.include.AddProduct')
@include('produit.include.editProduct')
@section('script')
<script>
    $(document).ready(function() {
        $("#table_produit").DataTable();
        $('.btn_delete').on('click', function(event) {
            event.preventDefault();
            const url = $(this).attr('href');
            console.log(url);
            Swal.fire({
                title: 'Are you shure to delete product ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'delete'
            }).then((result) => {
                if (result.value) {
                    window.location.href = url;
                    Swal.fire(
                        'deleting!',
                        'product has been deleted successfly',
                        'success'
                    )
                }
            })
        });

        $('#EditProduct').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal

            var modal = $(this)

            modal.find('#product_id').val(button.data('id'));
            modal.find('#ref_produitu').val(button.data('ref'));
            modal.find('#libelleu').val(button.data('libelle'));
            modal.find('#prix_unitaireu').val(button.data('prix'));
            modal.find('#quantity_stocku').val(button.data('qty'));
        })
    });
</script>
@endsection