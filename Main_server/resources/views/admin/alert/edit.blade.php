@extends('admin.layouts.app')

@section('title', 'Edit Alert')

@section('content')

@include('admin.layouts.partials.header')
@include('admin.layouts.partials.sidebar')

<main id="main" class="main">

    @include('admin.layouts.partials.breadcrums')
    @include('admin.layouts.partials.alerts')

    <section style="padding-top:60px; background-color: rgb(231, 231, 226);">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h5>Edit Alert</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('alert.update', $alert->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3 form-floating">
                                    <textarea class="form-control" id="alert" name="alert" rows="8" style="height: 200px;" placeholder="Enter alert message">{{ old('alert', $alert->alert) }}</textarea>
                                    <label for="alert">Alert Message</label>
                                    @error('alert')
                                    <div class="mt-1 validation-error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="disable" name="disable">
                                            <option value="1" {{ $alert->disable == 1 ? 'selected' : '' }}>Enable</option>
                                            <option value="0" {{ $alert->disable == 0 ? 'selected' : '' }}>Disable</option>
                                        </select>
                                        <label for="disable">Status</label>
                                    </div>
                                    @error('disable')
                                    <div class="validation-error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form><!-- End form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

@include('admin.layouts.partials.footer')

@endsection
