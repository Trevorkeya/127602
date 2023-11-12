@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

<div class="row">
    <div class="col-md-12">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success')}}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3>Materials
                    <a href="{{ url('/materials/create') }}" class="btn btn-primary btn-sm float-end">
                        Add Material
                    </a>
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Uploaded By</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($materials as $material)
                            <tr>
                                <td>{{ $material->id }}</td>
                                <td>{{ $material->title }}</td>
                                <td>{{ $material->category->name }}</td>
                                <td>{{ $material->user->name }}</td>
                                <td>{{ $material->type }}</td>
                                <td>
                                    <a href="{{ asset($material->file_path) }}" class="btn btn-sm btn-primary">Download</a>
                                    <form action="{{ route('materials.destroy', $material->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this material?')" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">No Materials Available</td>
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
