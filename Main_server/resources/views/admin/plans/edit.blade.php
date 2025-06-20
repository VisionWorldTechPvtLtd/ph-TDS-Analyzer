@extends('admin.layouts.app')

@section('title', 'Edit Plan')

@section('content')

    @include('admin.layouts.partials.header')


    @include('admin.layouts.partials.sidebar')


    <main id="main" class="main">

        @include('admin.layouts.partials.breadcrums')

        @include('admin.layouts.partials.alerts')

        <section class="section dashboard">
          <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Plan <span>| new</span></h5>
                        <hr>
                        <!-- Floating Labels Form -->
                        <form class="row g-3" method="POST" action="{{ route('plans.update', $plan->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $plan->title }}">
                                    <label for="title">Title *</label>
                                </div>
                                @error('title')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="duration" name="duration" value="{{ $plan->duration }}">
                                    <label for="duration">Duration *</label>
                                </div>
                                @error('duration')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="price" name="price"  value="{{ $plan->price }}">
                                    <label for="price">Price *</label>
                                </div>
                                @error('price')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="checkbox" class="mx-4" id="visiable" name="visiable" @if ($plan->visiable) checked @endif >
                                    <label for="visiable">Visiable</label>
                                </div>
                                <p class="text-info input-info">Check if you don`t want to show pump in front !</p>
                                @error('visiable')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" name="description" placeholder="description.." id="description" style="height: 70px;">{{ $plan->description }}</textarea>
                                    <label for="description">Description</label>
                                </div>
                                @error('description ')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>
                            <div class="text-left">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form><!-- End floating Labels Form -->

                    </div>

                </div>

            </div><!-- End Left side columns -->


          </div>
        </section>

      </main><!-- End #main -->


    @include('admin.layouts.partials.footer')

@endsection
