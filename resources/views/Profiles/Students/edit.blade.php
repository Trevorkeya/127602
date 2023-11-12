@extends('layouts.Main')

@section('title', 'Profile')

@section('content')

<div>
    <div class="container">
        
        @if(session('messsage'))
             <p class="alert alert-success">{{ session('message') }}</p>
        @endif

        @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
        @endif
           </br>
        <div class="row">
            <div class="card shadow">
                  </br>
                <div class="card-header bg-success">
                    Profile
                </div>
                <div class="card-body">
                        <form action="{{route('student.profile.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Phone number</label>
                                        <input type="text" name= "phone" value="{{ Auth::user()->student->phone_number ?? ''}}" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Date of Birth</label>
                                        <input type="text" name="dateofbirth" value="{{ Auth::user()->student->date_of_birth ?? ''}}" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="image">
                                        <label for="image">Add image</label>
                                        <input type="file" class="form-control" name="image" id="image" required>
                                    </div>
                                </div>
                                <div class="c0l-md-12">
                                    <button type="submit" class="btn btn-success">Save Profile</button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection