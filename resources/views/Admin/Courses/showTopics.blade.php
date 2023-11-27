@extends('layouts.master')

@section('title', 'Topics for ' . $course->title)

@section('content')
    <h3>Topics for {{ $course->title }}</h3>

    @if(count($topics) > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Action</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($topics as $topic)
                    <tr>
                        <td>{{ $topic->id }}</td>
                        <td>{{ $topic->title }}</td>
                        <td>
                            <form action="{{ route('topics.destroy', ['course' => $course->id, 'topic' => $topic->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this topic?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No topics available for this course.</p>
    @endif
@endsection
