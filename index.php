<!DOCTYPE html>
<html lang="en" style="">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MAP</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>

<div class="container-fluid">
    <div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div style="display: none;" id="gmaps-markerss" class="gmapss"></div>
            <div id="mapid"></div>
            <br>
            <div class="row">
                <div class="col-md-6">
                <form method="post" id="coordinates_form">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="display_name" class="col-form-label-mini">Latitude</label>
                            <input type="number" step="any" name="latitude" id="latitude"  class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="name" class="col-form-label-mini">Longitude</label>
                            <input type="number" step="any" name="longitude" id="longitude" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" value="Save"><span class="nc-icon nc-send"></span> Add</button>
                </form>

                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="display_name" class="col-form-label-mini">Shareable Link</label>
                            <input type="text" step="any" name="share" id="share"  class="form-control">
                        </div>
                    </div>
                    <button id="copyButton" class="btn btn-primary" >Copy to Clipboard</button>
                </div>
            </div>
        </div>
    </div>
    </div>

</div>
<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

<style>
    #mapid {
        height: 700px;
        width: 100%;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        var mymap = L.map('mapid').setView([7.3575577, 125.7035372], 15);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoid3JoaXN1bGEiLCJhIjoiY2tqdjAzNjhwMnF1czJxcXVheG5zM2Z0dyJ9.ADUJmb8cso0RObOix5SzOQ', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 100,
            minZoom: 1,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'your.mapbox.access.token'
        }).addTo(mymap);
        <?php if(isset($_GET['lat']) && isset($_GET['longi'])) : ?>
            var shareCoordinates = L.marker([<?=$_GET['lat']?>,<?=$_GET['longi']?>]).addTo(mymap);
        <?php endif; ?>

        mymap.on('click', addMarker);

        function onLocationFound(e) {
            var currentpos = L.marker([e.latlng.lat,e.latlng.lng]).addTo(mymap);
        }
        function onLocationError(e) {
            console.log(e.message);
        }
        mymap.on('locationfound', onLocationFound);
        mymap.on('locationerror', onLocationError);

        function locate() {
            mymap.locate({setView: true, maxZoom: 100});
        }
        locate();
        // call locate every 3 seconds... forever
        //setInterval(locate, 3000);

        function addMarker(e){
            // Add marker to map at click location; add popup window
            var newMarker = new L.marker(e.latlng).addTo(mymap);
            $('#share').val('index.php?lat='+e.latlng.lat+'&longi='+e.latlng.lng)
        }

        function addMarkerFromForm(latitude,longitude){
           var newMarker = new L.marker([latitude,longitude]).addTo(mymap);
        }
        $("#coordinates_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            addMarkerFromForm(document.getElementById('latitude').value,document.getElementById('longitude').value);
            //console.log($('#longitude').val());
        });

        $('#copyButton').click(function(){
            $('#share').select();
            document.execCommand("copy");
        });

    });
</script>
