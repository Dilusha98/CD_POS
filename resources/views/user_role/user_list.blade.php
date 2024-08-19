
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h4 class="m-0">User List</h4>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">User</a></li>
            <li class="breadcrumb-item active">User List</li>
            </ol>
        </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
    <!-- /.content-header -->

    <!-- /.style s-->
    <style>
        #userListTable th {
            text-align: center;
        }
        
        .dropdown-toggle::after {
            display: none;
        }

        .dropdown-menu {
            min-width: 120px;
        }

        .dropdown-item {
            padding: 0.25rem 1rem;
        }

        .dropdown-item i {
            width: 1rem;
            text-align: center;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }
    </style>
    <!-- /.style e -->

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-12 table-responsive">
                        <table id="userListTable" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>User Name</th>
                                <th>User Role</th>
                                <th>Phone Number</th>
                                <th>Date of Birth</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<script type="text/javascript">
    var user_edit = "{{ route('user_edit') }}";
</script>
