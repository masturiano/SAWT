<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><? echo $title; ?></title>

    <!-- Bootstrap Minified Css -->
    <? $bootstrap_min_css = array('application', 'libraries', 'bootstrap','css','bootstrap.min.css'); ?>
    <link href="<? echo base_url($bootstrap_min_css); ?>" rel="stylesheet">
    
    <!-- Html 5 Shiv Minified -->
    <? $html5shiv_min_js = array('application', 'libraries', 'bootstrap','js','html5shiv.min.js'); ?>
    <script src="<? echo base_url($html5shiv_min_js); ?>"></script>
    
    <!-- Respond Minified -->
    <? $respond_min_js = array('application', 'libraries', 'bootstrap','js','respond.min.js'); ?>
    <script src="<? echo base_url($respond_min_js); ?>"></script> 
    
    <!-- Jquery Minified Javascript -->
    <? $jquery_min_js = array('application', 'libraries', 'jquery','js','jquery-1.6.2.min.js'); ?>
    <script src="<? echo base_url($jquery_min_js); ?>"></script>
    <? $jquery_custom_min_js = array('application', 'libraries', 'jquery','js','jquery-ui-1.8.16.custom.min.js'); ?>
    <script src="<? echo base_url($jquery_custom_min_js); ?>"></script>
    
    <!-- Jquery Datepicker -->
    <? $jquery_ui_button_js = array('application', 'libraries', 'jquery','development-bundle','ui','jquery.ui.button.js'); ?>
    <script src="<? echo base_url($jquery_ui_button_js); ?>"></script>
    <? $jquery_ui_datepicker_js = array('application', 'libraries', 'jquery','development-bundle','ui','jquery.ui.datepicker.js'); ?>
    <script src="<? echo base_url($jquery_ui_datepicker_js); ?>"></script>
    
    <!-- Jquery Css -->
    <? $jquery_ui_custom_css = array('application', 'libraries', 'jquery','css','jquery-ui-1.8.16.custom.css'); ?>
    <link href="<? echo base_url($jquery_ui_custom_css); ?>" rel="stylesheet">
    <? $demos_css = array('application', 'libraries', 'jquery','css','demos.css'); ?>
    <link href="<? echo base_url($demos_css); ?>" rel="stylesheet">
    <? $jquery_ui_all_css = array('application', 'libraries', 'jquery','development-bundle','themes','base','jquery.ui.all.css'); ?>
    <link href="<? echo base_url($jquery_ui_all_css); ?>" rel="stylesheet">
    <? $demos_css = array('application', 'libraries', 'jquery','development-bundle','demos','demos.css'); ?>
    <link type="text/css" href="<? echo base_url($demos_css); ?>" />
    
    <!-- Background -->
    <? $menu_css = array('application', 'libraries', 'background','css','styles.css'); ?>
    <link href="<? echo base_url($menu_css); ?>" rel="stylesheet">
    
    <!-- My Style CSS -->
    <? $my_style_css = array('application', 'libraries', 'my_style.css'); ?>
    <link href="<? echo base_url($my_style_css); ?>" rel="stylesheet">
    
    <!-- Foo Table 3 -->
    <? $footable_css = array('application','libraries','foo_table3','src','css','FooTable.css'); ?>
    <link href="<? echo base_url($footable_css); ?>" rel="stylesheet">
    <? $footable_js = array('application', 'libraries','foo_table3','src','js','FooTable.js'); ?>
    <script src="<? echo base_url($footable_js); ?>"></script>
    
    <!-- Javascript -->
    <script type="text/javascript">
        // CHECK SESSION
        function checkSession() {
            $.ajax({
                url: "<?php echo base_url();?>site/check_session",
                type: "GET",
                success: function(Data){
                        eval(Data);
                    }                
               });  
            setTimeout("checkSession()",5000); 
        }    
    </script>
    
  </head>

  <body onload=" checkSession(); startTime();">
  
    <div class="header_bg">
    </div>
    <div class="header_logo">
    </div>
    
    <?php 
    include('view_menu.php');
    ?>
    
    <br />
    
    <div class="grey">
        <div class="container" align="center">
            <div class="well">
                Home            
            </div>
        </div>
    </div>
    
    <div class="container table-responsive toggle-circle-filled">
    
        <div class="panel panel-primary">
            <div class="panel-heading">
                My Table
            </div>
            <!-- table-striped=gray&white -->
            <table class="table table-striped table-hover table-bordered table-condensed" border=1>
                <tr class="info">
                    <th>Cont1</th>
                    <th>Cont2</th>
                    <th>Cont3</th>
                </tr>
                <tbody>
                    <tr>
                        <td>Cont1</td>
                        <td>Cont2</td>
                        <td>Cont3333333333333333333333333333333333333</td>
                    </tr>
                    <tr>
                        <td>Cont1</td>
                        <td>Cont2</td>
                        <td>Cont3</td>
                    </tr>
                    <tr>
                        <td>Cont1</td>
                        <td>Cont2</td>
                        <td>Cont3</td>
                    </tr>
                    <tr>
                        <td>Cont1</td>
                        <td>Cont2</td>
                        <td>Cont3</td>
                    </tr>
                    <tr>
                        <td>Cont1</td>
                        <td>Cont2</td>
                        <td>Cont3</td>
                    </tr>
                    <tr>
                        <td>Cont1</td>
                        <td>Cont2</td>
                        <td>Cont3</td>
                    </tr>
                    <tr>
                        <td>Cont1</td>
                        <td>Cont2</td>
                        <td>Cont3</td>
                    </tr>
                    <tr>
                        <td>Cont1</td>
                        <td>Cont2</td>
                        <td>Cont3</td>
                    </tr>
                </tbody> 
            </table>
        </div>
    
    
        <!-- sm=small, defult=medium, lg=large -->
        <ul class="pagination pagination-sm">
            <li class="disabled"><a href="">&laquo;</a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li class="active"><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href="">5</a></li>
            <li><a href="">6</a></li>
            <li><a href="">&raquo;</a></li>
        </ul>
        
        <hr>
        <ul class="pager">
            <li class="previous"><a href="">&larr;Previous One</a></li>
            <li class="next"><a href="">Next One&rarr;</a></li>
        </ul>
        
        <br />
        
        <div class="container">
