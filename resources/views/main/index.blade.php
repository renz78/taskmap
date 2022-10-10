@extends('layouts.main')

@section('content')
    <script>
        var markers = [
        {
            "title": 'Aksa Beach',
            "lat": '19.1759668',
            "lng": '72.79504659999998',
            "description": 'Aksa Beach is a popular beach and a vacation spot in Aksa village at Malad, Mumbai.'
        },
        {
            "title": 'Juhu Beach',
            "lat": '19.0883595',
            "lng": '72.82652380000002',
            "description": 'Juhu Beach is one of favorite tourist attractions situated in Mumbai.'
        },
        {
            "title": 'Girgaum Beach',
            "lat": '18.9542149',
            "lng": '72.81203529999993',
            "description": 'Girgaum Beach commonly known as just Chaupati is one of the most famous public beaches in Mumbai.'
        },
        {
            "title": 'Jijamata Udyan',
            "lat": '18.979006',
            "lng": '72.83388300000001',
            "description": 'Jijamata Udyan is situated near Byculla station is famous as Mumbai (Bombay) Zoo.'
        },
        {
            "title": 'Sanjay Gandhi National Park',
            "lat": '19.2147067',
            "lng": '72.91062020000004',
            "description": 'Sanjay Gandhi National Park is a large protected area in the northern part of Mumbai city.'
        }
        ];
        function myMap() {
            var mapProp= {
            center:new google.maps.LatLng(51.508742,-0.120850),
            zoom:5,
            };
            var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
            for (var i = 0, length = markers.length; i < length; i++) {
                var data = markers[i],
                    latLng = new google.maps.LatLng(data.lat, data.lng); 
                // Creating a marker and putting it on the map
                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: data.title
                });
            }
        }
    </script>
    
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
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <form action="javascript:void(0)" onsubmit="addMarker()">
                    <label class="form-check-label" for="title">Назва</label>
                    <input type="text" name="title" id="title" class="form-control" >
                    @error('title') <span class="error">{{ $message }}</span> @enderror
                    <label class="form-check-label" for="latitude">Latitude</label>
                    <input type="text" name="latitude" id="latitude" class="form-control" required>
                    @error('latitude') <span class="error">{{ $message }}</span> @enderror
                    <label class="form-check-label" for="longitude">Longitude</label>
                    <input type="text" name="longitude" id="longitude" class="form-control" required>
                    @error('longitude') <span class="error">{{ $message }}</span> @enderror
                    <label class="form-check-label" for="description">Опис</label>
                        <textarea name="description" id="description" cols="20" rows="8" class="form-control"></textarea>
                    @error('description') <span class="error">{{ $message }}</span> @enderror
                    <button type="submit" class="btn btn-primary btn-submit mt-1">Відправити</button>
                    
                </form>
            </div>
        </div>
    </div>
        
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQhBg5cIrNqsll1mXvjKR_fyt4yWenncU&callback=myMap"></script>

    <script type="text/javascript">


        function addMarker() {
            var title = $("#title").val();
            var latitude = $("#latitude").val();
            var longitude = $("#longitude").val();
            var description = $("#description").val();
    
            $.ajax({
               type:'POST',
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               url:"{{ route('marker.store') }}",
               data:{title:title, latitude:latitude, longitude:longitude, description:description},
               success:function(data){
                    if($.isEmptyObject(data.error)){
                        alert(data.success);
                    } else {
                    
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
        // $(".btn-submit").click(function(e){
        //     e.preventDefault();
    
            
        // });
    
    </script>
    
@endsection