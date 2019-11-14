@extends("layouts.app")
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/account.css') }}">
@endsection
@section('content')

    <h4 class="font-weight-bold py-3 mb-4">
        Account Settings
    </h4>

    <div class="card overflow-hidden">
        <div class="row no-gutters row-bordered row-border-light">
            <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links">
                    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change password</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Info</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-social-links">Social links</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-connections">Connections</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-notifications">Notifications</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-settings">Settings</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="account-general">
                        <div class="mx-3">
                            @if(is_null(auth()->user()->email_verified_at))
                                <div class="alert alert-warning mt-3">
                                    Your email is not confirmed. Please check your inbox.<br>
                                    <a href="javascript:void(0)">Resend confirmation</a>
                                </div>
                            @endif
                        </div>
                        <div class="card-body media align-items-center">
                            <img id="avatarImg" src="{{ \App\Libs\Avatar::render(auth()->user()->email) }}" alt="" class="d-block ui-w-80">
                            <div class="media-body ml-4">
                                <label class="btn btn-outline-primary">
                                    <form id="avatarUpload" action="{{ route('post-avatar-upload') }}" method="post">
                                        @csrf
                                        Upload new photo
                                        <input type="file" class="account-settings-fileinput" accept="image/*">
                                    </form>
                                </label> &nbsp;
                                <button type="button" class="btn btn-default md-btn-flat">Reset</button>

                                <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                            </div>
                        </div>
                        <hr class="border-light m-0">

                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-label">SID</label>
                                        <span class="d-block text-muted mb-1">{{ auth()->user()->sid }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <span class="d-block text-muted">{{ auth()->user()->name }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <span class="d-block text-muted mb-1">{{ auth()->user()->email }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Mobile</label>

                                        @if (!is_null(auth()->user()->phone))
                                            <span class="d-block text-muted mb-1">{{ App\Libs\Format::phone(auth()->user()->phone) }}</span>
                                        @else
                                            <span class="d-block text-muted mb-1">N/A</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="" class="form-label">Office</label>
                                        <span class="d-block text-muted mb-1">Salt Lake City</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="form-label">Address</label>
                                        <span class="d-block text-muted mb-1">11758 S District Drive <br> South Jordan, UT 84095</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="form-label">Phone</label>
                                        <span class="d-block text-muted mb-1">{{ \App\Libs\Format::phone('8018707735') }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="tab-pane fade" id="account-change-password">
                        <div class="card-body pb-2">

                            <div class="form-group">
                                <label class="form-label">Current password</label>
                                <input type="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-label">New password</label>
                                <input type="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Repeat new password</label>
                                <input type="password" class="form-control">
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="account-info">
                        <div class="card-body pb-2">

                            <div class="form-group">
                                <label class="form-label">Bio</label>
                                <textarea class="form-control" rows="5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nunc arcu, dignissim sit amet sollicitudin iaculis, vehicula id urna. Sed luctus urna nunc. Donec fermentum, magna sit amet rutrum pretium, turpis dolor molestie diam, ut lacinia diam risus eleifend sapien. Curabitur ac nibh nulla. Maecenas nec augue placerat, viverra tellus non, pulvinar risus.</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Birthday</label>
                                <input type="text" class="form-control" value="May 3, 1995">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Country</label>
                                <select class="custom-select">
                                    <option>USA</option>
                                    <option selected>Canada</option>
                                    <option>UK</option>
                                    <option>Germany</option>
                                    <option>France</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Languages</label>
                                <select multiple class="account-settings-multiselect form-control w-100">
                                    <option selected>English</option>
                                    <option>German</option>
                                    <option>French</option>
                                </select>
                            </div>

                        </div>
                        <hr class="border-light m-0">
                        <div class="card-body pb-2">

                            <h6 class="mb-4">Contacts</h6>
                            <div class="form-group">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" value="+0 (123) 456 7891">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Website</label>
                                <input type="text" class="form-control" value="">
                            </div>

                        </div>
                        <hr class="border-light m-0">
                        <div class="card-body pb-2">

                            <h6 class="mb-4">Interests</h6>
                            <div class="form-group">
                                <label class="form-label">Favorite music</label>
                                <input type="text" class="form-control account-settings-tagsinput" value="Rock,Alternative,Electro,Drum & Bass,Dance">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Favorite movies</label>
                                <input type="text" class="form-control account-settings-tagsinput" value="The Green Mile,Pulp Fiction,Back to the Future,WALL·E,Django Unchained,The Truman Show,Home Alone,Seven Pounds">
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="account-social-links">
                        <div class="card-body pb-2">

                            <div class="form-group">
                                <label class="form-label">Twitter</label>
                                <input type="text" class="form-control" value="https://twitter.com/user">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Facebook</label>
                                <input type="text" class="form-control" value="https://www.facebook.com/user">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Google+</label>
                                <input type="text" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label class="form-label">LinkedIn</label>
                                <input type="text" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Instagram</label>
                                <input type="text" class="form-control" value="https://www.instagram.com/user">
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="account-connections">
                        <div class="card-body">
                            <button type="button" class="btn btn-twitter">Connect to <strong>Twitter</strong></button>
                        </div>
                        <hr class="border-light m-0">
                        <div class="card-body">
                            <h5 class="mb-2">
                                <a href="javascript:void(0)" class="float-right text-muted text-tiny"><i class="ion ion-md-close"></i> Remove</a>
                                <i class="ion ion-logo-google text-google"></i>
                                You are connected to Google:
                            </h5>
                            nmaxwell@mail.com
                        </div>
                        <hr class="border-light m-0">
                        <div class="card-body">
                            <button type="button" class="btn btn-facebook">Connect to <strong>Facebook</strong></button>
                        </div>
                        <hr class="border-light m-0">
                        <div class="card-body">
                            <button type="button" class="btn btn-instagram">Connect to <strong>Instagram</strong></button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="account-notifications">
                        <div class="card-body pb-2">

                            <h6 class="mb-4">Activity</h6>

                            <div class="form-group">
                                <label class="switcher">
                                    <input type="checkbox" class="switcher-input" checked>
                                    <span class="switcher-indicator">
                          <span class="switcher-yes"></span>
                          <span class="switcher-no"></span>
                        </span>
                                    <span class="switcher-label">Email me when someone comments on my article</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="switcher">
                                    <input type="checkbox" class="switcher-input" checked>
                                    <span class="switcher-indicator">
                          <span class="switcher-yes"></span>
                          <span class="switcher-no"></span>
                        </span>
                                    <span class="switcher-label">Email me when someone answers on my forum thread</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="switcher">
                                    <input type="checkbox" class="switcher-input">
                                    <span class="switcher-indicator">
                          <span class="switcher-yes"></span>
                          <span class="switcher-no"></span>
                        </span>
                                    <span class="switcher-label">Email me when someone follows me</span>
                                </label>
                            </div>
                        </div>
                        <hr class="border-light m-0">
                        <div class="card-body pb-2">

                            <h6 class="mb-4">Application</h6>

                            <div class="form-group">
                                <label class="switcher">
                                    <input type="checkbox" class="switcher-input" checked>
                                    <span class="switcher-indicator">
                          <span class="switcher-yes"></span>
                          <span class="switcher-no"></span>
                        </span>
                                    <span class="switcher-label">News and announcements</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="switcher">
                                    <input type="checkbox" class="switcher-input">
                                    <span class="switcher-indicator">
                          <span class="switcher-yes"></span>
                          <span class="switcher-no"></span>
                        </span>
                                    <span class="switcher-label">Weekly product updates</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="switcher">
                                    <input type="checkbox" class="switcher-input" checked>
                                    <span class="switcher-indicator">
                          <span class="switcher-yes"></span>
                          <span class="switcher-no"></span>
                        </span>
                                    <span class="switcher-label">Weekly blog digest</span>
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="account-settings">
                        <div class="card-body pb-2">

                            <h6 class="mb-4">Layout</h6>

                            <div class="form-group">
                                <label class="switcher">
                                    <input id="rtl_direction" name="rtl" type="checkbox" class="switcher-input" {{ (auth()->user()->setting->rtl_direction) ? 'checked' : '' }}>
                                    <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                    <span class="switcher-label">RTL direction</span>
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="switcher">
                                    <input id="material_style" name="material_style" type="checkbox"
                                           class="switcher-input" {{ (auth()->user()->setting->material_style) ? 'checked' : '' }}>
                                    <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                    <span class="switcher-label">Material Style</span>
                                </label>
                            </div>

                            <h6 class="mb-4" style="margin-top: 40px;">Style</h6>


                            <div class="form-group w-25">
                                <select name="layout-style" id="layout-style" class="select2">
                                    <option value="static"
                                            {{ (auth()->user()->setting->layout_style === 'static') ? 'selected' : '' }} >Static</option>
                                    <option value="offcanvas"
                                            {{ (auth()->user()->setting->layout_style === 'offcanvas') ? 'selected' : '' }} >Offcanvas</option>
                                    <option value="fixed"
                                            {{ (auth()->user()->setting->layout_style === 'fixed') ? 'selected' : '' }} >Fixed</option>
                                    <option value="fixed-offcanvas"
                                            {{ (auth()->user()->setting->layout_style === 'fixed-offcanvas') ? 'selected' : '' }} >Fixed Offcanvas</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="switcher">
                                    <input id="layout-navbar-fixed" name="layout-navbar-fixed"
                                           type="checkbox" class="switcher-input" {{ (auth()->user()->setting->fixed_navbar) ? 'checked' : '' }}>
                                    <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                    <span class="switcher-label">Fixed navbar</span>
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="switcher">
                                    <input id="layout-footer-fixed" name="layout-footer-fixed"
                                           type="checkbox" class="switcher-input" {{ (auth()->user()->setting->fixed_footer) ? 'checked' : '' }}>
                                    <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                    <span class="switcher-label">Fixed footer</span>
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="switcher">
                                    <input id="layout-reversed" name="layout-reversed"
                                           type="checkbox" class="switcher-input" {{ (auth()->user()->setting->reversed) ? 'checked' : '' }}>
                                    <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                    <span class="switcher-label">Reversed</span>
                                </label>
                            </div>

                            <div class="row no-gutters">
                                <div class="col-4">
                                    <h6 class="mb-4 mt-5">Navbar Background</h6>
                                </div>
                                <div class="col-4">
                                    <h6 class="mb-4 mt-5">Sidenav Background</h6>
                                </div>
                                <div class="col-4">
                                    <h6 class="mb-4 mt-5">Footer Background</h6>
                                </div>
                            </div>

                            <div class="row no-gutters">
                                <div class="col-4">
                                    <div class="d-flex flex-wrap">
                                    @foreach($navbar_colors as $color)
                                            @php
                                                $border = ('bg-' . $color->value === auth()->user()->setting->navbarColor())
                                                ? '3px solid #696969' : '1px solid #e8e8e8'
                                            @endphp
                                        <div class="flex-1 bg-{{ $color->value }} my-1 mx-1" style="width: 28px;
                                        height: 28px; border-radius: 3px; border: {{ $border }};"></div>
                                    @endforeach
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="d-flex flex-wrap">
                                            @foreach($sidenav_colors as $color)
                                                @php
                                                $border = ('bg-' . $color->value === auth()->user()->setting->sidenavColor())
                                                ? '3px solid #696969' : '1px solid #e8e8e8'
                                                @endphp

                                                <div class="flex-1 bg-{{ $color->value }} my-1 mx-1" style="width: 28px;
                                                height: 28px; border-radius: 3px; border: {{ $border }};"></div>
                                            @endforeach
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex flex-wrap">
                                        @foreach($footer_colors as $color)
                                            @php
                                                $border = ('bg-' . $color->value === auth()->user()->setting->footerColor())
                                                ? '3px solid #696969' : '1px solid #e8e8e8'
                                            @endphp
                                            <div class="flex-1 bg-{{ $color->value }} my-1 mx-1" style="width: 28px;
                                             height: 28px; border-radius: 3px;border: {{ $border }};"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            <h6 class="mb-4" style="margin-top: 40px;">Theme</h6>
                            <div class="switchers-stacked">
                                @foreach (\App\ColorTheme::all() as $theme)
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="switcher">
                                                <input type="radio" class="switcher-input" name="color-theme"
                                                       value="{{ $theme->name }}"
                                                        {{ (auth()->user()->setting->color_theme_id === $theme->id) ? 'checked' : '' }}>
                                                <span class="switcher-indicator">
                                                    <span class="switcher-yes"></span>
                                                    <span class="switcher-no"></span>
                                                </span>
                                                    <span class="switcher-label">{{ ucfirst($theme->name) }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        @foreach(json_decode($theme->colors) as $color)
                                            <div class="d-inline-block relative" style="background: {{ $color }}; width: 20px; height: 20px; border-radius: 100%; border: 1px solid #e6e6e6;"></div>
                                        @endforeach
                                    </div>
                                    <div class="w-100 mt-2 mb-4" style="border-top: 1px solid; border-color: #e6e6e6 !important"></div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <hr class="border-light m-0">
                        <div class="card-body pb-2">

                            <h6 class="mb-4">Application</h6>

                            <div class="form-group">
                                <label class="switcher">
                                    <input type="checkbox" class="switcher-input" checked>
                                    <span class="switcher-indicator">
                          <span class="switcher-yes"></span>
                          <span class="switcher-no"></span>
                        </span>
                                    <span class="switcher-label">News and announcements</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="switcher">
                                    <input type="checkbox" class="switcher-input">
                                    <span class="switcher-indicator">
                          <span class="switcher-yes"></span>
                          <span class="switcher-no"></span>
                        </span>
                                    <span class="switcher-label">Weekly product updates</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="switcher">
                                    <input type="checkbox" class="switcher-input" checked>
                                    <span class="switcher-indicator">
                          <span class="switcher-yes"></span>
                          <span class="switcher-no"></span>
                        </span>
                                    <span class="switcher-label">Weekly blog digest</span>
                                </label>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="text-right mt-3">
        <button type="button" class="btn btn-primary">Save changes</button>&nbsp;
        <button type="button" class="btn btn-default">Cancel</button>
    </div>

@endsection
@section("scripts")
    <script>
        let avatarUpload = $("#avatarUpload");
        let avatarImg = $("#avatarImg");
        let navabarAvatarImg = $("#navbarAvatarImg");

        avatarUpload.change((e) => {

            let reader = new FileReader();
            let formData = new FormData();
            formData.append('avatar', e.target.files[0]);

            reader.onload = function(){
                avatarImg.attr('src', reader.result);
                navabarAvatarImg.attr('src', reader.result);
            };

            reader.readAsDataURL(e.target.files[0]);

            axios.post(avatarUpload.attr('action'), formData)
                .then((res) => {
                    console.log(res);
                }).catch((err) => {
                    console.log(err);
            })
        });

        // Layout
        let themeSettingsBoostrapCss = $(".theme-settings-bootstrap-css");
        let themeSettingsAppworkCss = $(".theme-settings-appwork-css");
        let themeSettingsThemeCss = $(".theme-settings-theme-css");
        let themeSettingsColorsCss = $(".theme-settings-colors-css");

        let rtlDirection = $("#rtl_direction");
        let materialStyle = $("#material_style");
        let layoutNavbarFixed = $("#layout-navbar-fixed");
        let layoutFooterFixed = $("#layout-footer-fixed");
        let layoutReversed = $("#layout-reversed");
        let layoutStyle = $("#layout-style");

        let colorTheme = $("input[name='color-theme']");

        let html = $("html");


        rtlDirection.change((e) => {
            let checked = $(e.target).is(':checked');
            if (checked) {
                html.attr('dir', 'rtl');
            } else {
                html.attr('dir', 'ltr');
            }
            axios.post('/settings/layout/direction', { rtl: checked })
                .then((res) => {
                    console.log(res);
                })
        });

        materialStyle.change((e) => {
            let checked = $(e.target).is(':checked');
            if (checked) {
                html.addClass('material-style').removeClass('default-style');
            } else {
                html.addClass('default-style').removeClass('material-style');
            }
            axios.post('/settings/style/material', { material: checked })
                .then((res) => {
                    const data = res.data;
                    if (data.success) {
                        themeSettingsBoostrapCss.attr('href', data.theme.boostrap);
                        themeSettingsAppworkCss.attr('href', data.theme.appwork);
                        themeSettingsThemeCss.attr('href', data.theme.theme);
                        themeSettingsColorsCss.attr('href', data.theme.colors)
                    }
                })
        });

        layoutNavbarFixed.change((e) => {
            let checked = $(e.target).is(':checked');
            if (checked) {
                html.addClass('layout-navbar-fixed');
            } else {
                html.removeClass('layout-navbar-fixed');
            }
            axios.post('/settings/layout/navbar-fixed', { fixed: checked })
                .then((res) => {
                    console.log(res);
                })
        });

        layoutFooterFixed.change((e) => {
            let checked = $(e.target).is(':checked');
            if (checked) {
                html.addClass('layout-footer-fixed');
            } else {
                html.removeClass('layout-footer-fixed');
            }
            axios.post('/settings/layout/footer-fixed', { fixed: checked })
                .then((res) => {
                    console.log(res);
                })
        });

        layoutReversed.change((e) => {
            let checked = $(e.target).is(':checked');
            if (checked) {
                html.addClass('layout-reversed');
            } else {
                html.removeClass('layout-reversed');
            }
            axios.post('/settings/layout/reversed', { fixed: checked })
                .then((res) => {
                    console.log(res);
                })
        });

        layoutStyle.change((e) => {
            let style = $(e.target).val();
            console.log(style);
            html.removeClass('layout-static');
            html.removeClass('layout-offcanvas');
            html.removeClass('layout-fixed');
            html.removeClass('layout-fixed-offcanvas');

            html.addClass('layout-' + style);
            axios.post('/settings/layout/style', { style: style })
                .then((res) => {
                    console.log(res);
                });
        });

        colorTheme.change((e) => {
            let theme = $(e.target).val();
            axios.post('/settings/color/theme', { theme: theme })
                .then((res) => {
                    const data = res.data;
                    if (data.success) {
                        themeSettingsBoostrapCss.attr('href', data.theme.boostrap);
                        themeSettingsAppworkCss.attr('href', data.theme.appwork);
                        themeSettingsThemeCss.attr('href', data.theme.theme);
                        themeSettingsColorsCss.attr('href', data.theme.colors)
                    }
                })
        })
    </script>
@endsection