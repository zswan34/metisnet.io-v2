@extends("layouts.app")

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-3 mb-4">
        <div>Accounts</div>
        <button type="button" class="btn d-block btn-primary rounded-pill waves-effect"
            data-toggle="modal" data-target="#create-user-account">
            <span class="ion ion-md-add"></span>&nbsp; Add user</button>
    </h4>

    <!-- Filters -->
    <div class="ui-bordered px-4 pt-4 mb-4">
        <div class="form-row align-items-center">
            <div class="col-md mb-4">
                <label class="form-label">Verified</label>
                <select class="custom-select">
                    <option>Any</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="col-md mb-4">
                <label class="form-label">Role</label>
                <select class="custom-select">
                    <option>Any</option>
                    @foreach(\Spatie\Permission\Models\Role::all() as $role)
                        <option value="{{ str_replace(' ', '-', $role->name) }}">{{ ucwords($role->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md mb-4">
                <label class="form-label">Status</label>
                <select class="custom-select">
                    <option>Any</option>
                    <option>Active</option>
                    <option>Banned</option>
                    <option>Deleted</option>
                </select>
            </div>
            <div class="col-md mb-4">
                <label class="form-label">Latest activity</label>
                <input type="text" id="user-list-latest-activity" class="form-control" placeholder="Any">
            </div>
            <div class="col-md col-xl-2 mb-4">
                <label class="form-label d-none d-md-block">&nbsp;</label>
                <button type="button" class="btn btn-secondary btn-block">Show</button>
            </div>
        </div>
    </div>
    <!-- / Filters -->

    <div class="card">
        <div class="card-datatable table-responsive">
            <table id="user-table" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>SID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>LDAP User</th>
                    <th>PKI Access</th>
                    <th>Type</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    @include("pages.accounts.modals.create-account")
@endsection
@section("scripts")
    <script>
        let userTable = $("#user-table");
        let table = userTable.DataTable({
            serverSide: true,
            ajax: {
                url: "/api/v1/users",
                type: 'GET'
            },
            columns: [
                {name: 'sid', data: 'sid'},
                {name: 'name', data: 'name',
                    render: (data, type, row) => {
                        return `<a href="/accounts/${row.uid}">${data.toProperCase()}</a>`;
                    }
                },
                {name: 'email', data: 'email'},
                {name: 'phone', data: 'phone',
                    render: (data) => {
                        return (data === null) ? 'Phone not provided' : data;
                    }
                },
                {name: 'verified', data: 'email_verified_at',
                    render: (data) => {
                        return (data === null) ? 'Email not verified' :
                            '<i class="lnr lnr-checkmark-circle text-success"></i> Verified';
                    }
                },
                {name: 'has_ldap', data: 'ldap_user',
                    render: (data) => {
                        return (data) ? 'Yes' : 'No';
                    }
                },
                {name: 'pkcs12', data: 'pkcs12',
                    render: (data) => {
                        return (data !== null) ? 'Yes' : 'False';
                    }
                },
                {name: 'user_type_name', data: 'user_type_name',
                    render: (data) => {
                        return (data !== null) ? data.toProperCase() : 'Not assigned';
                    }
                }
            ]
        })
    </script>
@endsection