import 'ol/ol.css';
import Map from 'ol/Map';
import Overlay from 'ol/Overlay';
import OSM from 'ol/source/OSM';
import {transform, transformExtent} from 'ol/proj';
import TileLayer from 'ol/layer/Tile';
import View from 'ol/View';
import Feature from 'ol/Feature'
import VectorSource from 'ol/source/Vector'
import VectorLayer from 'ol/layer/Vector'
import Point from 'ol/geom/Point'
import {toLonLat} from 'ol/proj';
import {Circle as CircleStyle, Fill, Stroke, Style} from 'ol/style';

var establishFill = new Fill({
    color: 'rgba(0,0,0,0.25)'
});

var establishStroke = new Stroke({
    color: 'olive',
    width: 3
});

var styles = [
    new Style({
        image: new CircleStyle({
          radius: 8,
          fill: establishFill,
          stroke: establishStroke,
        }),
    }),
];
    
var ip_latitude = $('#ip_latitude_temporary').val();
var ip_longitude = $('#ip_longitude_temporary').val();

var tLayer = new TileLayer({
    source: new OSM(),
});

var establishmentView = new View({
    center: transform([ip_longitude, ip_latitude], 'EPSG:4326', 'EPSG:3857'),
    zoom: 10,
});

var establishmentMap = new Map({
    layers: [tLayer],
    target: 'establishmentMap',
    view: establishmentView,
});

establishmentMap.on("pointermove", function () {
    this.getTargetElement().style.cursor = 'pointer';
});

establishmentMap.on('singleclick', function (evt) {
    
    var bounds = transformExtent(establishmentMap.getView().calculateExtent(establishmentMap.getSize()), 'EPSG:3857','EPSG:4326');
    var coordinates = toLonLat(evt.coordinate);
    var latitude = coordinates[1];
    var longitude = coordinates[0];

    establishmentMap.getLayers().forEach(layer => {
        if (layer && layer.get('name') === 'establishment') {
            establishmentMap.removeLayer(layer);
        }
    });
    var establishment = new VectorLayer({
        name: 'establishment',
        style: styles,
        source: new VectorSource({
            features: [
                new Feature({
                    geometry: new Point(evt.coordinate)
                })
            ]
        }),
        
    });
    $('#latitude').val(latitude);
    $('#longitude').val(longitude);
    
    $('#north_latitude').val(bounds[3]);
    $('#south_latitude').val(bounds[1]);
    $('#east_longitude').val(bounds[0]);
    $('#west_longitude').val(bounds[2]);
    establishmentMap.addLayer(establishment);
});

establishmentMap.on('moveend', function () {
    var bounds = transformExtent(establishmentMap.getView().calculateExtent(establishmentMap.getSize()), 'EPSG:3857','EPSG:4326');
    $('#north_latitude').val(bounds[3]);
    $('#south_latitude').val(bounds[1]);
    $('#east_longitude').val(bounds[0]);
    $('#west_longitude').val(bounds[2]);
});