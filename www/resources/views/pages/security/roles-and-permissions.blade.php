@extends("layouts.app")
@section('styles')
    <style>


        /* Important part */
        .edit-modal-dialog{
            overflow-y: initial !important
        }
        .edit-modal-body{
            height: 500px;
            overflow-y: auto;
        }
    </style>
@endsection
@section("content")
    <div id="roles-and-permissions-wrapper"></div>
@endsection
@section('scripts')
    <script>
        $('.select2-roles').each(function() {
            $(this)
                .wrap('<div class="position-relative"></div>')
                .select2({
                    placeholder: 'Select value',
                    dropdownParent: $(this).parent()
                });
        })
    </script>
@endsection