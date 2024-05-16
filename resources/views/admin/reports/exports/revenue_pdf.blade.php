<!DOCTYPE html>
<html>
<head>
    <title>Revenue Report PDF</title>
    <style>
        /* CSS styling for PDF */
        /* Add your styling here */
    </style>
</head>
<body>
    <h2>Revenue Report</h2>
    <hr>
    <p>Period: {{ $startDate }} - {{ $endDate }}</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Activity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $record)
            <tr>
                <td>{{ $record->created_at }}</td>
                <td>{{ $record->name }}</td>
                <td>
                    @if(isset($record->service_name))
                    Booking: {{ $record->service_name }}
                    @elseif(isset($record->code))
                    Order: {{ $record->code }}
                    @endif
                </td>
                <td>
                    @if(isset($record->service_name))
                    {{ $record->total }}
                    @elseif(isset($record->code))
                    {{ $record->grand_total }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
