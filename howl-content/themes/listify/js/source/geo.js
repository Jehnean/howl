(function($, google) {
	'use strict';

 $.fn.exists = function(callback) {
   var args = [].slice.call(arguments, 1);
   if (this.length) callback.call(this, args);
   return this;
 };

	var geo = {};

 geo.location = {
   "lat": 0,
   "lng": 0
 };

 geo.location.updateHtml = function($elem, location){
   var $address = $elem.find(".address");
   if(typeof location !== "undefined"){
    $address.html(location.city + ", " + location["region_code"]);
    //$action.html();
   }
 };

 geo.location.freegeoip = function($elem){
   $.getJSON('https://freegeoip.net/json/')
   .done(function(location) {
      geo.location.updateHtml($elem, location);
   });
 };

 function arrHas(check){
   return typeof check !== "undefined";
 }

 function getGoogleAddress($elem, myLatitude, myLongitude) {

   var geocoder = new google.maps.Geocoder(); // create a geocoder object
   var location = new google.maps.LatLng(myLatitude, myLongitude); // turn coordinates into an object

   geocoder.geocode({
     'latLng': location
   }, function(results, status) {
     var city = "",
         state = "",
         addr = "",
         $address = $elem.find(".address");
     if (status == google.maps.GeocoderStatus.OK) {
       // if geocode success
       // if address found, pass to processing function
       var hasResult = false;

       if(arrHas(results[1])){
         if(arrHas(results[1]["address_components"])){
           addr = results[1]["address_components"];
           if(addr){
             city = addr[0]["long_name"];
             state = addr[2]["short_name"];
             hasResult = true;
           }
         }
       }

       if(hasResult){
         $address.html(city + ", " + state);
       }else{
         $address.html("");
         geo.location.freegeoip($elem);
       }
     } else {
       $address.html("");
       geo.location.freegeoip($elem);
       return false;
     }
   });
 }

function getBrowserLatLng($elem){


  // function to get lat/long and plot on a google map
  function success(position) {
    var latitude = position.coords.latitude; // set latitude variable
    var longitude = position.coords.longitude; // set longitude variable
    getGoogleAddress($elem, latitude, longitude); // geocode the lat/long into an address
  }


  navigator.geolocation.getCurrentPosition(success);
}

 geo.location.gmaps = function($elem){
   var $address = $elem.find(".address");
   if (navigator.geolocation) {
     getBrowserLatLng($elem);
     // if geolocation supported, call function
   } else {
     $address.html("");
     geo.location.freegeoip($elem);
   }
 };

 geo.location.get = function($elem, format, action){
   switch (action) {
    case "freegeoip":
       geo.location.freegeoip($elem);
     break;
    case "google":
       geo.location.gmaps($elem);
     break;
   }
 };

 geo.location.change = function($elem, action){
   var $address = $elem.find(".address");
   var format = $address.attr("data-format");
   var $action = $elem.find(".action");
   var actionText = $action.attr("data-action");
   var action = (typeof actionText !== "undefined") && (actionText.length > 0) ? actionText : action;
   geo.location.get($elem, format, action);
 };

 geo.event = {};
 geo.event.assign = function($elem, action){
   $($elem).on("click", function(e){
      e.preventDefault();
      geo.location.change($(this), action);
   });
 };

 geo.init = function() {
   var $geos = $('.geo-location');
   var action = "freegeoip";
   $geos.exists(function() {
     console.log("geo.init");
     this.each(function(index, $geo){
        geo.event.assign($geo, action);
        geo.location.change($($geo), action);
     });
   });
 };

	geo.init();

})(jQuery, google);
