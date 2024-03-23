<?php
//$arrData = executeSelect('users',array(),array(),'id desc');
?>
<style>
    .user_img{
        height: auto;
        width:100px;

    }
</style>
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        All <span class="fw-300"><i>Subscription Plans</i></span>
                    </h2>
                    <div class="panel-toolbar">
                    <a href="<?=urlAction('mod_plan')?>" class="btn btn-info waves-effect waves-themed">Add Data</a>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <!-- <div class="panel-tag">
                            <code>hello</code>
                        </div> -->
                        <!-- datatable start -->
                        <!-- dt-basic-example -->
                        <table id="plans_datatable" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Sl</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Description</th>
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
<script>
    document.addEventListener("DOMContentLoaded", function(event) { 
        load_all_subscription_plans();
    });
</script>                    