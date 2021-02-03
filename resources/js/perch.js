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
import fcose from 'cytoscape-fcose';
var MobileDetect = require('mobile-detect');

$(function() {
    $('.choices__input').change(function() {
        updateCytoscape();
    });
    updateCytoscape();
    var md = new MobileDetect(window.navigator.userAgent);
    var geoStepMobile = "<li>Tap on the map where there\'s an issue<br/>(pinch to zoom).</li>";
    var geoStepOther = "<li>Click on the map where there\'s an issue (use your mousewheel to zoom).<br/><li>";
    var mobileStep = "<li>Click the <b class='text-xs'>GO TO ISSUE</b> button.</li>";
    var descriptionStep = "<li>Provide a description of the issue and solution.</li>";
    var perchStep = "<li>Click Perch.</li>";
    // Setting the Perch instructions this really hackish way.
    var instructionsMobile = "<ol style='list-style: decimal;'>" + geoStepMobile + mobileStep + descriptionStep + perchStep + "</ol>";
    var instructionsOther = "<ol style='list-style: decimal;'>" + geoStepOther + descriptionStep + perchStep + "</li></ol>";
    
    if (md.mobile())
    {
        $('#instructions').hide().html(instructionsMobile).fadeIn(1000);
        var startItem;
    } else {
        $('#instructions').html(instructionsOther).fadeIn(1000);
    }
    var perchFill = new Fill({
        color: 'rgba(222, 222, 222, 0.0)'
    });
    
    var perchStroke = new Stroke({
        color: 'rgba(0, 0, 0, 0.5)',
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
        return [new Style({
        image: new CircleStyle({
                radius: 8,
                fill: new Fill({ color: '#' + feature.get('color') }),
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
        element: overlayContainerElement,
        autoPan: true
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
            let color = '#' + feature.get('color');
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
    window.addEventListener('duration', dur => {
        alert('Duration: ' + dur.detail);
    })
    perchMap.on('moveend', function () {
        var bounds = transformExtent(perchMap.getView().calculateExtent(perchMap.getSize()), 'EPSG:3857','EPSG:4326');
        $('#north_latitude').val(bounds[3]);
        $('#south_latitude').val(bounds[1]);
        $('#east_longitude').val(bounds[0]);
        $('#west_longitude').val(bounds[2]);
        window.livewire.emit('set:map-attributes', $('#latitude').val(), $('#longitude').val(), $('#north_latitude').val(), $('#south_latitude').val(), $('#east_longitude').val(), $('#west_longitude').val());
    });

    Livewire.on('saved', () => {
        
        perchMap.getLayers().forEach(layer => {
            if (layer && layer.get('title') === 'Perch Data') {
                perchMap.removeLayer(layer);
            }
        });
        var perchJSON = new VectorSource({
            format: new GeoJSON({
                defaultDataProjection: 'EPSG:4326' // added line
            }),
            url: '../data/perchJSON/'
        });
        console.log(perchJSON);
        var perchLayer = new VectorLayer({
            title: 'Perch Data',
            source: perchJSON,
            visible: true,
            style: function (feature, resolution) {
            return [new Style({
            image: new CircleStyle({
                    radius: 8,
                    fill: new Fill({ color: '#111' }),
                    stroke: perchStroke
                })
            })];
            }
        });
        perchMap.addLayer(perchLayer);
    })
    function updateCytoscape()
    {
        window.tempCytoscapeData = {};
        window.tempCytoscapeData['nodes'] = [];
        window.tempCytoscapeData['edges'] = [];
        window.tempCytoscapeData['nodes'].push({ data: { id: 'Issues' } });
        window.tempCytoscapeData['nodes'].push({ data: { id: 'Solutions' } });

        var issue_color = "#fff";
        // var issue_color = window.user_color;
        var issue_category = $('#issue_category').val();
        for (const issue_entry in issue_category) {
        var issue_node_data = { data: { parent: 'Issues', id: 'I:' + issue_category[issue_entry], weight: 1} };
        window.tempCytoscapeData['nodes'].push(issue_node_data);
        }
        var solution_category = $('#solution_category').val();
        for (const solution_entry in solution_category) {
        var solution_node_data = { data: { parent: 'Solutions', id: 'S:' + solution_category[solution_entry], weight: 1} };
        window.tempCytoscapeData['nodes'].push(solution_node_data);
        }

        var edge_width = (((issue_category.length*1/(issue_category.length)) + (solution_category.length*1/(solution_category.length)))/(issue_category.length + solution_category.length))*3;
        for (var issue_entry in issue_category) {
            for (var solution_entry in solution_category) {

            var edge_data = { data: { source: 'I:' + issue_category[issue_entry], target: 'S:' + solution_category[solution_entry], color: '#' + issue_color, width: edge_width} }
            window.tempCytoscapeData['edges'].push(edge_data);
            }
        }
      // console.log(tempCytoscapeData);
      var cy = cytoscape({

        container: document.getElementById('cy'), // container to render in
        
        elements: tempCytoscapeData,

        style: [ // the stylesheet for the graph
        {
            selector: 'node',
            style: {
            'background-color': '#666',
            'label': 'data(id)'
            }
        },
        {
            selector: 'node:parent',
            style: {
            'shape' : 'round-rectangle',
            'background-opacity': 0.10
            }
        },
        {
            selector: 'edge',
            style: {
            'width': 'data(width)',
            'line-color': 'data(color)',
            'target-arrow-color': '#000',
            'target-arrow-shape': 'triangle',
            'curve-style': 'haystack'
            }
        }
        ],
        
        });
        var layout = cy.layout({
          name: 'fcose',
          animate: false,
        });
        layout.run();
    }
});