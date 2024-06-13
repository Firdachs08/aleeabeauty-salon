<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Bill Summary</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }
        .container {
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background: #fff;
        }
        .card {
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #f2f2f2;
            padding: 5px 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        .card-body {
            padding: 10px;
        }
        .card-title {
            margin: 0;
            font-size: 18px;
        }
        .details {
            margin-bottom: 10px;
        }
        .details table {
            width: 100%;
            font-size: 14px;
            line-height: 1.3;
        }
        .details th,
        .details td {
            padding: 2px 0;
            vertical-align: top;
            text-align: left;
        }
        .details th {
            width: 40%;
            padding-right: 10px;
        }
        .btn-print {
            display: block;
            width: 100%;
            margin-top: 10px;
            padding: 8px;
            background-color: #ffc107;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-print:hover {
            background-color: #ff9800;
        }
        .logo-2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo-2 img {
            height: 60px;
            transform: scale(2);
            object-fit: cover;
        }
    </style>
</head>
<body onload="printBill()">
    <div class="container">
        <div class="logo-2 furniture-logo ptb-30">
            <a href="/">
                <img src="{{ asset('frontend/assets/img/logo/logo.jpg') }}" alt="">
            </a>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bill Summary</h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h2 class="text-dark font-weight-medium">Booking ID #{{ $booking->id }}</h2>
                </div>
                <div class="details">
                    <p><strong>Customer Details:</strong></p>
                    <table>
                        <tr>
                            <th>Name:</th>
                            <td>{{ $booking->name }}</td>
                        </tr>
                        <tr>
                            <th>WhatsApp:</th>
                            <td>{{ $booking->handphone }}</td>
                        </tr>
                    </table>
                </div>
                <div class="details">
                    <p><strong>Service Details:</strong></p>
                    <table>
                        <tr>
                            <th>Service:</th>
                            <td>{{ $booking->service_name }}</td>
                        </tr>
                        <tr>
                            <th>Category:</th>
                            <td>{{ $booking->category }}</td>
                        </tr>
                        <tr>
                            <th>Schedule:</th>
                            <td>{{ $booking->date }}</td>
                        </tr>
                        <tr>
                            <th>Time:</th>
                            <td>{{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }}</td>
                        </tr>
                        <tr>
                            <th>Price:</th>
                            <td>IDR. {{ number_format($booking->total, 0, '.', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Payment Status:</th>
                            <td>{{ $booking->status }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-footer text-center">
                <button class="btn-print" onclick="printBill()">Print Bill</button>
            </div>
        </div>
    </div>
</body>
</html>

<!-- Print Bill Script -->
<script>
    function printBill() {
        window.print();
        window.close();
    }
</script>
