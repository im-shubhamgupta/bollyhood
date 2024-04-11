<?php
// if(isset($_GET['id'])){
$id = isset($_GET['id']) ? escapeString($_GET['id']) : '';
$data = executeSelectSingle('casting',array(),array('id' => $id));


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
                <div class="panel-container show">
                    <div class="panel-content">
                        <form  method="POST" id="mod_casting" >
                            <input type="hidden" name='id' value="<?=$id?>">
                            <div class="form-group">
                            <label class="form-label" for="simpleinput">Company Logo</label>
                                <div class="custom-file">
                                    <input type="file" name="logo_image" class="custom-file-input" id="logo_image" >
                                    <input type="hidden" name="company_logo" class="custom-file-input" id="company_logo" value="<?=isset($data['company_logo']) ? $data['company_logo'] : ''?>">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                            <div class="row form-group" > 
                                <div class=" col-md-6 ">
                                    <label class="form-label" for="simpleinput">Company Name</label>
                                    <input required type="text" maxlength="220"  id="company_logo" name="company_name"  placeholder="Enter Company Name" class="form-control" value="<?=isset($data['company_name']) ? $data['company_name'] : ''?>">
                                </div>
                                
                                <div class=" col-md-6">
                                    <label class="form-label" for="simpleinput">Organization</label>
                                    <input required type="text" maxlength="220"  id="organization" name="organization"  placeholder="Enter Organization"  class="form-control" value="<?=isset($data['organization']) ? $data['organization'] : ''?>">
                                </div>
                            </div>
                            <div class="row form-group" > 
                                <div class="col-md-6">
                                        <label class="form-label text-muted">Shifting</label>
                                        <select class="custom-select form-control" name="shifting" required>
                                            <?php
                                            if(!isset($_GET['id'])) echo "<option value=''>--Select Shifting--</option>";
                                            foreach(SHIFTING as $k => $val){
                                                echo '<option value="'.$k.'" '.((isset($data['shifting']) && $data['shifting'] == $k ) ? 'selected' : '').'>'.$val.'</option>';
                                            }
                                            
                                            ?>
                                        </select>
                                </div>
                                <div class=" col-md-6">
                                    <label class="form-label" for="simpleinput">Date</label>
                                    <input required type="date" id="date" name="date"  placeholder="Enter Date"  class="form-control" value="<?=isset($data['date']) ? $data['date'] : ''?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Description</label>
                                <textarea name="description" id="description" class="form-control " rows="4"><?=isset($data['description']) ? $data['description'] : ''?></textarea>
                            </div>
                            <div class="row form-group" > 
                                <div class=" col-md-6 ">Requirement</label>
                                    <input required type="text" maxlength="220"  id="requirement" name="requirement"  placeholder="Enter requirement Name" class="form-control" value="<?=isset($data['requirement']) ? $data['requirement'] : ''?>">
                                </div>
                                
                                <div class=" col-md-6">
                                    <label class="form-label" for="simpleinput">Skill</label>
                                    <input required type="text" maxlength="220"  id="skill" name="skill"  placeholder="Enter skill"  class="form-control" value="<?=isset($data['skill']) ? $data['skill'] : ''?>">
                                </div>
                            </div>
                            <div class="row form-group" > 
                                <div class=" col-md-6 ">Role</label>
                                    <input required type="text" maxlength="220"  id="role" name="role"  placeholder="Enter Role" class="form-control" value="<?=isset($data['role']) ? $data['role'] : ''?>">
                                </div>
                                <div class=" col-md-6">
                                    <label class="">Location</label>
                                    <input type="text" maxlength="220"  name="location" class="form-control"  placeholder="Enter Location" id="location" value="<?=isset($data['location']) ? $data['location'] : ''?>">
                                </div>
                            </div>
                            <div class="row form-group" > 
                                <div class=" col-md-12">
                                    <label class="">Upload Documents</label>
                                    <input type="file" name="doc_image" accept="application/pdf" class="custom-file-input " id="doc_image" >
                                    <input type="hidden" name="document" class="custom-file-input" id="document" value="<?=isset($data['document']) ? $data['document'] : ''?>">
                                    <label class="custom-file-label mt-4" for="customFile">Choose file</label>
                                </div>
                            </div>
                            <br>
                            <div class="frame-wrap">
                                <label class="form-label mb-3" for="simpleinput">Choose Type:</label>
                                <div class="form-group">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required type="radio" onclick="show_amount()"  class="custom-control-input" id="defaultInline1Radio" name="price_discussed" value="0" <?=(isset($data['price_discussed']) && $data['price_discussed'] == 0) ? 'checked' : ''?> <?=(!isset($_GET['id'])) ? 'checked' : ''?> >
                                         <label class="custom-control-label" for="defaultInline1Radio">Amount</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required type="radio"  class="custom-control-input" id="defaultInline1Radio_"  onclick="hide_amount()" name="price_discussed" value="1" 
                                        <?=(isset($data['price_discussed']) && $data['price_discussed'] == 1) ? 'checked' : ''?>
                                        >
                                         <label class="custom-control-label" for="defaultInline1Radio_">To Be Discussed</label>
                                    </div>
                                    <div class=" col-md-3  mt-5 price_div <?=(isset($data['price_discussed']) && $data['price_discussed'] == 1) ? 'd-none' : ''?>" id="price_div">
                                        <input type="text" maxlength="220"   placeholder="Enter Price"   class="form-control" id="price" name="price" value="<?=isset($data['price']) ? $data['price'] : ''?>" >
                                        
                                    </div>
                                </div>
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

<script>
    function show_amount(){
        var element = document.getElementById("price_div");
        element.classList.remove("d-none");
        document.getElementById('price').value = ''
    } 
    function hide_amount(){
        var element = document.getElementById("price_div");
        element.classList.add("d-none");
        document.getElementById('price').value = ''
    } 

</script>