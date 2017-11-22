<!DOCTYPE html>
<html>
<head>
    <title>Map</title>
    <meta charset="UTF-8">

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
        <label>Latitude</label>
        <input name="lat" type="text" value="">

        <label>Longitude</label>
        <input name="lng" type="text" value="">

        <label>Formatted Address</label>
        <input name="formatted_address" type="text" value="">
    </fieldset>

    <a id="reset" href="#" style="display:none;">Reset Marker</a>
</form>

<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=AIzaSyCe9HuiwGmXU1c8arIq8m63fTrE1wrV5Bw"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<script src="{{url('/js/jquery.geocomplete.min.js')}}"></script>

<script>
    $(function () {
        $("#geocomplete").geocomplete({
            map: ".map_canvas",
            details: "form ",
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
    });
</script>

</body>
</html>

