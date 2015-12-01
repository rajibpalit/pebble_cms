<style>
    .control-label{
        width: 230px;
        height: 50px;       
    }

</style>
<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>Contact</b></h3>
    </div>
    <div style="margin-top: 5%; margin-left: 10%">
        <form class="form-horizontal" id="contact_form" role="form" method="post" action="<?php echo base_url('main/add_contact') ?>">
            <?php if (isset($keywords)) { ?>
                <input type="hidden" value="<?php echo $keywords[0]['contact_id'] ?>" name="contact_id" >
            <?php } ?>
            <div class="form-inline">
                <div class="form-group" style="width: 50%;">
                    <label class="control-label col-sm-2" for="contact_type">Contact Type</label>
                    <div class="col-sm-3" name="">
                        <select class="form-control" id="contact_type" onchange="toggle()" name="contact_type" style="width: 180px;"> 
                            <option value=" ">Please Select</option>                         
                            <option <?php echo isset($keywords) && ($keywords[0]['contact_type'] == 'Employee') ? 'selected' : '' ?> >Employee</option>
                            <option <?php echo isset($keywords) && ($keywords[0]['contact_type'] == 'Artisan') ? 'selected' : '' ?> >Artisan</option>
                            <option <?php echo isset($keywords) && ($keywords[0]['contact_type'] == 'Client') ? 'selected' : '' ?> >Client</option>
                            <option <?php echo isset($keywords) && ($keywords[0]['contact_type'] == 'Supplier') ? 'selected' : '' ?> >Supplier</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" style="width:58%" for="title">Title</label>
                    <div class="col-sm-3">
                        <select class="form-control select-button" name="title" style="width: 180px;">  
                            <option value="">Please Select</option>
                            <?php
                            foreach ($title as $country) {
                                if ($country['keyword_id'] == $keywords[0]['title']) {
                                    $checked = 'selected';
                                } else {
                                    $checked = '';
                                }
                                echo '<option ' . $checked . ' value="' . $country['keyword_id'] . '">' . $country['keyword_value'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-inline">
                <div class="form-group" id="">
                    <label class="control-label col-sm-2" for="first_name">First Name</label>
                    <div class="col-sm-3">          
                        <input type="text" class="form-control" name="first_name" value="<?php echo isset($keywords) ? $keywords[0]['first_name'] : '' ?>" id="" placeholder="First Name">
                    </div>
                </div>
                <div class="form-group" id="">
                    <label class="control-label col-sm-2" for="last_name">Last Name</label>
                    <div class="col-sm-3">          
                        <input type="text" class="form-control" name="last_name" value="<?php echo isset($keywords) ? $keywords[0]['last_name'] : '' ?>" id="" placeholder="Last Name">
                    </div>
                </div>
            </div>
            <div class="form-inline">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="dob">Date Of Birth</label>
                    <div class="col-sm-3" >          
                        <input type="text" class="form-control" name="dob" value="<?php echo isset($keywords) ? $keywords[0]['dob'] : '' ?>" id="dob">
                    </div>
                    <script type="text/javascript">
                        $(function () {
                            $("#dob").datepicker();
                        });
                    </script>
                </div>

                <div class="form-group" id="">
                    <label class="control-label col-sm-2" for="spouse_name">Spouse Name</label>
                    <div class="col-sm-3">          
                        <input type="text" class="form-control" name="spouse_name" value="<?php echo isset($keywords) ? $keywords[0]['spouse_name'] : '' ?>" id="" placeholder="Spouse Name">
                    </div>
                </div>
            </div>
            <div class="form-inline">
                <div class="form-group" id="">
                    <label class="control-label col-sm-2" for="join_date">Join Date</label>
                    <div class="col-sm-3">          
                        <input type="text" class="form-control" name="join_date" value="<?php echo isset($keywords) ? $keywords[0]['join_date'] : '' ?>" id="join_date">
                    </div>
                    <script type="text/javascript">
                        $(function () {
                            $("#join_date").datepicker();
                        });
                    </script>
                </div>
                <div class="form-group" id="">
                    <label class="control-label col-sm-2" for="national_id">National ID/SSN</label>
                    <div class="col-sm-3">          
                        <input type="text" class="form-control" name="national_id" value="<?php echo isset($keywords) ? $keywords[0]['national_id'] : '' ?>" id="" placeholder="National ID/SSN">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="address">Address</label>
                <div class="col-sm-3">
                    <textarea class="form-control" name="address" value="" id=""><?php echo isset($keywords) ? $keywords[0]['address'] : '' ?></textarea>


                </div>
            </div>
            <div class="form-inline">



                <div class="form-group" style="width:50%">
                    <label class="control-label col-sm-2" for="country">Country</label>
                    <div class="col-sm-3">
                        <select class="form-control" name="country" style="width: 180px;">   
                            <option value="">Please Select</option>
                            <?php
                            foreach ($countrys as $coun) {
                                if ($coun['keyword_id'] == $keywords[0]['country']) {
                                    $checked = 'selected';
                                } else {
                                    $checked = '';
                                }

                                echo '<option ' . $checked . ' value="' . $coun['keyword_id'] . '">' . $coun['keyword_value'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" style="width:58%" for="city">City</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="city" value="<?php echo isset($keywords) ? $keywords[0]['city'] : '' ?>" placeholder="City" style="width: 180px;"> 

                    </div>
                </div>
            </div>
            <div class="form-inline">
                <div class="form-group" id="">
                    <label class="control-label col-sm-2" for="post_code">Zip/Postal code</label>
                    <div class="col-sm-3">          
                        <input type="text" class="form-control" name="post_code" value="<?php echo isset($keywords) ? $keywords[0]['post_code'] : '' ?>" id="" placeholder="Zip/Postal code">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="state">State</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="state" value="<?php echo isset($keywords) ? $keywords[0]['state'] : '' ?>" placeholder="State" style="width: 180px;"> 

                    </div>
                </div>
            </div>
            <div class="form-inline">
                <div class="form-group" id="">
                    <label class="control-label col-sm-2" for="phone">Phone</label>
                    <div class="col-sm-3">          
                        <input type="text" class="form-control" name="phone" value="<?php echo isset($keywords) ? $keywords[0]['phone'] : '' ?>" id="" placeholder="Phone">
                    </div>
                </div>
                <div class="form-group" id="">
                    <label class="control-label col-sm-2" for="cell_no">Cell No</label>
                    <div class="col-sm-3">          
                        <input type="text" class="form-control" name="cell_no" value="<?php echo isset($keywords) ? $keywords[0]['cell_no'] : '' ?>" id="" placeholder="Cell No">
                    </div>
                </div>
            </div>

            <div class="form-inline">
                <div class="form-group" id="">
                    <label class="control-label col-sm-2" for="email">Email</label>
                    <div class="col-sm-3">          
                        <input type="text" class="form-control" name="email" id="email" value="<?php echo isset($keywords) ? $keywords[0]['email'] : '' ?>" id="" placeholder="Email">
                    </div>
                    <span id="usr_verify" class="verify"></span>
                </div>
                <div class="form-group" id="">
                    <label class="control-label col-sm-2" for="web_address">Web Address</label>
                    <div class="col-sm-3">          
                        <input type="text" class="form-control" name="web_address" value="<?php echo isset($keywords) ? $keywords[0]['web_address'] : '' ?>" id="" placeholder="Web Address">
                    </div>
                </div>
            </div>

            <div class="form-inline">



                <div class="form-group" style="width:50%">
                    <label class="control-label col-sm-2" for="job_title">Job Title</label>
                    <div class="col-sm-3">
                        <select class="form-control" name="job_title" style="width: 180px;">   
                            <option value="">Please Select</option>
                            <?php
                            foreach ($job_title as $coun) {
                                if ($coun['keyword_id'] == $keywords[0]['job_title']) {
                                    $checked = 'selected';
                                } else {
                                    $checked = '';
                                }

                                echo '<option ' . $checked . ' value="' . $coun['keyword_id'] . '">' . $coun['keyword_value'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="width:50%">
                    <label class="control-label col-sm-2" for="job_status"  style="width: 155px;">Job Status</label>
                    <div class="col-sm-3">
                        <select class="form-control" name="job_status" style="width: 180px;">   
                            <option value="">Please Select</option>
                            <?php
                            foreach ($job_status as $coun) {
                                if ($coun['keyword_id'] == $keywords[0]['job_status']) {
                                    $checked = 'selected';
                                } else {
                                    $checked = '';
                                }

                                echo '<option ' . $checked . ' value="' . $coun['keyword_id'] . '">' . $coun['keyword_value'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-inline">



                <div class="form-group" style="width:50%">
                    <label class="control-label col-sm-2" for="division">Division</label>
                    <div class="col-sm-3">
                        <select class="form-control" name="division" style="width: 180px;">   
                            <option value="">Please Select</option>
                            <?php
                            foreach ($division as $coun) {
                                if ($coun['keyword_id'] == $keywords[0]['division']) {
                                    $checked = 'selected';
                                } else {
                                    $checked = '';
                                }

                                echo '<option ' . $checked . ' value="' . $coun['keyword_id'] . '">' . $coun['keyword_value'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-inline" id="avg_working_capacity" document.onload="toggle()">
                <div class="form-group" >
                    <label class="control-label col-sm-2" for="avg_working_capacity">Avg. Working Capacity</label>
                    <div class="col-sm-3">          
                        <input type="text" class="form-control" name="avg_working_capacity" value="<?php echo isset($keywords) ? $keywords[0]['avg_working_capacity'] : '' ?>" id="" placeholder="Avg. Working Capacity">
                    </div>
                </div>

            </div>
            <div class="form-inline">
                <div class="form-group" style="width:42%">
                    <div>

                        <label class="control-label col-sm-2" for="gender" style="margin-right: 20px">Gender </label>
                    </div>
                    <div style="margin-left: 13px; width: 420px;">
                        <label class="radio-inline">
                            <input type="radio" name="gender" id="inlineRadio1" <?php echo isset($keywords) && ($keywords[0]['gender'] == 1) ? 'checked' : '' ?>  value="1"> Male
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="gender" id="inlineRadio2" <?php echo isset($keywords) && ($keywords[0]['gender'] == 0) ? 'checked' : '' ?> value="0"> Female
                        </label>
                        
                    </div>

                </div>
                <div class="form-group">
                    <div>

                        <label class="control-label col-sm-2" for="status" style="margin-right: 20px">Status </label>
                    </div>
                    <div style="margin-left: 13px; width: 420px">
                        <label class="radio-inline">
                            <input type="radio" name="status" <?php echo!isset($keywords) ? 'checked' : '' ?> <?php echo isset($keywords) && ($keywords[0]['status'] == 1) ? 'checked' : '' ?> id="inlineRadio1" value="1"> Active
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" id="inlineRadio2" <?php echo isset($keywords) && ($keywords[0]['status'] == 0) ? 'checked' : '' ?> value="0"> Inactive
                        </label>
                    </div>

                </div>
            </div>


            <div class="form-group" style="alignment-adjust: middle; margin-top: 50px;">        
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="submit" class="btn col-sm-3" style="background-color: #6BCACE; margin-right: 10px; padding: 4px; color: white; font-size: 20px;"><b>Save</b></button>                  
                    <a href="<?php echo base_url('main/contact_list'); ?>" class="btn col-sm-3" style="background-color: #6BCACE; padding: 4px; color: white; font-size: 20px;"><b><?php echo (isset($keywords)) ? 'Back' : 'Close' ?></b></a>                                                        
                </div>
            </div>
        </form>
    </div>
    
<script>
//    $.validator.setDefaults({
//        submitHandler: function () {
//            alert("submitted!");
//        }
//    });

    $().ready(function () {

        // validate signup form on keyup and submit
        $("#contact_form").validate({
            rules: {
                contact_type: "required",
                title: "required",
                first_name: "required",
                last_name: "required",
                dob: "required",
                
                spouse_name: "required",
                join_date: "required",
                national_id: "required",
                country: "required",
                city: "required",
                post_code: "required",
                phone: "required",
                cell_no: "required",
                job_title: "required",
                job_status: "required",
                division: "required",
                avg_working_capacity: "required",
                gender: "required"
            },
            messages: {
                contact_type: "required.",
                title: "required.",
                first_name: "required.",
                last_name: "required.",
                dob: "required.",
                
                spouse_name: "required.",
                join_date: "required.",
                national_id: "required.",
                country: "required.",
                city: "required.",
                post_code: "required.",
                phone: "required.",
                cell_no: "required.",
                job_title: "required.",
                job_status: "required.",
                
                division: "required.",
                avg_working_capacity: "required.",
                gender: "required.",
            }
        });
    });

    $(document).ready(function () {
        $("#rawmat_form").validate({
            messages: {
                email: {
                    required: 'Enter this!'
                }
            }
        });
    });
</script>

    
    
    
    
    

    <script type="text/javascript">
        function toggle() {
            var e = document.getElementById("contact_type");
            var contact_type = e.options[e.selectedIndex].value;
            var divToHide1 = document.getElementById("avg_working_capacity");
            if (contact_type == "Artisan")
            {
                divToHide1.style.display = "block";
            }
            else
            {
                divToHide1.style.display = "none";
            }
        }
        window.onload = toggle;
    </script>
    <script>

        $(document).ready(function (e) {
            $('#email').on('change', function () {
                var sEmail = $('#email').val();
// Checking Empty Fields
                if ($.trim(email).length == 0) {
                    alert('All fields are mandatory');
                    e.preventDefault();
                }
                if (validateEmail(sEmail)) {
                    
                }
                else {
                    alert('Invalid Email Address');
                    e.preventDefault();
                }
            });
        });
// Function that validates email address through a regular expression.
        function validateEmail(sEmail) {
            var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
            if (filter.test(sEmail)) {
                return true;
            }
            else {
                return false;
            }
        }
    </script>
    
    
    
