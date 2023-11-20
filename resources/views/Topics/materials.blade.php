@extends('layouts.Main')

@section('title', 'Add Materials')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-6">
            <h2 class="text-center">Add Materials to Topic: {{ $topic->title }}</h2>

            <a href="{{ url()->previous() }}">
                <span class="material-symbols-outlined">
                    arrow_back
                </span>
            </a>

            <form action="{{ route('topics.storeMaterials', ['course' => $course->id, 'topic' => $topic->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Search input for filtering materials -->
                <div class="mb-3">
                    <label for="materialSearch" class="form-label">Search Materials:</label>
                    <input type="text" id="materialSearch" class="form-control" placeholder="Search Materials">
                </div>

                <!-- List of materials from the system with search functionality -->
                <div class="mb-3">
                    <label for="existingMaterials" class="form-label">Choose from existing materials:</label>
                    <select id="existingMaterials" name="existing_materials[]" multiple class="form-control">
                        @foreach ($materials as $material)
                            <option value="{{ $material->id }}">{{ $material->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Division style -->
                <hr class="my-4">

                <!-- Input section to upload a file -->
                <h3>Upload a file:</h3>
                <div class="mb-3">
                    <label for="file" class="form-label">File:</label>
                    <input type="file" name="file" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title:</label>
                    <input type="text" name="title" class="form-control" placeholder="Title">
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category:</label>
                    <select name="category" class="form-control">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Add Material button -->
                <button type="submit" class="btn btn-primary">Add Material</button>
            </form>
        </div>
    </div>
    <script>
        // JavaScript code for filtering materials based on user input
        document.getElementById('materialSearch').addEventListener('input', function () {
            var input, filter, select, option, i;
            input = document.getElementById('materialSearch');
            filter = input.value.toUpperCase();
            select = document.getElementById('existingMaterials');
            option = select.getElementsByTagName('option');

            for (i = 0; i < option.length; i++) {
                if (option[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    option[i].style.display = '';
                } else {
                    option[i].style.display = 'none';
                }
            }
        });
    </script>
@endsection
