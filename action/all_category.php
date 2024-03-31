<?php
// $arrData = executeSelect('category',array(),array(),'id desc');
?>
<main id="js-page-content" role="main" class="page-content">
                        <div class="row">
                            <div class="col-xl-12">
                                <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            Category
                                        </h2>
                                        <div class="panel-toolbar">
                                            <a href="<?=urlAction('mod_category')?>" class="btn btn-primary" >Add Category</a>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <!-- tab content -->
                                            <div class="tab-content pt-4">
                                                <div class="tab-pane fade show active" id="tab_default-1" role="tabpanel">
                                                    <!-- row -->
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <!-- datatable start -->
                                                            <table id="category_datatable" class="table table-bordered table-hover table-striped w-100">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Sl No.</th>
                                                                    <th>Image</th>
                                                                    <th>Type</th>
                                                                    <th>Category</th>
                                                                    <th>Created At</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            </table>
                                                            <!-- datatable end -->
                                                        </div>
                                                    </div>
                                                    <!-- end row -->
                                                </div>
                                            </div>
                                            <!-- end tab content -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                 
<script>
    document.addEventListener("DOMContentLoaded", function(event) { 
        fetch_all_category();
    });
</script>                     