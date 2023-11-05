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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($category as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
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