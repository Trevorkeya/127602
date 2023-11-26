@extends('layouts.main')

@section('title', 'Quiz Results')

@section('content')
    <div class="container mt-4">
        <h1>Results</h1>

        @if(Auth::user()->type == 'user')
            @foreach($user->courses as $course)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->title }}</h5>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ $course->title }}</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($course->quizzes ?? [] as $quiz)
                                    @php
                                        $latestResult = $user->quizResults()
                                            ->where('quiz_id', $quiz->id)
                                            ->orderByDesc('created_at')
                                            ->first();
                                    @endphp

                                    @if($latestResult)
                                        <tr>
                                            <td>{{ $quiz->name }}</td>
                                            <td>{{ $latestResult->score }} / {{ $quiz->questions->count() }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
