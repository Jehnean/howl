(function( $ ) {
	$(function() {
		var url = FindPros.url + "?action=findpros_search";
		$( "#search_keywords" ).autocomplete({
			source: url,
			delay: 500,
			minLength: 3,
   select: function(event, ui) {
       var origEvent = event;
       while (origEvent.originalEvent !== undefined){
           origEvent = origEvent.originalEvent;
       }
       if (origEvent.type == 'click'){
           if(ui.item){
               setTimeout(function () {
                 $('#search_keywords').val(ui.item.value);
                 $('.job_search_form').submit();
               }, 1);
           }
       } else {
           if(ui.item){
               $('#search_keywords').val(ui.item.value);
               $('.job_search_form').submit();
           }
       }
   }
		});
	});

})( jQuery );
