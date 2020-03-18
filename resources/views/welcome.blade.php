<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=1.0, width=device-width" />

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
        <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
        <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" type="text/javascript" charset="utf-8"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>
                <div style="width: 640px; height: 480px" id="mapContainer"></div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
      /**
      * An event listener is added to listen to tap events on the map.
      * Clicking on the map displays an alert box containing the latitude and longitude
      * of the location pressed.
      * @param  {H.Map} map      A HERE Map instance within the application
      */
      function setUpClickListener(map) {
        // Attach an event listener to map display
        // obtain the coordinates and display in an alert box.
        map.addEventListener('tap', function (evt) {
          var coord = map.screenToGeo(evt.currentPointer.viewportX,
                  evt.currentPointer.viewportY);
          console.log("lat : "+coord.lat);
          console.log("lng : "+coord.lng);
          // logEvent('Clicked at ' + Math.abs(coord.lat.toFixed(4)) +
          //     ((coord.lat > 0) ? 'N' : 'S') +
          //     ' ' + Math.abs(coord.lng.toFixed(4)) +
          //     ((coord.lng > 0) ? 'E' : 'W'));
        });
      }

      /**
      * Boilerplate map initialization code starts below:
      */

      //Step 1: initialize communication with the platform
      // In your own code, replace variable window.apikey with your own apikey
      var platform = new H.service.Platform({
        apikey: window.api_key
      });
      var defaultLayers = platform.createDefaultLayers();

      //Step 2: initialize a map
      var map = new H.Map(document.getElementById('mapContainer'),
        defaultLayers.vector.normal.map,{
        center: {lat: -7.94625288456589, lng: 110.10861860580418},
        zoom: 10,
        pixelRatio: window.devicePixelRatio || 1
      });
      // add a resize listener to make sure that the map occupies the whole container
      window.addEventListener('resize', () => map.getViewPort().resize());

      //Step 3: make the map interactive
      // MapEvents enables the event system
      // Behavior implements default interactions for pan/zoom (also on mobile touch environments)
      var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

      setUpClickListener(map);                  
    </script>
</html>
