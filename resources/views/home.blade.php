@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}
                    <div class="float-right">
                        @if($data->UserSaldo !== null)
                        <button id="" class="btn btn-info mr-2" data-toggle="modal" data-target="#transferModal"> Transfer
                            <i class="fa fa-download btn-xs" aria-hidden="true"></i>
                        </button>
                            <button id="" class="btn btn-warning mr-2" data-toggle="modal" data-target="#withdrawModal"> Withdraw
                                <i class="fa fa-download btn-xs" aria-hidden="true"></i>
                            </button>
                            <button id="" class="btn btn-primary mr-2" data-toggle="modal" data-target="#topUpModal"> Top Up
                                <i class="fa fa-download btn-xs" aria-hidden="true"></i>
                            </button>
                        @endif
                        <button id="" class="btn btn-success mr-2" data-toggle="modal" data-target="#historyModal"> History
                            <i class="fa fa-download btn-xs" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($data->User->saldo_user != null)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Saldo Anda</label>
                                        <input type="text" class="form-control" disabled value="{{isset($data->UserSaldo) ? rupiah($data->UserSaldo->amount) : ''}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Number Card</label>
                                        <input type="text" class="form-control" disabled value="{{isset($data->UserSaldo) ? $data->UserSaldo->number_card : ''}}">
                                    </div>
                                </div>
                            </div>
                        @else
                            <button class="btn btn-success mr-2" data-toggle="modal" data-target="#registerSaldo"> Register Account Saldo
                                <i class="fa fa-download btn-xs" aria-hidden="true"></i>
                            </button>
                        @endif

                </div>
            </div>
        </div>
    </div>
</div>

<!-- History Modal -->
@include('Modal.HistoryModal');
<!-- End History Modal -->

<!-- Transfer Modal -->
@include('Modal.TransferModal')
<!-- End Transfer Modal -->

<!-- RegisterSaldo Modal -->
@include('Modal.RegisterSaldoModal')
<!-- End Register Modal -->

<!-- Withdraw Modal -->
@include('Modal.WithdrawModal')
<!-- End Withdraw -->

<!-- Withdraw Modal -->
@include('Modal.TopUpModal')
<!-- End Withdraw -->


<script type="text/javascript">

    $(document).on('keyup', ".tfrupiah",  function () {
        this.value = formatRupiah(this.value, "");

    });

    $(document).on('keyup', ".topupidr",  function () {
        this.value = formatRupiah(this.value, "");

    });

    $(document).on('keyup', ".withdrawidr",  function () {
        this.value = formatRupiah(this.value, "");

    });

    var rupiah = document.getElementById('rupiah');
    rupiah.addEventListener('keyup', function(e){
        rupiah.value = formatRupiah(this.value, "");
    });

    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   	    = number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
        return prefix === undefined ? rupiah : rupiah ? rupiah : "";
    }

</script>

@endsection
