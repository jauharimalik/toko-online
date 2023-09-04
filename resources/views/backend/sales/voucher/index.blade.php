@extends('backend.layouts.app')

@section('content')

<div class="card">
    <form class="" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col-lg-12  text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('Penjualan Voucher') }}</h5>
            </div>
            <div class="col-lg-3 mt-3 ml-auto">
                <select class="form-control aiz-selectpicker" name="lokasi" id="lokasi" data-live-search="true" onchange="sort_orders()">
                    <option value="">{{translate('Pilih Lokasi')}}</option>
                    <?php
                        $lokasi_filter = \App\Vorder::whereNotNull('lokasi')->groupBy('lokasi')->get();
                        foreach($lokasi_filter as $keyl => $vall){
                            $nas = \App\Na::where("id",$vall->lokasi)->first();
                    ?>
                    <option value="{{ $vall->lokasi }}"  
                    @isset($lokasi) 
                        @if($lokasi == $vall->lokasi ) selected @endif 
                    @endisset>{{ $nas->shortname ?? "Tidak Tahu" }}</option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-2 mt-3 ml-auto">
                <select class="form-control aiz-selectpicker" name="payment_status" id="payment_status" data-live-search="true" onchange="sort_orders()">
                    <option value="">{{translate('Status Pembayaran')}}</option>
                    <option value="Lunas"  @isset($payment_status) @if($payment_status == 'Lunas') selected @endif @endisset>{{translate('Lunas')}}</option>
                    <option value="Pending"  @isset($payment_status) @if($payment_status == 'Pending') selected @endif @endisset>{{translate('Pending')}}</option>
                    <option value="Gagal"  @isset($payment_status) @if($payment_status == 'Gagal') selected @endif @endisset>{{translate('Gagal')}}</option>
                </select>
            </div>
            <div class="col-lg-3 mt-3  ml-auto">
                <div class="form-group mb-0">
                    <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Tanggal') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                </div>
            </div>
            <div class="col-lg-2 mt-3 ml-auto">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Order code & hit Enter') }}">
                </div>
            </div>
            <div class="col-lg-2 mt-3  ml-auto">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                </div>                    
            </div>
        </div>
    </form>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ translate('Order Code') }}</th>
                    <th data-breakpoints="md">{{ translate('Qty') }}</th>
                    <th data-breakpoints="md">{{ translate('Lokasi') }}</th>
                    <th data-breakpoints="md">{{ translate('Tanggal') }}</th>
                    <th data-breakpoints="lg">{{ translate('Customer') }}</th>
                    <th data-breakpoints="md">Total</th>
                    <th data-breakpoints="md">{{ translate('Status') }}</th></th>
                    <th data-breakpoints="lg" class="text-right" width="15%">{{translate('options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $key => $order)
                @php 
                    $qty = \App\VorderDetail::where("order_id",$order->code)->sum('qty');
                @endphp
                <tr>
                    <td>
                        {{ ($key+1) + ($orders->currentPage() - 1)*$orders->perPage() }}
                    </td>
                    <td>
                        <a href="{{ route('voucher.transdetail',$order->code) }}" target="_blank">{{ $order->code}}</a>
                    </td>
                    <td>
                        {{ $qty }} Voucher
                    </td>
                    <td>
                        <?php $nas = \App\Na::where("id",$order->lokasi)->first(); echo $nas->shortname ?? "Belum Tahu"; ?>
                    </td>                    
                    <td>
                                    <?php
                                        $tanggal = date('D, Y-m-d H:i:s', strtotime($order->date));
                                        $tanggal0 = explode(" ",$tanggal);
                                        $hari = \App\Tanggalan::hari(str_replace(",","",$tanggal0[0]));
                                        $tanggal = \App\Tanggalan::tgl_indo($tanggal0[1]);
                                        $waktu = $hari.",".$tanggal;
                                    ?>
                                    {{ $waktu }}</td>
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
                        @if ($order->payment_status != 'Lunas')
                        <span class="badge badge-inline badge-danger">{{ $order->payment_status }}</span>
                        @else
                        <span class="badge badge-inline badge-success">{{ $order->payment_status}}</span>
                        @endif
                    </td>
                    <td class="text-right">
                        @if ($order->payment_status == 'Lunas')
                        <span class="btn btn-soft-danger btn-icon btn-circle btn-sm" onclick="payment('{{$order->code}}','Pending');"  target="_blank" title="Cancell Payment">
                            <i class="las la-money-bill"></i>
                        </span>
                        @else
                        <span class="btn btn-soft-success btn-icon btn-circle btn-sm" onclick="payment('{{$order->code}}','Lunas');" target="_blank" title="Terima Pembayaran">
                            <i class="las la-money-bill"></i>
                        </span>
                        @endif
                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('voucher.transdetail',$order->code) }}" target="_blank" title="{{ translate('View') }}">
                            <i class="las la-eye"></i>
                        </a>
                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('voucher.destroy', $order->code)}}" title="{{ translate('Delete') }}">
                            <i class="las la-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
        <table class="table table-borderless">
            <tbody>
                <tr>
                    <td class="w-50 font-weight-bold">Total Penjualan</td>
                    <td class="text-right">
                        <strong><span>{{ single_price($total) }}</span></strong>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
        </div>
        <div class="aiz-pagination">
            {{ $orders->appends(request()->input())->links() }}
        </div>
        
    </div>
</div>

@endsection
@section('script')
    <script type="text/javascript">
        function payment(id,status){
            $.post('{{ route('voucher.bayar') }}',{_token:'{{ @csrf_token() }}', id:id,status:status}, function(data){
                location.reload();
            });
        }
    </script>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection