@extends('layouts.Main')

@section('title', 'Quiz')

@section('content')

<!-- Add this to your existing styles or create a new CSS file -->

<style>
    .containers {
        background-color: #fff;
        padding: 20px;
        margin-top: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #007bff;
    }

    p {
        color: #6c757d;
    }

    button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    fieldset {
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: none;
    }
    fieldset.active {
        display: block;
    }

    legend {
        font-weight: bold;
        color: #007bff;
    }

    .form-check-input {
        margin-right: 8px;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .modal-content {
        border-radius: 8px;
    }

    .modal-header {
        background-color: #007bff;
        color: #fff;
        border-radius: 8px 8px 0 0;
    }

    .modal-title {
        margin: 0;
    }

    .btn-success {
        background-color: #28a745;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-success:hover {
        background-color: #218838;
    }
</style>

<div class="container mt-4">
<div class="containers mt-4">
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
        <div id="questionsContainer">
            @foreach($quiz->questions as $key => $question)
                <fieldset class="mb-4 @if($key === 0) active @endif">
                    <legend>{{ $question->question }}</legend>
                    @foreach($question->answers as $answer)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" required>
                            <label class="form-check-label">{{ $answer->answer }}</label>
                        </div>
                    @endforeach
                </fieldset>
            @endforeach
        </div>
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-primary" onclick="prevQuestion()">Previous</button>
            <input type="range" min="0" max="{{ $quiz->questions->count() - 1 }}" value="0" oninput="showQuestion(this.value)">
            <button type="button" class="btn btn-primary" onclick="nextQuestion()">Next</button>
        </div>
            <button type="submit" class="btn btn-primary mt-3">Finish Quiz</button>
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
                            <input type="text" name="answers[0][answer]" class="form-control mb-2" required>
                            <div class="form-check">
                                <input type="checkbox" name="answers[0][is_correct]" class="form-check-input">
                                <label class="form-check-label">Correct Answer</label>
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
    newAnswerGroup.querySelector('input[type="checkbox"]').checked = false;

    // Increment answer index
    answerIndex++;

    // Update the name attribute with the new index
    newAnswerGroup.querySelector('input[type="text"]').name = `answers[${answerIndex}][answer]`;
    newAnswerGroup.querySelector('input[type="checkbox"]').name = `answers[${answerIndex}][is_correct]`;

    answersContainer.appendChild(newAnswerGroup);
   }

   let currentQuestionIndex = 0;
    const totalQuestions = {{ $quiz->questions->count() }};

    function showQuestion(index) {
        const questions = document.querySelectorAll('fieldset');
        questions.forEach((question, i) => {
            if (i === index) {
                question.classList.add('active');
            } else {
                question.classList.remove('active');
            }
        });
    }

    function nextQuestion() {
        if (currentQuestionIndex < totalQuestions - 1) {
            currentQuestionIndex++;
            showQuestion(currentQuestionIndex);
        }
    }

    function prevQuestion() {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            showQuestion(currentQuestionIndex);
        }
    }
 </script>

<!-- Modal -->

@endsection
