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
                    
                       
                        <div class="row">
                            <div class="col-xl-12">
                                <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            Casting <span class="fw-300"><i>Table</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                        <!-- <a href="<?=urlAction('mod_casting')?>" class="btn btn-info waves-effect waves-themed">Add Data</a> -->
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                         
                                            <table id="casting_datatable" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Sl</th>
                                                        <th>User Image</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Mobile</th>
                                                        <th>Company Logo</th>
                                                        <th>Company Name</th>
                                                        <th>Organization</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Sl</th>
                                                        <th>User Image</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Mobile</th>
                                                        <th>Company Logo</th>
                                                        <th>Company Name</th>
                                                        <th>Organization</th>
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
        load_all_casting_apply();
    });
</script>                    