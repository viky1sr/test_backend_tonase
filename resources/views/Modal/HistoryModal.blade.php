<div class="modal fade" id="historyModal">
    <div class="modal-dialog modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <h3 class="modal-title"></h3>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="card">
                        <ul class="nav nav-tabs mb-3">
                            <li class="nav-item">
                                <a href="#pengumumanTab" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                    <span class="d-none d-lg-block">History Trasnfer</span>
                                </a>
                            </li>
                            <li class="nav-item hidden">
                                <a href="#topUpTab" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                    <span class="d-none d-lg-block">History Top Up</span>
                                </a>
                            </li>
                            <li class="nav-item hidden">
                                <a href="#withdrawTab" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                    <span class="d-none d-lg-block">History Withdraw</span>
                                </a>
                            </li>
                        </ul>


                        <div class="tab-content">

                            <!-- Detail Tender -->
                            <div class="tab-pane show active" id="pengumumanTab">
                                <div class="row">
                                    <!-- column -->
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>History Transfer</h4>
                                                <div class="table-responsive">
                                                    <table class="table table-hover" id="transferTable">
                                                        <thead>
                                                        <tr>
                                                            <th>Name Account</th>
                                                            <th>Status</th>
                                                            <th>Amount</th>
                                                            <th>Info Card</th>
                                                            <th>Date</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Detail Tender -->

                            <div class="tab-pane" id="topUpTab">
                                <div class="row">
                                    <!-- column -->
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>History Top Up</h4>
                                                <div class="table-responsive">
                                                    <table class="table table-hover" id="topUpTable">
                                                        <thead>
                                                        <tr>
                                                            <th>Name Account</th>
                                                            <th>Status</th>
                                                            <th>Amount</th>
                                                            <th>Info Card</th>
                                                            <th>Date</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="withdrawTab">
                                <div class="row">
                                    <!-- column -->
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>History Withdraw</h4>
                                                <div class="table-responsive">
                                                    <table class="table table-hover" id="withdrawTable">
                                                        <thead>
                                                        <tr>
                                                            <th>Name Account</th>
                                                            <th>Status</th>
                                                            <th>Amount</th>
                                                            <th>Info Card</th>
                                                            <th>Date</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- /.box-body -->

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger pull-left" data-dismiss="modal">Close</button>
                </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type="text/javascript">

    var tableTransfer = $('#transferTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('info-transfer.index') }}",
        "columnDefs": [
            { "width": "100%", "targets": 0 }
        ],
        columns: [
            {data: 'name_info', name: 'name_info'},
            {data: 'status', name: 'status'},
            {data: 'amount_info', name: 'amount_info'},
            {data: 'info_transfer', name: 'info_transfer'},
            {data: 'waktu', name: 'waktu'},
        ]
    });

    var tableTopUp = $('#topUpTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('history-top-up.index') }}",
        "columnDefs": [
            { "width": "100%", "targets": 0 }
        ],
        columns: [
            {data: 'name_info', name: 'name_info'},
            {data: 'status', name: 'status'},
            {data: 'amount_info', name: 'amount_info'},
            {data: 'info_transfer', name: 'info_transfer'},
            {data: 'waktu', name: 'waktu'},
        ]
    });

    var tableWithdraw = $('#withdrawTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('withdraw.index') }}",
        "columnDefs": [
            { "width": "100%", "targets": 0 }
        ],
        columns: [
            {data: 'name_info', name: 'name_info'},
            {data: 'status', name: 'status'},
            {data: 'amount_info', name: 'amount_info'},
            {data: 'info_transfer', name: 'info_transfer'},
            {data: 'waktu', name: 'waktu'},
        ]
    });
</script>
