$(function(){$("#datatables1").dataTable({bProcessing:!0,sAjaxSource:"js/datatables/objects.txt",aoColumns:[{mData:"engine"},{mData:"browser"},{mData:"platform"},{mData:"version"},{mData:"grade"}]}),$("#datatables2").dataTable({sDom:"<'row-fluid'<'span6'T><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",bProcessing:!0,sAjaxSource:"js/datatables/objects.txt",aoColumns:[{mData:"engine"},{mData:"browser"},{mData:"platform"},{mData:"version"},{mData:"grade"}],oTableTools:{aButtons:["copy","print","pdf","csv"],sSwfPath:"js/datatables/tabletools/swf/copy_csv_xls_pdf.swf"}}),$("#datatables3").dataTable({bProcessing:!0,sAjaxSource:"js/datatables/objects.txt",aoColumns:[{mData:"engine"},{mData:"browser"},{mData:"platform"},{mData:"version"},{mData:"grade"}],sDom:"RC<'clearfix'>'<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",aoColumnDefs:[{bVisible:!1,aTargets:[2]}],oLanguage:{sSearch:"Search:"},bSortCellsTop:!0}),$(".syncronize .themes-choice > a, .unsyncronize .themes-navbar > a").on("click",function(e){e.preventDefault();var t=$(this).attr("data-theme");$.each($(".widget"),function(){var e=$(this),n=e.find(".widget-header"),r=e.find(".widget-action");e.is('[class*="border-"]')&&e.attr("class","widget border-"+t),e.is('[class*="bg-"]')&&e.attr("class","widget bg-"+t),n.is('[class*="bg-"]')&&n.attr("class","widget-header bg-"+t),r.is('[class*="color-"]')&&r.attr("class","widget-action color-"+t)})})});