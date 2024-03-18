<?php
// if(isset($_GET['id'])){
$id = isset($_GET['id']) ? $_GET['id'] : '';
$data = executeSelectSingle('category',array(),array('id' => $id));

// $category_name =  $data['category_name'];
?>

<main id="js-page-content" role="main" class="page-content">
                        
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Add <span class="fw-300"><i>Category</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                
                        <!--  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong><//$_SESSION['msg']?></strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div> -->


                <?php 

                if(isset($_SESSION['flash'])){?>
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
                    <!-- url('controller/form-controller.php') -->
                    <!--  -->
                    <div class="panel-content">
                        <form action="<?=url('?controller=form-controller')?>" method="POST" enctype="multipart/form-data" id="mod_category"  >
                            <input type="hidden" name='submit_action' value="add_category">
                            <input type="hidden" name='id' value="<?=$id?>">

                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Text</label>
                                <input required type="text" id="category_name" name="category_name" class="form-control" value="<?=isset($data['category_name']) ? $data['category_name'] : ''?>">
                                <span class="form_error" id="cat_error"></span>
                            </div>
                            <div class="form-group">
                            <label class="form-label" for="simpleinput">Image</label>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="image" >
                                    <input type="hidden" name="category_image" class="custom-file-input" id="category_image" value="<?=isset($data['category_image']) ? $data['category_image'] : ''?>" >
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