<h1>Bootstrap Table Examples <a href="https://github.com/wenzhixin/bootstrap-table-examples" class="btn btn-primary" role="button" target="_blank">Learn more &raquo;</a></h1>
<div id="toolbar">
<button id="remove" class="btn btn-danger" disabled>
<i class="glyphicon glyphicon-remove"></i> Delete
</button>
</div>
<table id="table"
data-toolbar="#toolbar"
data-search="true"
data-show-refresh="true"
data-show-toggle="true"
data-show-columns="true"
data-show-export="true"
data-detail-view="true"
data-detail-formatter="detailFormatter"
data-minimum-count-columns="2"
data-show-pagination-switch="true"
data-pagination="true"
data-id-field="id"
data-page-list="[10, 25, 50, 100, ALL]"
data-show-footer="true"
data-side-pagination="server"
data-url="/examples/bootstrap_table/data"
data-response-handler="responseHandler">
</table>
</div>
<script>
var $table = $('#table'),
$remove = $('#remove'),
selections = [];
$(function () {
$table.bootstrapTable({
height: getHeight(),
columns: [
[
{
field: 'state',
checkbox: true,
rowspan: 2,
align: 'center',
valign: 'middle'
}, {
title: 'Item ID',
field: 'id',
rowspan: 2,
align: 'center',
valign: 'middle',
sortable: true,
footerFormatter: totalTextFormatter
}, {
title: 'Item Detail',
colspan: 3,
align: 'center'
}
],
[
{
field: 'name',
title: 'Item Name',
sortable: true,
editable: true,
footerFormatter: totalNameFormatter,
align: 'center'
}, {
field: 'price',
title: 'Item Price',
sortable: true,
align: 'center',
editable: {
type: 'text',
title: 'Item Price',
validate: function (value) {
value = $.trim(value);
if (!value) {
return 'This field is required';
}
if (!/^$/.test(value)) {
return 'This field needs to start width $.'
}
var data = $table.bootstrapTable('getData'),
index = $(this).parents('tr').data('index');
console.log(data[index]);
return '';
}
},
footerFormatter: totalPriceFormatter
}, {
field: 'operate',
title: 'Item Operate',
align: 'center',
events: operateEvents,
formatter: operateFormatter
}
]
]
});
// sometimes footer render error.
setTimeout(function () {
$table.bootstrapTable('resetView');
}, 200);
$table.on('check.bs.table uncheck.bs.table ' +
'check-all.bs.table uncheck-all.bs.table', function () {
$remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
// save your data, here just save the current page
selections = getIdSelections();
// push or splice the selections if you want to save all data selections
});
$table.on('expand-row.bs.table', function (e, index, row, $detail) {
if (index % 2 == 1) {
$detail.html('Loading from ajax request...');
$.get('LICENSE', function (res) {
$detail.html(res.replace(/\n/g, '<br>'));
});
}
});
$table.on('all.bs.table', function (e, name, args) {
console.log(name, args);
});
$remove.click(function () {
var ids = getIdSelections();
$table.bootstrapTable('remove', {
field: 'id',
values: ids
});
$remove.prop('disabled', true);
});
$(window).resize(function () {
$table.bootstrapTable('resetView', {
height: getHeight()
});
});
});
function getIdSelections() {
return $.map($table.bootstrapTable('getSelections'), function (row) {
return row.id
});
}
function responseHandler(res) {
$.each(res.rows, function (i, row) {
row.state = $.inArray(row.id, selections) !== -1;
});
return res;
}
function detailFormatter(index, row) {
var html = [];
$.each(row, function (key, value) {
html.push('<p><b>' + key + ':</b> ' + value + '</p>');
});
return html.join('');
}
function operateFormatter(value, row, index) {
return [
'<a class="like" href="javascript:void(0)" title="Like">',
'<i class="glyphicon glyphicon-heart"></i>',
'</a> ',
'<a class="remove" href="javascript:void(0)" title="Remove">',
'<i class="glyphicon glyphicon-remove"></i>',
'</a>'
].join('');
}
window.operateEvents = {
'click .like': function (e, value, row, index) {
alert('You click like action, row: ' + JSON.stringify(row));
},
'click .remove': function (e, value, row, index) {
$table.bootstrapTable('remove', {
field: 'id',
values: [row.id]
});
}
};
function totalTextFormatter(data) {
return 'Total';
}
function totalNameFormatter(data) {
return data.length;
}
function totalPriceFormatter(data) {
var total = 0;
$.each(data, function (i, row) {
total += +(row.price.substring(1));
});
return '$' + total;
}
function getHeight() {
return $(window).height() - $('h1').outerHeight(true);
}
</script>

    </div>

  </body>
</html>