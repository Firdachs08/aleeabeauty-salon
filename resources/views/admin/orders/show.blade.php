@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="content">
        <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5">
            <div class="d-flex justify-content-between">
                <h2 class="text-dark font-weight-medium">Order ID #{{ $order->code }}</h2>
                <div class="btn-group">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-warning">Go Back</a>
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-xl-4 col-lg-4">
                    <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Billing Address</p>
                    <address>
                       Name: {{ $order->customer_first_name }} {{ $order->customer_last_name }}
                        <br> {{ $order->customer_address1 }}
                        <br> {{ $order->customer_address2 }}
                        <br>  {{ $order->customer_email }}
                        <br> Phone: {{ $order->customer_phone }}
                    </address>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Details</p>
                    <address>
                        ID: <span class="text-dark">#{{ $order->code }}</span>
                        <br> DATE: <span>{{ $order->order_date }}</span>
                        <br> NOTE: <span>{{ $order->note }}</span>
                        <br> Status: {{ $order->status }} {{ $order->cancelled_at }}
                        <br> Payment Status: {{ $order->payment_status }}
                        @if ($order->payment_status === 'unpaid')
                            <form action="{{ route('admin.orders.markAsPaid', $order) }}" method="POST" class="d-inline-block">
                                @csrf
                                <input type="hidden" name="total_paid" id="hidden-total-paid">
                                <input type="hidden" name="change_amount" id="hidden-change-amount">
                               
                            </form>
                        @else
                            <p>Uang Pembeli: Rp.{{ number_format(session('total_paid'), 0, '.', '.') }}</p>
                            <p>Kembalian: Rp.{{ number_format($order->change_amount, 0, '.', '.') }}</p>
                        @endif
                    </address>
                </div>
            </div>
            <table class="table mt-3 table-striped table-responsive table-responsive-large" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Unit Cost</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($order->orderItems as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>Rp.{{ number_format($item->base_price) }}</td>
                            <td>Rp.{{ number_format($item->sub_total) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Order item not found!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="row justify-content-end">
                <div class="col-lg-5 col-xl-4 col-xl-3 ml-sm-auto">
                    <ul class="list-unstyled mt-4">
                        <li class="mid pb-3 text-dark">Total Order
                            <span class="d-inline-block float-right text-default">{{ number_format($order->base_total_price, 0, '.', '.') }}</span>
                        </li>
                        @if ($order->payment_status === 'unpaid')
                        <li class="mid pb-3 text-dark">
                            <form action="{{ route('admin.orders.savePayment', $order) }}" method="POST" class="d-inline-block">
                                @csrf
                                <label for="total-paid">Uang Pembeli :</label>
                                <input type="number" id="total-paid" name="total_paid" class="form-control" required>
                                <button class="btn btn-sm btn-success mt-2" type="submit">Simpan Pembayaran</button>
                            </form>
                        </li>
                        @endif
                        <li class="mid pb-3 text-dark">Kembalian
                            <span class="d-inline-block float-right text-default" id="change-amount">{{ number_format($order->change_amount, 0, '.', '.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('total-paid').addEventListener('input', function() {
        var totalPaid = parseFloat(this.value) || 0;
        var totalOrder = {{ $order->base_total_price }};
        var change = totalPaid - totalOrder;
        document.getElementById('change-amount').textContent = 'Rp.' + new Intl.NumberFormat('id-ID').format(change);
    });
</script>
@endsection
