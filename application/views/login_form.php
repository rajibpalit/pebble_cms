<style>
    input[placeholder] { 
        font-size: 1.9em;   
    }
    input{
        border-radius: 5px!important; 
    }
</style>
<body style=" height: 100%">
    <div class="container main">
        <div class="col-sm-3 col-md-3 logo">
            <div class="logo-image">
                <img class="image" src="assets/images/pebble-logo.png">
            </div>
            <div class="logo-color">

            </div>
        </div>
        <div class="col-sm-5 col-md-5 log-in-form">
            <div class="wrapper">
                <form id="signin" action="login/check_login" method="post" class="navbar-form navbar-right" role="form">
                    <div class="input-group" style="width:49%">
                        <input id="login_id" class="form-control email-content" type="text" placeholder="Login ID" name="login_id">
                    </div>
                    <div class="input-group" style="width:49%">
                        <input id="password" class="form-control password-value" type="password" placeholder="Password" name="password" >
                    </div>
                    <button class="btn btn-primary btn-block login-btn" type="submit">Login</button>
                </form>
            </div>
        </div>
        <div class="col-sm-4 col-md-4">
            <div>
                <img class="side-image" src="<?php echo base_url() ?>/assets/images/doll_2.png">
            </div>
        </div>

    </div>
</body>
