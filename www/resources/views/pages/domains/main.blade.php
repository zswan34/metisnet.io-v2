@extends("layouts.app")
@section("content")

    <div id="domain-account-wrapper"></div>
    
    
    <!-- Modal -->
    <div class="modal fade" id="create-domain-account" tab-index="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="create-account-form" action="/domains/" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add an account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="account-nickname">Name</label>
                            <input class="form-control" type="text" id="account-nickname"
                                   name="account-nickname" placeholder="Name"/>
                        </div>
                        <div class="form-group">
                            <label for="account-type" class="form-label">Type</label>
                            <select name="domain-account-type" id="account-type" class="select2">
                                <option value="godaddy">Godaddy</option>
                                <option value="google">Google Domains</option>
                            </select>
                        </div>
                        <div id="godaddy-options">
                            <div class="form-group">
                                <label for="godaddy-account-api-key" class="form-label">Api Key</label>
                                <input type="text" id="godaddy-account-api-key"
                                       name="godaddy-account-api-key" class="form-control"
                                       placeholder="Api Key"/>
                            </div>
                            <div class="form-group">
                                <label for="godaddy-account-api-secret" class="form-label">Api
                                    Secret</label>
                                <input type="text" id="godaddy-account-api-secret"
                                       name="godaddy-account-api-secret" class="form-control"
                                       placeholder="Api Secret"/>
                            </div>
                        </div>

                        <div id="google-options" style="display: none;">
                            <p>In progress</p>
                            <div class="form-group">
                                <label for="account-api-key" class="form-label">Api Key</label>
                                <input type="text" id="account-api-key" name="account-api-key"
                                       class="form-control" placeholder="Api Key"/>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Cancel
                        </button>
                        <button type="submit"
                                class="btn btn-primary">Save changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        let accountType = $("#account-type");
        let godaddyOptions = $("#godaddy-options");
        let googleOptions = $("#google-options");


        accountType.change((e) => {
            if ($(e.target).val() === 'godaddy') {
                googleOptions.hide();
                godaddyOptions.show();
            }

            if ($(e.target).val() === 'google') {
                godaddyOptions.hide();
                googleOptions.show();
            }
        });



    </script>
@endsection