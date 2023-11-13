@extends('layouts.Main')

@section('title', 'Quiz')

@section('content')

<div class="container mt-4">
    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <h2>{{ $quiz->name }}</h2>
    <p>Status: {{ $quiz->status }}</p>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createQuestionModal">
        Open Question Modal
    </button>

    <h3>Questions</h3>
    <form action="{{ route('quizzes.finish', $quiz->id) }}" method="POST">
        @csrf
        @foreach($quiz->questions as $question)
            <fieldset class="mb-4">
                <legend>{{ $question->question }}</legend>
                @foreach($question->answers as $answer)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" required>
                        <label class="form-check-label">{{ $answer->answer }}</label>
                    </div>
                @endforeach
            </fieldset>
        @endforeach

        <button type="submit" class="btn btn-primary">Finish Quiz</button>
    </form>
</div>

<!-- Modal -->
 <div class="modal fade" id="createQuestionModal" tabindex="-1" aria-labelledby="createQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createQuestionModalLabel">Create Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form action="{{ route('questions.store', ['quiz' => $quiz]) }}" method="POST" id="questionForm">
                    @csrf

                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <input type="text" name="question" class="form-control" required>
                    </div>

                    <div id="answersContainer">
                        <label class="form-label">Answers</label>
                        <div class="form-group answer-group">
                            <input type="text" name="answers[][answer]" class="form-control mb-2" required>
                            <div class="form-check">
                                <input type="radio" name="correct_answer" value="0" class="form-check-input">
                                <label class="form-check-label">Correct</label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                    <button type="button" class="btn btn-success" onclick="addAnswer()">Add Answer</button>
                    <button type="submit" class="btn btn-primary">Add Question</button>
                </form>
            </div>
        </div>
    </div>
 </div>
 <script>
    let answerIndex = 1;

    function addAnswer() {
        var answersContainer = document.getElementById('answersContainer');
        var lastAnswerGroup = answersContainer.lastElementChild;
        var newAnswerGroup = lastAnswerGroup.cloneNode(true);

        // Clear values for cloned input fields
        newAnswerGroup.querySelector('input[type="text"]').value = '';
        newAnswerGroup.querySelector('input[type="radio"]').checked = false;

        // Increment answer index
        answerIndex++;

        // Update the name attribute with the new index
        newAnswerGroup.querySelector('input[type="radio"]').name = `correct_answer_${answerIndex}`;
        newAnswerGroup.querySelector('input[type="radio"]').value = answerIndex;

        answersContainer.appendChild(newAnswerGroup);
    }
 </script>

<!-- Modal -->

@endsection
