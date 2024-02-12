<?php
// if(isset($_GET['id'])){
$id = isset($_GET['id']) ? $_GET['id'] : '';
$data = executeSelectSingle('record_data',array(),array('id' => $id));

$text =  $data['text'] ?? '';
$source =  $data['source'] ?? '';
$category =  $data['category']?? '';
?>

<main id="js-page-content" role="main" class="page-content">
                        <!-- <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">SmartAdmin</a></li>
                            <li class="breadcrumb-item">Form Stuff</li>
                            <li class="breadcrumb-item active">Basic Inputs</li>
                            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
                        </ol> -->
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
                                   
                                           <!--  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                  <strong><?=$_SESSION['msg']?></strong>
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
                                            <form action="<?=url('?controller=form-controller')?>" method="POST"  >
                                                <input type="hidden" name='submit_action' value="add_form">
                                                <input type="hidden" name='id' value="<?=$id?>">

                                                <div class="form-group">
                                                    <label class="form-label" for="simpleinput">Text</label>
                                                    <input required type="text" id="text" name="text" class="form-control" value="<?=$text?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label" for="example-textarea">Text area</label>
                                                    <textarea class="form-control" id="source" name="source" rows="5"><?=$source?></textarea>
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
