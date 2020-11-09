import 'ol/ol.css';
import Map from 'ol/Map';
import OSM from 'ol/source/OSM';
import Overlay from 'ol/Overlay';
import TileLayer from 'ol/layer/Tile';
import View from 'ol/View';
import Feature from 'ol/Feature'
import SourceVector from 'ol/source/Vector'
import LayerVector from 'ol/layer/Vector'
import Point from 'ol/geom/Point'
import {toLonLat} from 'ol/proj';

var tLayer = new TileLayer({
    source: new OSM(),
});

var view = new View({
    center: [0, 0],
    zoom: 1,
});

var establishmentMap = new Map({
    layers: [tLayer],
    target: 'map',
    view: view,
});

establishmentMap.on("pointermove", function (evt) {
    this.getTargetElement().style.cursor = 'pointer';
});

establishmentMap.on('click', function (evt) {
    var coordinates = toLonLat(evt.coordinate);
    var latitude = coordinates[1];
    var longitude = coordinates[0];

    establishmentMap.getLayers().forEach(layer => {
        if (layer && layer.get('name') === 'establishment') {
            establishmentMap.removeLayer(layer);
        }
    });
    var establishment = new LayerVector({
        name: 'establishment',
        source: new SourceVector({
            features: [
                new Feature({
                    geometry: new Point(evt.coordinate)
                })
            ]
        })
    });
    $('#latitude').val(latitude);
    $('#longitude').val(longitude);
    establishmentMap.addLayer(establishment);
});