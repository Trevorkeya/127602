@extends('layouts.master')

@section('title', 'Categories')

@section('content')

<div class="row">
    <div class="col-md-12">
        @if(session('message'))
            <div class="alert alert-success">{{ session('message')}}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3>Categories
                    <a href="{{ url('/categories/create')}}" class="btn btn-primary btn-sm float-end">
                        Add Category
                    </a>
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($category as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-success">Edit</a>

                                        <!-- Delete Form -->
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this category?')" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                        <!-- End Delete Form -->
                                    </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">No Categories Available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection