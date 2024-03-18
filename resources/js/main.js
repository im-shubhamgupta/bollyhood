function ajax_url(url){
    console.log(site_url);
	return site_url+'/ajax/'+url;
}
function is_valid(val){
    console.log(val);
    if(val=='' || val==null || val == undefined || val.length < 0 || isNaN(val)==true) {
        return true;
    }else{
        return false;
    }
}
function is_valid_number(val){
    if(Number.isInteger(val)) {
        return true;
    }else{
        return false;
    }
}
function redirect(action_val){
    window.location.href=site_url+'?action='+action_val;
}
"use strict"; 
$(document).ready(function(){
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
        }
    //login form validate
    $("#js-login-btn").click(function(event){
        // Fetch form to apply custom Bootstrap validation
        var form = $("#js-login")
        if (form[0].checkValidity() === false)
        {
            event.preventDefault()
            event.stopPropagation()
        }
        form.addClass('was-validated');
        // Perform ajax submit here...
    });
}); 

$(document).on('submit',"#mod_category",function(e){
    var cat = $('#category_name').val();
    // if(is_valid(cat)){
    if(cat == '' || cat.length < 0){
        $("#cat_error").html("*Category field required");
        return false;
    }else{
        // e.preventDefault();
        
    }

});
// function add_user(self){
$(document).on('submit',"#add_user",function(e){
    e.preventDefault();    
   var formData = new FormData(this);
   formData.append("ajax_action",'add_user');
   var btn_name = $('button[type="submit"]').text(); 
   $.ajax({
            url:ajax_url("ajaxHandller.php "),
            type:"POST",
            data:formData,
            dataType: 'JSON',
            contentType:false,
            cache:false,
            processData:false,
            beforeSend: function() {
                $('button[type="submit"]').html("please wait...").attr("disabled", true);  
            },
            complete: function() {
                $('button[type="submit"]').html(btn_name).attr("disabled", false); 
            },
            success:function(data) {
                if(data.check == 'success' ){
                    toastr["success"](data.msg);
                    // toastr.options.onHidden = function() {
                    //      alert(123);
                    // }
                    redirect('users');
                    
                }else{
                    Command: toastr["error"](data.msg);
                }
            }
    });
})  
$(document).on('submit',"#mod_expertise",function(e){
    e.preventDefault();    
   var formData = new FormData(this);
   formData.append("ajax_action",'mod_expertise');
   var btn_name = $('button[type="submit"]').text(); 
   $.ajax({
            url:ajax_url("ajaxHandller.php "),
            type:"POST",
            data:formData,
            dataType: 'JSON',
            contentType:false,
            cache:false,
            processData:false,
            beforeSend: function() {
                $('button[type="submit"]').html("please wait...").attr("disabled", true);  
            },
            complete: function() {
                $('button[type="submit"]').html(btn_name).attr("disabled", false); 
            },
            success:function(data) {
                if(data.check == 'success' ){
                    toastr["success"](data.msg);
                    // toastr.options.onHidden = function() {
                    //      alert(123);
                    // }
                    redirect('expertise');
                    
                }else{
                    Command: toastr["error"](data.msg);
                }
            }
    });
})

$(document).on('submit',"#mod_banner",function(e){
    e.preventDefault();    
   var formData = new FormData(this);
   formData.append("ajax_action",'add_banner');
   var btn_name = $('button[type="submit"]').text(); 
   $.ajax({
            url:ajax_url("ajaxHandller.php "),
            type:"POST",
            data:formData,
            dataType: 'JSON',
            contentType:false,
            cache:false,
            processData:false,
            beforeSend: function() {
                $('button[type="submit"]').html("Uploading...").attr("disabled", true);  
            },
            complete: function() {
                $('button[type="submit"]').html(btn_name).attr("disabled", false); 
            },
            success:function(data) {
                if(data.check == 'success' ){
                    // toastr.options.onHidden = function() { alert(123); }
                    toastr["success"](data.msg);
                    redirect('banner');
                }else{
                    Command: toastr["error"](data.msg);
                }
            }
    });
})
function delete_banner(self){
    var id = $(self).data('id');
    if(confirm("Are you sure want to delete")){
        if(!is_valid_number(id)){
            return false;
        }
        $.ajax({
                url:ajax_url("ajaxHandller.php "),
                type:"POST",
                data:{
                    id : id,
                    ajax_action: "delete_banner"
                },
                dataType: 'JSON',
                success:function(data) {
                    if(data.check == 'success' ){
                        toastr["success"](data.msg);
                        location.reload();
                        // toastr.options.onHidden = function() {
                        // }
                        //$('#banner_Datatable').DataTable().destroy();
                        // $('#banner_Datatable').dataTable().fnDestroy();
                    }else{
                        Command: toastr["error"](data.msg);
                    }
                }
        });
    }    
} 
function delete_user(self){
    var id = $(self).data('id');
    if(confirm("Are you sure want to delete")){
        if(!is_valid_number(id)){
            return false;
        }
        $.ajax({
                url:ajax_url("ajaxHandller.php "),
                type:"POST",
                data:{
                    id : id,
                    ajax_action: "delete_user"
                },
                dataType: 'JSON',
                success:function(data) {
                    if(data.check == 'success' ){
                        toastr["success"](data.msg);
                        location.reload();
                        
                    }else{
                        Command: toastr["error"](data.msg);
                    }
                }
        });
    }    
} 
function delete_category(self){
    var id = $(self).data('id');
    if(confirm("Are you sure want to delete")){
        if(!is_valid_number(id)){
            return false;
        }
        $.ajax({
                url:ajax_url("ajaxHandller.php "),
                type:"POST",
                data:{
                    id : id,
                    ajax_action: "delete_category"
                },
                dataType: 'JSON',
                success:function(data) {
                    if(data.check == 'success' ){
                        toastr["success"](data.msg);
                        location.reload();
                    }else{
                        Command: toastr["error"](data.msg);
                    }
                }
        });
    }    
}
function delete_expertise(self){
    var id = $(self).data('id');
    if(confirm("Are you sure want to delete")){
        if(!is_valid_number(id)){
            return false;
        }
        $.ajax({
                url:ajax_url("ajaxHandller.php "),
                type:"POST",
                data:{
                    id : id,
                    ajax_action: "delete_expertise"
                },
                dataType: 'JSON',
                success:function(data) {
                    if(data.check == 'success' ){
                        toastr["success"](data.msg);
                        location.reload();
                        
                    }else{
                        Command: toastr["error"](data.msg);
                    }
                }
        });
    }    
}	
function all_documents_datatable(){
    $('#document_datatable').dataTable({
        "lengthMenu": [ [10, 25, 50, 100,-1], [10, 25, 50, 100,'All'] ],
        'order':[0,'DESC'],
        responsive: true,
        lengthChange: false,
        dom:
            "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                titleAttr: 'Generate PDF',
                className: 'btn-outline-danger btn-sm mr-1'
            },
            {
                extend: 'excelHtml5',
                text: 'Excel',
                titleAttr: 'Generate Excel',
                className: 'btn-outline-success btn-sm mr-1'
            },
            {
                extend: 'csvHtml5',
                text: 'CSV',
                titleAttr: 'Generate CSV',
                className: 'btn-outline-primary btn-sm mr-1'
            },
            {
                extend: 'copyHtml5',
                text: 'Copy',
                titleAttr: 'Copy to clipboard',
                className: 'btn-outline-primary btn-sm mr-1'
            },
            {
                extend: 'print',
                text: 'Print',
                titleAttr: 'Print Table',
                className: 'btn-outline-primary btn-sm'
            }
        ],
        "processing": true,
            "serverSide": true,
            "scrollX": true,
            "ajax":{
                'url' :site_url + 'ajax/ajaxHandller.php', 
                'type': "post",
                'data' : {
                    'ajax_action' : 'fetch_document_data' 
                }
                // 'data': function(d){
                // // // ClassType: classtype,
                // // d.custom = custom_params() 
                // },
        },
    });
    
}    

function all_users_datatable(){
    $('#datas_datatable').dataTable({
        "lengthMenu": [ [10, 25, 50, 100,-1], [10, 25, 50, 100,'All'] ],
        'order':[0,'DESC'],
        responsive: true,
        lengthChange: false,
        dom:
            "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        buttons: [
            /*{
                extend:    'colvis',
                text:      'Column Visibility',
                titleAttr: 'Col visibility',
                className: 'mr-sm-3'
            },*/
            {
                extend: 'print',
                text: 'Print',
                titleAttr: 'Print Table',
                className: 'btn-outline-primary btn-sm'
            }
        ],
        "processing": true,
            "serverSide": true,
            "scrollX": true,
            "ajax":{
                'url' :site_url + 'ajax/ajaxDatatable.php', 
                'type': "post",
                'data' : {
                    'ajax_action' : 'fetch_all_users' 
                }
        },
    });
}

function fetch_all_category(){
    $('#category_datatable').dataTable({
        "lengthMenu": [ [10, 25, 50, 100,-1], [10, 25, 50, 100,'All'] ],
        'order':[0,'DESC'],
        responsive: true,
        lengthChange: false,
        dom:
            "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "columnDefs": [
            {"className": "text-center", "targets": "_all"}
            ],
        buttons: [
            {
                extend: 'print',
                text: 'Print',
                titleAttr: 'Print Table',
                className: 'btn-outline-primary btn-sm'
            }
        ],
        "processing": true,
            "serverSide": true,
            "scrollX": true,
            "ajax":{
                'url' :site_url + 'ajax/ajaxDatatable.php', 
                'type': "post",
                'data' : {
                    'ajax_action' : 'fetch_all_category' 
                }
        },
    });
}
function load_all_expertise_datatable(){
    $('#expertise_datatable').dataTable({
        "lengthMenu": [ [10, 25, 50, 100,-1], [10, 25, 50, 100,'All'] ],
        "ordering": false,
        'order':[0,'DESC'],
        responsive: true,
        lengthChange: false,
        dom:
            "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        buttons: [
            {
                extend: 'print',
                text: 'Print',
                titleAttr: 'Print Table',
                className: 'btn-outline-primary btn-sm'
            }
        ],
        "processing": true,
            "serverSide": true,
            "scrollX": true,
            "ajax":{
                'url' :ajax_url('ajaxDatatable.php'), 
                'type': "post",
                'data' : {
                    'ajax_action' : 'fetch_all_expertise' 
                }
        },
    });
}


