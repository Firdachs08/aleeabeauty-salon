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
        <h2>ORDER CONFIRMATION</h2>
    </div>
    <div class="shop-page-wrapper shop-page-padding ptb-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    {{-- <div class="table-content table-responsive">
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
                                    <td>{{ $booking->time }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div> --}}
                    <h3 class="text-center">Are you sure you want to continue paying with the <span class="font-weight-bold">Cashless</span> method with a total of <span class="font-weight-bold">IDR. {{ number_format( $order->base_total_price, 0, '.', '.') }}.</span></h1>
                    <div class="text-center">
                        <button class="btn btn-dark mt-2" id="pay-button">Pay Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script type="text/javascript">
      // For example trigger on button clicked, or any time you need
      var payButton = document.getElementById('pay-button');
      payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay('{{ $snapToken }}', {
          onSuccess: function(result){
            /* You may add your own implementation here */
            alert("payment success!"); console.log(result);
            window.location.replace("{{ route('order.success', $order->id) }}");
          },
          onPending: function(result){
            /* You may add your own implementation here */
            alert("wating your payment!"); console.log(result);
          },
          onError: function(result){
            /* You may add your own implementation here */
            alert("payment failed!"); console.log(result);
          },
          onClose: function(){
            /* You may add your own implementation here */
            alert('you closed the popup without finishing the payment');
          }
        })
      });
    </script>
@endpush
