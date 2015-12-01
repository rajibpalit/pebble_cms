<div class="modal fade" id="password_modal" onblur="clear_pass_info(this)">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close1" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Change Password</h4>
            </div>
            <form class="form-inline" action="" method="post" >
                <div class="modal-body">


                    <div class="form-group" style="width: 100%">
                        <label class="col-sm-4" for="password" >Current Password</label>
                        <input style="margin-bottom: 15px;" type="password" class="form-control" name="current_password" id="current_password" placeholder="Current Password">
                    </div>
                    <div class="form-group" style="width: 100%">
                        <label class="col-sm-4" for="new_password">New Password</label>
                        <!--<input type="text" class="form-control" name="branch_name" id="branch_name" placeholder="Branch Name">-->
                        <input style="margin-bottom: 15px;" type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password">
                    </div>
                    <div class="form-group" style="width: 100%">
                        <label class="col-sm-4" for="conform_password">Conform Password</label>
                        <!--<input type="text" class="form-control" name="account_numnber" id="account_numnber" placeholder="Account Number">-->
                        <input style="margin-bottom: 15px;" type="password" class="form-control" name="conform_password" id="conform_password" placeholder="Conform Password">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="close" data-dismiss="modal">Close</button>
                    <button type="button" id="save_change"  class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

</html>


<script>
    var pathArray = location.pathname.split('/');
    var location1 = window.location.origin + '/' + pathArray[1] + '/' + 'main' + '/';
    var user_id = <?php echo $this->session->userdata('login_id') ?>;
//    console.log(location1);
//    console.log(user_id);
    $(document).ready(function () {
        $("#save_change").on('click', function () {
            var new_password = $('#new_password').val();
            var count = new_password.length;
            if (count >= 6)
            {
                if ($('#new_password').val() == $('#conform_password').val())
                {
                    var current_password = $('#current_password').val();
                    var url = location1 + 'check_password';
                    console.log(url);
                    $.ajax({
                        async: false,
                        type: "POST",
                        url: url, //Relative or absolute path to response.php file
                        data: 'password=' + current_password + ' ' + new_password,
                        dataType: 'json',
                        success: function (data) {
                            if (data == 1)
                            {
                                alert("Successfully Password Changed!!");
//                        $('#password_modal').dialog("close");
                                $("#password_modal").modal('hide');
                            }
                            else if (data == 0)
                            {
                                alert("Error Current Password!!");
                            }

                        }
                    });
                }
                else
                {
                    alert('Miss Matched New Password');
                }
            }
            else
            {
                alert("Expected Password More Than 5 Digit.");
            }

        });
    });
    $('#password_modal').on('hidden.bs.modal', function (e) {
        $(this)
                .find("input")
                .val('')
                .end();
    });
</script>
