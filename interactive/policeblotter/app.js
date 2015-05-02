/**
 * This is the SB Statesman Police Blotter. It displays campus crime in a map
 * and a table simultaneously.
 * 
 * TODO: Make it easier to enter crimes
 * allow user to increment the slider by week, so she can see crime week-by-week
 * easily
 * have a way to differentiate crimes that happen at the same place in the 
 * same time range.
 * Enhance map display: different colors, heatmap overlays.
 */
google.load('visualization', '1', { packages: ['table'] });

markers = [];
var infoWindow = new google.maps.InfoWindow();
var tableSelect;

/**
 * Sets the initial state of the table, this is bad design which indicates a 
 * general failure on my part. I should send one query to Fusion Tables, than 
 * build the table and the map with the one response I receive.
 */
function initTable() {
  var rawMin = new Date(new Date().setDate(new Date().getDate()-7));
  var rawMax = new Date(Date.now());
  var min = (rawMin.getMonth() + 1) + '/' + rawMin.getDate() + '/' +  rawMin.getFullYear();
  var max = (rawMax.getMonth() + 1) + '/' + rawMax.getDate() + '/' +  rawMax.getFullYear();
  queryFusion("SELECT Date, Description, Type, Location, 'Geo Location' FROM 15WUfB0yHg3HpCJipvraEi9wHl3GPj0ITUhpVkoKE WHERE Date >= '"+min+"' AND Date <= '"+max+"' ORDER BY Date Desc", tableCallback);
}

/**
 * Query a Google Fusion Table.
 * @query The query to send to the Fusion Table, in string, plaintext format.
 * @query A function to call when the Fusion Table sends its response.
 */
function queryFusion(query, callback) {
  var queryText = encodeURIComponent(query);
  var gvizQuery = new google.visualization.Query(
      'http://www.google.com/fusiontables/gvizdata?tq=' + queryText);
  gvizQuery.send(callback);
}

/**
 * Given a Fusion Tables response, draws a google Data Table.
 */
var mapCallback = function(response) {
  var numRows = response.getDataTable().getNumberOfRows();
  // For each row in the table, create a marker
  for (var i = 0; i < numRows; i++) {
    var date = response.getDataTable().getValue(i, 0);
    var desc = response.getDataTable().getValue(i, 1);
    var stringCoordinates = response.getDataTable().getValue(i, 2);
    var splitCoordinates = stringCoordinates.split(',');
    var lat = splitCoordinates[0];
    var lng = splitCoordinates[1];
    var coordinate = new google.maps.LatLng(lat, lng);
    createMarker(coordinate, date, desc);
  }
}

/**
 * Given a Fusion Tables response, draws a google Data table.
 */
var tableCallback = function(response) {
  var data = response.getDataTable();
  if(data.getNumberOfRows()===0) {
    document.getElementById('table').innerHTML = "<div id='datawarn'>Sorry, no data available for this period.</div>"
  } else {
    var table = new google.visualization.Table(document.getElementById('table'));
    var dview = new google.visualization.DataView(data);
    dview.setColumns([0,1,2,3]);
    table.draw(dview, {
      height: '525px',
    });
    $('.google-visualization-table-th:contains(Date)').css('width', '75px');
    
    //create selection event to sync table with map
    google.visualization.events.addListener(table, 'select', function() {
      var selected = table.getSelection();
      //if selected row, select corresponding point on map
      if(selected.length !== 0) {
        var row = [];
        for (var i=0;i<data.getNumberOfColumns();i++) {
          row[i] = data.getValue(selected[0].row,i);
        }
        var coords = row[4].replace(' ', '').split(',');
        var coord = {'lat': parseFloat(coords[0]), 'lng': parseFloat(coords[1])};
        spawnInfo(coord, row[0], row[1]);
      //else unselect point on map
      } else {
        killInfo();
      }
    });
    
    //Expose an API to control which row in table is selected
    tableSelect = function(coordinate, date, description) {
      row = null;
      for (var i=0;i<data.getNumberOfRows();i++) {
        var lat = coordinate.k.toFixed(6).toString();
        var lng = coordinate.B.toFixed(6).toString();
        var coord = lat+', '+lng;
        var dateBool = data.getValue(i,0).toString()===date.toString();
        var descBool = data.getValue(i,1)===description;
        var coorBool = data.getValue(i,4)===coord;
        if (dateBool && descBool && coorBool) {
          row = i;
        }
      }
      table.setSelection([]);
      table.setSelection([{'row':row, 'column':null}]);
    };
  }
}

/**
 * Given a Date object, returns a string representing the date in AP format.
 */
