<div class="modal fade" id="registerSaldo">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="register_form" method="POST" action="{{route('register-acc-saldo.store')}}">
                @csrf

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <h3 class="modal-title">Register Account Saldo</h3>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="box-body">

                        <div class="form-group">
                            <label>Number Card</label>
                            <input type="text" min="0" maxlength="11" class="form-control"  id="number_card" name="number_card"  autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Amount</label>
                            <input type="text" class="form-control tfrupiah"  name="amount"  autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <!-- /.box-body -->

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script>
    $(document).ready(function(){
        $('#register_form').on('submit', function(e){

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#search").prop('disabled', true);
            $.ajax({
                type: 'post',
                url: $(this).attr("action"),
                data: $(this).find('input,select').serialize(),
                dataType: 'json',
                success: (data) => {
                    if(data.status == "ok"){
                        toastr["success"](data.messages);
                        window.location.reload(true);
                    }
                },
                error: (data) => {
                    var data = data.responseJSON;

                    console.log(data)
                    if(data.status == "fails"){
                        toastr["error"](data.messages);
                    }
                }
            });
        });
    });
</script>
