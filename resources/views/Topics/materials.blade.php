@extends('layouts.Main')

@section('title', 'Add Materials')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-6">
            <h2 class="text-center">Add Materials to Topic: {{ $topic->title }}</h2>

            <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Back</a>

            <form action="{{ route('topics.storeMaterials', ['course' => $course->id, 'topic' => $topic->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- List of materials from the system -->
                <h3>Choose from existing materials:</h3>
                <select name="existing_materials[]" multiple class="form-control mb-3">
                    @foreach ($materials as $material)
                        <option value="{{ $material->id }}">{{ $material->title }}</option>
                    @endforeach
                </select>

                <!-- Search feature to look for specific materials -->
                <h3>Search for specific materials:</h3>
                <!-- Implement your search functionality here -->

                <!-- Input section to upload a file -->
                <h3>Upload a file:</h3>
                <input type="file" name="file" class="form-control mb-3">
                <input type="text" name="title" placeholder="Title" class="form-control mb-3">
                <select name="category" class="form-control mb-3">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <!-- Add Material button -->
                <button type="submit" class="btn btn-primary">Add Material</button>
            </form>
        </div>
    </div>
@endsection
