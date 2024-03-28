<?php
// if(isset($_GET['id'])){
$id = isset($_GET['id']) ? escapeString($_GET['id']) : '0';

// $category = executeSelect('category',array(),array());
$data = executeSelectSingle('subscription_plan',array(),array('plan_id'=>$id));
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
                        <span class="fw-300"><i>Plans</i></span>
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
                        <form  method="POST" id="mod_subscription_plan" >
                            <input type="hidden" name='id' value="<?=$id?>">
                            
                            <div class="form-group">
                                <label class="form-label text-muted">Type</label>
                                <select class="custom-select form-control" name="type" required>
                                    <option selected value="">--Select type--</option>
                                    <?php
                                    foreach(PLANS as $k => $val){
                                        $selected = (isset($_GET['id']) &&  $val == $data['type']) ? 'selected' : ''; 
                                        echo "<option value='".$k."' ".$selected.">".$val."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Title</label>
                                <input required type="text" id="title" name="title" class="form-control" placeholder="Enter Title" value="<?=isset($data['title']) ? $data['title'] : ''?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Price</label>
                                <input required type="number" id="price" name="price" class="form-control" placeholder="Enter price" value="<?=isset($data['price']) ? $data['price'] : ''?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Description</label>
                                <input required type="text" id="description" name="description" class="form-control" placeholder="Enter Description" value="<?=isset($data['description']) ? $data['description'] : ''?>">
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