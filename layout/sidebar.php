<?php 
//if(isset($_SESSION['login']) && $_SESSION['login']=='y'){?>
<!-- BEGIN Left Aside -->
    <aside class="page-sidebar">
        <div class="page-logo">
            <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
                <img src="<?=asset('/img/logo.png')?>" alt="SmartAdmin WebApp" aria-roledescription="logo">
                <span class="page-logo-text mr-1"><?=admin::company_name?></span>
                <!-- <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span> -->
                <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
            </a>
        </div>
        <!-- BEGIN PRIMARY NAVIGATION -->
        <nav id="js-primary-nav" class="primary-nav" role="navigation">
            <div class="nav-filter">
                <div class="position-relative">
                    <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                    <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                        <i class="fal fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="info-card">
                <img src="<?=asset('/img/demo/avatars/avatar-admin.png')?>" class="profile-image rounded-circle" alt="<?= admin::name?>">
                <div class="info-card-text">
                    <a href="#" class="d-flex align-items-center text-white">
                        <span class="text-truncate text-truncate-sm d-inline-block">
                        <?= admin::name?>
                        </span>
                    </a>
                    <span class="d-inline-block text-truncate text-truncate-sm"><?= admin::address?></span>
                </div>
                <img src="<?=asset('/img/card-backgrounds/cover-2-lg.png')?>" class="cover" alt="cover">
                <!-- <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                    <i class="fal fa-angle-down"></i>
                </a> -->
            </div>
            <ul id="js-nav-menu" class="nav-menu">
                <li class="active open">
                    <a href="#" title="Application Intel" data-filter-tags="application intel">
                        <i class="fal fa-info-circle"></i>
                        <span class="nav-link-text" data-i18n="nav.application_intel">Application Intel</span>
                    </a>
                    <ul>
                        <li class="">
                            <a href="<?=urlAction('form')?>" title="Add Data" data-filter-tags="application intel analytics dashboard">
                                <span class="nav-link-text" data-i18n="nav.application_intel_analytics_dashboard">Add Data</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="<?=urlAction('all_data')?>" title="Add Data" data-filter-tags="application intel marketing dashboard">
                                <span class="nav-link-text" data-i18n="nav.application_intel_marketing_dashboard">All Datas </span>
                            </a>
                        </li>
                        <li class="">
                            <a href="<?=urlAction('all_document')?>" title="Add Document" data-filter-tags="application intel marketing dashboard">
                                <span class="nav-link-text" data-i18n="nav.application_intel_marketing_dashboard">All Documents </span>
                            </a>
                        </li>
                        <li class="">
                            <a href="<?=urlAction('category')?>" title="Add Category" data-filter-tags="application intel marketing dashboard">
                                <span class="nav-link-text" data-i18n="nav.application_intel_marketing_dashboard">All Category </span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul id="js-nav-menu" class="nav-menu">
                <li class="active open">
                    <a href="#" title="Master" data-filter-tags="Master">
                        <i class="fal fa-info-circle"></i>
                        <span class="nav-link-text" data-i18n="nav.application_intel">Master</span>
                    </a>
                    <ul>
                        <li class="">
                            <a href="<?=urlAction('category')?>" title="Category" data-filter-tags="application intel analytics dashboard">
                                <span class="nav-link-text" data-i18n="nav.application_intel_analytics_dashboard">Category</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="filter-message js-filter-message bg-success-600"></div>
        </nav>
        <!-- END PRIMARY NAVIGATION -->
    </aside>
     <!-- END Left Aside -->
<?php //}?>
   

