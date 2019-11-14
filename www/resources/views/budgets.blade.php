@extends("layouts.app")

@section('content')

    <h4 class="font-weight-bold py-3 mb-4">
        Budgets
        <div class="text-muted text-tiny mt-1"><small class="font-weight-normal">Today is {{ \Carbon\Carbon::now()->format('l, F jS, Y') }}</small></div>
    </h4>

    <div class="row justify-content-center">
        <div class="col-6">
            <h4 class="text-muted text-center font-italic">You have not created any budgets</h4>
            <div class="text-center my-5">
                <a href="{{ route('get-budget-builder') }}">
                <button class="btn btn-primary">Build Budget</button>
                </a>
            </div>
        </div>
    </div>

@endsection