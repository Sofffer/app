<!DOCTYPE html>
<html>
<head>
    <title>Map</title>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style type="text/css" media="screen">
        body {
            color: #333;
        }

        body, input, button {
            line-height: 1.4;
            font: 13px Helvetica, arial, freesans, clean, sans-serif;
        }

        a {
            color: #4183C4;
            text-decoration: none;
        }

        #examples a {
            text-decoration: underline;
        }

        #geocomplete {
            width: 200px
        }

        .map_canvas {
            width: 600px;
            height: 400px;
            margin: 10px 20px 10px 0;
        }

        #multiple li {
            cursor: pointer;
            text-decoration: underline;
        }

        form {
            width: 300px;
            float: left;
            margin-left: 20px
        }

        fieldset {
            width: 320px;
            margin-top: 20px
        }

        fieldset strong {
            display: block;
            margin: 0.5em 0 0em;
        }

        fieldset input {
            width: 95%;
        }

        ul span {
            color: #999;
        }
    </style>
</head>
<body>

<div class="map_canvas"></div>

<form>
    <input id="geocomplete" type="text" placeholder="Type in an address" value="Rampura, Dhaka, Bangladesh"/>
    <input id="find" type="button" value="find"/>

    <fieldset>
        <label>Shop name</label>
        <input id="name" value="">

        <label>Latitude</label>
        <input id="lat" name="lat" type="text" value="">

        <label>Longitude</label>
        <input id="lon" name="lng" type="text" value="">

        <label>Address</label>
        <input name="formatted_address" id="address" type="text" value="">


        <label>administrative_area_level_1</label>
        <input name="administrative_area_level_1" type="text" value="">


        <label>City</label>
        <input name="locality" id="city" type="text" value="">

        <label>State</label>
        <input name="sublocality" id="state" type="text" value="">


        <label>postal_code</label>
        <input name="postal_code" id="zip" type="text" value="">


        <label>viewport</label>
        <input name="viewport" type="text" value="">

        <label>Location</label>
        <input name="location" type="text" value="">


        <label>Country</label>


        <input name="country" type="text" value="">


    </fieldset>

    <a id="reset" href="#" style="display:none;">Reset Marker</a>
</form>

<button id="add">Add</button>
<p id="msg"></p>

<script src="http://maps.googleapis.com/maps/api/js?sensor=true&amp;language=en&libraries=places&key=AIzaSyCe9HuiwGmXU1c8arIq8m63fTrE1wrV5Bw"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<script src="{{url('/js/jquery.geocomplete.min.js')}}"></script>

<script>
    $(function () {
        $("#geocomplete").geocomplete({
            map: ".map_canvas",
            details: "form ",
//            detailsAttribute: "data-geo",
            markerOptions: {
                draggable: true
            }
        });

        $("#geocomplete").bind("geocode:dragged", function (event, latLng) {
            $("input[name=lat]").val(latLng.lat());
            $("input[name=lng]").val(latLng.lng());
            $("#reset").show();
        });


        $("#reset").click(function () {
            $("#geocomplete").geocomplete("resetMarker");
            $("#reset").hide();
            return false;
        });

        $("#find").click(function () {
            $("#geocomplete").trigger("geocode");
        }).click();

        $('#add').click(function () {

            //        $table->string('name');
//        $table->string('street');
//        $table->string('city', 50);
//        $table->string('state', 2)->nullable();
//        $table->string('zip', 12)->nullable();
//        $table->string('phone', 30)->nullable();
//        $table->float('latitude', 10, 6);
//        $table->float('longitude', 10, 6);

            $('#msg').html("Please wait.....");
            $.ajax({
                type: 'POST',
                url: '{{url('/map/record/add')}}',
                data: {
                    'name': $('#name').val(),
                    'street': $('#address').val(),
                    'city': $('#city').val(),
                    'state': $('#state').val(),
                    'zip': $('#zip').val(),
                    'phone': 'none',
                    'latitude': $('#lat').val(),
                    'longitude': $('#lon').val(),
                    '_token': '{{csrf_token()}}'
                },
                success: function (data) {

                    $('#msg').html(data);
                }
            });
        });
    });
</script>

</body>
</html>

