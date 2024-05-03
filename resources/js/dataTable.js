function refresh_tab(){
        $('#sub_category_datatable').DataTable().ajax.reload();
        // $('#sub_category_datatable').DataTable().clear().draw();
    }
function load_all_sub_category(){ 
    
    var table = $('#sub_category_datatable').dataTable({
        "lengthMenu": [ [10, 25, 50, 100,-1], [10, 25, 50, 100,'All'] ],
        "ordering": false,
        // 'order':[0,'DESC'],
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
        "createdRow": function (row, data, dataIndex) {
            // Example of adding rowspan to the first column
            // console.log($('td:eq(1)', row).remove());


            // console.log(data);
            // console.log(dataIndex);
            // if (dataIndex === 1) {
            //     $('td:eq(1)', row).attr('rowspan', '2');
            // }
            // this.DataTable().draw();

        },
        "drawCallback": function( settings ) {
            $('<li><a onclick="refresh_tab()" class="btn btn-primary fa fa-refresh">REfresh</a></li>').prependTo('div.dataTables_paginate ul.pagination');
        },
        // "columns": [
        //     { "data": "name" },
        //     { "data": "position" },
        //     { "data": "office" },
        //     { "data": "age" },
        //     { "data": "start_date" },
        //     { "data": "salary" }
        // ],
        "initComplete": function () {
            // Apply rowspan after data is loaded
            applyRowspan();
        },
        "processing": true,
            "serverSide": true,
            "scrollX": true,
            "ajax":{
                'url' :ajax_url('ajaxDatatable.php'), 
                'type': "post",
                'data' : {
                    'ajax_action' : 'fetch_all_sub_category' 
                },
        //          "dataSrc": function (json) {
        //         // Manipulate your JSON data here if needed
        //             return json;
        //         }
        },
    });
    

        // table.rows().invalidate('dom').draw();
               
    // $('#sub_category_datatable').DataTable().ajax.reload();
}
function applyRowspan() {
    // alert(1);
        // Example: Apply rowspan to the first cell of the first row
        // $('#sub_category_datatable tbody tr:first-child td:nth-child(2)').attr('rowspan', 2);
        
        // Redraw the DataTable
        // table.draw();
        // table.rows().invalidate('dom').draw();
    }

function load_all_subscription_plans(){
    // alert(12);
    $('#plans_datatable').dataTable({
        "lengthMenu": [ [10, 25, 50, 100,-1], [10, 25, 50, 100,'All'] ],
        // 'order':[0,'DESC'],
        "ordering" : false,
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
                'url' : ajax_url('ajaxDatatable.php'), 
                'type': "post",
                'data' : {
                    'ajax_action' : 'fetch_all_subscription_plans' 
                }
        },
    });
}
function load_all_bookings(){
    $('#booking_datatable').dataTable({
        "lengthMenu": [ [10, 25, 50, 100,-1], [10, 25, 50, 100,'All'] ],
        // 'order':[0,'DESC'],
        "ordering" : false,
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
                'url' : ajax_url('ajaxDatatable.php'), 
                'type': "post",
                'data' : {
                    'ajax_action' : 'fetch_all_bookings' 
                }
        },
    });
}
function load_all_casting(){
    $('#casting_datatable').dataTable({
        "lengthMenu": [ [10, 25, 50, 100,-1], [10, 25, 50, 100,'All'] ],
        // 'order':[0,'DESC'],
        "ordering" : false,
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
                'url' : ajax_url('ajaxDatatable.php'), 
                'type': "post",
                'data' : {
                    'ajax_action' : 'fetch_all_castings' 
                }
        },
    });
}
function load_all_casting_apply(){
    $('#casting_datatable').dataTable({
        "lengthMenu": [ [10, 25, 50, 100,-1], [10, 25, 50, 100,'All'] ],
        // 'order':[0,'DESC'],
        "ordering" : false,
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
                'url' : ajax_url('ajaxDatatable.php'), 
                'type': "post",
                'data' : {
                    'ajax_action' : 'fetch_all_casting_apply' 
                }
        },
    });
}