@extends('layouts.master')

@section('title', 'Categories')

@section('content')

<div class="row">
    <div class="col-md-12">
        @if(session('message'))
            <div class="alert alert-success">{{ session('message')}}</div>
        @endif

        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                   <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif

        <div class="card">
            <div class="card-header">
                <h3>Add category
                    <a href="{{ url('/categories/index')}}" class="btn btn-danger btn-sm float-end">
                        Back
                    </a>
                </h3>
            </div>
            <div class="card-body">

            <form method="POST" action="{{ url('/categories') }}" >
              @csrf

              <label for="name">Category Name:</label>
              <input type="text" id="name" name="name">

              <div class="col-md-12 text-end">
              <button type="submit" class="btn btn-primary">Create Category</button>
              </div>

            </form>

            </div>
        </div>
    </div>
</div>


@endsection