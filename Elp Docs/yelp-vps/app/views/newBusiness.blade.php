@extends('layout')

@section('title','Add New Business')

@section('content')
<div class="container full-content">
<div class="row">
<div class="col-md-6 col-md-offset-3">
  <form action="{{URL::route('addBusiness')}}" method="post">

  	<label> Business Name </label>
  	<input type="text" class="form-control" name="name" required>
  	<div id="locationField" class="form-group">
        <label>Enter your address</label>
        <p> Use this input box to search the place in map </p>
        <input class="form-control" id="autocomplete" placeholder="Enter your address"
               onFocus="geolocate()" type="text"></input>
      </div>
      <div id="map-canvas" style="width: 400px; height: 200px;"></div>
      <div id="address" class="form-group">
          <label>Street Number</label>
          <input class="field form-control" id="street_number"  name="street_number" disabled="true"></input>
      </div>
      <div class="form-group">
          <label> Street Name </label>
          <input class="field form-control" id="route" name="street_name" disabled="true"></input>
      </div>
      <div class="form-group">
          <label>City</label>
          <input class="field form-control" id="locality" name="city" disabled="true"></input>
      </div>
      <div class="form-group">
          <label>State</label>
          <input class="field form-control" id="administrative_area_level_1" disabled="true" name="state"></input>
          <label>Zip code</label>
          <input class="field form-control" id="postal_code" name="zipcode" disabled="true"></input>
      </div>
      <div class="form-group">
          <label>Country</label>
          <input class="field form-control"  name="country" id="country" disabled="true"></input>
      </div>
      <input type="text" id="latitude" name="lat" hidden="true" required>
      <input type="text" id="longitude" name="lon" hidden="true" required>


      
 <div class="form-group">
  <label> Phone Number </label>
  <input type="text" class="form-control" name="phone">
 </div>
 <div class="form-group">
  <label> Website </label>
  <input type="url" class="form-control" name="website">
 </div>
 <div class="form-group">
  <label> Category </label>
  <select name="category" class="form-control" id="category"  required>
    <option selected="selected"> Choose a category </option>
      @foreach($categories as $category)
      	<option value="{{$category->id}}" class="category" onclick="getSubcategory({{$category->id}})"> {{$category->category_name}} </option>
      @endforeach
  </select>
  </div>
  <div class="form-group">
  <label> Sub Category </label>
  <select name="sub_category" class="form-control" id="sub_category" required>
  </select>
  </div>
  <div class="form-group">
  <input type="checkbox" name="featured" value="true"> Make it as featured listing ( ${{Config::get('settings.featuredAdCost')}} /month) <br>
  </div>
  <input type="submit" value="Add Business" class="btn btn-primary">
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

  // Try HTML5 geolocation
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude,
                                       position.coords.longitude);


      map.setCenter(pos);
    }, function() {
      handleNoGeolocation(true);
    });
  }

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
      title: 'Hello World!'
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