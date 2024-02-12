<?php
$arrData = executeSelect('record_data',array(),array(),'id desc');
?>
                    <!-- the #js-page-content id is needed for some plugins to initialize -->
                    <main id="js-page-content" role="main" class="page-content">
                        <div class="row">
                            <div class="col-xl-12">
                                <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            All <span class="fw-300"><i>Documents</i></span>
                                        </h2>
                                        <div class="mr-auto">
                                            <a href="<?=urlAction('add_document')?>" class="btn btn-info waves-effect waves-themed">Add Document</a>
                                        </div>
                                        <!-- <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                        </div> -->
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                           
                                            <table id="document_datatable" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <th>#ID</th>
                                                         <th>Category</th>
                                                        <th>Text</th>
                                                        <th width="80%">Images</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // foreach($arrData as $val){
                                                    //    echo "<tr>
                                                    //     <td>".$val['id']."</td>
                                                    //     <td>".$val['category']."</td>
                                                    //     <td>".$val['text']."</td>
                                                    //     <td>".$val['source']."</td>
                                                    //     <td></td>
                                                    //     </tr>";
                                                    // }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>#ID</th>
                                                         <th>Category</th>
                                                        <th>Text</th>
                                                        <th>Images</th>
                                                        <th>Action++</th>
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
        all_documents_datatable();
    });
    // $(document).ready(function(){
    //     all_documents_datatable();
    // });
</script>                    