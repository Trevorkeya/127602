@extends('layouts.Main')

@section('title', 'Home')

@section('content')

<style>
   .containers {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;

    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1)
   }

   form input, form select, form button {
    display: block;
    margin-bottom: 10px;
    width: 100%;
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #ccc;
  }

  .upload {
    background: #27ae60;
    color: #fff;
    border: none;
    cursor: pointer;
  }

  .upload:hover {
    background: #219d53;
  }

</style>
<div class="containers">
    <form action="{{ route('materials.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" name="title" placeholder="Title">
        <input type="file" name="file">
        <!-- <select name="category">
            <option value="">Select Category</option>
        </select> -->
        <button class="upload" type="submit">Upload</button>
    </form>
</div>

@endsection