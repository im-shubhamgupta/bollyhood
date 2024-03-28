<?php
// if(isset($_GET['id'])){
// $id = isset($_GET['id']) ? $_GET['id'] : '';
$id =  $action;
$data = executeSelectSingle('cms_readme',array(),array('type' => $action));

// $category_name =  $data['category_name'];
?>

<main id="js-page-content" role="main" class="page-content">
                        
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        <?=isset($_GET['id']) ? 'Edit' : 'Add' ?> 
                        <span class="fw-300"><i>Terms Condition</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form method="POST" enctype="multipart/form-data" id="mod_cms_readme"  >
                            <input type="hidden" name='id' value="<?=$id?>">
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Description</label>
                                <textarea rows="10" required id="description" name="description" class="form-control" ><?=isset($data['description']) ? $data['description'] : ''?></textarea>
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
