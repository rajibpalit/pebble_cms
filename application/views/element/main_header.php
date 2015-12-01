<!DOCTYPE html>
<html lang="en">
    <head>

        <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>">
        <link rel="stylesheet" href="<?php echo base_url("assets/css/style.css"); ?>">
        <!--<link rel="stylesheet" href="<?php echo base_url("assets/css/screen.css"); ?>">-->
        <link rel="stylesheet" href="<?php echo base_url("assets/css/jqueryui.css"); ?>">
        <script type="text/javascript" src="<?php echo base_url("assets/js/jquery.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/jqueryui.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/validation/pjquery.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/validation/jquery.validate.js"); ?>"></script>
        <!--<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>-->

        <link rel="stylesheet" href="css/bootstrap.css"> 
        <title>Pebble CMS</title>
    </head>
    <body>
        <div class="container" style="padding: 0;">

            <div class="col-sm-3 col-md-3 logo" style="border-bottom: 5px solid #6BCACE; margin-bottom: 10px;">
                <div class="logo-image">
                    <img class="image" src="<?php echo base_url('assets/images/pebble-logo.png') ?>"  style="margin-bottom: 7px">
                </div>
            </div>
            <div class="col-sm-9 col-md-9" style="padding-right: 0px">
                <div class="col-sm-12 col-md-12 " style="margin-top: 10px; padding: 0;">

                    <?php
//                    $config = $this->session->flashdata('config');
//                    var_dump($config);
                    ?>
                    <div class="top_menu">
                        <?php if (isset($config) && $config != 'null') { ?>
                            <a href="<?php echo base_url('home') ?>" >Home</a> |
                        <?php } else { ?>
                            <a href="<?php echo base_url('main/config') ?>" >Configuration</a> |
                        <?php } ?>
                        <a href="" data-toggle="modal" data-target="#password_modal" >Change Password</a> |
                        <a href="<?php echo base_url('main/logout') ?>" >Log Out</a>
                    </div>

                    <div  style="float: right; font-size: 12px; margin-top: 9px;">
                        <div>
                            <?php echo $this->session->userdata('user_name'); ?>
                        </div>
                        <div>
                            <?php
                            echo date('d M, Y');
                            ?>
                        </div>
                    </div>

                </div>

                <div class="col-sm-12 col-md-12" style="margin-top: 10px; padding: 0;z-index: 99;">
                    <?php if (!isset($config)) { ?>
                        <nav class="navbar navbar-default">
                            <div class="">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>

                                </div>
                                <div id="navbar" class="navbar-collapse collapse">
                                    <ul class="nav navbar-nav menu-padding">
                                        <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('home/') ?>">Home</a></li>
<!--                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Invoice<span class="caret"></span></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li <?php // if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('home/invoice') ?>">Invoice  </a></li>
                                                <li <?php // if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('pending_workorder') ?>">Workorder </a></li>

                                            </ul>
                                        </li>-->


                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Distribution<span class="caret"></span></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('home/pending_distribution_list') ?>">Product  Distribution  </a></li>
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('home/pending_rawdistribution_list') ?>">Raw Material Distribution</a></li>
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('home/receivedistribution_list') ?>">Distribution Receive</a></li>
                                            </ul>
                                        </li>
                                        <!--<li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="backend/dashboard">Product Movement</a></li>-->
                                        <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('packing') ?>">Packing Note</a></li>
                                        <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('shipment') ?>">Shipment</a></li>
                                        <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('home/payment_list') ?>">Payment</a></li>
                                        <!--<li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('rawmat') ?>">Raw Material</a></li>-->

                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Raw Material<span class="caret"></span></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'pre_orders')) echo 'class="active"'; ?>><a href="<?php echo base_url('rawmat_pur') ?>">Raw Material Purchase</a></li>
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'orders')) echo 'class="active"'; ?>><a href="<?php echo base_url('rawmat_rec') ?>">Raw Material Receive</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Stock<span class="caret"></span></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('home/stock_list') ?>">Stock Entry</a></li>
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('home/raw_mat_stock_list') ?>">Raw Material Stock Entry</a></li>
                                            </ul>
                                        </li>
                                        <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="#">Report</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    <?php } else { ?>
                        <nav class="navbar navbar-default">
                            <div class="">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>

                                </div>
                                <div id="navbar" class="navbar-collapse collapse">
                                    <ul class="nav navbar-nav menu-padding">

                                        <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/client_list') ?>">Client</a></li>

                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Currency<span class="caret"></span></a>
                                            <ul class="dropdown-menu" role="menu">

                                                <li <?php if ((!empty($page_name)) && ($page_name == 'pre_orders')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/currency_list') ?>">Currency</a></li>
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'orders')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/exchange_rates_list') ?>">Exchange Rate</a></li>

                                            </ul>
                                        </li>


                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Product Flow<span class="caret"></span></a>
                                            <ul class="dropdown-menu" role="menu">

                                                <li <?php if ((!empty($page_name)) && ($page_name == 'pre_orders')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/mu_list') ?>">MU Conversion</a></li>
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'orders')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/skill_list') ?>">Skill</a></li>
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'orders')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/product_actions_list') ?>">Production Action</a></li>
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'orders')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/flow_action_list') ?>">Flow Action</a></li>
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'orders')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/product_list') ?>">Product</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Label<span class="caret"></span></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'pre_orders')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/#') ?>">Product Label Mapping</a></li>
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'orders')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/#') ?>">Client Label Mapping</a></li>
                                            </ul>
                                        </li>

                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Shipment<span class="caret"></span></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'pre_orders')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/shipment_provider_list') ?>">Shipment Provider</a></li>

                                            </ul>
                                        </li>


                                        <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('bank') ?>">Bank</a></li>


                                        <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/users_list') ?>">Users</a></li>

                                        <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('rawmatsupp') ?>">Raw Material Supplier</a></li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Other<span class="caret"></span></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/contact_list') ?>">Contacts</a></li>
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/mail_list') ?>">Mail</a></li>
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/payment_list') ?>">Payment Mode</a></li>
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/rural_center_list') ?>">Rural Center</a></li>
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/insurance_companies_list') ?>">Insurance Company</a></li>
                                                <li <?php if ((!empty($page_name)) && ($page_name == 'dashboard')) echo 'class="active"'; ?>><a href="<?php echo base_url('main/list_keyword') ?>">Keywords</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    <?php } ?>
                </div>

            </div>

        </div>






        <div class="container main-content" style="padding: 0px">

