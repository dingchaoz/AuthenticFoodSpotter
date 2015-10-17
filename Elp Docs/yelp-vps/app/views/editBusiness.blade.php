@extends('layout')

@section('title','Edit ')

@section('content')
<div class="container full-content">
<div class="row">
<div class="col-md-6 col-md-offset-3">
  <form action="{{URL::route('updateBusinessRequest',array('id'=>$business->id))}}" method="post">

  	<label> Business Name </label>
  	<input type="text" class="form-control" name="name" value="{{$business->name}}" required>
  	<div id="locationField" class="form-group">
        <label>Enter your address</label>
        <p> Use this input box to search the place in map </p>
        <input class="form-control" id="autocomplete" placeholder="Enter your address"
               onFocus="geolocate()" type="text"></input>
      </div>
      <div id="map-canvas" style="width: 400px; height: 200px;"></div>
      <div id="address" class="form-group">
          <label>Door Number</label>
          <input class="field form-control" id="street_number" value="{{$business->street_no}}" name="street_number"></input>
      </div>
      <div class="form-group">
          <label> Street Name </label>
          <input class="field form-control" id="route" name="street_name" value="{{$business->street_name}}"></input>
      </div>
      <div class="form-group">
          <label>City</label>
          <input class="field form-control" id="locality" name="city" value="{{$business->city->label}}"></input>
      </div>
      <div class="form-group">
          <label>State</label>
          <input class="field form-control" id="administrative_area_level_1" name="state" value="{{$business->state->label}}"></input>
          <label>Zip code</label>
          <input class="field form-control" id="postal_code" name="zipcode" value="{{$business->zipcode}}"></input>
      </div>
      <div class="form-group">
          <label>Country</label>
          <input class="field form-control"  name="country" id="country" value="{{$business->country->label}}"></input>
      </div>
      <input type="text" id="latitude" name="lat" hidden="true" value="{{$business->lat}}" required>
      <input type="text" id="longitude" name="lon" hidden="true" value="{{$business->lon}}" required>


      
 <div class="form-group">
  <label> Phone Number </label>
  <input type="text" class="form-control" name="phone" value="{{$business->phone}}">
 </div>
 <div class="form-group">
  <label> Website </label>
  <input type="url" class="form-control" name="website" value="{{$business->website}}">
 </div>
  <input class="btn btn-md btn-primary" type="submit" value="Save Changes">
  </form>
</div>
</div>
</div>
@stop

@section('script')

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
    <script>
// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

var placeSearch, autocomplete;
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function getSubCategory(id)
{
	$.ajax({
		url: "{{URL::to('getSubcategory')}}/"+id,
	}).done(function(data){
    $('#sub_category').html(data);
	});
}


$(document).ready(function(){

	


  // Create the autocomplete object, restricting the search
  // to geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
      /** @type {HTMLInputElement} */(document.getElementById('autocomplete')),
      { types: ['geocode'] });
  // When the user selects an address from the dropdown,
  // populate the address fields in the form.
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    fillInAddress();
  });

  var mapOptions = {
    zoom: 6
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  // if(navigator.geolocation) {
  //   navigator.geolocation.getCurrentPosition(function(position) {
  //     var pos = new google.maps.LatLng(position.coords.latitude,
  //                                      position.coords.longitude);


  //     map.setCenter(pos);
  //   }, function() {
  //     handleNoGeolocation(true);
  //   });
  // }
  
  var newLatLng = new google.maps.LatLng('{{$business->lat}}','{{$business->lon}}');

  var marker = new google.maps.Marker({
      position: newLatLng,
      map: map,
      draggable: true,
      title: '{{$business->name}}'
  });

  map.setCenter(newLatLng);

  map.setZoom(18);

  google.maps.event.addListener(marker, 'dragend', function(ev){
    $('#latitude').val(marker.getPosition().lat());
    $('#longitude').val(marker.getPosition().lng());
});

});



// [START region_fillform]
function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

console.log(place.geometry.location.lat());

console.log(place.geometry.location.lng());

var newLatLng = new google.maps.LatLng(place.geometry.location.lat(),place.geometry.location.lng());

  var marker = new google.maps.Marker({
      position: newLatLng,
      map: map,
      draggable: true,
      title: '{{$business->name}}'
  });

  $('#latitude').val(marker.getPosition().lat());
  $('#longitude').val(marker.getPosition().lng());

  google.maps.event.addListener(marker, 'dragend', function(ev){
    $('#latitude').val(marker.getPosition().lat());
    $('#longitude').val(marker.getPosition().lng());
});

  map.setCenter(newLatLng);

  map.setZoom(18);

//console.log(place.geometry.location.toString());

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = new google.maps.LatLng(
          position.coords.latitude, position.coords.longitude);
      autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,
          geolocation));
    });
  }
}
// [END region_geolocation]
 $('#category').change(function(){
    var val = $('#category').val();
    getSubCategory(val);
  });




    </script>


@stop