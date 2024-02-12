<?php
//$arrData = executeSelect('category',array(),array(),'id desc');
?>
<main id="js-page-content" role="main" class="page-content">
                        <!-- <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">SmartAdmin</a></li>
                            <li class="breadcrumb-item">Datatables</li>
                            <li class="breadcrumb-item active">AltEditor (beta)</li>
                            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
                        </ol>
                        <div class="subheader">
                            <h1 class="subheader-title">
                                <i class='subheader-icon fal fa-table'></i> DataTables: <span class='fw-300'>AltEditor (beta)</span> <sup class='badge badge-primary fw-500'>ADDON</sup>
                                <small>
                                    Custom made editor plugin designed for Datatables
                                </small>
                            </h1>
                        </div> -->
                        <!-- <div class="alert alert-primary">
                            <div class="d-flex flex-start w-100">
                                <div class="mr-2 hidden-md-down">
                                    <span class="icon-stack icon-stack-lg">
                                        <i class="base base-2 icon-stack-3x opacity-100 color-primary-500"></i>
                                        <i class="base base-2 icon-stack-2x opacity-100 color-primary-300"></i>
                                        <i class="fal fa-info icon-stack-1x opacity-100 color-white"></i>
                                    </span>
                                </div>
                                <div class="d-flex flex-fill">
                                    <div class="flex-fill">
                                        <span class="h5">About</span>
                                        <p>
                                            DataTables AltEditor is a MIT licensed free editor. The plugin adds capabilities to add, edit and delete rows in your datatables through the use of modals. We have modified the editor extensively to be used with SmartAdmin WebApp and make your job a little easier. This current version of AltEditor is exclusive to SmartAdmin and we intend to keep it up to date to be compatible with DataTables.
                                        </p>
                                        <p class="m-0">
                                            You can find the definitions of its elements on their <a href="https://github.com/KasperOlesen/DataTable-AltEditor" target="_blank">official github</a> page. Note: Only use the exclusive plugin included with this WebApp as the one on github may not be compatible with SmartAdmin.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            Example <span class="fw-300"><i>Table</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <!-- <div class="panel-tag">
                                                <p>
                                                    Datatable accepts the following callback functions as arguments: <code>onAddRow(datatable, rowdata, success, error)</code>, <code>onEditRow(datatable, rowdata, success, error)</code>, <code>onDeleteRow(datatable, rowdata, success, error)</code>
                                                </p>
                                                <p>
                                                    In the most common case, these function should call <code>$.ajax </code>as expected by the webservice. The two functions success and error should be passed as arguments to <code>$.ajax</code>. Webservice must return the modified row in JSON format, because the success() function expects this. Otherwise you have to write your own success() callback (e.g. refreshing the whole table).
                                                </p>
                                            </div> -->
                                            <!-- tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active p-3" data-toggle="tab" href="#tab_default-1" role="tab">
                                                        <i class="fal fa-table text-success"></i>
                                                        <span class="hidden-sm-down ml-1">Alt-Editor Example</span>
                                                    </a>
                                                </li>
                                                <!-- <li class="nav-item">
                                                    <a class="nav-link p-3" data-toggle="tab" href="#tab_default-2" role="tab">
                                                        <i class="fal fa-cog text-info"></i>
                                                        <span class="hidden-sm-down ml-1">Supported Modifiers</span>
                                                    </a>
                                                </li> -->
                                            </ul>
                                            <!-- end tabs -->
                                            <!-- tab content -->
                                            <div class="tab-content pt-4">
                                                <div class="tab-pane fade show active" id="tab_default-1" role="tabpanel">
                                                    <!-- row -->
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <!-- datatable start -->
                                                            <table id="category_datatable" class="table table-bordered table-hover table-striped w-100">
                                                            <thead>
                                                                <tr>
                                                                    <!-- <th>#ID</th> -->
                                                                    <th>Category</th>
                                                                    <th>Text</th>
                                                                    <!-- <th width="80%">Images</th> -->
                                                                    <!-- <th>Action</th> -->
                                                                </tr>
                                                            </thead>
                                                            </table>
                                                            <!-- datatable end -->
                                                        </div>
                                                        <!-- <div class="col-xl-12">
                                                            <hr class="mt-5 mb-5">
                                                            <h5>Event <i>logs (AJAX Calls)</i></h5>
                                                            <div id="app-eventlog" class="alert alert-primary p-1 h-auto my-3"></div>
                                                        </div> -->
                                                    </div>
                                                    <!-- end row -->
                                                </div>
                                            </div>
                                            <!-- end tab content -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                 
<script>
    document.addEventListener("DOMContentLoaded", function(event) { 
        fetch_all_category();
    });
</script>                     