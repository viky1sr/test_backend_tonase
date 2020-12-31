<div class="modal fade" id="withdrawModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="withdraw_form" method="POST" action="{{route('withdraw-saldo.store')}}">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                </div>

                <div class="modal-body">

                    <div class="box-body">
                        <h4 class="modal-title text-center">Withdraw Saldo</h4>
                        <br>

                        <div class="form-group">
                            <label >Amount</label>
                            <input type="text" class="form-control withdrawidr"  name="amount">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <!-- /.box-body -->

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="search" class="btn btn-primary">Submit</button>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function(){
        $('#withdraw_form').on('submit', function(e){

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'post',
                url: $(this).attr("action"),
                data: $(this).find('input,select').serialize(),
                dataType: 'json',
                success: (data) => {
                    $("#search").prop('disabled', true);
                    if(data.status === "ok"){
                        toastr["success"](data.messages);
                        window.location.reload(true);
                    }
                },
                error: (data) => {
                    var data = data.responseJSON;
                    console.log(data);
                    if(data.status == "fails"){
                        toastr["error"](data.messages);
                    }
                }
            });
        });
    });
</script>
