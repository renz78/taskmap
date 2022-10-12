@extends('layouts.main')

@section('content')
    
    
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3>Тестове завдання</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div id="googleMap" style="width:100%;height:500px;"></div>
            </div>
            <div class="col-md-4">
                <h4>Додайте маркер на карту</h4>
                <div class="alert alert-success print-success-msg" style="display:none">
                    <div class="success"></div>
                </div>
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <form action="javascript:void(0)" id="marker_form" onsubmit="saveMarker()">
                    <label class="form-check-label" for="title">Назва</label>
                    <input type="text" name="title" id="title" class="form-control" >
                    @error('title') <span class="error">{{ $message }}</span> @enderror
                    <label class="form-check-label" for="lat">Latitude</label>
                    <input type="number" name="lat" id="lat" step="any" class="form-control" required>
                    @error('lat') <span class="error">{{ $message }}</span> @enderror
                    <label class="form-check-label" for="lng">Longitude</label>
                    <input type="number" name="lng" id="lng" step="any" class="form-control" required>
                    @error('lng') <span class="error">{{ $message }}</span> @enderror
                    <label class="form-check-label" for="description">Опис</label>
                    <textarea name="description" id="description" cols="20" rows="8" class="form-control"></textarea>
                    @error('description') <span class="error">{{ $message }}</span> @enderror
                    <button type="submit" class="btn btn-primary btn-submit mt-1">Додати</button>
                </form>

                <input type="button" value="Delete" onclick="DeleteMarkers()" />
            </div>
        </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQhBg5cIrNqsll1mXvjKR_fyt4yWenncU"></script>    
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQhBg5cIrNqsll1mXvjKR_fyt4yWenncU&callback=myMap"></script> --}}
    <script>
        var markers = [];//{!! json_encode($markers) !!};
        var mapOptions = {
                center: new google.maps.LatLng(48.779502, 30.967857),
                zoom: 5,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
        // function myMap() {
        //     var myLatlng = new google.maps.LatLng(48.779502, 30.967857);
        //     var myOptions = {
        //         zoom: 6,
        //         center: myLatlng,
        //         mapTypeId: google.maps.MapTypeId.ROADMAP
        //     }
        //     map = new google.maps.Map(document.getElementById("googleMap"), myOptions);
        //     // for (var i = 0, length = markers.length; i < length; i++) {
        //     //     var data = markers[i];
        //     //     latLng = new google.maps.LatLng(data.lat, data.lng); 
        //     //     var marker = new google.maps.Marker({
        //     //         position: latLng,
        //     //         map: map,
        //     //         title: data.title
        //     //     });
        //     // }
        // }
        
        var arrmarkers = {!! json_encode($markers) !!};
        function addMarker(data) {
            const d = new Date();
            let minutes = d.getMinutes();
            //console.log(data)
            newplace = new google.maps.LatLng(data.lat, data.lng);
            //console.log(newplace);
            
            var marker = new google.maps.Marker({
                position: newplace,
                map: map,
                title: data.title
            });
            //console.log(marker.getPosition().lat());
            // if(data.id == 16) {
            //     markers.push(marker);
            // }
            // while(markers.length) { 
            //     markers.pop().setMap(null); 
            // }
            //marker.setMap(null);
            const infowindow = new google.maps.InfoWindow({
                content: data.description,
            });
            marker.addListener("click", () => {
                infowindow.open({
                anchor: marker,
                map,
                    shouldFocus: false,
                });
            });
            markers.push(marker);
               
            
        }

        setInterval(function mapload(){
            console.log(arrmarkers);
            //markers = [];
            $.ajax({
                type: "GET", 
                url:"{{ route('marker.index') }}",
                // data: form_data,
                success: function(data)
                {
                    console.log(arrmarkers.length);
                    
                    //var json_obj = jQuery.parseJSON(JSON.stringify(data));
                    console.log()
                    
                    for ( var j in arrmarkers ) {
                        //console.log('j-'+j);
                        var check = 0;
                        for (var i in data) {	
                            //console.log('i-'+i);
                            
                            if (arrmarkers[j]['id'] == data[i]['id']) {
                                check = 1;
                                
                                //console.log(arrmarkers[j]['id']+'----'+data[i]['id']);
                            }
                        
                            addMarker(data[i]); 
                            if (data.length > arrmarkers.length) {
                                
                            }
                                
                            
                        }
                        if (check == 0) {
                            console.log('deleted');
                            DeleteMarkers();
                            //console.log(data[j]['id']);
                        }
                    }         
                    arrmarkers = data;
                    //console.log(typeof arrmarkers);
                },
                dataType: "json"//set to JSON    
            })    
        }, 1000);
        
        
         window.onload = function () {
            
            for (var i = 0, length = arrmarkers.length; i < length; i++) {
                var data = arrmarkers[i];
                latLng = new google.maps.LatLng(data.lat, data.lng); 
                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: data.title
                });
                markers.push(marker);
            }
        //     // //Attach click event handler to the map.
        //     google.maps.event.addListener(map, 'click', function (e) {
    
        //         //Determine the location where the user has clicked.
        //         var location = e.latLng;
    
        //         //Create a marker and placed it on the map.
        //         var marker = new google.maps.Marker({
        //             position: location,
        //             map: map
        //         });
    
        //         //Attach click event handler to the marker.
        //         google.maps.event.addListener(marker, "click", function (e) {
        //             var infoWindow = new google.maps.InfoWindow({
        //                 content: 'Latitude: ' + location.lat() + '<br />Longitude: ' + location.lng()
        //             });
        //             infoWindow.open(map, marker);
        //         });
    
        //         //Add marker to the array.
        //         markers.push(marker);
        //         console.log(markers)
        //     });
         };

        function DeleteMarkers() {
            //Loop through all the markers and remove
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
        };
        
    </script>
    <script type="text/javascript">
        function saveMarker() {
            var title = $("#title").val();
            var lat = $("#lat").val();
            var lng = $("#lng").val();
            var description = $("#description").val();
    
            $.ajax({
                type:'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{ route('marker.store') }}",
                data:{title:title, lat:lat, lng:lng, description:description},
                success:function(data){
                    if($.isEmptyObject(data.error)){
                        printSuccessMsg(data.success);
                        $('#marker_form').trigger("reset");
                        //addMarker(lat, lng);
                    } 
                },
                error: function(data){
                    console.log(data.responseJSON);
                    printErrorMsg(data.responseJSON.errors);
                }
            });
        }

        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }

        function printSuccessMsg (msg) {
            $(".print-success-msg").find("div").html('');
            $(".print-success-msg").css('display','block');
            $(".print-success-msg").find("div").append('<b>'+msg+'</b>');
            setTimeout(() => {
                $(".print-success-msg").css('display','none');
            }, 2000);
        }
    </script>
    
@endsection