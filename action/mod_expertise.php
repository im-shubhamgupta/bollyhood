<?php
// if(isset($_GET['id'])){
$id = isset($_GET['id']) ? escapeString($_GET['id']) : '';
$data = executeSelectSingle('expertise',array(),array('id' => $id));
$category = getResultAsArray("SELECT `id`,`category_name` from category where 1 ");

//('category',array(),array(),'category_name');
// print_R($data);
// print_R($category);

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
                    
                    //showFlashMsg();
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
                        <form  method="POST" id="mod_expertise" >
                            <input type="hidden" name='id' value="<?=$id?>">

                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Name</label>
                                <input required type="text" id="category_name" name="name"  placeholder="Enter Name" class="form-control" value="<?=isset($data['name']) ? $data['name'] : ''?>">
                            </div>
                            <div class="form-group">
                            <label class="form-label" for="simpleinput">Image</label>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="image" >
                                    <input type="hidden" name="user_image" class="custom-file-input" id="user_image" value="<?=isset($data['user_image']) ? $data['user_image'] : ''?>" >
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Mobile</label>
                                <input required type="number" id="mobile" name="mobile" class="form-control" placeholder="Enter Mobile" value="<?=isset($data['mobile']) ? $data['mobile'] : ''?>">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="simpleinput">Reviews</label>
                                        <input required type="text" id="reviews" name="reviews" class="form-control" placeholder="Enter reviews" value="<?=isset($data['reviews']) ? $data['reviews'] : ''?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="simpleinput">Jobs done</label>
                                        <input required type="text" id="jobs_done" name="jobs_done" class="form-control" placeholder="Enter jobs_done" value="<?=isset($data['jobs_done']) ? $data['jobs_done'] : ''?>">
                                    </div>
                                </div>    
                            </div>  
                            <br>  
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Description</label>
                                <textarea name="description" id="description" class="form-control " rows="4"><?=isset($data['description']) ? $data['description'] : ''?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Work links</label>
                                <textarea name="work_links" id="work_links" class="form-control " rows="4"><?=isset($data['work_links']) ? $data['work_links'] : ''?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label text-muted">Category</label>
                                <select class="custom-select form-control" name="cat_id[]" multiple required>
                                    <option selected value="">--Select Category--</option>
                                    <?php
                                    foreach($category as $val){
                                        $selected = (isset($_GET['id']) &&  in_array($val['id'],explode(',',$data['categories']))) ? 'selected' : ''; 
                                        $ca = getSingleResult("SELECT `id`,`category_name` from category where id = '".$val['id']."' ");
                                        echo "<option value='".$val['id']."' ".$selected.">".$ca['category_name']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label text-muted">Status</label>
                                <select class="custom-select form-control" name="status" required>
                                    <?php
                                    if(!isset($_GET['id'])) echo "<option selected=''>--Select Status--</option>";
                                    $selected = ($data['cat_id']== 1 ) ? 'selected' : '';
                                    ?>
                                        <option value='1' <?=(isset($data['status']) && $data['status']== 1 ) ? 'selected' : ''?>>Active</option>
                                        <option value='0' <?=(isset($data['status']) && $data['status']== 0 ) ? 'selected' : ''?>>Deactive</option>
                                </select>
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