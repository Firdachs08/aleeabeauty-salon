@extends('layouts.admin')

@section('content')
   <div class="container">
    @if(session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ __('Orders') }}
                </h6>
            </div>
            <div class="col-md-4 mb-3">
    <form action="{{ route('admin.orders.index') }}" method="GET">
        <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
        </div>
    </form>
</div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Order ID</th>
                        <th>Grand Total</th>
                        <th>Name</th>
                        <th>WhatsApp</th>
                        <th>Payment</th>
                        <th class="text-center" style="width: 30px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                            {{ $order->code }} <br/>
                            {{ $order->order_date }}
                            </td>
                            <td>{{ number_format($order->base_total_price, 0, '.', '.') }}</td>
                            <td>
                                {{ $order->customer_first_name }} <br/>
                                {{ $order->customer_email }}
                            </td>
                            <td>{{ $order->customer_phone }}</td>
                            <td>
                                {{ $order->payment_status === 'unpaid' ? $order->payment_status : '' . $order->payment_status . '' }}
                                
                            </td>
                           

                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <form onclick="return confirm('are you sure !')" action="{{ route('admin.orders.destroy', $order) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="12">No products found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="12">
                                <div class="float-right">
                                    {!! $orders->appends(request()->all())->links() !!}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
   </div>
@endsection
