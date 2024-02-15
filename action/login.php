
        <div class="page-wrapper auth">
            <div class="page-inner bg-brand-gradient">
                <div class="page-content-wrapper bg-transparent m-0">
                    <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
                        <div class="d-flex align-items-center container p-0">
                            <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9 border-0">
                                <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                                    <img src="img/logo.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
                                    <span class="page-logo-text mr-1"><?=admin::company_name?></span>
                                </a>
                            </div>
                            <!-- <a href="page_register.html" class="btn-link text-white ml-auto">
                                Create Account
                            </a> -->
                        </div>
                    </div>
                    <div class="flex-1" style="background: url(img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                        <div class="container my-lg-5 px-4 px-sm-0">
                        <!-- py-4   py-lg-5 -->
                            <div class="row">
                            
                                <!-- <div class="col col-md-6 col-lg-7 hidden-sm-down">
                                    <h2 class="fs-xxl fw-500 mt-4 text-white">
                                        The simplest UI toolkit for developers &amp; programmers
                                        <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60">
                                            Presenting you with the next level of innovative UX design and engineering. The most modular toolkit available with over 600+ layout permutations. Experience the simplicity of SmartAdmin, everywhere you go!
                                        </small>
                                    </h2>
                                    <a href="#" class="fs-lg fw-500 text-white opacity-70">Learn more &gt;&gt;</a>
                                    <div class="d-sm-flex flex-column align-items-center justify-content-center d-md-block">
                                        <div class="px-0 py-1 mt-5 text-white fs-nano opacity-50">
                                            Find us on social media
                                        </div>
                                        <div class="d-flex flex-row opacity-70">
                                            <a href="#" class="mr-2 fs-xxl text-white">
                                                <i class="fab fa-facebook-square"></i>
                                            </a>
                                            <a href="#" class="mr-2 fs-xxl text-white">
                                                <i class="fab fa-twitter-square"></i>
                                            </a>
                                            <a href="#" class="mr-2 fs-xxl text-white">
                                                <i class="fab fa-google-plus-square"></i>
                                            </a>
                                            <a href="#" class="mr-2 fs-xxl text-white">
                                                <i class="fab fa-linkedin"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- col-md-6 col-lg-5 col-xl-4 -->
                                
                                <div class="col-sm-5 m-auto">
                                <?php 
                                    if(isset($_SESSION['flash']) && $_SESSION['flash']['check']=='success'){?>
                                    <div class="row mrg-top">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                                </button>
                                                <strong><?php sessionFlash()?></strong>
                                            </div>
                                        </div>
                                    </div> 
                                <?php 
                                }elseif(isset($_SESSION['flash']) && $_SESSION['flash']['check']!='success'){?>
                                    <div class="row mrg-top">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                                </button>
                                                <strong><?php sessionFlash()?></strong>
                                            </div>
                                        </div>
                                    </div> 
                                <?php } ?>
                                    <!-- <h1 class="text-white fw-300 mb-3 d-sm-block d-md-none">
                                        Secure login
                                    </h1> -->
                                    <div class="card p-4 rounded-plus bg-faded">
                                        <form  action="<?=urlController('auth_controller')?>" method="post" id="js-login" novalidate="">
                                            <input type="hidden" name="submit_action" value="log_in"> 
                                            <input type="hidden" name="get_action" value="<?=isset($_GET['action']) ? $_GET['action'] : ''?>"> 
                                            <div class="form-group">
                                                <label class="form-label" for="username">Username</label>
                                                <input type="text" id="username" name="username" class="form-control form-control-lg" placeholder="your mobile or email"  required>
                                                <div class="invalid-feedback">No, you missed this one.</div>
                                                <!-- <div class="help-block">Your unique username to app</div>   -->
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="password">Password</label>
                                                <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="password" required>
                                                <div class="invalid-feedback">Sorry, you missed this one.</div>
                                                <div class="help-block">Your password</div>
                                            </div>
                                            <!-- <div class="form-group text-left">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="rememberme">
                                                    <label class="custom-control-label" for="rememberme"> Remember me for the next 30 days</label>
                                                </div>
                                            </div> -->
                                            <div class="row no-gutters">
                                                <div class="col-lg-6 pl-lg-1 my-2">
                                                    <!-- <button id="js-login-btn" type="submit" class="btn btn-danger btn-block btn-lg">Secure login</button> -->
                                                    <!-- <input id="js-login-btn" type="submit" class="btn btn-danger btn-block btn-lg" value="Secure login"> -->
                                                    <button  id="js-login-btn"  type="submit" class="btn btn-danger btn-block btn-lg">Secure login</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                            <?=date('Y') .' '.admin::copyright?>&nbsp;<a href='#' class='text-white opacity-40 fw-500' title='' target='_blank'></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        