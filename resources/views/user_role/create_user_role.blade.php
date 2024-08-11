<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0">User Role</h4>
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




<!-- container -->
<div class="container-fluid">
    <form action="{{ route('create_user_role') }}" method="POST">
        @csrf

        {{-- user role --}}
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Basic Info</span></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role_name">Role Name</label>
                            <input type="text" class="form-control form-control-sm" id="roleName" name="roleName"
                                placeholder="Enter role name" maxlength="45">
                            <small id="charCount" class="form-text text-muted">45 characters left</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- tabs --}}
        <div class="card card-primary card-outline card-outline-tabs">
            {{-- tabs --}}
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    @foreach ($groupedData as $key => $permissions)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                id="custom-tabs-{{ $key }}-tab" data-toggle="pill"
                                href="#custom-tabs-{{ $key }}" role="tab"
                                aria-controls="custom-tabs-{{ $key }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ ucfirst($key) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>


            {{-- tabs content --}}
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    @foreach ($groupedData as $key => $permissions)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                            id="custom-tabs-{{ $key }}" role="tabpanel"
                            aria-labelledby="custom-tabs-{{ $key }}-tab">

                            <!-- Select All Checkbox -->
                            <label>
                                <input type="checkbox" class="select-all"
                                    data-target="custom-tabs-{{ $key }}">
                                <span style="margin-left: 8px;">Select All</span>
                            </label>

                            <!-- Checkbox -->
                            <div class="form-group">
                                <ul style="list-style-type: none; padding-left: 0; margin-top:10px">
                                    @foreach ($permissions as $permission)
                                        <li>
                                            <label>
                                                <input type="checkbox" name="permissions[]"
                                                    id="{{ $permission['uPerissnId'] }}"
                                                    value="{{ $permission['uPerissnId'] }}">
                                                <span
                                                    style="margin-left: 8px; font-weight: normal;">{{ $permission['displayTxt'] }}</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Card Footer --}}
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
<!-- /.container -->



<!-- js -->
<script>
    //add event for count characters
    document.addEventListener('DOMContentLoaded', function() {
        var maxChars = 45;
        var input = document.getElementById('roleName');
        var charCount = document.getElementById('charCount');

        input.addEventListener('input', function() {
            var remaining = maxChars - input.value.length;
            charCount.textContent = remaining + ' characters left';
        });
    });


    // Add event listener to all 'Select All' checkboxes
    document.querySelectorAll('.select-all').forEach(function(selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            let target = this.dataset.target;
            let checkboxes = document.querySelectorAll('#' + target +
                ' input[type="checkbox"]:not(.select-all)');

            // Set all checkboxes to the state of the 'Select All' checkbox
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
    });

    // Add event listener to all individual checkboxes
    document.querySelectorAll('.tab-pane input[type="checkbox"]:not(.select-all)').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            let tabPane = this.closest('.tab-pane');
            let allCheckboxes = tabPane.querySelectorAll('input[type="checkbox"]:not(.select-all)');
            let allChecked = Array.from(allCheckboxes).every(function(cb) {
                return cb.checked;
            });

            // Check or uncheck the 'Select All' checkbox based on individual checkboxes
            let selectAllCheckbox = tabPane.querySelector('.select-all');
            selectAllCheckbox.checked = allChecked;
        });
    });

    //empty field with reloading the page
    window.onload = function() {
        // Clear the text input
        document.getElementById('roleName').value = '';

        // Uncheck all checkboxes within the tab content
        let checkboxes = document.querySelectorAll('#custom-tabs-four-tabContent input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
    };
</script>
<!-- /.js -->
