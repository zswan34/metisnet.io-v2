@extends("layouts.app")
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