<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>User Information</b></h3>
    </div>

    <?php
//    echo '<pre>';
//    print_r($value[0]);
//    echo '</pre>';
    ?>
    <div style="margin-top: 5%; margin-left: 15%">
        <form class="form-horizontal" id="user_form" role="form" method="post" action="<?php echo base_url('main/add_user') ?>">
            <?php if (isset($value)) { ?>
                <input type="hidden" value="<?php echo $value[0]['user_id'] ?>" name="user_id" >
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-sm-2" for="login_id">Login Id</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="login_id" value="<?php echo isset($value) ? $value[0]['login_id'] : '' ?>" id="login_id" placeholder="Enter Login Id">
                </div>
            </div> 


            <div class="form-group">
                <label class="control-label col-sm-2" for="user_name">User Name</label>
                <div class="col-sm-3">
                    <input type="hidden" class="form-control" readonly id="user_name" name="user_name" value="<?php echo isset($value) ? $value[0]['contact_id'] : '' ?>" id="">
                    <input type="text" class="form-control" readonly id="user_first_name" name="user_first_name" value="<?php echo isset($value) ? $value[0]['first_name'] . ' ' . $value[0]['last_name'] : '' ?>" id="">

                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="role">Role</label>
                <div class="col-sm-3">
                    <select class="form-control" id="role" name="role">
                        <option value="">Please Select...</option>
                        <?php
                        foreach ($roles as $role) {
                            if ($role['role_id'] == $value[0]['role']) {
                                $checked = 'selected';
                            } else {
                                $checked = '';
                            }
                            echo '<option ' . $checked . ' value="' . $role['role_id'] . '">' . $role['role_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="password">Password</label>
                <div class="col-sm-3">          
                    <input type="password" class="form-control" name="password" value="<?php echo isset($value) ? $value[0]['password'] : '' ?>" id="password" placeholder="Enter Password">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="comments">Comments</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="comments" value="<?php echo isset($value) ? $value[0]['comments'] : '' ?>" id="comments" placeholder="Enter Comments">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="user_remarks">Remarks</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="user_remarks" value="<?php echo isset($value) ? $value[0]['user_remarks'] : '' ?>" id="comments" placeholder="Enter Remarks">
                </div>
            </div>
            <div class="form-group">
                <div>

                    <label class="control-label col-sm-2" for="user_status" style="margin-right: 20px">Status </label>
                </div>
                <div style="margin-left: 13px;">
                    <label class="radio-inline">
                        <input type="radio" name="user_status" <?php echo!isset($value) ? 'checked' : '' ?> <?php echo isset($value) && ($value[0]['user_status'] == 1) ? 'checked' : '' ?> id="inlineRadio1" value="1"> Active
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="user_status" id="inlineRadio2" <?php echo isset($value) && ($value[0]['user_status'] == 0) ? 'checked' : '' ?> value="0"> Inactive
                    </label>
                </div>

            </div>
            <div class="form-group" style="alignment-adjust: middle; margin-top: 50px;">        
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="submit" id="submit" class="btn col-sm-3" style="background-color: #85C51F; margin-right: 10px; padding: 4px; color: white; font-size: 20px;"><b>Save</b></button>                  
                    <a href="<?php echo base_url('main/users_list'); ?>" class="btn col-sm-3" style="background-color: #85C51F; padding: 4px; color: white; font-size: 20px;"><b><?php echo (isset($value)) ? 'Back' : 'Close' ?></b></a>                                                        
                </div>
            </div>
        </form>
    </div>
</div>

<script>
//    $.validator.setDefaults({
//        submitHandler: function () {
//            alert("submitted!");
//        }
//    });

    $().ready(function () {

        // validate signup form on keyup and submit
        $("#user_form").validate({
            rules: {
                login_id: "required",
                role: "required",
                contact_no: "required",
                mobile_no: "required",
                interval_days: "required",
                password: {
                    required: true,
                    minlength: 5
                },
                confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
            },
            messages: {
                login_id: "Please type your login id.",
                role: "Please select your role.",
                contact_no: "Please enter contact_no.",
                mobile_no: "Please enter mobile no.",
                interval_days: "Please enter interval days.",
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                confirm_password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Please enter the same password as above"
                },
            }
        });
    });
</script>



<script>
    $(document).ready(function () {
        $('#submit').on('click', function () {
            if ($('#key_id').val() == '') {
                $('#key_id').css('border', '1px solid red');
            }
            else {
                $('#key_id').css('border', '1px solid #ccc');
            }
            if ($('#keyword_value').val() == '') {
                $('#keyword_value').css('border', '1px solid red');
            }
            else {
                $('#keyword_value').css('border', '1px solid #ccc');
            }
        });
        $(function () {
            $("#login_id").autocomplete({
                source: "<?php echo base_url(); ?>main/get_birds" // path to the get_birds method
            });
        });
    });
</script>



<script>
    $(document).ready(function () {
        $('#login_id').on('change', function () {
            var email = $(this).val();
            var url = '<?php echo site_url('main/ajax_data_user') ?>';
            $.ajax({
                type: "POST",
                url: url, //Relative or absolute path to response.php file
                data: 'email=' + email,
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    var contact = data.contact_id;
                    var name = data.first_name + ' ' + data.last_name;
                    $('#user_first_name').val(name);
                    $('#user_name').val(contact);
                }
            });
        });
    });
</script>
