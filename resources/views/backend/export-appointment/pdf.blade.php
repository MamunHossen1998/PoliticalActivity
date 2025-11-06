<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Appointment Export</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .hospital-logo {
            width: 60px;
            height: auto;
            margin-bottom: 5px;
        }
        .hospital-name {
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }
        .hospital-name span {
            font-weight: 300;
        }
        hr {
            border: none;
            border-top: 2px solid #ccc;
            margin: 10px 0 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }
        th {
            background: #f3f3f3;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        {{-- If you have a logo image, use it below --}}
        {{-- <img src="{{ public_path('images/hospital-logo.png') }}" alt="Hospital Logo" class="hospital-logo"> --}}

        <!-- Hospital Name -->
        <div class="hospital-name">
            <strong>AL-</strong><span class="fw-light">BARAQAH</span>
        </div>
        <hr>
    </div>

    <h4 style="text-align:center; margin-bottom:5px;">
        {{ $doctor?->name ?? 'All Doctors' }} - Appointment List
    </h4>

    <!-- Appointment Date -->
    @if($date)
        <p style="text-align:center; margin:0;"><strong>Date:</strong> {{ $date }}</p>
    @endif

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Patient</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $a)
            <tr>
                <td>{{ $a->id }}</td>
                <td>{{ $a->name }}</td>
                <td>{{ $a->phone }}</td>
                <td>{{ $a->gender }}</td>
                <td>{{ $a->age }}</td>
                <td>{{ $a->type }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
