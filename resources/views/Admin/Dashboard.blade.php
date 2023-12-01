@extends('layouts.master')

@section('title', 'Administrator')

@section('content')
<div class="container-fluid px-4">

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Total Courses: {{ $coursesCount }}</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ url('/admin/courses') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Total Students: {{ $studentsCount }}</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ url('admin/students') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Total Administrators: {{ $adminsCount }}</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ url('admin/administrators') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">Total Instructors: {{ $instructorsCount }}</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ url('admin/instructors') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="width: 300px; height: 300px;">
    <canvas id="userTypeChart" width="100" height="100"></canvas>
</div>
<div class="col-md-12" style="width: 300px; height: 300px;">
    <canvas id="courseEnrollmentChart" width="100" height="100"></canvas>
</div>


    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('userTypeChart').getContext('2d');
    var userTypeChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Users', 'Administrators', 'Instructors'],
            datasets: [{
                data: [{{ $studentsCount }}, {{ $adminsCount }}, {{ $instructorsCount }}],
                backgroundColor: ['#007bff', '#28a745', '#ffc107'],
            }],
        },
    });
</script>
<script>
    var ctxEnrollment = document.getElementById('courseEnrollmentChart').getContext('2d');
    var enrollmentChart = new Chart(ctxEnrollment, {
        type: 'bar',
        data: {
            labels: @json($courses->pluck('title')), 
            datasets: [{
                label: 'Enrollment Count',
                data: @json($courses->pluck('users_count')), 
                backgroundColor: '#007bff',
            }],
        },
    });
</script>

@endsection
