@extends("layouts.app")

@section('content')

    <h4 class="font-weight-bold py-3 mb-4">
        Budget Builder
        <div class="text-muted text-tiny mt-1"><small class="font-weight-normal">Today is {{ \Carbon\Carbon::now()->format('l, F jS, Y') }}</small></div>
    </h4>

    <div class="row">
        <div class="col">
            <div class="card mb-4">
            <h6 class="card-header">
                Income
            </h6>
            <div class="card-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" placeholder="1234 Main St">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address 2</label>
                        <input type="text" class="form-control" placeholder="Apartment, studio, or floor">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="form-label">State</label>
                            <select class="custom-select">
                                <option>Select state</option>
                                <option>California</option>
                                <option>Hawaii</option>
                                <option>Florida</option>
                                <option>Texas</option>
                                <option>Massachusetts</option>
                                <option>Alabama</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="form-label">Zip</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox m-0">
                            <input type="checkbox" class="custom-control-input">
                            <span class="custom-control-label">Check this custom checkbox</span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </form>
            </div>
        </div>
        </div>
        <div class="col">
            <div class="card mb-4">
            <h6 class="card-header">
                Income
            </h6>
            <div class="card-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" placeholder="1234 Main St">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address 2</label>
                        <input type="text" class="form-control" placeholder="Apartment, studio, or floor">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="form-label">State</label>
                            <select class="custom-select">
                                <option>Select state</option>
                                <option>California</option>
                                <option>Hawaii</option>
                                <option>Florida</option>
                                <option>Texas</option>
                                <option>Massachusetts</option>
                                <option>Alabama</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="form-label">Zip</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox m-0">
                            <input type="checkbox" class="custom-control-input">
                            <span class="custom-control-label">Check this custom checkbox</span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </form>
            </div>
        </div>
        </div>
    </div>
@endsection