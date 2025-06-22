(function($) {
"use strict";
$( document ).ready( function () { 
     $("body").on("change",".pdfcreator_formwidget",function(){
          var form_ids = $(this).val();
          $("#pdfcreator_formwidget_entry").html("<option>Loading...</option>");
          $.ajax({
             url: ajaxurl,
             'type': "POST",
             data: {
                 action: 'yeepdf_el_get_entries',
                 form_ids: form_ids
             },
             success: function(msg){
                    var ot = '<option value="0">Sample to show</option>';
                    ot += msg;
                  $("#pdfcreator_formwidget_entry").html(ot);
              }
         });
     })
})
})(jQuery);