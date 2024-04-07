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
                        All <span class="fw-300"><i>Bookings</i></span>
                    </h2>
                    <div class="panel-toolbar">
                    <!-- <a href="<?=urlAction('mod_booking')?>" class="btn btn-info waves-effect waves-themed">Add Data</a> -->
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        
                        <table id="booking_datatable" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Whatsapp Number</th>
                                    <th>Purpose</th>
                                    <th>Date & time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Whatsapp Number</th>
                                    <th>Purpose</th>
                                    <th>Date & time</th>
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
        load_all_bookings();
    });
</script>                    