function prettyPrintDate(date) {
  months = ['Jan.', 'Feb.', 'Mar.', 'Apr.', 'May', 'Jun.', 'Jul.', 'Aug.', 
            'Sep.', 'Oct.', 'Nov.', 'Dec.']
  return months[date.getMonth()] + ' ' + date.getDate() + ', '
         + date.getFullYear();
}

/**
 * A specialized function to create crime Markers on the map, can be rewritten
 * to introduce additional features, such as different display/style of types of
 * crimes.
 */
function createMarker(coordinate, date, description) {
  var marker = new google.maps.Marker({
    map: map,
    position: coordinate,
  });
  google.maps.event.addListener(marker, 'click', function(event) {
    spawnInfo(coordinate, date, description);
    tableSelect(coordinate, date, description)
  });
  markers.push(marker);
};

/**
 * Creates an infowindow on the map. An infowindow is the little popup that
 * tells you more information about the crime.
 */
function spawnInfo(coordinate, date, description) {
  infoWindow.setPosition(coordinate);
  infoWindow.setContent('<b>Date: </b>' + prettyPrintDate(date)
                      + '<br><b>Description: </b>' + description
                      + '<br>&nbsp;');
  infoWindow.open(map);
}

/**
 * Kills the infoWindow on the map. I say the because there is only ever one
 * on the map at a time.
 */
function killInfo() {
  infoWindow.close();
}

/**
 * Deletes all markers from the map.
 * NOTE: Potential debate over whether the markers should be deleted or 
 * hidden, to later be reactivated by some caching scheme. Arguments for 
 * deletion: Using Googles servers not ours. Cons: slower.
 */
function deleteMarkers() {
  markers.forEach(function(marker) {
    marker.setMap(null);
  });
  markers = [];
}

/**
 * Initialize the Google Map. Run an initial query on it (last week).
 */
function initialize() {
  var mapOptions = {
    center: { lat: 40.915785, lng: -73.123560},
    zoom: 15,
    panControl: false,
  };
  window.map = new google.maps.Map(document.getElementById('map'),
      mapOptions);
  
  var rawMin = new Date(new Date().setDate(new Date().getDate()-7));
  var rawMax = new Date(Date.now());
  var min = (rawMin.getMonth() + 1) + '/' + rawMin.getDate() + '/' +  rawMin.getFullYear();
  var max = (rawMax.getMonth() + 1) + '/' + rawMax.getDate() + '/' +  rawMax.getFullYear();
  queryFusion("SELECT Date, Description, 'Geo Location' FROM 15WUfB0yHg3HpCJipvraEi9wHl3GPj0ITUhpVkoKE WHERE Date >= '"+min+"' AND Date <= '"+max+"' ORDER BY Date Desc", mapCallback);
}

//initialize the app
google.setOnLoadCallback(initTable);
google.maps.event.addDomListener(window, 'load', initialize);

/**
 * Create the Date Slider, allow the user to query the database with an
 * arbitrarily sized date range. The minimum is the beginning of data 
 * collection; the maximum is now.
 */
$("#slider").dateRangeSlider({
  arrows: false,
  bounds: {
    min: new Date(2014, 2, 24),
    max: Date.now()
  },
  defaultValues: {
    min: new Date(new Date().setDate(new Date().getDate()-7)),
    max: Date.now()
  },
  formatter: function(val) {
    return prettyPrintDate(val)
  }
});

/**
 * Bind an event to the slider that is caught whenever the values change. i.e.
 * The user was moving/sliding it and stopped. On the moment the slider stops,
 * this event is called.
 */
$("#slider").bind("valuesChanged", function(e, data){
  deleteMarkers();
  var rawMin = data.values.min
  var rawMax = data.values.max
  var min = (rawMin.getMonth() + 1) + '/' + rawMin.getDate() + '/' +  rawMin.getFullYear()
  var max = (rawMax.getMonth() + 1) + '/' + rawMax.getDate() + '/' +  rawMax.getFullYear()
  queryFusion("SELECT Date, Description, 'Geo Location' FROM 15WUfB0yHg3HpCJipvraEi9wHl3GPj0ITUhpVkoKE WHERE Date >= '"+min+"' AND Date <= '"+max+"' ORDER BY Date Desc", mapCallback);
  
  queryFusion("SELECT Date, Description, Type, Location, 'Geo Location' FROM 15WUfB0yHg3HpCJipvraEi9wHl3GPj0ITUhpVkoKE WHERE Date >= '"+min+"' AND Date <= '"+max+"' ORDER BY Date Desc", tableCallback)
});