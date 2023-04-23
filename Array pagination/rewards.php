<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:100">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<style type="text/css">
    .Milestons-chart-wrapper ul li {
        width: 17%;
        padding: 15px;
    }

    .Milestons-chart-wrapper ul li canvas {
        /*width: 200px!important;
        height: 110px!important;*/
        margin: 0 auto;
    }

    .canvas-wrap {
        padding: 15px;
    }

    .Milestons-chart-wrapper h4 {
        font-size: 17px;
    }


    .dataTables_wrapper.no-footer .dataTables_scrollBody {
        border-bottom: 0px;
    }


    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #070393 !important;
        border: 0px !important;
        color: #ffffff !important;
        border-radius: 50%;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 50%;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        border: 0px;
        border-radius: 50%;
        background: #f7bb06 !important;
    }

    .dataTables_wrapper.no-footer div.dataTables_scrollHead table.dataTable,
    .dataTables_wrapper.no-footer div.dataTables_scrollBody>table {
        border-left: 1px solid #bdbdbd;
        border-right: 1px solid #bdbdbd;
        border-top: 1px solid #bdbdbd;
    }

    table.dataTable thead .sorting_asc:nth-child(1):after {
        display: none !important;
    }

    table.dataTable thead th:nth-child(1),
    table.dataTable thead td:nth-child(1) {
        padding: 10px 30px;
    }

    table.dataTable thead th {
        background: #eee !important;
    }

    table.dataTable thead>tr>th {
        vertical-align: middle;
        border-right: 1px solid;
        border-color: #ccc !important;
        color: rgba(0, 0, 0, 0.7);
    }

    table.dataTable tbody>tr>td {
        border-right: 1px solid #ccc;
    }

    table.dataTable.display tbody tr.odd>.sorting_1 {
        background-color: #ffffff;
    }

    table.dataTable.display tbody tr.even>.sorting_1 {
        background: #fafafa;
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_desc:after {
        content: '\f107' !important;
        font-family: 'FontAwesome';
        opacity: 1 !important;
        color: #000;
    }

    table.dataTable thead .sorting_asc:after {
        content: '\f106' !important;
        font-family: 'FontAwesome';
        opacity: 1 !important;
        color: #000;
    }

    table.dataTable tbody>tr>td:nth-child(1) {
        padding-left: 20px;
    }

    table.dataTable.stripe tbody tr.odd,
    table.dataTable.display tbody tr.odd {
        background: #ffffff !important;
    }

    table.dataTable.stripe tbody tr.even,
    table.dataTable.display tbody tr.even {
        background: #fafafa !important;
    }

    table.dataTable tbody>tr>td>p {
        margin: 0px;
    }

    table.dataTable tbody>tr>td>p.mar-top-10,
    button.mar-top-10 {
        margin-top: 10px;
    }

    form label.error {
        color: red;
    }

    /*.campaignsTableDesign {
        border-spacing: 0px 14px !important;
        border-bottom: none !important;
    }*/

    .campaignsTableDesign tbody tr ,
    .campaignsTableDesign2 tbody tr {
        box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.3);
        border-radius: 0;
        overflow: hidden;
    }

    .campaignsTableDesign tr th ,
    .campaignsTableDesign2 tr th {
        font-size: 14px !important;
        font-weight: 600 !important;
        padding-left: 18px !important;
        border-right: 0px !important;
    }

    .campaignsTableDesign tbody td,
    .campaignsTableDesign2 tbody td {
        padding: 8px 18px !important;
        border-top: none;
        border-right: 0px !important;
    }

    .campaignsTableDesign thead th,
    .campaignsTableDesign2 thead th,
    .campaignsTableDesign tbody td ,
    .campaignsTableDesign2 tbody td {
        padding-top: 13px !important;
        padding-bottom: 13px !important;
    }

    .campaignsTableDesign tbody tr:hover td ,
    .campaignsTableDesign2 tbody tr:hover td {
        background-color: #f5f5f5 !important;
    }

    .campaignsTableDesign .dataTables_empty ,
    .campaignsTableDesign2 .dataTables_empty {
        padding-top: 25px !important;
        padding-bottom: 180px !important;
    }
    table.dataTable.campaignsTableDesign2 {
        border: none;
        border-collapse: collapse!important;
    }
    table.campaignsTableDesign2.dataTable tbody>tr>td>p i {
        width: 18px;
        text-align: center;
    }
    table.campaignsTableDesign2.dataTable thead>tr>th:last-of-type{
        min-width: 120px;
    }
    table.dataTable.no-footer {
        border: none;
    }

    .table-btn-wrp {
        white-space: nowrap;
    }

    .select2-dropdown {
        z-index: 99999;
    }
    /*category*/
    .category-ul-list li a {
        color: #070393;
        font-size: 14px;
        line-height: 22px;
        width: 100%;
        display: block;
        background-color: #f1f1f1;
        margin-bottom: 3px;
        padding: 5px 10px;
        transition: 0.3s ease-in-out;
    }
    .category-ul-list li a:hover , .category-ul-list li a.active{
        background-color: #070393;
        color: #fff;
    }
    .category-head {
        font-size: 18px;
        line-height: 26px;
        color: #000;
    }
    .category-ul-list {
        max-height: 500px;
        height: 100%;
        overflow: hidden;
        overflow-y: auto;
    }
    .no-data-found {
        font-size: 22px;
        line-height: 28px;
        color: #000;
    }
    .search-cart-link .search-field {
        /*margin-left: auto;*/
        margin-right: 15px;
    }
    .catelog-head h5 {
        font-size: 20px;
        line-height: 28px;
    }
    .catelog-head h5 span {
        font-size: 15px;
        line-height: 23px;
    }
    .btn.cs-cart-btn {
        position: relative;
        background-color: #070393;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        transition: 0.3s ease-in-out;
    }

    .cs-badge { 
        position: absolute;
        top: -13px;
        right: -10px;
        background: #ff0000;
        border-radius: 50%;
        min-width: 20px;
        min-height: 20px;
        font-size: 13px;
        font-weight: 600;
        line-height: 20px;
        color: #fff;
        padding: 0 6px;
        border: 1px solid #fff;
    }
    .product-found p {
        color: #868686;
        font-size: 15px;
        line-height: 22px;
    }
    .top-right-img img {
        position: absolute;
        top: 10px;
        right: 10px;
        max-width: 30px;
        object-fit: scale-down;
    }
    .top-right-img {
        position: absolute;
        top: 10px;
        right: 10px;
        max-width: 30px;
        width: 100%;
        height: 30px;
    }
    .top-right-img img {
        position: absolute;
        top: 0;
        right: 0;
        left: 0
        bottom:0;
        width: 100%;
        height: 100%;
        object-fit: scale-down;
        z-index: 9  
    }
    /*category end*/

    /*slider */
    .cs-banner-img{
        position: relative;
    } 
    .cs-banner-img,
    .cs-banner-img a,
    .cs-banner-img a img{
        width: 100%;
    }
    /*.cs-banner-img img{
        height: 150px;
    }*/
    .cs-banner-img a{
        display: inline-block; 
    }
    .cs-banner-img .dt-button{
        width: auto;
        position: absolute;
        right: 10px;
        top: 10px;
        margin: 0;
        font-size: 29px;
        padding: 0;
        line-height: 29px;
    }
    .cs-banner-img .dt-button { 
        z-index: 9;
    }
    /*slider end*/

    @media(max-width: 991px) {
        .Milestons-chart-wrapper ul li {
            width: 25%;
        }
    }

    @media(max-width: 767px) {
        .Milestons-chart-wrapper ul li {
            width: 50%;
        }
    }

    @media(max-width: 575px) {
        .Milestons-chart-wrapper ul li {
            width: 100%;
        }
         .category-ul-list {
            max-height: 300px!important;
        }
    }

    /*loader style*/
    .cs_loader {
        position: fixed;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 99999;
        background-color: rgba(0, 0, 0, 0.8);
    }

    .cs_loader img {
        width: 70px;
        height: 70px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }


    /*loader style end*/
    .select-all input {
        margin: 0 5px 0 0;
    }

    .select-all {
        padding-bottom: 10px;
        display: flex;
        align-items: center;
        text-transform: capitalize;
    }
    .selection .select2-selection {
        max-height: 100px !important;
        overflow-y: auto;
        height: 100%;
        width: 100%;
        overflow-x: hidden;
    }

    .status-message .select-all {
        position: static;
    }
    .status-message {
        position: relative;
    }
    .status-message label.error {
        position: absolute;
        left: 0;
        top: calc(100% - 5px);
    }
    .product-wrap {
        position: relative;
        margin-top: 30px;
    }
    .product-wrap  a.wishlist {
        position: absolute;
        bottom: 20px;
        right: 20px;
        font-size: 18px; 
        line-height: 18px;
        z-index: 9;
        color: red;
    }
    .product-wrap a.wishlist.added i:before{
        content: "\f004";
    }
    .product-wrap figure{
        position: relative;
        padding-bottom: 64%;
        border-radius: 5px;
        overflow: hidden;
    }
    .product-wrap figure img{
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        object-fit: scale-down;
        object-position: center;
    }
    .product-wrap h3.product-title {
        font-size: 16px;
        margin: 10px 0 5px 0;
        color: #000;
        line-height: 23px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .product-wrap h3.product-title a{
        color: inherit;
    }
    .product-wrap h3.product-title a:hover{
        color: #070393;
    }
    .product-wrap .product-description p {
        font-size: 14px;
        line-height: 20px;
        margin: 0;
        color: #656565;
    }
    .product-wrap .product-description {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 40px;
    }
    .product-wrap h5.product-price {
        font-size: 19px;
        line-height: 19px;
        color: #070393;
    }
    .product-wrap .add-to-cart  {
        background-color: #070393 !important;
        font-size: 1em;
        color: #fff;
        border-radius: 4px;
        background-image: none !important;
        border: 0px !important;
        position: relative;
        display: inline-block;
        box-sizing: border-box;
        margin-right: 0.333em;
        padding: 0.5em 1em;
        outline: none;
        width: 100%;
    }
    .cs-product-des .row{
        display: flex;
        flex-wrap: wrap;
    }
    .cs-product-des .row:after,
    .cs-product-des .row:before{
        display: none;
    }
    .search-field input {
        border-radius: 2px;
        padding-left: 10px;
        padding-right: 30px;
        margin-left: auto;
        display: block;
    }
    .pagination-wrap {
        text-align: center;
    } 
    .search-cart-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .product-outer {
        border-radius: 5px;
        background: #eee;
        padding: 10px;
        display: inline-flex;
        align-items: flex-start;
    }
    .product-outer  + .product-outer {
        margin-top: 20px;
    }
    .cs-product-img img {
        width: 100%;
    }
    .product-text{
        width: 250px;
    }

    .cs-product-img {
        width: 100px;
        margin-right: 10px;
        display: inline-block;
    }

    .daterangepicker.show-calendar {
       z-index: 99999;
    }

       /* The switch - the box around the slider */
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    /* The slider */
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
    .sort-field {
        margin-left: auto;
        padding: 0 10px;
    }
    .sort-field select {
        border: 1px solid #bfcbd9;
        box-shadow: none;
        color: #494949;
        font-size: 14px;
        line-height: 1;
        height: 36px;
        background: transparent;
        width: 110px;
        border-radius: 3px;
    }
    .cs-main-category ul li a{
        color: #0c0c0c;
        font-size: 14px;
        line-height: 22px;
        width: 100%;
        display: block;
        background-color: #f1f1f1;
        margin-bottom: 3px;
        transition: 0.3s ease-in-out;
        padding: 10px 15px;
        position: relative;
        padding-right: 30px;
    }  
    .cs-main-category ul li a.dropdown-category:after{
        content: "\f107";
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-family: "Font Awesome 5 Free";
        font-weight: 700;
        font-size: 16px;
        color: #0c0c0c;
    }
    .cs-main-subcategory h3 a{
        color: #ffffff;
        font-size: 16px;
        line-height: 22px;
        width: 100%;
        display: block;
        background-color: #0a0198;
        margin-bottom: 10px;
        transition: 0.3s ease-in-out;
        padding: 10px 15px;
        position: relative;
        padding-right: 30px;
        font-weight: 500;
    }
    .cs-main-subcategory h3{
        margin-top: 0;
    }
    .cs-main-subcategory h3 a:after,
    .cs-main-subcategory ul li a.dropdown-category:after{
        content: "\f106";
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-family: "Font Awesome 5 Free";
        font-weight: 700;
        font-size: 16px;
        color: #fff;
    }
    .cs-main-subcategory ul li a.dropdown-category:after{
        color: #333;
        content: "\f107";
    }
    .cs-main-subcategory ul li a {
        color: #333;
        font-size: 15px;
        line-height: 22px;
        width: 100%;
        display: block;
        transition: 0.3s ease-in-out;
        padding: 6px 15px;
        position: relative;
        padding-right: 30px;
        font-weight: 400;
    }
    .cs-main-subcategory ul li a.active{
        color: #0a0198!important;
    }
    .cs-main-subcategory ul ul{
        padding-left: 20px;
    }
    .cs-main-subcategory ul li a.active.dropdown-category:after{
        content: "\f106";
        color: #0a0198!important;
    }
    #milestone_Modal .modal-content .form-group{
        position: relative;
    }
    .image-carousel .owl-nav button {
        position: absolute;
        bottom: 30px;
        width: 25px;
        height: 25px;
        left: 10px;
        background: #fff!important;
        display: inline-block;
        border-radius: 50%;
        text-align: center;
        line-height: 25px!important;
        color: #070393!important;
        font-size: 25px!important;
        padding: 0!important;
    }
    .image-carousel .owl-nav button span{
        line-height: 10px;
        height: 11px;
        top: -1px;
        position: relative;
        display: inline-block;
    }
    .image-carousel .owl-nav button.owl-next {
        right: 10px;
        left: unset;
    }
    .image-carousel .owl-dots {
        display: flex;
        justify-content: center;
    }
    .image-carousel .owl-dots button.owl-dot {
        margin: 3px;
        width: 8px;
        height: 8px;
        display: inline-block;
        background: #120e94;
        border-radius: 50%;
    }
    .eligible-decline{
        color: red;
        font-size: 20px;
    }
    .eligible-app{
        color: green;
        font-size: 20px;
    }
    .eligible-pending{
        color: #0eccdf;
        font-size: 20px;
    }
