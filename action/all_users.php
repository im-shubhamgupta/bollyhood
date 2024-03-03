<?php
//$arrData = executeSelect('users',array(),array(),'id desc');
?>
<style>
    .user_img{
        height: auto;
        width:100px;

    }
</style>
                    <!-- the #js-page-content id is needed for some plugins to initialize -->
                    <main id="js-page-content" role="main" class="page-content">
                        <!-- <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">SmartAdmin</a></li>
                            <li class="breadcrumb-item">Datatables</li>
                            <li class="breadcrumb-item active">Buttons</li>
                            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
                        </ol> -->
                       
                        <div class="row">
                            <div class="col-xl-12">
                                <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            Example <span class="fw-300"><i>Table</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                        <a href="<?=urlAction('mod_user')?>" class="btn btn-info waves-effect waves-themed">Add Data</a>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <!-- <div class="panel-tag">
                                                <code>hello</code>
                                            </div> -->
                                            <!-- datatable start -->
                                            <!-- dt-basic-example -->
                                            <table id="datas_datatable" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Sl</th>
                                                        <th>Name</th>
                                                        <th>Image</th>
                                                        <th>Email</th>
                                                        <th>Mobile</th>
                                                        <th>Status</th>
                                                        <th>Create At</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Sl</th>
                                                        <th>Name</th>
                                                        <th>Image</th>
                                                        <th>Email</th>
                                                        <th>Mobile</th>
                                                        <th>Status</th>
                                                        <th>Create At</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <!-- datatable end -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                    <!-- this overlay is activated only when mobile menu is triggered -->
<script>
    document.addEventListener("DOMContentLoaded", function(event) { 
        all_users_datatable();
    });
</script>                    