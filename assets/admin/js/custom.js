jQuery(document).ready(function(){
	var base_url = $('#base_url').val();
	$(document).on('click', '.dd_fields_action', function(e) {
		var form_contianer='form_contianer_update';
		e.preventDefault();
		var action = $(this).data('action');
		var name = '', type = '', arr = {};
		var bool = true;
		if(action=='create'){
		var form_contianer='form_contianer_add';
		}
		if(action == 'create' || action == 'update'){
			$('.'+form_contianer+' .dd_fields_creator').each(function(k, v){
				name = $(this).attr('name');
				if($(this).val() == ''){
					bool = false;
				}
				if($(this).attr('type') == 'checkbox'){
					if($(this).prop("checked") == true)
						arr[name] = 1;
					else
						arr[name] = 0;
				}else{
					arr[name] = $(this).val();
				}
			});
			
			
			var dd_field_type= $('.'+form_contianer+' .dd_field_type').val();
			if(dd_field_type == 'select' || dd_field_type == 'checkbox' || dd_field_type == 'radio'){
				var options = [];
				$('.'+form_contianer+' .dd_fields_creator_option').each(function(k, v){
					if($(this).val() == ''){
						bool = false;
					}
					options.push( $(this).val() );
				});
				arr['options'] = options;
			}
		}
		if(action == 'update' || action == 'delete'){
			if(!confirm('Are you sure?')){
				return false;
			}
			var field_id = $(this).data('field_id');
			arr['field_id'] = field_id;
		}
		if(bool === false){
			toastr.error("All fields are required.");
			return false;
		}
		arr['action'] = action;
		$.ajax({
			type:'post',
			url : base_url+'admin/fields',
			data: arr,
			success:function(response){
				var result = jQuery.parseJSON(response);
				if(result.status){
					toastr.success(result.msg);
					//setTimeout(function(){location.reload();},500); 
				}
			}
		});
	});
	$("#edit_fields").on("hidden.bs.modal", function () {
		// put your default event here
		/*$('#edit_fields .modal-body').load('',function(){
			$('#edit_fields').modal({show:false});
		});*/
	});
	$(document).on('click', '.edit_fields', function(e){
		e.preventDefault();
		var field_id = $(this).data('field_id');
		$('#edit_fields .modal-body').load(base_url+'admin/edit_fields_popup/'+field_id,function(){
			$('#edit_fields').modal({show:true});
		});
	});
	$(document).on('click', '.add_option_btn', function(e){
		e.preventDefault();
		var html = '';
		html += '<div class="row field_option_remove"> <div class="col-md-8"> <div class="hs_input"> <input type="text" class="form-control dd_fields_creator_option" placeholder="Option Value" name="options"> </div></div><div class="col-md-4"><a href="" class="btn btn_icon margin-top-5 delete_field_option"><i class="fa fa-trash" aria-hidden="true"></i></a></div></div>';
		$('.manage_option_field_append').append(html);
	});
	$(document).on('click', '.delete_field_option', function(e){
		e.preventDefault();
		$(this).parents('.field_option_remove').remove();
	});
	$(document).on('change', '.dd_field_type', function(e){
		e.preventDefault();
		if($(this).val() == 'select' || $(this).val() == 'checkbox' || $(this).val() == 'radio'){
			$('.manage_option_div').removeClass('hide');
		}else{
			$('.manage_option_div').addClass('hide');
		}
	});
});
if($('#map_canvas').length >0){
	
 /*window.onload=function(){
		  var map;
		  function initialize() {
			  var lat=document.getElementById("latitute").value ;
			  var longt= document.getElementById("longtitute").value;
			  var myLatlng = new google.maps.LatLng(lat,longt);

			  var myOptions = {
				  zoom: 16,
				  center: myLatlng,
				  mapTypeId: google.maps.MapTypeId.ROADMAP
			  };
			  map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

			  var marker = new google.maps.Marker({
				  draggable: true,
				  position: myLatlng,
				  map: map,
				  title: "Your location"
			  });

			  google.maps.event.addListener(marker, 'dragend', function (event) {
				  document.getElementById("latitute").value = event.latLng.lat();
				  document.getElementById("longtitute").value = event.latLng.lng();
				  //infoWindow.open(map, marker);
			  });
		  }
		  google.maps.event.addDomListener(window, "load", initialize());
			}*///]]> 
			
			
		
			
	var markers = [];
      
	    var lat=document.getElementById("latitute").value ;
	    var longt= document.getElementById("longtitute").value;
        var myLatlng = new google.maps.LatLng(lat,longt);
        var myOptions = {
		  zoom: 15,
		  center: myLatlng,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		}

        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        addMarker(myLatlng, 'Default Marker', map);
		
		// Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
		
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
		
		searchBox.addListener('places_changed', function() {
		
          var places = searchBox.getPlaces();
		 
		   var bounds = new google.maps.LatLngBounds();
		   places.forEach(function(place) {
		   if (!place.geometry) {
		   return ;
		   }else{
			  var new_lat= place.geometry.location.lat();
			  var new_long=place.geometry.location.lng();
			  var myLatlng = new google.maps.LatLng(new_lat,new_long);
			  document.getElementById("latitute").value = new_lat;
		      document.getElementById("longtitute").value = new_long;
			  addMarker(myLatlng, 'Default Marker', map);
			}
			 if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
		    return false;
		   });
		   map.fitBounds(bounds);
		
		});
		
		
      
	  function addMarker(latlng,title,map) {
	     DeleteMarkers();
		var marker = new google.maps.Marker({
				position: latlng,
				map: map,
				title: title,
				draggable:true
		});
       marker.addListener('dragend', handleEvent);
	   markers.push(marker);
     }
	
	 function DeleteMarkers() {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
     };
 

	function handleEvent(event) {
		document.getElementById("latitute").value = event.latLng.lat();
		document.getElementById("longtitute").value = event.latLng.lng();
	}
				
		
}