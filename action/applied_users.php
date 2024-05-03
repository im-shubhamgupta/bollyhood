<?php
$user = executeSelectSingle('users',array(),array('id'=>$_GET['id']));
// $worklinks = executeSelect('users_worklink',array(),array('uid'=>$_GET['id']));
$allCastings = getResultAsArray("SELECT  * from casting c INNER JOIN casting_apply ca ON c.id = ca.casting_id where ca.uid = '".$_GET['id']."'");

?>
<style>
.user_img{
  padding:10px;
  width:80px;
  height:80px;
}

</style>

<main id="js-page-content" role="main" class="page-content">    
    <!-- <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
          </ol>
        </nav>
      </div>
    </div> -->

    <div class="row">
      <div class="col-lg-12">
      <label><h3>User Details:</h3></label>
        <div class="card mb-4" >
          <div class="card-body">
          
            <div class="row">
            
              <div class="col-sm-3">
                <p class="mb-0">Full Name</p>
              </div>
              <div class="col-sm-3">
                <p class="text-muted mb-0"><?=$user['name']?></p>
              </div>
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-3">
                <p class="text-muted mb-0"><?=$user['email']?></p>
              </div>
              
            </div>
            <hr>
            <div class="row">
            <div class="col-sm-3">
                <p class="mb-0">Mobile</p>
              </div>
              <div class="col-sm-3">
                <p class="text-muted mb-0"><?=$user['mobile']?></p>
              </div>
              <div class="col-sm-3">
                <p class="mb-0"></p>
              </div>
              <div class="col-sm-3">
                <p class="text-muted mb-0"></p>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
      <label><h3>Casting Applies:</h3></label>

      <?php
    foreach($allCastings as $val){ 
      ?>
        <div class="card mb-4" >
          <div class="card-body">
          
            <div class="row">
            
              <div class="col-sm-3">
                <p class="mb-0">Company Logo</p>
              </div>
              <div class="col-sm-3">
                <p class="text-muted mb-0"><?php echo "<img class='user_img' src='".COMPANY_LOGO_PATH.$val['company_logo']."' "?></p>
              </div>
              <div class="col-sm-3">
                <p class="mb-0">Company Name</p>
              </div>
              <div class="col-sm-3">
                <p class="text-muted mb-0"><?=$val['company_name']?></p>
              </div>
              
            </div>
            <hr>
            <div class="row">
            
              <div class="col-sm-3">
                <p class="mb-0">Orgnization</p>
              </div>
              <div class="col-sm-3">
                <p class="text-muted mb-0"><?=$val['organization']?></p>
              </div>
              <div class="col-sm-3">
                <p class="mb-0">Shifting</p>
              </div>
              <div class="col-sm-3">
                <p class="text-muted mb-0"><?=SHIFTING[$val['shifting']]?></p>
              </div>
              
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                <p class="mb-0">Images</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">
                      <?php
                      $image_app = !empty($val['images']) ? explode(',',$val['images']) : '';
                      // print_r($image_app);
                      foreach($image_app as $img){

                          echo "<span class='logo'><img class='user_img' src='".CASTING_APPLY_IMAGES.$img."' </span>";
                      }
                      ?>
                  </p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                <p class="mb-0">Video</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">
                    
                      <?php 
                      if(!empty($val['video'])){?>
                        <video width="280" height="180" controls>
                          <source src=<?=CASTING_APPLY_VIDEO.$val['video']?> type="video/mp4">

                        </video>

                      <?php 
                    }?>
                     
                    
                  </p>
                </div>
            </div>
          </div>
        </div>
        <?php
    }?>
        
      </div>
    </div>
    
</main>    
  <!-- </div>
</section> -->