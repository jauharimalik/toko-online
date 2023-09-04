@extends('backend.layouts.app')

@section('content')
@php
    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
@endphp

<div class="card">
    <form class="" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col-lg-12  text-center text-md-left">
                <h5 class="mb-md-0 h6">Penjualan Produk</h5>
            </div>
            <div class="col-lg-3 mt-3 ml-auto">
                <select class="form-control aiz-selectpicker" name="reseller" id="reseller" data-live-search="true" onchange="sort_orders()">
                    <option value="">{{translate('Pilih Reseller')}}</option>
                    <?php
                        $user = \App\User::get();
                        foreach($user as $keyl => $vall){
                    ?>
                    <option value="{{ $vall->id }}"  @isset($levely) @if($levely == $vall->id ) selected @endif 
                        @endisset>{{ $vall->name }}</option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-2 mt-3 ml-auto">
                <select class="form-control aiz-selectpicker" name="payment_status" id="payment_status" data-live-search="true" onchange="sort_orders()">
                    <option value="">Status Pembayaran</option>
                    <option value="paid" @if($payment == "paid") selected @endif>Lunas</option>
                    <option value="unpaid" @if($payment == "unpaid") selected @endif>Pending</option>
                </select>
            </div>
            <div class="col-lg-3 mt-3 ml-auto">
                <div class="form-group mb-0">
                    <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                </div>
            </div>
            <div class="col-lg-3 mt-3 ml-auto">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Order code & hit Enter') }}">
                </div>
            </div>       
            <div class="col-lg-1 mt-3 ml-auto">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                </div>
            </div>
        </div>
    </form>
    <div class="card-body">
    @isset($levely)
        <div class="row gutters-5 slidebox">
            <div class="col-3">
                <div class="bg-grad-3 text-white rounded-lg mb-3 overflow-hidden">
                    <div class="px-3 pt-3">
                        <div class="opacity-50">
                        <span class="fs-12 d-block"> Total Penjualan</span></div>
                        <div class="h5 fw-700 mb-3">{{ single_price($penjualan_produk) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="bg-grad-4 text-white rounded-lg mb-3 overflow-hidden">
                    <div class="px-3 pt-3">
                        <div class="opacity-50">
                        <span class="fs-12 d-block">Total Komisi</span></div>
                        <div class="h5 fw-700 mb-3">{{ single_price($komisi_produk) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="bg-grad-1 text-white rounded-lg mb-3 overflow-hidden">
                    <div class="px-3 pt-3">
                        <div class="opacity-50">
                        <span class="fs-12 d-block">Status Komisi</span></div>
                        <div class="h5 fw-700 mb-3">Manual</div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="bg-grad-2 text-white rounded-lg mb-3 overflow-hidden">
                    <div class="px-3 pt-3">
                        <div class="opacity-50">
                        <span class="fs-12 d-block">Total Downline</span></div>
                        <div class="h5 fw-700 mb-3">{{ ($cdownline) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="bg-grad-1 text-white rounded-lg mb-3 overflow-hidden">
                    <div class="px-3 pt-3">
                        <div class="opacity-50">
                        <span class="fs-12 d-block">Penjualan Pribadi</span></div>
                        <div class="h5 fw-700 mb-3">{{ single_price($penjualan_produk1) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="bg-grad-2 text-white rounded-lg mb-3 overflow-hidden">
                    <div class="px-3 pt-3">
                        <div class="opacity-50">
                        <span class="fs-12 d-block">Penjualan Downline</span></div>
                        <div class="h5 fw-700 mb-3">{{ single_price($penjualan_produk2) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="bg-grad-3 text-white rounded-lg mb-3 overflow-hidden">
                    <div class="px-3 pt-3">
                        <div class="opacity-50">
                        <span class="fs-12 d-block">Komisi Penjualan</span></div>
                        <div class="h5 fw-700 mb-3">{{ single_price($komisi_produk1) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="bg-grad-4 text-white rounded-lg mb-3 overflow-hidden">
                    <div class="px-3 pt-3">
                        <div class="opacity-50">
                        <span class="fs-12 d-block">Komisi Downline</span></div>
                        <div class="h5 fw-700 mb-3">{{ single_price($komisi_produk2) }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endisset
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ translate('Code') }}</th>
                    <th data-breakpoints="md">{{ translate('Qty') }}</th>
                    <th data-breakpoints="md">{{ translate('Pelanggan') }}</th>
                    <th data-breakpoints="md">Total</th>
                    @isset($upline)
                    <th data-breakpoints="md">Komisi</th>
                    @else
                    <th data-breakpoints="md">Pengiriman</th>
                    @endisset
                    <th data-breakpoints="md">Pembayaran</th>
                    @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                    <th>{{ translate('Refund') }}</th>
                    @endif
                    <th class="text-right" width="15%">{{translate('options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $key => $order)
                <tr>
                    <td>
                        {{ ($key+1) + ($orders->currentPage() - 1)*$orders->perPage() }}
                    </td>
                    <td>
                        {{ $order->code }}
                    </td>
                    <td>
                        {{ count($order->orderDetails) }}
                    </td>
                    <td>
                        @if ($order->user != null)
                        {{ $order->user->name }}
                        @else
                        Guest ({{ $order->guest_id }})
                        @endif
                    </td>
                    <td>
                        {{ single_price($order->grand_total) }}
                    </td>
                    <td>
                        @php
                            $status = 'Delivered';
                            foreach ($order->orderDetails as $key => $orderDetail) {
                                if($orderDetail->delivery_status != 'delivered'){
                                    $status = ucwords($orderDetail->delivery_status);
                                } if($orderDetail->delivery_status == 'cancelled') {
                                    $status = '<span class="badge badge-inline badge-danger">'.translate('Cancel').'</span>';
                                }
                            }

                            $d_komisi_produk = 0;
                            $agid = ($order->user) ? $order->user->id : null;
                            $agen = \App\Agen::where('user_id', $agid)->first();
                            if(isset($agen)){
                                $level = \App\AgenPaket::where('id',$agen->paket_id)->first();
                                if($level != null){
                                    $d_komisi_produk = ($order->grand_total / 100 * $level->downline);
                                    if(isset($upline)){
                                        if($order->user->id == $upline){
                                            $d_komisi_produk = ($order->grand_total / 100 * $level->komisi_produk);
                                        }
                                    }
                                    
                                }
                            }

                        @endphp
                        @isset($upline) {{ single_price($d_komisi_produk) }}
                        @else {!! $status !!} @endisset
                    </td>
                    <td>
                        @if (strtolower($order->payment_status) == 'paid')
                        <span class="badge badge-inline badge-success">{{translate('Paid')}}</span>
                        @else
                        <span class="badge badge-inline badge-danger">{{translate('Unpaid')}}</span>
                        @endif
                    </td>
                    @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                    <td>
                        @if (count($order->refund_requests) > 0)
                        {{ count($order->refund_requests) }} {{ translate('Refund') }}
                        @else
                        {{ translate('No Refund') }}
                        @endif
                    </td>
                    @endif
                    <td class="text-right">
                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('all_orders.show', encrypt($order->id))}}" title="{{ translate('View') }}">
                            <i class="las la-eye"></i>
                        </a>
                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('invoice.download', $order->id) }}" title="{{ translate('Download Invoice') }}">
                            <i class="las la-download"></i>
                        </a>
                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('orders.destroy', $order->id)}}" title="{{ translate('Delete') }}">
                            <i class="las la-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="aiz-pagination">
            {{ $orders->appends(request()->input())->links() }}
        </div>
        
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection
