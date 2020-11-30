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

    var perchFill = new Fill({
        color: 'rgba(0, 0, 0, 0.75)'
    });
    
    var perchStroke = new Stroke({
        color: 'rgba(245, 245, 245, 0.5)',
        width: 3
    });
    
    var styles = [
        new Style({
            image: new CircleStyle({
            radius: 8,
            fill: perchFill,
            stroke: perchStroke,
            }),
        }),
    ];
    
    var tLayer = new TileLayer({
        source: new OSM(),
    });
    
    var perchJSON = new VectorSource({
        format: new GeoJSON({
            defaultDataProjection: 'EPSG:4326' // added line
        }),
        url: '../data/perchJSON/'
    });
    
    var perchLayer = new VectorLayer({
        title: 'Perch Data',
        source: perchJSON,
        visible: true,
        style: function (feature, resolution) {
        console.log(feature.getProperties());
        return [new Style({
        image: new CircleStyle({
                radius: 8,
                fill: new Fill({ color: feature.get('color') }),
                stroke: perchStroke
            })
        })];
        }
    });

    if ($('#latitude').val() === '' && $('#longitude').val() === '')
    {
        var use_latitude = $('#ip_latitude').val();
        var use_longitude = $('#ip_longitude').val();
    }
    else
    {
        var use_latitude = $('#latitude').val();
        var use_longitude = $('#longitude').val();
    }

    var perchView = new View({
        center: transform([use_longitude, use_latitude], 'EPSG:4326', 'EPSG:3857'),
        zoom: 10,
    });
    
    var perchMap = new Map({
        layers: [tLayer, perchLayer],
        target: 'perchMap',
        view: perchView,
    });

    function decodeEntities(encodedString) {
        var textArea = document.createElement('textarea');
        textArea.innerHTML = encodedString;
        return textArea.value;
    }

    var overlayContainerElement = document.querySelector('.overlay-container');
    var overlayFeatureCompass = document.querySelector('.compass-color');
    var overlayFeatureSocialCompass = document.querySelector('.social-compass');
    var overlayFeatureEconomicCompass = document.querySelector('.economic-compass');
    var overlayFeatureIssue = document.querySelector('.perch-issue');
    var overlayFeatureSolution = document.querySelector('.perch-solution');
    
    const overlayLayer = new Overlay({
        element: overlayContainerElement
    })

    perchMap.addOverlay(overlayLayer);

    perchMap.on("pointermove", function () {
        this.getTargetElement().style.cursor = 'pointer';
    });

    perchMap.on('singleclick', function (evt) {

        var bounds = transformExtent(perchMap.getView().calculateExtent(perchMap.getSize()), 'EPSG:3857','EPSG:4326');
        var coordinates = toLonLat(evt.coordinate);
        var latitude = coordinates[1];
        var longitude = coordinates[0];

        overlayLayer.setPosition(undefined);

        perchMap.forEachFeatureAtPixel(evt.pixel, function (feature, layer)
        {
            let clickedCoordinate = evt.coordinate;
            let color = feature.get('color');
            let socialCompass = feature.get('social-compass');
            let economicCompass = feature.get('economic-compass');
            let issue = decodeEntities(feature.get('issue'));
            let solution = decodeEntities(feature.get('solution'));
            // let view = perchMap.getView();
            // view.animate({
            //     center: clickedCoordinate,
            //     zoom:   view.getZoom()
            // });
            
            overlayLayer.setPosition(clickedCoordinate);
            overlayFeatureCompass.style.backgroundColor = color;
            overlayFeatureSocialCompass.innerHTML = socialCompass;
            overlayFeatureEconomicCompass.innerHTML = economicCompass;
            overlayFeatureIssue.innerHTML = issue;
            overlayFeatureSolution.innerHTML = solution;
        },
        {
            layerFilter: function(layerCandidate)
            {
                return layerCandidate.get('title') === 'Perch Data';
            }
        })
        

        perchMap.getLayers().forEach(layer => {
            if (layer && layer.get('name') === 'perch') {
                perchMap.removeLayer(layer);
            }
        });
        var perch = new VectorLayer({
            name: 'perch',
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
        $('#perch_flag').val(1);

        perchMap.addLayer(perch);
        window.livewire.emit('set:map-attributes', $('#latitude').val(), $('#longitude').val(), $('#north_latitude').val(), $('#south_latitude').val(), $('#east_longitude').val(), $('#west_longitude').val());
    });

    perchMap.on('moveend', function () {
        var bounds = transformExtent(perchMap.getView().calculateExtent(perchMap.getSize()), 'EPSG:3857','EPSG:4326');
        $('#north_latitude').val(bounds[3]);
        $('#south_latitude').val(bounds[1]);
        $('#east_longitude').val(bounds[0]);
        $('#west_longitude').val(bounds[2]);
        window.livewire.emit('set:map-attributes', $('#latitude').val(), $('#longitude').val(), $('#north_latitude').val(), $('#south_latitude').val(), $('#east_longitude').val(), $('#west_longitude').val());
    });


});