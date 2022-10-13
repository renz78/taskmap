@extends('layouts.main')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <h3>Тестове завдання</h3>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div id="googleMap" style="height:500px;"></div>
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
        
        var arrmarkers = {!! json_encode($markers) !!};

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
        };

        function addMarker(data) {
            const d = new Date();
            let minutes = d.getMinutes();
            
            newplace = new google.maps.LatLng(data.lat, data.lng);
           
            var marker = new google.maps.Marker({
                position: newplace,
                map: map,
                title: data.title
            });
           
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
            $.ajax({
                type: "GET", 
                url:"{{ route('marker.index') }}",
                // data: form_data,
                success: function(data)
                {
                    //var json_obj = jQuery.parseJSON(JSON.stringify(data));
                    for ( var j in arrmarkers ) {
                        var check = 0;
                        for (var i in data) {	
                            if (arrmarkers[j]['id'] == data[i]['id']) {
                                check = 1;
                            }
                            addMarker(data[i]); 
                        }
                        if (check == 0) {
                            console.log('deleted');
                            DeleteMarkers();
                        }
                    }         
                    arrmarkers = data;
                },
                dataType: "json"   
            })    
        }, 1000);
        
        
         

        function DeleteMarkers() {
            //Loop through all the markers and remove
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
        };
        
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