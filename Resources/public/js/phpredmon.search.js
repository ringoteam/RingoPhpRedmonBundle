$(document).ready(function() {
   $('.select').click(function(){
       if($('input[type=checkbox]:checked').length == 0) {
           $('input[type=checkbox]').prop('checked', true);
       }else {

           $('input[type=checkbox]').removeAttr('checked');

       }

   });
});