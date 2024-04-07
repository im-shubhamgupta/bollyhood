<?php
$user = executeSelectSingle('users',array(),array('id'=>$_GET['id']));
$worklinks = executeSelect('users_worklink',array(),array('uid'=>$_GET['id']));
$bookings = getResultAsArray("SELECT u.name,ub.w_mobile,ub.purpose,ub.booking_date from users u INNER JOIN users_booking ub ON u.id = ub.uid where ub.uid = '".$_GET['id']."'");

?>

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
      <div class="col-lg-4">
        <div class="card mb-4" style="min-height: 160px;">
          <div class="card-body text-center">
            <img src="<?=USER_IMAGE_PATH.$user['image']?>" style="width:80px;min-height:90px;height:90px;" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3"><?=$user['name']?></h5>
          </div>
        </div>
        
      </div>
      <div class="col-lg-8">
        <div class="card mb-4" >
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Full Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?=$user['name']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?=$user['email']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Mobile</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?=$user['mobile']?></p>
              </div>
            </div>
            
          </div>
        </div>
        
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Description</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?=$user['mobile']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">jobs done :</p>
              </div>
              <div class="col-sm-3">
                <p class="text-muted mb-0"><?=$user['mobile']?></p>
              </div>
              <div class="col-sm-3">
                <p class="mb-0">Experience :</p>
              </div>
              <div class="col-sm-3">
                <p class="text-muted mb-0">(097) 234-5678</p>
              </div>
            </div>
            <hr>
            
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">Password :</p>
                </div>
                <div class="col-sm-3">
                    <p class="text-muted mb-0"><?=$user['password']?></p>
                </div>
                <div class="col-sm-3">
                    <p class="mb-0">Subscription :</p>
                </div>
                <div class="col-sm-3">
                    <p class="text-muted mb-0"><?=$user['is_subscription']?></p>
                </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <label><h3>Worklinks:</h3></label>
        <div class="card mb-4">
          <div class="card-body">
            <?php 
            foreach($worklinks as $val){?>
              <div class="row">
                <div class="col-sm-1">
                  <p class="mb-0">Name:</p>
                </div>
                <div class="col-sm-2">
                  <p class="mb-0"><?=$val['worklink_name']?></p>
                </div>
                <div class="col-sm-2">
                  <p class="text-muted mb-0">Worklink URL:</p>
                </div>
                <div class="col-sm-7">
                  <p class="text-muted mb-0"><?=$val['worklink_url']?></p>
                </div>
              </div>
              <hr>
            <?php 
            }?>  
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <label><h3>Bookings:</h3></label>
        <div class="card mb-4">
          <div class="card-body">
            <?php 
            foreach($bookings as $val){?>
              <div class="row">
                <div class="col-sm-2">
                  <p class="mb-0">Name:</p>
                </div>
                <div class="col-sm-3">
                  <p class="mb-0"><?=$val['name']?></p>
                </div>
                <div class="col-sm-2">
                  <p class="mb-0">Whatsapp Mobile:</p>
                </div>
                <div class="col-sm-5">
                  <p class="text-muted mb-0"><?=$val['w_mobile']?></p>
                </div>
                
              </div>
              <div class="row mt-4">
              <div class="col-sm-2">
                  <p class=" mb-0">Booking Date:</p>
                </div>
                <div class="col-sm-3">
                  <p class="text-muted mb-0"><?=$val['booking_date']?></p>
                </div>
                <div class="col-sm-2">
                  <p class=" mb-0">Purpose:</p>
                </div>
                <div class="col-sm-5">
                  <p class="text-muted mb-0"><?=$val['purpose']?></p>
                </div>
                
              </div>
              <hr>
            <?php 
            }?>  
          </div>
        </div>
      </div>
    </div>
</main>    
  <!-- </div>
</section> -->