<?php
// if(isset($_GET['id'])){
$id = isset($_GET['id']) ? $_GET['id'] : '';

$data = executeSelectSingle('document',array(),array('id' => $id));

$name =  $data['name'] ?? '';
$source =  $data['source'] ?? '';
$category =  $data['category']?? '';
?>

<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-edit'></i> Basic Inputs
            <small>
                Add your inputs
            </small>
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        General <span class="fw-300"><i>inputs</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                    
                </div>
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
                } ?>   
                <div class="panel-container show">
                    <div class="panel-content">
                        <form action="<?=urlController('doc_controller')?>" method="POST" enctype="multipart/form-data"  >
                            <input type="hidden" name='request_action' value="add_document">
                            <input type="hidden" name='id' value="<?=$id?>">

                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Document Name</label>
                                <input required type="text" id="name" name="name" class="form-control" value="<?=$name?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Documents (Browser)</label>
                                <div class="custom-file">
                                    <input type="file" name="image[]" class="custom-file-input" multiple id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <select class="custom-select form-control" name="category"  required>
                                    <?php
                                    //print_R(CAT);
                                        foreach(CAT as $key => $val){
                                            $selected = ($category== $key) ? 'selected' : '';
                                            echo "<option value='".$key."' ".$selected." >".$val."</option>";     
                                        }
                                    ?>
                                </select>
                            </div>
                            <!-- <div class="form-group mb-0">
                                <label class="form-label">File (Browser)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div> -->
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
