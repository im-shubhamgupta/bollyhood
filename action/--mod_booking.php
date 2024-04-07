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
                        <span class="fw-300"><i>Booking</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                   
                <div class="panel-container show">
                    <div class="panel-content">
                        <form  method="POST" id="mod_booking" >
                            <input type="hidden" name='id' value="<?=$id?>">
                            <input type="hidden" name='uid' value="<?=$uid?>">
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Name</label>
                                <input required type="text" id="name" name="name" class="form-control" placeholder="Enter Name" value="<?=isset($data['name']) ? $data['name'] : ''?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Whatsapp Number</label>
                                <input required type="number" id="w_mobile" name="" class="form-control" placeholder="Enter Whatsapp Number" value="<?=isset($data['w_mobile']) ? $data['w_mobile'] : ''?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Purpose Of Booking</label>
                                <textarea required type="text" rows="4" id="purpose" name="purpose" class="form-control" placeholder="Enter purpose"><?=isset($data['purpose']) ? $data['description'] : ''?></textarea>
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