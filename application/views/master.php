<!DOCTYPE html>
<html>

    <head>
        <style>
            #header {
                background-color:black;
                color:white;
                text-align:center;
                padding:5px;
            }
            #nav {
                line-height:30px;
                background-color:#eeeeee;
                height:300px;
                width:100px;
                float:left;
                padding:5px;	      
            }
            .main_content {
                width:350px;
                float:left;
                padding:10px;	 	 
            }
            #footer {
                background-color:black;
                color:white;
                clear:both;
                text-align:center;
                padding:5px;	 	 
            }
        </style>
    </head>

    <body>

        <div id="header">
            <h1>Welcome to Grameen Phone Cafeteria Management System.</h1>
            <?php
            $admin_name = $this->session->userdata('admin_name');
            echo 'Hello '.$admin_name;
            ?>
            <br>
            <a href="<?php echo base_url(); ?>super_login/user_logout" class="button red" text-aline="left">Logout</a>
        </div>

        <div id="nav">
            London<br>
            Paris<br>
            Tokyo<br>
        </div>

        <div class="main_content">
            <?php echo $maincontent; ?>
        </div>

        <div id="footer">
            Copyright © Domain Technology Ltd.
        </div>

    </body>
</html>