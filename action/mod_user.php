<?php
// if(isset($_GET['id'])){
$id = isset($_GET['id']) ? escapeString($_GET['id']) : '';
$data = executeSelectSingle('users',array(),array('id' => $id));
$category = executeSelect('category',array(),array(),'category_name');

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
                        <form  method="POST" id="add_user" >
                            <input type="hidden" name='submit_action' value="add_user">
                            <input type="hidden" name='id' value="<?=$id?>">

                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Name</label>
                                <input required type="text" id="category_name" name="name"  placeholder="Enter Name" class="form-control" value="<?=isset($data['name']) ? $data['name'] : ''?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Email</label>
                                <input required type="text" id="email" name="email"  placeholder="Enter Email"  class="form-control" value="<?=isset($data['email']) ? $data['email'] : ''?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Mobile</label>
                                <input required type="number" id="mobile" name="mobile" class="form-control" placeholder="Enter Mobile" value="<?=isset($data['mobile']) ? $data['mobile'] : ''?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label text-muted">Category</label>
                                <select class="custom-select form-control" name="cat_id" required>
                                    <option selected="">--Select Category--</option>
                                    <?php
                                    foreach($category as $val){
                                        $selected = (isset($_GET['id']) &&  $val['id']==$data['cat_id']) ? 'selected' : ''; 
                                        echo "<option value='".$val['id']."' ".$selected.">".$val['category_name']."</option>";
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
                                    <button type="button" class="btn btn-primary waves-effect waves-themed" onclick="add_user(this)"  id="customFile">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script> 
    function validateForm() {
        alert(456);
            // Retrieve form inputs
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            
            // Basic validation example
            if (name === '' || email === '') {
                alert('Name and email are required');
                return false; // Prevent form submission
            }
            // You can add more complex validation logic here
            
            // If validation passes, allow form submission
            return false;
        }

</script>