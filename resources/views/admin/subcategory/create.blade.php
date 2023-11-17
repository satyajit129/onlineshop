@extends('admin.layout.master')

@section('style')
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Sub Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.subcategory.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{ route('admin.subcategory.store') }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Name">
                                </div>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Category</label>

                                    <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                        <option value="" selected disabled>Select one</option>

                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="" disabled>No categories found</option>
                                        @endif
                                    </select>

                                </div>
                                @error('category')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Statue</label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                        <option disabled selected>Select One</option>
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                                @error('status')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug"
                                        class="form-control @error('slug') is-invalid @enderror" placeholder="Slug"
                                        readonly>
                                </div>
                                @error('slug')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>


                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="pb-5 d-flex justify-content-between pt-3">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="{{ route('admin.subcategory.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('jsfile')
    <script>
        // jQuery script to automatically update the slug based on the name
        $(document).ready(function() {
            $('#name').on('input', function() {
                // Replace spaces with dashes and convert to lowercase
                var slug = $(this).val().trim().replace(/\s+/g, '-').toLowerCase();
                $('#slug').val(slug);
            });
        });
    </script>
@endsection
