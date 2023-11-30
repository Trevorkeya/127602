<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course List - PDF</title>
</head>

<body>

    <div style="width: 95%; margin: 0 auto;">
        
        <div style="width: 50%; float: left;">
            <h1>All Courses Details</h1>
        </div>
    </div>

    <table style="position: relative; top: 50px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Course Code</th>
                <th>Title</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->course_code }}</td>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->status ? 'Active' : 'Inactive' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No Courses Available</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
