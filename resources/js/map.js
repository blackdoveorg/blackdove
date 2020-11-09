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
import {fromLonLat, toLonLat} from 'ol/proj';
import {toStringHDMS} from 'ol/coordinate';

var tLayer = new TileLayer({
    source: new OSM(),
});

var map = new Map({
    layers: [tLayer],
    target: 'map',
    view: new View({
        center: [0, 0],
        zoom: 2,
    }),
});

map.on("pointermove", function (evt) {
    this.getTargetElement().style.cursor = 'pointer';
});

map.on('click', function (evt) {
    map.getLayers().forEach(layer => {
        if (layer && layer.get('name') === 'establishment') {
          map.removeLayer(layer);
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
    map.addLayer(establishment);
});