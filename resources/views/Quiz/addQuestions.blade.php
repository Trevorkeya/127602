@extends('layouts.Main')

@section('title', 'Add Questions')

@section('content')

<div class="container">
@if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
        @endif
    <h2>Add Questions to {{ $quiz->name }}</h2>
    <form action="{{ route('questions.store', $quiz->id) }}" method="POST">
        @csrf
        <div id="questions-container">
            <div class="mb-3 question">
                <label for="question">Question 1</label>
                <input type="text" name="questions[]" class="form-control" required>

                <label for="answer1">Answer 1</label>
                <input type="text" name="answers[1][]" class="form-control" required>

                <label for="answer2">Answer 2</label>
                <input type="text" name="answers[1][2]" class="form-control" required>

                <label for="answer3">Answer 3</label>
                <input type="text" name="answers[1][3]" class="form-control" required>

                <label for="answer4">Answer 4</label>
                <input type="text" name="answers[1][4]" class="form-control" required>

                <label for="correctAnswer">Correct Answer (choose a number)</label>
                <select name="correctAnswers[]" class="form-control" required>
                    @foreach(range(1, 4) as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="button" class="btn btn-success" id="add-question">Add Question</button>
        <button type="submit" class="btn btn-primary">Finish Questions</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        let questionIndex = 1;

        $('#add-question').click(function() {
            questionIndex++;

            const newQuestion = $('#questions-container .question:first').clone();
            newQuestion.find('label').each(function() {
                const labelFor = $(this).attr('for').replace(/\d+/g, questionIndex);
                $(this).attr('for', labelFor);
            });

            newQuestion.find('input, select').each(function() {
                const name = $(this).attr('name').replace(/\d+/g, questionIndex);
                $(this).attr('name', name);
                $(this).val('');
            });

            $('#questions-container').append(newQuestion);
        });
    });
</script>

@endsection
