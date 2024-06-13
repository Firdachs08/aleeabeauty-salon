@extends('layouts.frontend')
@section('title', 'Services')
@push('style')
    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="{{ config('midtrans.clientKey') }}"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
@endpush
@section('content')
    <div class="section-title-furits text-center">
        <h2>DETAIL BOOKING SERVICE</h2>
    </div>
    <div class="shop-page-wrapper shop-page-padding ptb-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>WhatsApp</th>
                                    <th>Price</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $booking->name }}</td>
                                    <td>{{ $booking->handphone }}</td>
                                    <td>{{ $booking->total }}</td>
                                    <td>{{ $booking->date }}</td>
                                    <td>{{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-dark" id="pay-button">Pay Now</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script type="text/javascript">
  var payButton = document.getElementById('pay-button');
  payButton.addEventListener('click', function () {
    window.snap.pay('{{ $snapToken }}', {
      onSuccess: function(result){
        alert("Payment success!");
        window.location.replace("{{ route('booking.print', ['bookingId' => $booking->id]) }}");
      },
      onPending: function(result){
        alert("Waiting for your payment!");
      },
      onError: function(result){
        alert("Payment failed!");
      },
      onClose: function(){
        alert('You closed the popup without finishing the payment');
      }
    });
  });
</script>

@endpush

