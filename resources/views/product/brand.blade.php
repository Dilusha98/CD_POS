<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h4 class="m-0">Brand</h4>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Brand</li>
            </ol>
        </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
    <!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#brandAddModal">Add New</button>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                    <table id="BrandListTbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $brand)
                                <tr>
                                    <td>{{ $brand->name }}</td>
                                    <td>{{ $brand->status }}</td>
                                    <td>{{ $brand->created_by }}</td>
                                    <td>{{ $brand->created_at }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="actionDropdown{{ $brand->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $brand->id }}">
                                                <li><a class="dropdown-item" href="#" onclick="editBrand({{ $brand->id }})">Edit</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="deleteBrand({{ $brand->id }})">Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            </div>
        </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

<!-- brand add modal -->
@include('product.modals.brandAddModal')
