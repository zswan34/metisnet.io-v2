@extends("layouts.app-blank")
@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card col-6 col-offset-3 mt-4 mb-3">
                <div class="card-body">
                    <div class="mb-3 text-center">
                        <img class="w-75" src="{{ asset('assets/logos/mc-nb-logo.png') }}" alt="">
                    </div>
                    <h4 class="card-title">Hi {{ auth()->user()->fname() }}!</h4>
                    <form class="my-3" action="{{ route('post-setup') }}" id="setup-form" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label for="secondary-email" class="form-label">Secondary Email</label>
                            <input type="email" class="form-control" name="secondary-email" id="secondary-email" placeholder="Secondary Email">
                            <small class="form-text text-muted">This is your recovery email</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Timezone</label>
                            <select type="text" class="form-control" name="timezone">
                                @foreach(\App\Timezone::all() as $timezone)
                                    @php
                                        $default = '';
                                        $tz = \App\Timezone::find(auth()->user()->timezone_id);
                                         if ($tz->value === $timezone->value) {
                                            $default = 'selected';
                                        }
                                    @endphp
                                    <option value="{{ $timezone->value }}" {{ $default }}>{{ $timezone->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <p><b>TODO: </b>create input to invite a user(s) via email to see account budget</p>
                        <button type="submit" class="btn btn-primary">Finish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section("scripts")
    <script>
    let setupForm = $("#setup-form");
    setupForm.validate({
        rules: {
            timezone: 'required',
            'secondary-email': {
                required: true,
                email: true
            }
        },
        messages: {
            timezone: 'A timezone is required',
            'secondary-email': {
                email: 'Must be a valid email address',
                required: 'Email is required'
            }
        },
        errorPlacement: function errorPlacement(error, element) {
            let $parent = $(element).parents('.form-group');

            // Do not duplicate errors
            if ($parent.find('.jquery-validation-error').length) { return; }

            $parent.append(
                error.addClass('jquery-validation-error small form-text invalid-feedback')
            );
        },
        highlight: function(element) {
            let $el = $(element);
            let $parent = $el.parents('.form-group');

            $el.addClass('is-invalid');

            // Select2 and Tagsinput
            if ($el.hasClass('select2-hidden-accessible') || $el.attr('data-role') === 'tagsinput') {
                $el.parent().addClass('is-invalid');
            }
        },
        unhighlight: function(element) {
            $(element).parents('.form-group').find('.is-invalid').removeClass('is-invalid');
        },
        submitHandler: (form) => {
            let data = $(form).serialize();

            axios.post($(form).attr('action'), data)
                .then((res) => {
                    const data = res.data;
                    console.log(data);
                    if (data.success) {
                        window.location.href = '/home';
                    }
                }).catch((err) => {
                    console.log(err);
            })
        }
    })
    </script>
@endsection