<?php
$arrData = executeSelect('banners',array(),array(),'id desc');
?>
<style>
.banner_img{
    width: 300px;
    height:auto;
}

</style>
<main id="js-page-content" role="main" class="page-content">
                        <div class="row">
                            <div class="col-xl-12">
                                <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            Banner
                                        </h2>
                                        <div class="panel-toolbar">
                                            <a href="<?=urlAction('mod_banner')?>" class="btn btn-primary" >Add Banner</a>
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
                                                            <table id="banner_Datatable" class="table table-bordered table-hover table-striped w-100">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Sl No.</th>
                                                                    <th>Banner Image</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $html = '';
                                                                foreach($arrData as $k => $val){
                                                                    $k++;
                                                                    $html .="<tr>";
                                                                    $html .=" <td class='text-center'>".$k."</td>";
                                                                    $html .=" <td class='text-center'>
                                                                    <img src='".BANNER_IMAGE_PATH.$val['banner_image']."' class = 'banner_img' alt='banner image' >
                                                                    </td>";
                                                                    $html .=" <td class='text-center'>".($val['status']==1 ? 'Active' : 'Deactive' )."</td>";

                                                                    
                                                                    $action = '
                                                                    <span><a href="#" onclick="delete_banner(this)" data-id="'.$val['id'].'" class="btn btn-danger btn-sm btn-icon waves-effect waves-themed">
                                                                    <i class="fal fa-times"></i></a></span>';
                                                                    
                                                                    $html .=" <td class='text-center'>".$action."</td>";

                                                                    $html .="</tr>";
                                                                }
                                                                echo $html;
                                                                ?>
                                                            </tbody>
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
        $('#banner_Datatable').dataTable();
    });
</script>                     