<?php 
//if(isset($_SESSION['login']) && $_SESSION['login']=='y'){?>
<div class="page-content-wrapper"> <!-- div close on footer -->
    <!-- BEGIN Page Header -->
    <header class="page-header" role="banner">
        <!-- we need this logo when user switches to nav-function-top -->
        <div class="page-logo">
            <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
                <img src="img/logo.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
                <span class="page-logo-text mr-1">SmartAdmin WebApp</span>
                <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
                <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
            </a>
        </div>
        <!-- DOC: nav menu layout change shortcut -->
        <div class="hidden-md-down dropdown-icon-menu position-relative">
            <a href="#" class="header-btn btn js-waves-off" data-action="toggle" data-class="nav-function-hidden" title="Hide Navigation">
                <i class="ni ni-menu"></i>
            </a>
            <ul>
                <li>
                    <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-minify" title="Minify Navigation">
                        <i class="ni ni-minify-nav"></i>
                    </a>
                </li>
                <li>
                    <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-fixed" title="Lock Navigation">
                        <i class="ni ni-lock-nav"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- DOC: mobile button appears during mobile width -->
        <div class="hidden-lg-up">
            <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on">
                <i class="ni ni-menu"></i>
            </a>
        </div>
        
        <div class="ml-auto d-flex">
            <!-- activate app search icon (mobile) -->
            <div class="hidden-sm-up">
                <a href="#" class="header-icon" data-action="toggle" data-class="mobile-search-on" data-focus="search-field" title="Search">
                    <i class="fal fa-search"></i>
                </a>
            </div>
            <div>
                <a href="#" class="header-icon" data-toggle="dropdown" title="My Apps">
                    <i class="fal fa-cube"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-animated w-auto h-auto">
                    <div class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center rounded-top">
                        <h4 class="m-0 text-center color-white">
                            Quick Shortcut
                            <small class="mb-0 opacity-80">User Applications & Addons</small>
                        </h4>
                    </div>
                    <div class="custom-scroll h-100">
                        <ul class="app-list">
                            <li>
                                <a href="#" class="app-list-item hover-white">
                                    <span class="icon-stack">
                                        <i class="base-2 icon-stack-3x color-primary-600"></i>
                                        <i class="base-3 icon-stack-2x color-primary-700"></i>
                                        <i class="ni ni-settings icon-stack-1x text-white fs-lg"></i>
                                    </span>
                                    <span class="app-list-name">
                                        Services
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="app-list-item hover-white">
                                    <span class="icon-stack">
                                        <i class="base-2 icon-stack-3x color-primary-400"></i>
                                        <i class="base-10 text-white icon-stack-1x"></i>
                                        <i class="ni md-profile color-primary-800 icon-stack-2x"></i>
                                    </span>
                                    <span class="app-list-name">
                                        Account
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="app-list-item hover-white">
                                    <span class="icon-stack">
                                        <i class="base-9 icon-stack-3x color-success-400"></i>
                                        <i class="base-2 icon-stack-2x color-success-500"></i>
                                        <i class="ni ni-shield icon-stack-1x text-white"></i>
                                    </span>
                                    <span class="app-list-name">
                                        Security
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="app-list-item hover-white">
                                    <span class="icon-stack">
                                        <i class="base-18 icon-stack-3x color-info-700"></i>
                                        <span class="position-absolute pos-top pos-left pos-right color-white fs-md mt-2 fw-400">28</span>
                                    </span>
                                    <span class="app-list-name">
                                        Calendar
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="app-list-item hover-white">
                                    <span class="icon-stack">
                                        <i class="base-7 icon-stack-3x color-info-500"></i>
                                        <i class="base-7 icon-stack-2x color-info-700"></i>
                                        <i class="ni ni-graph icon-stack-1x text-white"></i>
                                    </span>
                                    <span class="app-list-name">
                                        Stats
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="app-list-item hover-white">
                                    <span class="icon-stack">
                                        <i class="base-4 icon-stack-3x color-danger-500"></i>
                                        <i class="base-4 icon-stack-1x color-danger-400"></i>
                                        <i class="ni ni-envelope icon-stack-1x text-white"></i>
                                    </span>
                                    <span class="app-list-name">
                                        Messages
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="app-list-item hover-white">
                                    <span class="icon-stack">
                                        <i class="base-4 icon-stack-3x color-fusion-400"></i>
                                        <i class="base-5 icon-stack-2x color-fusion-200"></i>
                                        <i class="base-5 icon-stack-1x color-fusion-100"></i>
                                        <i class="fal fa-keyboard icon-stack-1x color-info-50"></i>
                                    </span>
                                    <span class="app-list-name">
                                        Notes
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="app-list-item hover-white">
                                    <span class="icon-stack">
                                        <i class="base-16 icon-stack-3x color-fusion-500"></i>
                                        <i class="base-10 icon-stack-1x color-primary-50 opacity-30"></i>
                                        <i class="base-10 icon-stack-1x fs-xl color-primary-50 opacity-20"></i>
                                        <i class="fal fa-dot-circle icon-stack-1x text-white opacity-85"></i>
                                    </span>
                                    <span class="app-list-name">
                                        Photos
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="app-list-item hover-white">
                                    <span class="icon-stack">
                                        <i class="base-19 icon-stack-3x color-primary-400"></i>
                                        <i class="base-7 icon-stack-2x color-primary-300"></i>
                                        <i class="base-7 icon-stack-1x fs-xxl color-primary-200"></i>
                                        <i class="base-7 icon-stack-1x color-primary-500"></i>
                                        <i class="fal fa-globe icon-stack-1x text-white opacity-85"></i>
                                    </span>
                                    <span class="app-list-name">
                                        Maps
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="app-list-item hover-white">
                                    <span class="icon-stack">
                                        <i class="base-5 icon-stack-3x color-success-700 opacity-80"></i>
                                        <i class="base-12 icon-stack-2x color-success-700 opacity-30"></i>
                                        <i class="fal fa-comment-alt icon-stack-1x text-white"></i>
                                    </span>
                                    <span class="app-list-name">
                                        Chat
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="app-list-item hover-white">
                                    <span class="icon-stack">
                                        <i class="base-5 icon-stack-3x color-warning-600"></i>
                                        <i class="base-7 icon-stack-2x color-warning-800 opacity-50"></i>
                                        <i class="fal fa-phone icon-stack-1x text-white"></i>
                                    </span>
                                    <span class="app-list-name">
                                        Phone
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="app-list-item hover-white">
                                    <span class="icon-stack">
                                        <i class="base-6 icon-stack-3x color-danger-600"></i>
                                        <i class="fal fa-chart-line icon-stack-1x text-white"></i>
                                    </span>
                                    <span class="app-list-name">
                                        Projects
                                    </span>
                                </a>
                            </li>
                            <li class="w-100">
                                <a href="#" class="btn btn-default mt-4 mb-2 pr-5 pl-5"> Add more apps </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- app user menu -->
            <div>
                <a href="#" data-toggle="dropdown" title="drlantern@gotbootstrap.com" class="header-icon d-flex align-items-center justify-content-center ml-2">
                    <img src="<?=asset('img/demo/avatars/avatar-admin.png')?>" class="profile-image rounded-circle" alt="Dr. Codex Lantern">
                </a>
                <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
                    <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
                        <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
                            <!-- <span class="mr-2">
                                <img src="img/demo/avatars/avatar-admin.png" class="rounded-circle profile-image" alt="Dr. Codex Lantern">
                            </span> -->
                            <div class="info-card-text">
                                <div class="fs-lg text-truncate text-truncate-lg"><?= admin::name?></div>
                                <span class="text-truncate text-truncate-lg opacity-80"><?= admin::email?></span>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider m-0"></div>
                    <a href="#" class="dropdown-item" data-action="app-fullscreen">
                        <span data-i18n="drpdwn.fullscreen">Fullscreen</span>
                        <i class="float-right text-muted fw-n">F11</i>
                    </a>
                    <a href="#" class="dropdown-item" data-action="app-print">
                        <span data-i18n="drpdwn.print">Print</span>
                        <i class="float-right text-muted fw-n">Ctrl + P</i>
                    </a>
                    <div class="dropdown-divider m-0"></div>
                    <a class="dropdown-item fw-500 pt-3 pb-3" href="<?=urlController('auth_controller&submit_action=log_out')?>">
                        <span data-i18n="drpdwn.page-logout">Logout</span>
                        <span class="float-right fw-n">&commat;codexlantern</span>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <!-- END Page Header -->
    <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div> <!-- END Page Content -->
<?php// }?>    
                    