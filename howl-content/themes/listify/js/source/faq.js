(function($) {
	'use strict';

 $.fn.exists = function(callback) {
   var args = [].slice.call(arguments, 1);
   if (this.length) callback.call(this, args);
   return this;
 };

	var faq = {};

 faq.init = function() {
			console.log("faq init");
 };

	faq.init();

})(jQuery);
