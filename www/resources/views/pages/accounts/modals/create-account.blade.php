<div class="modal fade" id="create-user-account" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="user-name" class="form-label">Name</label>
                            <input class="form-control" type="text" id="user-name" name="user-name" />
                        </div>
                        <div class="form-group col-6">
                            <label for="user-email" class="form-label">Email</label>
                            <input class="form-control" type="email" id="user-email" name="user-email" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="user-phone" class="form-label">Phone</label>
                            <input class="form-control" type="tel" id="user-phone" name="user-phone" />
                        </div>
                        <div class="form-group col-6">
                            <label for="user-secondary-phone" class="form-label">Secondary Phone</label>
                            <input class="form-control" type="tel" id="user-secondary-phone" name="user-secondary-phone" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="user-employee" class="form-label">Employee</label>
                            <select class="form-control select2" name="user-employee" id="user-employee">
                                <option value="false" selected>No</option>
                                <option value="true">Yes</option>
                            </select>
                        </div>
                        <div class="form-group col-3">
                            <label for="user-type" class="form-label">Type</label>
                            <select class="form-control select2" id="user-type" name="user-type">
                                @foreach(\App\UserType::all() as $type)
                                    <option value="{{ $type->id }}">{{ ucwords($type->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="user-roles" class="form-label">Roles</label>
                            <select class="form-contol select2" name="user-roles" id="user-roles" multiple>
                                @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                    <option value="{{ str_replace(' ', '_', $role->name) }}">{{ ucwords($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label class="switcher">
                                <input type="checkbox" class="switcher-input" name="user-verification-email">
                                    <span class="switcher-indicator">
                                        <span class="switcher-yes"></span>
                                        <span class="switcher-no"></span>
                                    </span>
                                    <span class="switcher-label">Send verification email</span>
                            </label>
                            <label class="switcher">
                                <input type="checkbox" class="switcher-input" name="user-change-password">
                                <span class="switcher-indicator">
                                        <span class="switcher-yes"></span>
                                        <span class="switcher-no"></span>
                                    </span>
                                <span class="switcher-label">Change password on login</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>