import 'ol/ol.css';
import Map from 'ol/Map';
import Overlay from 'ol/Overlay';
import OSM from 'ol/source/OSM';
import {transform, transformExtent} from 'ol/proj';
import TileLayer from 'ol/layer/Tile';
import VectorImage from 'ol/layer'
import View from 'ol/View';
import Feature from 'ol/Feature'
import VectorSource from 'ol/source/Vector'
import VectorLayer from 'ol/layer/Vector'
import Point from 'ol/geom/Point'
import {toLonLat} from 'ol/proj';
import {Circle as CircleStyle, Fill, Stroke, Style} from 'ol/style';
import GeoJSON from 'ol/format/GeoJSON';

$(function() {

    var flyFill = new Fill({
        color: 'rgba(0, 0, 0, 0.75)'
    });
    
    var flyStroke = new Stroke({
        color: 'rgba(245, 245, 245, 0.5)',
        width: 3
    });
    
    var styles = [
        new Style({
            image: new CircleStyle({
            radius: 8,
            fill: flyFill,
            stroke: flyStroke,
            }),
        }),
    ];
    
    var tLayer = new TileLayer({
        source: new OSM(),
    });
    
    var flyJSON = new VectorSource({
        format: new GeoJSON({
            defaultDataProjection: 'EPSG:4326' // added line
        }),
        url: '../data/flyJSON/'
    });
    
    var flyLayer = new VectorLayer({
        title: 'Fly Data',
        source: flyJSON,
        visible: true,
        style: function (feature, resolution) {
        return [new Style({
        image: new CircleStyle({
                radius: 8,
                fill: new Fill({ color: '#222' }),
                stroke: flyStroke
            })
        })];
        }
    });

    var ip_latitude = $('#ip_latitude').val();
    var ip_longitude = $('#ip_longitude').val();

    var flyView = new View({
        center: transform([ip_longitude, ip_latitude], 'EPSG:4326', 'EPSG:3857'),
        zoom: 10,
    });
    
    var flyMap = new Map({
        layers: [tLayer, flyLayer],
        target: 'flyMap',
        view: flyView,
    });

    function decodeEntities(encodedString) {
        var textArea = document.createElement('textarea');
        textArea.innerHTML = encodedString;
        return textArea.value;
    }

    var overlayContainerElement = document.querySelector('.overlay-container');
    // var overlayFeatureCompass = document.querySelector('.compass-color');
    // var overlayFeatureSocialCompass = document.querySelector('.social-compass');
    // var overlayFeatureEconomicCompass = document.querySelector('.economic-compass');
    var overlayFeatureIssue = document.querySelector('.fly-issue');
    var overlayFeatureSolution = document.querySelector('.fly-solution');
    
    const overlayLayer = new Overlay({
        element: overlayContainerElement
    })

    flyMap.addOverlay(overlayLayer);

    flyMap.on("pointermove", function () {
        this.getTargetElement().style.cursor = 'pointer';
    });

    flyMap.on('singleclick', function (evt) {

        var bounds = transformExtent(flyMap.getView().calculateExtent(flyMap.getSize()), 'EPSG:3857','EPSG:4326');
        var coordinates = toLonLat(evt.coordinate);
        var latitude = coordinates[1];
        var longitude = coordinates[0];

        overlayLayer.setPosition(undefined);

        flyMap.forEachFeatureAtPixel(evt.pixel, function (feature, layer)
        {
            let clickedCoordinate = evt.coordinate;
            console.log(feature);
            // let color = feature.get('color');
            // let socialCompass = feature.get('social-compass');
            // let economicCompass = feature.get('economic-compass');
            let issue = decodeEntities(feature.get('issue'));
            let solution = decodeEntities(feature.get('solution'));
            // let view = flyMap.getView();
            // view.animate({
            //     center: clickedCoordinate,
            //     zoom:   view.getZoom()
            // });
            
            overlayLayer.setPosition(clickedCoordinate);
            // overlayFeatureCompass.style.backgroundColor = color;
            // overlayFeatureSocialCompass.innerHTML = socialCompass;
            // overlayFeatureEconomicCompass.innerHTML = economicCompass;
            overlayFeatureIssue.innerHTML = issue;
            overlayFeatureSolution.innerHTML = solution;
        },
        {
            layerFilter: function(layerCandidate)
            {
                return layerCandidate.get('title') === 'Fly Data';
            }
        })
        

        flyMap.getLayers().forEach(layer => {
            if (layer && layer.get('name') === 'fly') {
                flyMap.removeLayer(layer);
            }
        });
        var fly = new VectorLayer({
            name: 'fly',
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
        $('#fly_flag').val(1);

        flyMap.addLayer(fly);
        window.livewire.emit('set:map-attributes', $('#latitude').val(), $('#longitude').val(), $('#north_latitude').val(), $('#south_latitude').val(), $('#east_longitude').val(), $('#west_longitude').val());
    });

    flyMap.on('moveend', function () {
        var bounds = transformExtent(flyMap.getView().calculateExtent(flyMap.getSize()), 'EPSG:3857','EPSG:4326');
        $('#north_latitude').val(bounds[3]);
        $('#south_latitude').val(bounds[1]);
        $('#east_longitude').val(bounds[0]);
        $('#west_longitude').val(bounds[2]);
        window.livewire.emit('set:map-attributes', $('#latitude').val(), $('#longitude').val(), $('#north_latitude').val(), $('#south_latitude').val(), $('#east_longitude').val(), $('#west_longitude').val());
    });


});