<?php
// if(isset($_GET['id'])){
$id = isset($_GET['id']) ? escapeString($_GET['id']) : '0';

$category = executeSelect('category',array(),array());
$data = executeSelectSingle('sub_category',array(),array('sub_cat_id'=>$id));
// print_R($data);
?>
<main id="js-page-content" role="main" class="page-content">
                        
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        <?php
                            echo isset($_GET['id']) ? 'Update' : 'Add';
                        ?>
                        <span class="fw-300"><i>User</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <?php 

                if(isset($_SESSION['flash'])){
                    ?>
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
                        <form  method="POST" id="add_sub_category" >
                            <input type="hidden" name='id' value="<?=$id?>">
                            
                            <div class="form-group">
                                <label class="form-label text-muted">Category</label>
                                <select class="custom-select form-control" name="category_id" required>
                                    <option selected value="">--Select Category--</option>
                                    <?php
                                    foreach($category as $val){
                                        $selected = (isset($_GET['id']) &&  $val['id'] == $data['category_id']) ? 'selected' : ''; 
                                        echo "<option value='".$val['id']."' ".$selected.">".$val['category_name']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Sub category Name</label>
                                <input required type="text" id="sub_cat_name" name="sub_cat_name" class="form-control" placeholder="Enter Name" value="<?=isset($data['sub_cat_name']) ? $data['sub_cat_name'] : ''?>">
                            </div>
                            
                            <div class="form-group mb-0">
                                <div class="">
                                    <button type="submit" class="btn btn-primary waves-effect waves-themed"   id="customFile">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>