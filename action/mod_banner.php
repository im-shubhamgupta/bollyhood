<?php
// if(isset($_GET['id'])){
$id = isset($_GET['id']) ? $_GET['id'] : '0';
$data = executeSelectSingle('category',array(),array('id' => $id));

// $category_name =  $data['category_name'];
?>

<main id="js-page-content" role="main" class="page-content">
                        
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Add <span class="fw-300"><i>Banner</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>

                <?php 

                if(isset($_SESSION['flash'])){?>
                    <!-- show_success_alert(); -->
                    <div class="row mrg-top">
                        <div class="col-md-12 col-sm-12">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                </button>
                                <strong><?=sessionFlash()?></strong>
                            </div>
                        </div>
                    </div> 
                <?php 
                // unset($_SESSION['flash']['msg']);
            } ?>   
                
                <div class="panel-container show">
                  
                    <div class="panel-content">
                        <form action="" method="POST" id="mod_banner"  >
                            <input type="hidden" name='submit_action' value="add_category">
                            <!-- <input type="hidden" name='id' value="<?=$id?>"> -->
                            <div class="form-group">
                            <label class="form-label" for="simpleinput">Banner Image</label>
                            <div class="custom-file">
                                    
                                    <input type="file" name="banner_image" class="custom-file-input" id="banner_image" required>
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                </div>
                            <div class="form-group mb-0">
                                <div class="">
                                    <button type="submit" class="btn btn-primary waves-effect waves-themed" id="customFile">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