</style>
<div class="cs_loader" style="display: none;">
    <img src="https://crm.rateshop.ca/assets/images/loadergif.gif">
</div>
<div id="wrapper">
    <div class="screen-options-area"></div>
    <div class="content">
        <div class="row">
            <div class="panel_s">
                <div class="panel-body">
                    <!-- chart sec  -->
                    <div class="Milestons-chart-wrapper">
                        <?php if(is_admin() != 1){ ?>
                        <ul class="d-flex flex-wrap text-center">
                            <li>
                                <div>
                                    <h4>Total Points</h4>
                                </div>
                                <div class="canvas-wrap">
                                    <!-- <div id="chartContainer">
                                    </div> -->
                                    <canvas id="chartProgress"></canvas>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h4>Year to Date</h4>
                                </div>
                                <div class="canvas-wrap">
                                    <canvas id="chartProgress-2"></canvas>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h4>Lifetime Points</h4>
                                </div>
                                <div class="canvas-wrap">
                                    <canvas id="lifetimepoint-doughnut"></canvas>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h4>Redeemed</h4>
                                </div>
                                <div class="canvas-wrap">
                                    <canvas id="chartProgress-4"></canvas>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h4>Milestones</h4>
                                </div>
                                <div class="canvas-wrap">
                                    <canvas id="milestone-doughnut"></canvas>
                                </div>
                            </li>
                        </ul>
                        <?php } ?>
                    </div>
                    <!-- chart sec end -->

                    <!-- slider banner-->
                    <!-- <div class="cs-banner-img">
                        <div class="image-carousel owl-carousel">
                            <div class="item">
                                <a href="" target="_blank">
                                    <img src="https://crm.rateshop.ca/assets/banner/1626375089_moodlebanner-deactivated.jpg">
                                </a>
                            </div>
                        </div>
                    </div> -->
                    <div class="cs-banner-img">
                        <?php $banner = $this->db->get("tblrewards_banner")->result(); ?>
                        <?php if(is_admin()){ ?>
                        <a href="<?php echo admin_url("reward/edit_banner")?>" class="dt-button"><i class="fa fa-edit"></i></a>
                        <?php } ?>
                        <div class="image-carousel owl-carousel">
                            <?php foreach ($banner as $key => $value) { ?> 
                            <div class="item">
                                <a href="<?php echo $value->link; ?>" target="_blank">
                                    <img src="<?php echo site_url("assets/rewards/".$value->image)?>">
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- slider banner end -->
                    <!-- Milestons tab-->

                    <div class="Milestons-tab-sec">
                        <ul class="nav nav-tabs">    

                            <?php $p_tab = $this->input->get('t') ? $this->input->get('t') : 'tab1'; ?>
                            
                            <?php if(is_admin()): ?>

                            <li class="<?php if($p_tab == 'tab1'){ echo 'active';} ?>"><a data-toggle="tab" href="#home">Milestones</a></li>
                            
                            <li class="<?php if($p_tab == 'tab2'){ echo 'active';} ?>"><a data-toggle="tab" href="#redemptionTab">Redemptions</a></li>

                            <li class="<?php if($p_tab == 'tab3'){ echo 'active';} ?>"><a data-toggle="tab" href="#pointEarnedTab">Points Earned</a></li>
                            
                            <?php endif;?>

                            <!-- For agents only -->
                            <?php if(!is_admin()){ 
                                $p_tab = $this->input->get('t') ? $this->input->get('t') : 'tab3';
                            ?>

                            <li class="<?php if($p_tab == 'tab3'){ echo 'active';} ?>"><a data-toggle="tab" href="#pointEarnedTab">Points Earned</a></li>

                            <li class="<?php if($p_tab == 'tab2'){ echo 'active';} ?>"><a data-toggle="tab" href="#redemptionTab">Redemptions</a></li>

                            <?php } ?>
                            <!-- For agents only -->

                            <?php if(!is_admin()): ?>
                            <li class="<?php if($p_tab == 'tab8'){ echo 'active';} ?>"><a data-toggle="tab" href="#pointEligibleTab">Task Eligibility</a></li>
                            <?php endif; ?>

                            <li class="<?php if($p_tab == 'tab4'){ echo 'active';} ?>"><a data-toggle="tab" href="#wishlistTab">Wish List </a></li>

                            <li class="<?php if($p_tab == 'tab5'){ echo 'active';} ?>"><a data-toggle="tab" href="#catalogTab">Catalogue</a></li>

                            <?php if(is_admin()): ?>

                            <li class="<?php if($p_tab == 'tab6'){ echo 'active';} ?>"><a data-toggle="tab" href="#rewardRequestTab" id="btn_reward_requests">Reward Requests</a></li>

                            <li class="<?php if($p_tab == 'tab7'){ echo 'active';} ?>"><a data-toggle="tab" href="#assignManualRewardTab" id="btn_get_manual_reward">Assign Manual</a></li>

                            <!-- <li><a data-toggle="tab" href="#newMtab">New Milestone</a></li> -->

                            <?php endif;?>
                            
                        </ul>
                        <div class="tab-content">
                            <?php if(is_admin()): ?>
                            <div id="home" class="tab-pane fade <?php if($p_tab == 'tab1'){ echo 'in active';} ?> ">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#automatic">Automatic</a></li>
                                    <li><a data-toggle="tab" href="#manual">Manual</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="automatic" class="tab-pane fade <?php if($p_tab == 'tab1'){ echo 'in active';} ?>">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Select Department</label>
                                                    <select class="form-control" id="automaticCategory">
                                                        <option value="Admin Triggers">Admin Triggers</option>
                                                        <option value="Underwriting Triggers">Underwriting Triggers</option>
                                                        <option value="Marketing">Marketing</option>
                                                        <option value="Sales Triggers">Sales Triggers</option>
                                                        <option value="Training Triggers">Training Triggers</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <!-- <a href="javascript:void(0);" class="btn btn-info btn-lg btn-sm btn-xs" id="btn_add_reward">Add New</a> -->
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table campaignsTableDesign" id="rewardRecords_table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Date & Time</th>
                                                        <th>Task Name</th>
                                                        <th>Reward Point</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="rewardRecords">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="manual" class="tab-pane fade">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Select Department</label>
                                                    <select class="form-control" id="manualCategory">
                                                        <option value="Admin Triggers">Admin Triggers</option>
                                                        <option value="Underwriting Triggers">Underwriting Triggers</option>
                                                        <option value="Marketing">Marketing</option>
                                                        <option value="Sales Triggers">Sales Triggers</option>
                                                        <option value="Training Triggers">Training Triggers</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- manual rewards -->
                                        <div class="text-right">
                                            <a href="javascript:void(0);" class="btn btn-info btn-lg btn-sm btn-xs" id="manual_btn_add_reward">Add New</a>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table campaignsTableDesign" id="manualreward_table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Date & Time</th>
                                                        <th>Task Name</th>
                                                        <th>Reward Point</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="manual_rewardRecords">
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- manual rewards end -->
                                    </div>
                                </div>
                            </div>
                            <?php endif;?>
                            <div id="redemptionTab" class="tab-pane fade <?php if($p_tab == 'tab2'){ echo 'in active';} ?>">
                                <table class="table campaignsTableDesign2">
                                    <thead>
                                        <tr>
                                            <th>Order Date</th>
                                            <th>Order Items</th>
                                            <th>Order Customer Details</th>
                                            <th>Order Points</th>
                                            <!-- <th>Order Detail</th> -->
                                        </tr>
                                    </thead>
                                    <tbody id="my_orders"></tbody>
                                </table>
                            </div>
                            <div id="pointEarnedTab" class="tab-pane fade <?php if($p_tab == 'tab3'){ echo 'in active';} ?>">
                                <table class="table campaignsTableDesign" id="Milestons-table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <!-- <th>Agent Name</th>
                                            <th>Agent Email</th> -->
                                            <th>Task Name</th>
                                            <th>Reward Type</th>
                                            <th>Reward Point</th>
                                            <th>Approve Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="points-earned-table">
                                        <?php if(isset($pointEarnRows) && count($pointEarnRows) > 0): ?>
                                        <?php foreach($pointEarnRows as $pointEarnRow): ?>
                                        <tr>
                                            <!-- <td>
                                                <?php //echo $pointEarnRow->agent_first_name.' '.$pointEarnRow->agent_first_name; ?>
                                            </td>
                                            <td>
                                                <?php //echo $pointEarnRow->agent_email; ?>
                                            </td> -->
                                            <td>
                                                <?php echo $pointEarnRow->task_name; ?>
                                            </td>
                                            <td>
                                                <?php echo $pointEarnRow->reward_type; ?>
                                            </td>
                                            <td>
                                                <?php echo $pointEarnRow->reward_points; ?>
                                            </td>
                                             <td>
                                                <?php echo ($pointEarnRow->approved_status == 1) ? 'Approved' : 'Declined'; ?>
                                            </td>
                                             <td>
                                                <?php echo $pointEarnRow->approved_date; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php endif;?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="pointEligibleTab" class="tab-pane fade <?php if($p_tab == 'tab8'){ echo 'in active';} ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Department</label>
                                            <select class="form-control" id="eligibleCategory">
                                                <option value="Admin Triggers">Admin Triggers</option>
                                                <option value="Underwriting Triggers">Underwriting Triggers</option>
                                                <option value="Marketing">Marketing</option>
                                                <option value="Sales Triggers">Sales Triggers</option>
                                                <option value="Training Triggers">Training Triggers</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <table class="table campaignsTableDesign" id="eligible-table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Task Name</th>
                                            <!-- <th>Department</th> -->
                                            <th>Reward Type</th>
                                            <th>Reward Point</th>
                                            <!-- <th>Date</th> -->
                                            <th>Eligibility</th>
                                        </tr>
                                    </thead>
                                    <tbody id="eligibleData">
                                        <!-- <?php if(isset($pointEligibilityRows) && count($pointEligibilityRows) > 0): ?>
                                        <?php foreach($pointEligibilityRows as $pointEarnRow): 
                                            $task_name = ($pointEarnRow->reward_type=='manual')?$pointEarnRow->task:autoTaskName($pointEarnRow->task);
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $task_name; ?>
                                            </td>
                                            <td>
                                                <?php echo !empty($pointEarnRow->parent_category)?$pointEarnRow->parent_category:''; ?>
                                            </td>
                                            <td>
                                                <?php echo $pointEarnRow->reward_type; ?>
                                            </td>
                                            <td>
                                                <?php echo $pointEarnRow->reward_points; ?>
                                            </td>
                                            <td>
                                                <?php echo date('Y-m-d',strtotime($pointEarnRow->created_at)); ?>
                                            </td>
                                            <td>
                                                <?php if(checkEligibility($_SESSION['staff_user_id'],$task_name) > 0){ ?>
                                                    <i class="fa fa-check-circle eligible-app" aria-hidden="true" title="Eligible"></i>
                                                <?php }else{ ?>
                                                    <i class="fa fa-times eligible-decline" aria-hidden="true" title="Not Eligible"></i>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php endif;?> -->
                                    </tbody>
                                </table>
                            </div>
                            <div id="wishlistTab" class="tab-pane fade <?php if($p_tab == 'tab4'){ echo 'in active';} ?>">
                                <div id="wishlist_products"><!--HERE COMES ALL WISHLIST PRODUCTS--></div>
                            </div>
                            <div id="catalogTab" class="tab-pane fade <?php if($p_tab == 'tab5'){ echo 'in active';} ?>">
                                
                                <div id="catalog_data"><!--HERE COMES ALL CATALOUGE DATA--></div>
                                
                            </div>
                            <?php if(is_admin()): ?>
                            <div id="rewardRequestTab" class="tab-pane fade <?php if($p_tab == 'tab6'){ echo 'in active';} ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Department</label>
                                            <select class="form-control" id="rewardRequestCategory">
                                                <option value="Admin Triggers">Admin Triggers</option>
                                                <option value="Underwriting Triggers">Underwriting Triggers</option>
                                                <option value="Marketing">Marketing</option>
                                                <option value="Sales Triggers">Sales Triggers</option>
                                                <option value="Training Triggers">Training Triggers</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table campaignsTableDesign" id="rewardRequest_table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Date & Time</th>
                                                <th>Agent Name</th>
                                                <!-- <th>User Name</th> -->
                                                <!-- <th>Reward For</th> -->
                                                <th>Task Name</th>
                                                <th>Reward Point</th>
                                                <th>Reward Type</th>
                                                <th>Approved By</th>
                                                <th>Approved Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rewardRequestRecords">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="assignManualRewardTab" class="tab-pane fade <?php if($p_tab == 'tab7'){ echo 'in active';} ?>">
                                <h3>Assign Manual Reward</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <form method="post" action="<?php echo admin_url('manual-rewards/assign-agents') ?>" id="manualAssignAgentForm">    
                                            <div class="form-group">
                                                <label for="task">Parent Category</label>
                                                <select class="form-control" name="parent_category" id="manual_parent_category">
                                                    <option value="Admin Triggers">Admin Triggers</option>
                                                    <option value="Underwriting Triggers">Underwriting Triggers</option>
                                                    <option value="Marketing">Marketing</option>
                                                    <option value="Sales Triggers">Sales Triggers</option>
                                                    <option value="Training Triggers">Training Triggers</option>
                                                </select>
                                                <span class="text text-danger" id="pc_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="task">Manual Task</label>
                                                <select class="form-control" name="manual_reward_id" id="manual_reward_id">
                                                    <option value="">-Select-</option>
                                                </select>
                                                <span class="text text-danger" id="task_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="agents_ids">Staff Agents:</label>
                                                <div class="select-all"> <input type="checkbox" name="manual-check-all" id="manual-check-all"> select all</div>
                                                <select class="form-control staff-select" name="agents_ids[]" id="agents_ids" multiple>
                                                    <?php foreach($staffAgentsListRows as $staffAgentsListRow): ?>
                                                    <option value="<?php echo $staffAgentsListRow->staffid; ?>">
                                                        <?php echo $staffAgentsListRow->firstname.' '.$staffAgentsListRow->lastname; ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <span class="text text-danger" id="lead_status_id_error"></span>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-primary">Assign</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="newMtab" class="tab-pane fade">
                                <h2>Milestone</h2>
                                <div class="text-right">
                                    <a href="javascript:void(0);" class="btn btn-info btn-xs" id="btn_milestone">
                                      Add New
                                    </a>
                                </div>
                                <table class="table campaignsTableDesign" id="milestone_table">
                                    <thead>
                                        <tr>
                                            <th>Issued Category</th>
                                            <th>issued For</th>
                                            <th>Reward Points</th>
                                            <!-- <th>Due Date</th> -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>
                    <!-- Milestons tab end -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->
<!-- Modal for automatic reward-->
<div class="modal fade" id="rewardModal" tabindex="-1" role="dialog" aria-labelledby="title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Add New Reward</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rewardForm" method="post" action="<?php echo admin_url('rewards/save') ?>">
                <div class="modal-body">
                    <p class="text text-danger" id="err_msg"></p>
                    <p class="text text-success" id="success_msg"></p>
                    <div class="form-group">
                        <label for="task">Task</label>
                        <!-- <input type="text" name="task" id="task" class="form-control" placeholder="Task"> -->
                        <select class="form-control select-group" name="task" id="task">
                            <option value="">-Select-</option>
                            <option value="1">Change CRM password for the first time</option>
                            <option value="2">Update domain information/website</option>
                            <option value="3">Update license</option>
                            <option value="4">Update Facebook accounts</option>
                            <option value="5">Update Twitter accounts</option>
                            <option value="6">Update Linkedin accounts</option>
                            <option value="7">Upload a professional photo</option>
                            <option value="8">Participate in RateShop Wall</option>
                            <option value="9">Use the Communication tab to call clients</option>
                            <option value="10">Use the Communication tab to text clients</option>
                            <option value="11">Use the Communication tab to email clients</option>
                            <option value="12">Add New Lead</option>
                            <option value="13">Becoming a Verified Agent</option>
                            <option value="14">Completing First 5 Deals</option> <!-- used -->
                            <option value="15">Updating NOTES in CRM</option> <!-- used -->
                            <option value="16">Deal Stage: only when admin click on APPROVE status</option>
                            <option value="17">Creating a Landing Page using the CRM</option> <!-- used -->
                            <option value="18">Clicking on CliqBlast in CRM</option> <!-- used -->
                            <option value="19">Clicking on Cliqboost in CRM</option> <!-- used -->
                            <option value="20">Updating Status of the File in CRM</option>
                        </select>
                        <span class="text text-danger" id="task_error"></span>
                    </div>
                    <!-- <div class="form-group">
                        <label for="lead_status_id">Lead Status</label>
                        <select class="lead_changes form-control select-group" name="lead_status_id" id="lead_status_id">
                            <option value="">-select-</option>
                            <?php foreach($leadstatusRows as $leadstatusRow): ?>
                            <option value="<?php echo $leadstatusRow->id; ?>">
                                <?php echo $leadstatusRow->name; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="text text-danger" id="lead_status_id_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="deal_status">Deal</label>
                        <select class="form-control select-group" name="deal_status" id="deal_status">
                            <option value="">-select-</option>
                            <option value="added">Added</option>
                            <option value="approved">Approved</option>
                        </select>
                        <span class="text text-danger" id="lead_status_id_error"></span>
                    </div> -->
                    <div class="form-group">
                        <label for="staff_agents_ids">Staff Agents:</label>
                        <div class="select-all"> 
                            <input type="checkbox" name="check-all" id="check-all">
                            select all
                        </div>
                        <select class="form-control staff-select" name="staff_agents_ids[]" id="staff_agents_ids" multiple>
                            <?php foreach($staffAgentsListRows as $staffAgentsListRow): ?>
                            <option value="<?php echo $staffAgentsListRow->staffid; ?>">
                                <?php echo $staffAgentsListRow->firstname.' '.$staffAgentsListRow->lastname; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="text text-danger" id="lead_status_id_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="reward_points">Reward Points</label>
                        <input type="text" name="reward_points" id="reward_points" class="form-control" placeholder="Reward points">
                        <span class="text text-danger" id="reward_points_error"></span>
                    </div>
                    <!-- <div class="form-group">
                        <label for="due_day">Due day</label>
                        <input type="text" name="due_day" id="due_day" class="form-control" placeholder="Due day">
                        <span class="text text-danger" id="due_day_error"></span>
                    </div> -->
                    <div class="form-group">
                        <label for="status">Status</label>
                        <div class="status-message">
                        <div class="select-all">
                        <input type="radio" name="status" id="status_active" value="1">Active
                        </div>
                        <div class="select-all">
                        <input type="radio" name="status" id="status_inactive" value="0">Inactive
                        </div>
                    </div>
                        <span class="text text-danger" id="status_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" id="action" value="save">
                    <input type="hidden" name="reward_id" id="reward_id" value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveReward">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal for manual reward -->
<!-- Modal for automatic reward-->
<div class="modal fade" id="manual_rewardModal" tabindex="-1" role="dialog" aria-labelledby="title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Add New Reward</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="manual_rewardForm" method="post" action="<?php echo admin_url('manual-rewards/save') ?>">
                <div class="modal-body">
                    <p class="text text-danger" id="err_msg"></p>
                    <p class="text text-success" id="success_msg"></p>
                    <div class="form-group">
                        <label for="manual_task">Task</label>
                        <input type="text" name="task" id="task" class="form-control" placeholder="Task">
                        <span class="text text-danger" id="task_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="reward_points">Reward Points</label>
                        <input type="text" name="reward_points" id="reward_points" class="form-control" placeholder="Reward points">
                        <span class="text text-danger" id="reward_points_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="due_day">Parent Category</label>
                        <!-- <input type="text" name="due_day" id="due_day" class="form-control" placeholder="Due day"> -->
                        <select class="form-control" id="parent_category" name="parent_category">
                            <option value="Admin Triggers">Admin Triggers</option>
                            <option value="Underwriting Triggers">Underwriting Triggers</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Sales Triggers">Sales Triggers</option>
                            <option value="Training Triggers">Training Triggers</option>
                        </select>
                        <span class="text text-danger" id="parent_category_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <div class="status-message">
                            <div class="select-all">    
                               <input type="radio" name="status" id="status_active" value="1">Active
                            </div>
                            <div class="select-all">   
                               <input type="radio" name="status" id="status_inactive" value="0">Inactive
                            </div>
                            <span class="text text-danger" id="status_error"></span>
                       </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" id="action" value="save">
                    <input type="hidden" name="reward_id" id="reward_id" value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="manual_btnSaveReward">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal for manual reward end -->

<!--Milestone-Modal start-->
<div class="modal fade" id="milestone_Modal" tabindex="-1" role="dialog" aria-labelledby="title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Add New Milestone</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="milestone_Form" method="post" action="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="milestone_category_id">Award Issued Category:</label>
                                <select class="form-control" id="milestone_category_id" name="milestone_category_id">
                                    <option value="1">Lead Status</option>
                                    <option value="2">Deal</option>
                                </select>
                                <span class="text text-danger" id="award_issued_by_error"></span>
                            </div>

                            <div class="form-group">
                                <label for="milestone_trigger_id">Awarded For:</label>
                                <select class="form-control" id="milestone_trigger_id" name="milestone_trigger_id">
                                </select>
                                <span class="text text-danger" id="awarded_for_error"></span>
                            </div>

                            <div class="form-group">
                                <label for="agent_list">Agents List:</label>
                                 <div class="select-all"> 
                                    <input type="checkbox" name="select-all" id="select-all"> select all
                                </div>
                                <select class="form-control" name="agents_list[]" id="agents_list" multiple>
                                    <?php foreach($staffAgentsListRows as $staffAgentsListRow): ?>
                                    <option value="<?php echo $staffAgentsListRow->staffid; ?>">
                                        <?php echo $staffAgentsListRow->firstname.' '.$staffAgentsListRow->lastname; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="text text-danger" id="agent_list_error"></span>
                            </div>

                            <div class="form-group">
                                <label for="agent_list">Reward Points:
                                    <button type="button" data-points="50"  class="btn btn-xs btn-success point-reward">50</button>
                                    <button type="button" data-points="100" class="btn btn-xs btn-success point-reward">100</button>
                                    <button type="button" data-points="250" class="btn btn-xs btn-success point-reward">250</button>
                                    <button type="button" data-points="500" class="btn btn-xs btn-success point-reward">500</button>
                                </label>
                                <input type="text" name="points" id="points" class="form-control">
                                <span class="text text-danger" id="points_error"></span>
                            </div>

                            <!-- <div class="form-group">
                                <label for="due_date">Due Date:</label>
                                <input type="text" name="due_date" id="due_date" class="form-control">
                                <span class="text text-danger" id="due_date_error"></span>
                            </div> -->

                            <div class="form-group">
                                <label class="switch mini-switch ">
                                  <input type="checkbox" class="target_switch" name="active" id="active" value="1">
                                  <span class="slider round"></span>
                               </label>
                            </div>

                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="milestone_id" value="">
                    <input type="hidden" name="action" value="add">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="manual_btnSaveReward">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Milestone-Modal end-->


<!--Milestone-Modal start-->
<!-- <div class="modal fade" id="order_detail_Modal" tabindex="-1" role="dialog" aria-labelledby="title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Order Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div> -->
<!--Milestone-Modal end-->

<?php init_tail(); ?>
<!-- script -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
<!-- <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script> -->
<!-- <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script> -->
<!-- <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script> -->
<!-- <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script> -->

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(".navbar-nav>li.dropdown>a").click(function(){
        $(this).parent("li").toggleClass("open")
    });
    $(".navbar-nav>li.header-user-profile>a").click(function(){
        $(this).parent("li").toggleClass("open")
    });

    let configUrl = {

         'milestone-category-triggers': "<?php echo admin_url('reward/milestone-category-triggers'); ?>",
         'milestone-save'             : "<?php echo admin_url('reward/milestone-save'); ?>",
         'milestone-list'             : "<?php echo admin_url('reward/milestone-list'); ?>",
         'milestone-delete'           : "<?php echo admin_url('reward/milestone-delete'); ?>",
         'milestone-get'              : "<?php echo admin_url('reward/milestone-get'); ?>"
    }
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/milestone.js'); ?>"></script>
<script type="text/javascript">
</script>
<script type="text/javascript">
// slider
    $('.image-carousel').owlCarousel({
        loop: true,
        margin: 0,
        dots: true,
        nav: true,
        items: 1,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true
    });
// slider end
<?php 
   
    if(isset($milestone_Data)) {
        $total_reward_points = $milestone_Data->total_reward_points;
        $total_redeemed_points = $milestone_Data->total_redeemed_points;
        $total_points_curr_year = $milestone_Data->total_points_curr_year;
        $total_points_used = $milestone_Data->total_points_used;
        $total_milestones   = $milestone_Data->total_milestones;
        $earn_reward_points  = $milestone_Data->earn_reward_points;
        $approve_milestones = $milestone_Data->approve_milestones;
        $approve_milestones_percentage = $approve_milestones/$total_milestones * 100;

        $approve_milestones_percentage = number_format((float)$approve_milestones_percentage, 2, '.', '');
    }
?>
var myChartCircle = new Chart('chartProgress', {
    
    type: 'doughnut',
    data: {
        datasets: [{
            label: '',
            number: '<?php echo !empty($earn_reward_points)?$earn_reward_points:0 ?>',
            backgroundColor: ['#f7bb06']
        }]
    },
    plugins: [{
            beforeInit: (chart) => {
                const dataset = chart.data.datasets[0];
                chart.data.labels = [dataset.label];
                dataset.data = [dataset.number, 100 - dataset.number];
            }
        },
        {
            beforeDraw: (chart) => {
                var width = chart.chart.width,
                    height = chart.chart.height,
                    ctx = chart.chart.ctx;
                ctx.restore();
                var fontSize = (height / 150).toFixed(2);
                ctx.font = fontSize + "em sans-serif";
                ctx.fillStyle = "#9b9b9b";
                ctx.textBaseline = "middle";

                var text = chart.data.datasets[0].number,
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    textY = height / 2;
                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }
    ],
    options: {
        maintainAspectRatio: false,
        cutoutPercentage: 70,
        rotation: Math.PI / 2,
        legend: {
            display: false,
        },
        tooltips: {
            filter: tooltipItem => tooltipItem.index == 0
        }
    }

    // type: 'doughnut',
    // data: {
    //     datasets: [{
    //         label: '',
    //         number: '<?php echo !empty($total_reward_points)?$total_reward_points:0 ?>',
    //         backgroundColor: ['green', 'red']
    //     }]
    // },
    // plugins: [{
    //         beforeInit: (chart) => {
    //             const dataset = chart.data.datasets[0];
    //             chart.data.labels = [dataset.label];
    //             dataset.data = [dataset.number, '<?php echo !empty($total_points_used)?$total_points_used:0 ?>'];
    //         }
    //     },
    //     {
    //         beforeDraw: (chart) => {
    //             var width = chart.chart.width,
    //                 height = chart.chart.height,
    //                 ctx = chart.chart.ctx;
    //             ctx.restore();
    //             var fontSize = (height / 150).toFixed(2);
    //             ctx.font = fontSize + "em sans-serif";
    //             ctx.fillStyle = "#9b9b9b";
    //             ctx.textBaseline = "middle";
    //             var text = chart.data.datasets[0].number,
    //                 textX = Math.round((width - ctx.measureText(text).width) / 2),
    //                 textY = height / 2;
    //             ctx.fillText(text, textX, textY);
    //             ctx.save();
    //         }
    //     }
    // ],
    // options: {
    //     maintainAspectRatio: false,
    //     cutoutPercentage: 70,
    //     rotation: Math.PI / 2,
    //     legend: {
    //         display: false,
    //     },
    //     tooltips: {
    //         filter: tooltipItem => tooltipItem.index == 0
    //     }
    // }
});
var myChartCircle = new Chart('chartProgress-2', {
    type: 'doughnut',
    data: {
        datasets: [{
            label: '',
            number: '<?php echo !empty($total_points_curr_year)?$total_points_curr_year:0 ?>',
            backgroundColor: ['#f7bb06']
        }]
    },
    plugins: [{
            beforeInit: (chart) => {
                const dataset = chart.data.datasets[0];
                chart.data.labels = [dataset.label];
                dataset.data = [dataset.number, 100 - dataset.number];
            }
        },
        {
            beforeDraw: (chart) => {
                var width = chart.chart.width,
                    height = chart.chart.height,
                    ctx = chart.chart.ctx;
                ctx.restore();
                var fontSize = (height / 150).toFixed(2);
                ctx.font = fontSize + "em sans-serif";
                ctx.fillStyle = "#9b9b9b";
                ctx.textBaseline = "middle";

                var text = chart.data.datasets[0].number,
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    textY = height / 2;
                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }
    ],
    options: {
        maintainAspectRatio: false,
        cutoutPercentage: 70,
        rotation: Math.PI / 2,
        legend: {
            display: false,
        },
        tooltips: {
            filter: tooltipItem => tooltipItem.index == 0
        }
    }
});
var myChartCircle = new Chart('lifetimepoint-doughnut', {
    type: 'doughnut',
    data: {
        datasets: [{
            label: '',
            number: <?php echo isset($earn_reward_points) ? $earn_reward_points : 0; ?>,
            backgroundColor: ['#f7bb06']
        }]
    },
    plugins: [{
            beforeInit: (chart) => {
                const dataset = chart.data.datasets[0];
                chart.data.labels = [dataset.label];
                dataset.data = [dataset.number, 100 - dataset.number];
            }
        },
        {
            beforeDraw: (chart) => {
                var width = chart.chart.width,
                    height = chart.chart.height,
                    ctx = chart.chart.ctx;
                ctx.restore();
                var fontSize = (height / 150).toFixed(2);
                ctx.font = fontSize + "em sans-serif";
                ctx.fillStyle = "#9b9b9b";
                ctx.textBaseline = "middle";
                var text = chart.data.datasets[0].number,
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    textY = height / 2;
                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }
    ],
    options: {
        maintainAspectRatio: false,
        cutoutPercentage: 70,
        rotation: Math.PI / 2,
        legend: {
            display: false,
        },
        tooltips: {
            filter: tooltipItem => tooltipItem.index == 0
        }
    }
});
var myChartCircle = new Chart('chartProgress-4', {
    type: 'doughnut',
    data: {
        radius: "10%",
        datasets: [{
            label: '',
            number: <?php echo isset($total_redeemed_points) ? $total_redeemed_points : 0; ?>,
            backgroundColor: ['#f7bb06']
        }],

    },
    plugins: [{
            beforeInit: (chart) => {
                const dataset = chart.data.datasets[0];
                chart.data.labels = [dataset.label];
                dataset.data = [dataset.number, 100 - dataset.number];
            }
        },
        {
            beforeDraw: (chart) => {
                var width = chart.chart.width,
                    height = chart.chart.height,
                    ctx = chart.chart.ctx;
                ctx.restore();
                var fontSize = (height / 150).toFixed(2);
                ctx.font = fontSize + "em sans-serif";
                ctx.fillStyle = "#9b9b9b";
                ctx.textBaseline = "middle";
                var text = chart.data.datasets[0].number,
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    textY = height / 2;
                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }
    ],
    options: {
        maintainAspectRatio: false,
        cutoutPercentage: 70,
        // aspectRatio:2,
        rotation: Math.PI / 2,
        legend: {
            display: false,
        },
        tooltips: {
            filter: tooltipItem => tooltipItem.index == 0
        }
    }
});
var myChartCircle = new Chart('milestone-doughnut', {
    type: 'doughnut',
    data: {
        datasets: [{
            label: '',
            number: <?php echo isset($approve_milestones) ? $approve_milestones : 0; ?>,
            backgroundColor: ['green']
        }]
    },
    plugins: [{
            beforeInit: (chart) => {
                const dataset = chart.data.datasets[0];
                chart.data.labels = [dataset.label];
                dataset.data = [dataset.number, 100 - dataset.number];
            }
        },
        {
            beforeDraw: (chart) => {
                var width = chart.chart.width,
                    height = chart.chart.height,
                    ctx = chart.chart.ctx;
                ctx.restore();
                var fontSize = (height / 150).toFixed(2);
                ctx.font = fontSize + "em sans-serif";
                ctx.fillStyle = "#9b9b9b";
                ctx.textBaseline = "middle";
                var text = chart.data.datasets[0].number,
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    textY = height / 2;
                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }
    ],
    options: {
        maintainAspectRatio: false,
        cutoutPercentage: 70,
        rotation: Math.PI / 2,
        legend: {
            display: false,
        },
        tooltips: {
            filter: tooltipItem => tooltipItem.index == 0
        }
    }
});

</script>


<script type="text/javascript">
/*common functions*/

// <!-- =================datatable script================= -->
    function initializeDataTable(id) {

        let dt = $('body #'+id).DataTable({
            searching: false,
            paging: true,
            bSort: false,
            responsive: true,
            fixedHeader: {
                header: true,
            },
            pageLength: '10',
            dom: 'Bfrtip'
        });

        return dt;

    }
// <!-- =================datatable script End================= -->


  
</script>


<script type="text/javascript">
/*  common functions*/
function callLoader() {
    $('.cs_loader').css('display', 'block');
}
function endLoader() {
    $('.cs_loader').css('display', 'none');
}

$(document).ready(function() {

    /*
        stop modal to close when click outside
    */
    $('#rewardModal').modal({
        backdrop: 'static',
        keyboard: false,
        show: false
    });

    
    

    /*
        function to open modal
    */
    $('#btn_add_reward').on('click', function(event) {
        event.preventDefault();
        $('#rewardForm').trigger('reset');
        $('#rewardForm #action').val('save');
        $('#rewardForm #reward_id').val('');
        $('#rewardForm #err_msg').text('');
        $("#rewardForm span[id$='_error']").text('');
        $('#rewardModal #title').text('Add New Reward');
        rewardValidator.resetForm();
        $('#staff_agents_ids').val('').select2({ placeholder: "Choose elements", width: "100%" }).trigger('change');

        /*Indisabled form buttons*/
        $('#rewardForm').find('button').each(function() {
            $(this).attr('disabled', false)
        });
        $('#rewardModal').modal('show');
    });

    /*points eligibility*/
    let listRewardsEligibility = initializeDataTable('eligible-table');
    /*points eligibility*/

    
    $('#eligibleCategory').on('change',function(){
        var category = $(this).val();
        $.ajax({
            type:'post',
            url: '<?php echo admin_url('reward/showEligibilityFilter') ?>',
            async: false,
            dataType: 'json',
            data : {
                category : category
            },success:function(data){
                let html = '';
                listRewardsEligibility.clear().draw();
                if (data.length > 0) {
                    for (i = 0; i < data.length; i++) {
                        listRewardsEligibility.row.add([
                            data[i].task_name,
                            data[i].reward_points,
                            data[i].reward_type,
                            (data[i].eligibility >= 1)?'<i class="fa fa-check-circle eligible-app" aria-hidden="true" title="Eligible"></i>':'<i class="fa fa-times eligible-decline" aria-hidden="true" title="Not Eligible"></i>',
                        ]);
                    }
                } else {
                    listRewardsEligibility.row.add(['No Data Found','','', '']);
                }
                listRewardsEligibility.draw();
            }
        });
    });

    function listRewardsEligibilityData() {

        $.ajax({
            type: 'ajax',
            url: "<?php echo admin_url('rewards/showEligibility'); ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                // console.log(data)
                let html = '';
                if (data.length > 0) {
                    // console.log(data);
                    for (i = 0; i < data.length; i++) {
                        listRewardsEligibility.row.add([
                            data[i].task_name,
                            data[i].reward_points,
                            data[i].reward_type,
                            (data[i].eligibility >= 1)?'<i class="fa fa-check-circle eligible-app" aria-hidden="true" title="Eligible"></i>':'<i class="fa fa-times eligible-decline" aria-hidden="true" title="Not Eligible"></i>',
                        ]);
                    }
                } else {
                    listRewardsEligibility.row.add(['No Data Found','','', '']);
                }
                listRewardsEligibility.draw();
            },

        });
    }

    listRewardsEligibilityData();
    /*calling function to get automatic added reward lists*/

    /*POints Earned*/


    /*points eligibility*/
    let listPointsEarned = initializeDataTable('Milestons-table');
    /*points eligibility*/

    /*calling function to get automatic added reward lists*/

    /*POints Earned*/

    /*
        function to get reward list
    */

    let listRewardsDatatable = initializeDataTable('rewardRecords_table');

    $('#automaticCategory').on('change',function(){
        var category = $(this).val();
        $.ajax({
            type:'post',
            url: '<?php echo admin_url('reward/getByCategoryAuto') ?>',
            async: false,
            dataType: 'json',
            data : {
                category : category
            },success:function(data){
                let html = '';
                listRewardsDatatable.clear().draw();
                if (data.length > 0) {
                    var autoTask = [...document.querySelector("#task").options].map( opt => opt.text )
                    for (i = 0; i < data.length; i++) {
                        listRewardsDatatable.row.add([
                            data[i].created_at,
                            (autoTask[data[i].task])?autoTask[data[i].task]:data[i].task,
                            data[i].reward_points,
                            (data[i].status == '1')?'Active':'In-active',
                            `<div style="white-space:nowrap">
                            <a href="javascript:void(0);" class="btn btn-xs btn-warning btn_edit_reward" data-reward_id="${data[i].id}">Edit</a>
                            </div>`
                        ]);
                    }
                } else {
                    listRewardsDatatable.row.add(['No Data Found','','', '', '','','']);
                }
                $('#rewardRecords').html(html);
                listRewardsDatatable.draw();
            }
        });
    });


    function listRewards() {

        $('#task').select2({
            placeholder: "Choose elements",
            width: "100%",
            dropdownParent: $('#rewardModal')
        });

        $.ajax({
            type: 'ajax',
            url: "<?php echo admin_url('rewards/show'); ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                // console.log(data)
                let html = '';
                if (data.length > 0) {

                    var autoTask = [...document.querySelector("#task").options].map( opt => opt.text )
                    // console.log(autoTask)
                    
                    for (i = 0; i < data.length; i++) {

                            listRewardsDatatable.row.add([
                              data[i].created_at,
                              // data[i].lead_status_name,
                              // (data[i].deal_status == '' ? 'null' : data[i].deal_status),
                              // <a href="javascript:void(0);" class="btn btn-xs btn-danger btn_delete_reward" data-reward_id="${data[i].id}">Delete</a>
                              (autoTask[data[i].task])?autoTask[data[i].task]:data[i].task,
                              data[i].reward_points,
                              (data[i].status == '1')?'Active':'In-active',
                              `<div style="white-space:nowrap">
                               <a href="javascript:void(0);" class="btn btn-xs btn-warning btn_edit_reward" data-reward_id="${data[i].id}">Edit</a>
                               </div>`
                            ]);
                    }

                } else {

                    //html += '<tr class="odd"><td valign="top" colspan="7" class="dataTables_empty">No data available in table</td></tr>';
                    listRewardsDatatable.row.add(['No Data Found','','', '', '','','']);
                }

                $('#rewardRecords').html(html);
                listRewardsDatatable.draw();

            },

        });
    }

    /*calling function to get automatic added reward lists*/
    listRewards();


    /*
        function to crilestone Modal start
    */
    let rewardValidator = $("#rewardForm").validate({

        rules: {
            task: {
                required: true,
                // minlength: 3,
                // maxlength: 500
            },
            // lead_status_id: {

            //     required: function(element) {
            //         if ($("#rewardForm #deal_status :selected").val() == '') {
            //             return true
            //         }
            //         return false;
            //     }
            // },
            // deal_status: {

            //     required: function(element) {
            //         if ($("#rewardForm #lead_status_id :selected").val() == '') {
            //             return true
            //         }
            //         return false;
            //     }

            // },
            "staff_agents_ids[]": {

                required: true,
            },
            reward_points: {
                required: true,
                number: true,
                range: [1, 100000]
            },
            // due_day: {
            //     required: true,
            //     number: true,
            //     range: [1, 100]
            // },
            status: {
                required: true
            }
        },
        submitHandler: function(form) {

            $.ajax({

                type: "POST",
                url: "<?php echo admin_url('rewards/save'); ?>",
                dataType: "JSON",
                async: false,
                data: $(form).serialize(),
                beforeSend: function() {
                    $(form).find('button').each(function() {
                        $(this).attr('disabled', true)
                    });
                    callLoader();
                },
                complete: function() {
                    $(form).find('button').each(function() {
                        $(this).attr('disabled', false)
                    });
                    endLoader();
                },
                success: function(data) {
                    console.log('success');
                    window.location.reload();
                    $(form).trigger('reset');
                    /*to get reward list*/
                    listRewards();
                    $('#rewardModal').modal('hide');
                    /*Indisabled form buttons*/
                    $('#rewardForm').find('button').each(function() {
                        $(form).attr('disabled', false)
                    });
                },
                error: function(data) {

                    if (data.responseJSON) {

                        let errResponse = data.responseJSON;

                        if (errResponse.message) {
                            $('#rewardForm #err_msg').text(errResponse.message);
                        }

                        if (errResponse.validation) {

                            let validation = errResponse.validation

                            for (key in validation) {
                                $(`#rewardForm #${key}_error`).text(validation[key]);
                            }
                        }


                    } else {
                        console.log(data);
                    }

                    /*Indisabled form buttons*/
                    $('#rewardForm').find('button').each(function() {
                        $(this).attr('disabled', false)
                    });
                }
            });

            return false; // required to block normal submit since you used ajax
        }
    });


    /*
        function to get particluar reward
    */
    $('body').on('click', '.btn_edit_reward', function(event) {
        event.preventDefault();
        let reward_id = $(this).attr('data-reward_id');
        if (reward_id) {

            let url = "<?php echo admin_url('rewards/get'); ?>";

            $.ajax({

                type: "POST",
                url: url,
                dataType: "JSON",
                data: { reward_id: reward_id },
                async: false,
                success: function(data) {

                    /*set modal form values*/
                    // $('form#rewardForm #task').val(data.rewardRow.task);
                    $('form#rewardForm #task option[value='+data.rewardRow.task+']').prop('selected',true);

                    if (data.rewardRow.task) {

                        $('#task').val(data.rewardRow.task);
                        $('#task').select2({
                            placeholder: "Choose elements",
                            width: "100%"
                        }).trigger('change');

                    }

                    $('form#rewardForm #reward_points').val(data.rewardRow.reward_points);
                    // $('form#rewardForm #due_day').val(data.rewardRow.due_day);
                    if (data.rewardRow.lead_status_id) {
                        $('form#rewardForm select#lead_status_id option[value="' + data.rewardRow.lead_status_id + '"').prop('selected', true);
                    }
                    if (data.rewardRow.deal_status) {
                        $('form#rewardForm select#deal_status option[value="' + data.rewardRow.deal_status + '"').prop('selected', true);
                    }
                    if (data.rewardRow.status == 1) {
                        $("form#rewardForm #status_active").attr('checked', 'checked');
                    } else {
                        $("form#rewardForm #status_inactive").attr('checked', 'checked');
                    }

                    if (data.rewardRow.staff_agents_ids) {

                        let staff_agents_ids = JSON.parse(data.rewardRow.staff_agents_ids);

                        console.log(staff_agents_ids);

                        $('#staff_agents_ids').val(staff_agents_ids);
                        $('#staff_agents_ids').select2({

                            placeholder: "Choose elements",
                            width: "100%"
                        }).trigger('change');

                    }

                    if (data.is_checked_all == 1) {

                        $('#check-all').prop('checked', true);
                    } else {
                        $('#check-all').prop('checked', false);
                    }

                    $("form#rewardForm #action").val('update');
                    $("form#rewardForm #reward_id").val(data.rewardRow.id);
                    $('#rewardForm #err_msg').text('');
                    $("#rewardForm span[id$='_error']").text('');
                    $('#rewardModal #title').text('Update Reward')
                    /*Indisabled form buttons*/
                    $('#rewardForm').find('button').each(function() {
                        $(this).attr('disabled', false)
                    });
                    rewardValidator.resetForm();
                    $('#rewardModal').modal('show');

                },
                error: function(data) {

                    console.log(data);
                }
            });

        }

    });

    /*
        function to delete particluar reward
    */
    $('body').on('click', '.btn_delete_reward', function(event) {

        event.preventDefault();
        if (confirm('Are you sure to delete this record ?')) {

            let reward_id = $(this).attr('data-reward_id');
            if (reward_id) {

                let url = "<?php echo admin_url('rewards/delete'); ?>";
                $.ajax({

                    type: "POST",
                    url: url,
                    dataType: "JSON",
                    data: { reward_id: reward_id },
                    async: false,
                    success: function(data) {
                        /*to get reward list*/
                        window.location.reload();
                        // listRewards();
                    },
                    error: function(data) {

                        console.log(data);
                    }
                });

            }
        }

        return false;
    });


})
</script>



<script type="text/javascript">
$(document).ready(function() {

    /*
       Multi-select
    */

    $('#staff_agents_ids').select2({
        placeholder: "Choose elements",
        width: "100%"
    })

    /*
        check all staff agents
    */
    $("#check-all").click(function() {

        if ($("#check-all").is(':checked')) { //select all
            $("#staff_agents_ids").find('option').prop("selected", true);
            $("#staff_agents_ids").trigger('change');
        } else { //deselect all
            $("#staff_agents_ids").find('option').prop("selected", false);
            $("#staff_agents_ids").trigger('change');
        }

    });

});
</script>
<!-- script end -->


<!-- ===========================reward requests script start=============== -->
<script type="text/javascript">
$(document).ready(function() {

    $('#rewardRequestCategory').on('change',function(){
        var category = $(this).val();
        $.ajax({
            type: 'post',
            url: "<?php echo admin_url('reward/requests/listByCategory'); ?>",
            async: false,
            dataType: 'json',
            data: {category:category},
            success: function(data) {
                console.log(data)
                let html = '';
                if (data.length > 0) {
                    for (i = 0; i < data.length; i++) {
                        html += '<tr id="' + data[i].id + '">' +
                            '<td>' + data[i].created_at + '</td>';
                        if (data[i].staff_agent_id != null) {
                            html += '<td>' + data[i].agent_first_name + ' ' + data[i].agent_last_name + '</td>';
                        } else {
                            html += '<td></td>';
                        }
                        html += '<td>' + data[i].task_name + '</td>' +
                            '<td>' + data[i].reward_points + '</td>' +
                            '<td>' + data[i].reward_type + '</td>' +
                            '<td>' + ((data[i].approved_by != null)?data[i].approved_by:'') + '</td>' +
                            '<td>' + ((data[i].approved_date != null)?data[i].approved_date:'') + '</td>' +
                            '<td style="text-align:right;">';
                        if (data[i].approved_status == 0) {
                            html += `<button type="button" class="btn btn-xs btn btn-success btn_change_approve" data-approve-status='1' data-reward-request-id='${data[i].id}'>Approve</button>
                                    <button type="button" class="btn btn-xs btn btn-danger btn_change_approve" data-approve-status='2' data-reward-request-id='${data[i].id}'>Decline</button>`;
                        } else if (data[i].approved_status == 1) {
                            html += '<span>Approved</span>';
                        } else {
                            html += '<span>Declined</span>';
                        }
                        html += '</td></tr>';
                    }
                } else {
                    html += '<tr class="odd"><td valign="top" colspan="7" class="dataTables_empty">No data available in table</td></tr>';
                }
                $('#rewardRequestRecords').html(html);
            },
        });
    });

    /*
        function to get reward request list
    */
    function rewardsRequestList() {

        $.ajax({
            type: 'ajax',
            url: "<?php echo admin_url('reward/requests/list'); ?>",
            async: false,
            dataType: 'json',
            success: function(data) {

                let html = '';
                if (data.length > 0) {

                    for (i = 0; i < data.length; i++) {

                        html += '<tr id="' + data[i].id + '">' +
                            '<td>' + data[i].created_at + '</td>';

                        if (data[i].staff_agent_id != null) {

                            html += '<td>' + data[i].agent_first_name + ' ' + data[i].agent_last_name + '</td>';
                        } else {
                            html += '<td></td>';
                        }

                        html += '<td>' + data[i].task_name + '</td>' +
                            '<td>' + data[i].reward_points + '</td>' +
                            '<td>' + data[i].reward_type + '</td>' +
                            '<td>' + ((data[i].approved_by != null)?data[i].approved_by:'') + '</td>' +
                            '<td>' + ((data[i].approved_date != null)?data[i].approved_date:'') + '</td>' +
                            '<td style="text-align:right;">';

                        if (data[i].approved_status == 0) {

                            html += `<button type="button" class="btn btn-xs btn btn-success btn_change_approve" data-approve-status='1' data-reward-request-id='${data[i].id}'>Approve</button>
                                    <button type="button" class="btn btn-xs btn btn-danger btn_change_approve" data-approve-status='2' data-reward-request-id='${data[i].id}'>Decline</button>`;


                        } else if (data[i].approved_status == 1) {

                            html += '<span>Approved</span>';

                        } else {

                            html += '<span>Declined</span>';
                        }

                        html += '</td></tr>';

                    }

                } else {

                    html += '<tr class="odd"><td valign="top" colspan="7" class="dataTables_empty">No data available in table</td></tr>';
                }

                $('#rewardRequestRecords').html(html);
            },

        });
    }

    rewardsRequestList();
    $('#btn_reward_requests').on('click', function() {

        rewardsRequestList();
    });


    /*
        function to approve/decline reward request
    */
    $('body').on('click', '.btn_change_approve', function() {

        if(confirm('Are you sure?')) {

            let approve_status = $(this).attr('data-approve-status');
            let reward_request_id = $(this).attr('data-reward-request-id');

            $.ajax({

                type: "POST",
                url: "<?php echo admin_url('reward/requests/change-approve-status'); ?>",
                dataType: "JSON",
                data: { approve_status: approve_status, reward_request_id: reward_request_id },
                async: false,
                success: function(data) {
                    /*to get reward request list*/
                    if(data.approve_status == 1) {

                            swal({
                                title: "Reward",
                                text: data.approve_message,
                                button: "Ok",
                                showConfirmButton: false,
                                icon: "success"
                            });
                        
                    } else {

                            swal({
                                title: "Reward",
                                text: data.approve_message,
                                button: "Ok",
                                showConfirmButton: false,
                                icon: "warning"
                            });

                    }
                    rewardsRequestList();
                },
                error: function(data) {

                    console.log(data);
                }
            });

        } else {

            return false;
        }

    });

});
</script>
<!--============================= reward requests script end =============== -->


<!-- =============================manual reward============================= -->
<script type="text/javascript">
$(document).ready(function() {

    /*
        stop manual reward modal to close when click outside
    */
    $('#manual_rewardModal').modal({
        backdrop: 'static',
        keyboard: false,
        show: false
    });

    /*
        function to open manual reward modal
    */
    $('#manual_btn_add_reward').on('click', function(event) {
        event.preventDefault();
        $('#manual_rewardForm').trigger('reset');
        $('#manual_rewardForm #action').val('save');
        $('#manual_rewardForm #reward_id').val('');
        $('#manual_rewardForm #err_msg').text('');
        $("#manual_rewardForm span[id$='_error']").text('');
        $('#manual_rewardModal #title').text('Add New Manual Reward');
        /*Indisabled form buttons*/
        $('#manual_rewardForm').find('button').each(function() {
            $(this).attr('disabled', false)
        });
        manual_rewardValidator.resetForm();
        $('#manual_rewardModal').modal('show');
    });

    /*
       saving manual reward 
    */
    let manual_rewardValidator = $("#manual_rewardForm").validate({

        rules: {

            task: {

                required: true,
                minlength: 3,
                maxlength: 500
            },
            reward_points: {

                required: true,
                number: true,
                range: [1, 100000]
            },
            parent_category: {

                required: true,
                // number: true,
                // range: [1, 100]
            },
            status: {

                required: true
            }
        },
        submitHandler: function(form) {

            let event = window.event;
            event.preventDefault();

            $.ajax({

                type: "POST",
                url: "<?php echo admin_url('manual-rewards/save'); ?>",
                dataType: "JSON",
                async: false,
                data: $(form).serialize(),
                beforeSend: function() {
                    $(form).find('button').each(function() {
                        $(this).attr('disabled', true)
                    });
                    callLoader();
                },
                complete: function() {
                    $(form).find('button').each(function() {
                        $(this).attr('disabled', false)
                    });
                    endLoader();
                },
                success: function(data) {

                    $(form).trigger('reset');
                    /*to get manual reward list*/
                    window.location.reload();
                    manual_listRewards();
                    $('#manual_rewardModal').modal('hide');
                    /*Indisabled form buttons*/
                    $('#manual_rewardForm').find('button').each(function() {
                        $(form).attr('disabled', false)
                    });
                },
                error: function(data) {

                    if (data.responseJSON) {
                        let errResponse = data.responseJSON;
                        if (errResponse.message) {
                            $('#manual_rewardForm #err_msg').text(errResponse.message);
                        }

                        if (errResponse.validation) {
                            let validation = errResponse.validation
                            for (key in validation) {
                                $(`#manual_rewardForm #${key}_error`).text(validation[key]);
                            }
                        }
                    } else {
                        console.log(data);
                    }
                    /*Indisabled form buttons*/
                    $('#manual_rewardForm').find('button').each(function() {
                        $(this).attr('disabled', false)
                    });
                }
            });

            return false; // required to block normal submit since you used ajax
        }
    });

    /*
        function to get manual_reward list
    */
    let manualRewardDatatable = initializeDataTable('manualreward_table');

    $('#manualCategory').on('change',function(){
        var category = $(this).val();
        $.ajax({
            type:'post',
            url: '<?php echo admin_url('manual-rewards/getByCategoryManual') ?>',
            async: false,
            dataType: 'json',
            data : {
                category : category
            },success:function(data){
                let html = '';
                // console.log(data)
                manualRewardDatatable.clear().draw();
                if (data.length > 0) {
                    for (i = 0; i < data.length; i++) {
                        manualRewardDatatable.row.add([
                            data[i].created_at,
                            data[i].task,
                            data[i].reward_points,
                            (data[i].status == '1')?'Active':'In-active',
                            `<div style="white-space:nowrap">
                            <a href="javascript:void(0);" class="btn btn-xs btn-warning manual_btn_edit_reward" data-reward_id="${data[i].id}">Edit</a>
                            <a href="javascript:void(0);" class="btn btn-xs btn-danger manual_btn_delete_reward" data-reward_id="${data[i].id}">Delete</a>
                            </div>`
                        ]);       
                    }
                } else {
                    manualRewardDatatable.row.add(['No Data Found','','', '', '']);
                }
                //$('#manual_rewardRecords').html(html);
                manualRewardDatatable.draw();
            }
        });
    });

    function manual_listRewards() {

        $.ajax({

            type: 'ajax',
            url: "<?php echo admin_url('manual-rewards/show'); ?>",
            async: false,
            dataType: 'json',
            beforeSend: function() {
                callLoader();
            },
            complete: function() {
                endLoader();
            },
            success: function(data) {

                let html = '';
                if (data.length > 0) {

                    for (i = 0; i < data.length; i++) {

                            manualRewardDatatable.row.add([
                              data[i].created_at,
                              data[i].task,
                              data[i].reward_points,
                              (data[i].status == '1')?'Active':'In-active',
                              `<div style="white-space:nowrap">
                                <a href="javascript:void(0);" class="btn btn-xs btn-warning manual_btn_edit_reward" data-reward_id="${data[i].id}">Edit</a>
                                <a href="javascript:void(0);" class="btn btn-xs btn-danger manual_btn_delete_reward" data-reward_id="${data[i].id}">Delete</a>
                              </div>`
                            ]);
                            
                            
                    }

                } else {

                    //html += '<tr class="odd"><td valign="top" colspan="7" class="dataTables_empty">No data available in table</td></tr>';
                    manualRewardDatatable.row.add(['No Data Found','','', '', '']);
                }

                //$('#manual_rewardRecords').html(html);
                manualRewardDatatable.draw();
            },

        });
    }
    manual_listRewards();


    /*
        function to get particluar manual reward
    */
    $('body').on('click', '.manual_btn_edit_reward', function(event) {
        event.preventDefault();
        let reward_id = $(this).attr('data-reward_id');
        if (reward_id) {
            let url = "<?php echo admin_url('manual-rewards/get'); ?>";
            $.ajax({

                type: "POST",
                url: url,
                dataType: "JSON",
                data: { reward_id: reward_id },
                async: false,
                success: function(data) {

                    /*set manual modal form values*/
                    $('form#manual_rewardForm #task').val(data.rewardRow.task);
                    $('form#manual_rewardForm #reward_points').val(data.rewardRow.reward_points);
                    $('form#manual_rewardForm #parent_category option:selected').val(data.rewardRow.parent_category);
                    if (data.rewardRow.status == 1) {
                        $("form#manual_rewardForm #status_active").attr('checked', 'checked');
                    } else {
                        $("form#manual_rewardForm #status_inactive").attr('checked', 'checked');
                    }

                    $("form#manual_rewardForm #action").val('update');
                    $("form#manual_rewardForm #reward_id").val(data.rewardRow.id);
                    $('#manual_rewardForm #err_msg').text('');
                    $("#manual_rewardForm span[id$='_error']").text('');
                    $('#manual_rewardModal #title').text('Update Manual Reward')
                    /*Indisabled form buttons*/
                    $('#manual_rewardForm').find('button').each(function() {
                        $(this).attr('disabled', false)
                    });
                    manual_rewardValidator.resetForm();
                    $('#manual_rewardModal').modal('show');

                },
                error: function(data) {
                    console.log(data);
                }
            });

        }
    });

    /*
        function to delete particluar manual reward
    */
    $('body').on('click', '.manual_btn_delete_reward', function(event) {
        event.preventDefault();
        if (confirm('Are you sure to delete this record ?')) {
            $(this).attr('disabled', true);
            let reward_id = $(this).attr('data-reward_id');
            if (reward_id) {
                let url = "<?php echo admin_url('manual-rewards/delete'); ?>";
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "JSON",
                    data: { reward_id: reward_id },
                    async: false,
                    success: function(data) {
                        /*to get manual reward list*/
                        window.location.reload();
                        manual_listRewards();
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        }
        $(this).attr('disabled', false);
        return false;
    });

});
</script>
<!-- =============================manual reward end================================== -->


<!-- =============================Assign manual reward end============================-->
<script type="text/javascript">
$(document).ready(function() {

    /*
       Multi-select
    */

    $('#agents_ids').select2({
        placeholder: "Choose elements",
        width: "100%"
    });

    $('#manual_parent_category').on('change',function(){
        var category = $(this).val();
        $.ajax({
            type:'post',
            url: '<?php echo admin_url('manual-rewards/getByCategoryManual') ?>',
            async: false,
            dataType: 'json',
            data : {
                category : category
            },success:function(data){
                // manualRewardDatatable.clear().draw();
                // console.log(data)
                let html = '<option value="">-Select-</option>';
                if (data.length > 0) {
                    for (i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].task + '</option>';
                    }
                }
                $('#manual_reward_id').select2({
                    placeholder: "Choose elements",
                    width: "100%"
                });
                $('#manualAssignAgentForm #manual_reward_id').html(html);
            }
        });
    });

    $('#btn_get_manual_reward').on('click', function() {

        manualAssignAgentValidator.resetForm();
        $('#agents_ids').val('').select2({ placeholder: "Choose elements", width: "100%" }).trigger('change');

        /*to get manual tasks list*/
        $.ajax({

            type: 'ajax',
            url: "<?php echo admin_url('manual-rewards/show'); ?>",
            async: false,
            dataType: 'json',
            beforeSend: function() {
                callLoader();
            },
            complete: function() {
                endLoader();
            },
            success: function(data) {
                console.log(data)
                let html = '<option value="">-Select-</option>';
                if (data.length > 0) {
                    for (i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].task + '</option>';
                    }
                }
                $('#manual_reward_id').select2({
                    placeholder: "Choose elements",
                    width: "100%"
                });
                $('#manualAssignAgentForm #manual_reward_id').html(html);
            }

        });
    });

    /*function to assign agents manual tasks*/
    let manualAssignAgentValidator = $("#manualAssignAgentForm").validate({

        rules: {

            manual_reward_id: {

                required: true,
            },

            "agents_ids[]": {

                required: true
            }
        },
        submitHandler: function(form) {

            let event = window.event;
            event.preventDefault();

            $.ajax({

                type: "POST",
                url: "<?php echo admin_url('manual-rewards/assign-agents'); ?>",
                dataType: "JSON",
                async: false,
                data: $(form).serialize(),
                beforeSend: function() {
                    // console.log(123)
                    $(form).find('button').each(function() {
                        $(this).attr('disabled', true)
                    });
                    callLoader();
                },
                complete: function() {
                    $(form).find('button').each(function() {
                        $(this).attr('disabled', false)
                    });
                    endLoader();
                },
                success: function(data) {
                    toastr["info"](data.message);
                    $('#manualAssignAgentForm').trigger('reset');
                    manualAssignAgentValidator.resetForm();
                    $('#agents_ids').val('').select2({ placeholder: "Choose elements", width: "100%" }).trigger('change');

                },
                error: function(data) {
                    console.log(data);

                }
            });

            return false; // required to block normal submit since you used ajax
        }
    });

    /*
        check all staff agents for manual reward
    */
    $("#manual-check-all").click(function() {

        if ($("#manual-check-all").is(':checked')) { //select all
            $("#agents_ids").find('option').prop("selected", true);
            $("#agents_ids").trigger('change');
        } else { //deselect all
            $("#agents_ids").find('option').prop("selected", false);
            $("#agents_ids").trigger('change');
        }

    });

});
</script>
<!-- =============================Assignmanual reward end=============================-->


<!-- =============================CATALOG=============================-->
<script type="text/javascript"> 

    //----------------------------------Functin-to-covert-object-to-url-parameter---------------------------
    function createUrlParameterString(params) {
        // convert objec to a query string
        const qs = Object.keys(params)
            .map(function (key) {
                if (params[key] !== '' && params[key] !== null && params[key] !== undefined) {
                    return `${key}=${params[key]}`;
                }

                return null;

            }).filter(function (el) {
                return el != null;
            }).join('&');

        return qs;
    }

    let params = {
                   'page': 1,
                   'search': '',
                   'sort':'brand,asc',
                 //  'category_id':<?php echo $catalouge_categories_list[0]->category_id;?>,
                   'group':'',
                   'category':'',
                   'type':''
                 };

    function catalog_products() {

        $.ajax({

                type: "GET",
                url: "<?php echo admin_url('catalog/products'); ?>?"+createUrlParameterString(params),
                dataType: "JSON",
                async:true,
                beforeSend: function() {
                    callLoader();
                },
                complete: function() {

                    endLoader();
                    $('html, body').animate({
                        scrollTop: $('#catalog_data').offset().top
                    }, 'slow');
                },
                success: function(response) {    
                        
                    html = '<div class="row">';
                    
                    if(response.status == 1) {     
                       $('#catalog_data').html(response.data);
                        
                    }else {
                        console.log('no data found');
                    }                  

                },
                error: function(data) {
                    console.log(data);

                }
            });

    }

   /*
     * Add product to cart
   */
    function AddToCart(element) {
  
        let url  = $(element).attr('action'); 
        let data = $(element).serialize();

        $.ajax({

                type: "POST",
                url: url,
                dataType: "JSON",
                data: data,
                async:true,
                beforeSend: function() {
                    
                    /*disabled form buttons*/
                    $(element).find('button').each(function() {
                        $(this).attr('disabled', true)
                    });
                    callLoader();
                },
                complete: function() {
                    
                    /*enabled form buttons*/
                    $(element).find('button').each(function() {
                        $(this).attr('disabled', false)
                    });

                    endLoader();
                },
                success: function(response) {  

                    if(response.status == 1) {
                        toastr["success"](response.message);
                        if($('body .cs-cart-btn').has('.cs-badge').length) {  
                            $('body .cs-cart-btn').find('.cs-badge').text(response.count); }
                        else {
                            $('body .cs-cart-btn').append(`<span class="cs-badge">${response.count}</span>`);
                        }    
                    }
                     
                },
                error: function(response) {
                    
                    console.log(response);
                }
        });

        return false;

    }


    /*get catalog products on click TAB*/
    $(document).delegate('body a[href="#catalogTab"]','click',function() {

        params['page']     = 1;
        params['group']    = null;
        params['category'] = null;
        params['type']     = null;
        params['search']   = '';
        params['sort']     = 'brand,asc';
        $(document).find('body input[name="search"]').val(params['search']);
        $(document).find('body select[name="sort"]').val(params['sort']);


        catalog_products(); /*getting products*/ 
    });

    /*--------catalog products pagination-------*/ 
    $('body').on('click','.paginate',function(event) {
        event.preventDefault();

        let page = parseInt($(this).attr('data-page'));
        if(!(page > 0)){
            page = 1;
        }
        /*set params object values*/
        params['page'] = page;
        catalog_products(); /*getting products*/
    });

    /*--------catalog products search--------*/
        var typingTimer = null; //timer identifier
        var doneTypingInterval = 800; //time in ms (1 seconds)

        $(document).delegate('body input[name="search"]', 'keyup', function (event) {
            
            if(typingTimer) {

                clearTimeout(typingTimer);
                typingTimer = null;
            }
            
            /*set params object values*/
            params['page']   = 1;
            params['search'] = $(this).val().trim();
            typingTimer = setTimeout(catalog_products,doneTypingInterval);/*getting products*/
             
        });

    /*catalog products search end*/

    /*--------catalog brand sorting--------*/
    $(document).delegate('body select[name="sort"]','change', function() {
         
        let sort_val = $(this).val();
        if(sort_val != '') {params['sort'] = sort_val;}
        else { params['sort'] = ''; }
        catalog_products(); /*getting products*/

    });
    /*--------catalog brand sorting--------*/

    /*--------catalog category wise products search--------*/
    $(document).delegate('body .catalouge-categories', 'click', function (event) {
            
        /*set params object values*/
        params['page']   = 1;
        params['category_id'] = $(this).attr('data-cat_id');
        $('ul.category-ul-list').find('li a.active').each(function() {
            $(this).removeClass('active');
        });
        $(this).addClass('active');
        catalog_products();/*getting products*/
             
    });
    /*--------catalog category wise products search--------*/

    /*--------catalog group--------*/
    $(document).delegate('body .catalouge-group', 'click', function (event) {
        
        event.preventDefault();    
        /*set params object values*/
        params['page']     = 1;
        params['group']    = $(this).attr('data-group');
        params['category'] = null;
        params['type']     = null;
        catalog_products();/*getting products*/
             
    });
    /*--------catalog group--------*/

    /*--------catalog category--------*/
    $(document).delegate('body .catalouge-cat', 'click', function (event) {
        
        event.preventDefault();    
        /*set params object values*/
        params['page']     = 1;
        params['category'] = $(this).attr('data-category');
        params['type']     = null;
        catalog_products();/*getting products*/
             
    });
    /*--------catalog category--------*/

    /*--------catalog type--------*/
    $(document).delegate('body .catalouge-type', 'click', function (event) {
        
        event.preventDefault();    
        /*set params object values*/
        params['page']   = 1;
        params['type']   = $(this).attr('data-type');
        catalog_products();/*getting products*/
             
    });
    /*--------catalog type--------*/


</script>
<!-- =============================CATALOG END=============================-->

<!-- =============================WISHLIST START===========================-->
<script type="text/javascript">

    function add_to_wishlist(product_id,ele) {

         let event = window.event;
             event.preventDefault();

        if(product_id) {

            let url = $(ele).attr('href');

            $.ajax({

                type: "POST",
                url: url,
                dataType: "JSON",
                data : {product_id:product_id},
                async:true,
                beforeSend: function() {
                    
                    /*disabled form buttons*/
                    $(ele).css('disabled',true);
                    callLoader();
                },
                complete: function() {
                    
                    /*enabled form buttons*/
                    $(ele).css('disabled',false);
                    endLoader();
                },
                success: function(response) {  

                    if($(ele).hasClass('added')){
                        $(ele).removeClass('added');
                        /*remove product from wishlist on click*/
                        if($(ele).hasClass('wishlist-page')) {
                            $(ele).parents('.product-wrap').parent().remove();
                            let checkEle = $('#wishlist_products').find('div.row');
                            if(checkEle.children().length == 0) {
                               checkEle.html('<h2>NO DATA FOUND</h2> ');
                            }
                        }
                    } else {
                        $(ele).addClass('added');
                    } 
                     
                },
                error: function(response) {
                    
                    console.log(response);
                }
            });
        }

        return false;
    }
   
    /*get wishlist*/
    $(document).delegate('body a[href="#wishlistTab"]','click',function() {

        $.ajax({

            type: "POST",
            url: "<?php echo admin_url('catalog/wishlist')?>",
            dataType: "JSON",
            async:true,
            beforeSend: function() {
                callLoader();
            },
            complete: function() {
                endLoader();
            },
            success: function(response) {  
                 
                if(response.status == 1) {
                    $('#wishlist_products').html(response.data);
                }
            },
            error: function(response) {
                
                console.log(response);
            }
        });
    });
    /*get wishlist end*/

    

</script>
<!-- =============================WISHLIST END=============================-->

<!-- =============================My-Orders=============================-->
<script type="text/javascript">

  function myOrders() {

    $.ajax({

            type: "GET",
            url: "<?php echo admin_url('catalog/my-orders')?>",
            dataType: "JSON",
            data: {user_id:"<?php echo $_SESSION['staff_user_id'];?>"},
            async:true,
            beforeSend: function() {
                callLoader();
            },
            complete: function() {
                endLoader();
            },
            success: function(response) {   
                if(response.status == 1) { $('#my_orders').html(response.data); }

            },
            error: function(response) {
                
                console.log(response);
            }
        });

  } 

   
  $(document).ready(function() {
    
    $(document).delegate('body a[href="#redemptionTab"]','click',function() { myOrders(); });  

    $(document).delegate('body #my_orders .order_view','click',function() {

        let data_order_id = $(this).attr('data-order_id');
          
        $.ajax({

            type: "GET",
            url: "<?php echo admin_url('catalog/my-order-detail')?>",
            dataType: "JSON",
            data: {internal_order_id:data_order_id},
            async:true,
            beforeSend: function() {
                callLoader();
            },
            complete: function() {
                endLoader();
            },
            success: function(response) {   
                if(response.status == 1) { 
                    $('#order_detail_Modal .modal-body').html(response.data); 
                    $('#order_detail_Modal').modal('show');
                }

            },
            error: function(response) {
                
                console.log(response);
            }
        });
    });

  });

</script>
<!-- =============================My-Orders=============================-->

<script>
// $(document).ready(function(){
//   $('.dropdown-submenu a.category').on("click", function(e){
//     $(this).next('ul').toggle();
//     e.stopPropagation();
//     e.preventDefault();
//   });
// });
$(function(){
  $(".dropdown-menu > li > a.trigger").on("click",function(e){
    var current=$(this).next();
    var grandparent=$(this).parent().parent();
    if($(this).hasClass('left-caret')||$(this).hasClass('right-caret'))
      $(this).toggleClass('right-caret left-caret');
    grandparent.find('.left-caret').not(this).toggleClass('right-caret left-caret');
    grandparent.find(".sub-menu:visible").not(current).hide();
    current.toggle();
    e.stopPropagation();
  });
  $(".dropdown-menu > li > a:not(.trigger)").on("click",function(){
    var root=$(this).closest('.dropdown');
    root.find('.left-caret').toggleClass('right-caret left-caret');
    root.find('.sub-menu:visible').hide();
  });
});
</script>

