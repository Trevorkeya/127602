@extends('layouts.Main')

@section('title', 'E-Learning Library')

@section('content')
<div style="margin-left: 20px;">
    <div class="container">
        <div class="card-header" style="margin-top: 20px;">
            <h3>Library
                <a href="{{ url('/materials/create')}}" class="btn btn-primary btn-sm float-end">
                    Add Resource
                </a>
            </h3>
        </div>
    </div>
    <br>
    <div class="materials-container">
        <style>
            .title {
                margin-bottom: 10px;
            }

            .materials-container {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
            }

            .material-card {
                width: calc(33.33% - 20px);
                border: 1px solid #ccc;
                padding: 15px;
                margin-bottom: 20px;
                box-sizing: border-box; /* Include padding and border in the width calculation */
                margin-right: 10px;
                margin left: 10px;
            }
        </style>

        @foreach($materials as $key => $material)
        @if($key % 3 == 0)
            <div class="container" style="display: flex;">
        @endif
            <div class="material-card">
                <h3 class="title">{{ $material->title }}</h3>
                <p>Type: {{ $material->type }}</p>
                @if($material->type === 'pdf')
                    <a class="btn btn-primary btn-sm float-end" href="#" onclick="viewPDF('{{ asset($material->file_path) }}')">View</a>
                @else
                    <a class="btn btn-primary btn-sm float-end" href="{{ asset($material->file_path) }}" target="_blank">Download</a>
                @endif
                <div></div>
                <form action="{{ route('materials.destroy', $material->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm float-end" style="margin-right: 10px;" type="submit" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                </form>
            </div>
        @if(($key + 1) % 3 == 0 || $key + 1 == count($materials))
            </div>
        @endif
        @endforeach
    </div>
</div>
@endsection
