<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple Polylines</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>

      // This example creates a 2-pixel-wide red polyline showing the path of
      // the first trans-Pacific flight between Oakland, CA, and Brisbane,
      // Australia which was made by Charles Kingsford Smith.
      var result = {!! json_encode($result) !!};
      console.log(result);
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: {lat: parseFloat(result[0].latitud) , lng: parseFloat(result[0].longitud) },
          mapTypeId: 'terrain'
        });

        var inicio = new google.maps.Marker({
          position: {lat: parseFloat(result[0].latitud) , lng: parseFloat(result[0].longitud) },
          map: map,
          title: 'Inicio',
          label: 'A',
          icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/pink-dot.png"
          }
        });

        var fin = new google.maps.Marker({
          position: {lat: parseFloat(result[result.length-1].latitud) , lng: parseFloat(result[result.length-1].longitud) },
          map: map,
          title: 'Fin',
          label: 'B'
        });

        inicio.setMap(map);
        fin.setMap(map);

        var flightPlanCoordinates = [
        ];

        for (var i = 0; i < result.length; i++) {
          flightPlanCoordinates.push({ lat: parseFloat(result[i].latitud) , lng: parseFloat(result[i].longitud)  });
        }
        console.log(flightPlanCoordinates);
        var flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          geodesic: true,
          strokeColor: '#FF0000',
          strokeOpacity: 1.0,
          strokeWeight: 2
        });

        flightPath.setMap(map);
      }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADGL9QWoK8_07tmy4imHLfXPivCnuyeXo&callback=initMap">
    </script>
  </body>
</html>