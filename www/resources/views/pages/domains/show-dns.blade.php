@extends("layouts.app")
@section("content")
    <div id="godaddy-domain-dns-items"></div>
@endsection
@section('scripts')
    <script>
        const columns = [
            {
                title: 'Name',
                data: 'name'
            },
            {
                title: 'IP Address',
                data: 'data'
            },
        ];
        let table = $("#dnsList").DataTable( {
            dom: '<"data-table-wrapper"t>',
            ajax: '',
            columns: columns
        });
    </script>
@endsection