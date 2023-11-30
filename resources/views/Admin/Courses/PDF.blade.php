<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course List - PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            text-decoration: none;
            padding: 8px 16px;
            background-color: #4caf50;
            color: white;
            border-radius: 4px;
        }
        .btn-danger {
            background-color: #f44336;
        }
        .btn-warning {
            background-color: #ff9800;
        }
    </style>
</head>
<body>
    <h2>Course List</h2>
    
    <table>
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
