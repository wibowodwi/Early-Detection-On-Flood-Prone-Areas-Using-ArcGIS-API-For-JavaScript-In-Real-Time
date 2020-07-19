<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="initial-scale=1,maximum-scale=1,user-scalable=no"
    />
    <title>Flood Ealry Warning System</title>
    
    <link rel="stylesheet" href="https://js.arcgis.com/4.13/esri/themes/dark/main.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
      html,
      body,
      #viewDiv {
        padding: 0;
        margin: 0;
        height: 97%;
      }
    </style>
  </head>

  <body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Flood Early Warning System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="chart.php">Chart</a>
              </li>
            </ul>
            
      </div>
    </nav>
    
    			    

    
    <script src="https://js.arcgis.com/4.13/"></script>
    <script>
      var map, view;
      var geoJSONLayer;

      require([
        "esri/Map",
        "esri/views/MapView",
        "esri/layers/GeoJSONLayer",
        "esri/widgets/Search",
        "esri/widgets/ScaleBar",
        "esri/widgets/Legend",
        "esri/widgets/Compass",
        "esri/widgets/Locate",
        "esri/widgets/Expand",
        "esri/widgets/Print"
      ], function(
          Map, 
          MapView, 
          GeoJSONLayer, 
          Search, 
          ScaleBar, 
          Legend, 
          Compass, 
          Locate, 
          Expand, 
          Print) 
          {
              
        map = new Map({
          basemap: "dark-gray"
        });

        view = new MapView({
          map: map,
          container: "viewDiv",
          center: [110.42291410, -7.76327770],
          zoom: 14
        });
        
        // geoJSONLayer
        const geoJSONLayer = new GeoJSONLayer({
            url: "viewGeoJSON.php"
        });

        var search = new Search({
          view: view
        });
        
        var scaleBar = new ScaleBar({
          view: view,
          unit: "dual" // The scale bar displays both metric and non-metric units.
        });
        
        var legend = new Legend({
            view: view,
            layerInfos: [
              {
                layer: geoJSONLayer,
                title: "Keterangan"
              }
            ]
          });
          
        var compassWidget = new Compass({
          view: view
        });

        var locateBtn = new Locate({
          view: view
        });

        var print = new Print({
            view: view,
            // specify your own print service
            printServiceUrl:
              "https://utility.arcgisonline.com/arcgis/rest/services/Utilities/PrintingTools/GPServer/Export%20Web%20Map%20Task"
        });
          
        var bgExpand = new Expand({
          view: view,
          content: print
        });

        // close the expand whenever a basemap is selected
        print.watch("activePrint", function() {
          var mobileSize =
            view.heightBreakpoint === "xsmall" ||
            view.widthBreakpoint === "xsmall";

          if (mobileSize) {
            bgExpand.collapse();
          }
        });

        var template = {
                title: "{nama_alat}",
                content: [
            {
              type: "fields",
              fieldInfos: [
                {
                  fieldName: "nama_alat",
                  label: "Nama Alat"
                },
                {
                  fieldName: "alamat",
                  label: "Alamat"
                },
                {
                  fieldName: "ketinggian",
                  label: "Ketinggian"
                },
                {
                  fieldName: "waktu",
                  label: "Waktu"
                },
                {
                  fieldName: "status",
                  label: "Status"
                }
              ]
            }
            ]
            };
            
        const renderer = {
          type: "simple",
          field: "ketinggian",
          symbol: {
              type: "simple-marker",
              color: "red",
              outline: {
              color: "white"
            }
          },
          visualVariables: [
            {
              type: "size",
              field: "ketinggian",
              legendOptions: {
                title: "Ketinggian Air (cm)" },
              stops: [
                {
                  value: 40,
                  size: "20px"
                }, 
                {
                  value: 25,
                  size: "10px"
                }
              ]
            }
          ]
        };

        map.add(geoJSONLayer);  // adds the layer to the map
        geoJSONLayer.popupTemplate = template;
        geoJSONLayer.renderer = renderer;
          
        view.ui.add(locateBtn, {position: "top-left"});
        view.ui.add(compassWidget, "top-left");
        view.ui.add(legend, "bottom-right");
        view.ui.add(scaleBar, {position: "bottom-left"});
        view.ui.add(search, "top-right");
        view.ui.add(bgExpand, "top-right");
      });
    </script>
    
			    
    <div id="viewDiv"></div>
    
  </body>
</html>
