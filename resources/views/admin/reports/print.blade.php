<!-- print.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Revenue Report</title>
    <style>
        /* Define your print styles here */
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
    </style>
</head>
<body>
    <h2>Revenue Report</h2>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Service</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $record)
                @if(isset($record->service_name))
                <tr>
                    <td>{{ $record->created_at }}</td>
                    <td>{{ $record->name }}</td>
                    <td>{{ $record->category }} - {{ $record->service_name }}</td>
                    <td>{{ number_format($record->total, 0, '.', '.') }}</td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <h4>Total Revenue per Service</h4>
    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($totalRevenuePerService as $service => $total)
                <tr>
                    <td>{{ $service }}</td>
                    <td>{{ number_format($total, 0, '.', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
