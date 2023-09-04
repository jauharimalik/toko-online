@extends('frontend.layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')

                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('Affiliate') }}</h1>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Payment Settings')}}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('affiliate.payment_settings_store') }}" method="POST">
                                @csrf
                                <?php /*
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">{{translate('Paypal Email')}}</label>
                                    <div class="col-md-10">
                                        <input type="email" class="form-control" placeholder="{{ translate('Paypal Email')}}" name="paypal_email" value="{{ $affiliate_user->paypal_email }}">
                                    </div>
                                </div>
                                */ ?>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Nama Bank</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" placeholder="Contoh : BCA, Mandiri, BNI, BRI" name="bank_information" value="{{ $affiliate_user->bank_information }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">A.N Rekening</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" placeholder="Atas Nama Pada Rekening" name="nama_rekening" value="{{ $affiliate_user->nama_rekening }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Nomor Rekening</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" placeholder="Contoh : BCA, Mandiri, BNI, BRI" name="nomor_rekening" value="{{ $affiliate_user->nomor_rekening }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Kode Bank</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" placeholder="Masukkan Kode Bank Bila Ada" name="kode_bank" value="{{ $affiliate_user->kode_bank }}">
                                    </div>
                                </div>   
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">KCP Bank</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" placeholder="Masukkan KCP Pembuatan Rekening Bila Ada" name="kcp" value="{{ $affiliate_user->kcp }}">
                                    </div>
                                </div>       
                                <?php /*     
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">{{translate('Bank Informations')}}</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" placeholder="{{ translate('Acc. No, Bank Name etc')}}" name="bank_information" value="{{ $affiliate_user->bank_information }}">
                                    </div>
                                </div>
                                */ ?>
                                <div class="form-group mb-0 text-right">
                                    <button type="submit" class="btn btn-primary">{{translate('Update Payment Settings')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
