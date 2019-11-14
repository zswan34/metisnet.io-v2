@extends("layouts.app")
@section("content")

    <div id="domain-account-wrapper"></div>
    <!-- Modal -->
@endsection
@section('scripts')
    <script>
        let accountType = $("#account-type");
        let godaddyOptions = $("#godaddy-options");
        let googleOptions = $("#google-options");

        let form = $("#create-account-form");
        let modal = $("#create-domain-account");

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