    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0">New |<span class="text-muted small-text"> User Role</span></h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">User Role</a></li>
                <li class="breadcrumb-item active">Create User Role</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
      <!-- /.content-header -->

    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title"><span class="badge badge-primary">Basic Info</span></h3>
  
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <form>
                            <div class="form-group">
                                <label for="role_name">Role Name</label>
                                <input type="text" class="form-control form-control-sm" id="roleName" name="roleName" placeholder="Enter role name" maxlength="45">
                                <small id="charCount" class="form-text text-muted">45 characters left</small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>
    </div>



    {{-- want to add this style part to the custome style file --}}
    <style>
        .small-text {
            font-size: 1rem; /* Adjust as needed */
        }
        .text-muted-custom {
            color: #6c757d; /* Muted color */
        }
    </style>



    {{-- want to add this js part to the custome js file --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var maxChars = 45;
            var input = document.getElementById('roleName');
            var charCount = document.getElementById('charCount');

            input.addEventListener('input', function () {
                var remaining = maxChars - input.value.length;
                charCount.textContent = remaining + ' characters left';
            });
        });
    </script>
