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
    window.current_issue_color = $('#compass_color').val();
    $('.choices__input').change(function() {
        updateCytoscape();
    });
    updateCytoscape();
    var md = new MobileDetect(window.navigator.userAgent);
    var geoStepMobile = "<li>Tap on the map where there\'s an issue<br/>(pinch to zoom).</li>";
    var geoStepOther = "<li>Click on the map where there\'s an issue (use your mousewheel to zoom).<br/></li>";
    var mobileStep = "<li>Click the <b class='text-xs'>GO TO ISSUE</b> button.</li>";
    var descriptionStep = "<li>Provide a description and category of the issue and solution.</li>";
    var reportStep = "<li>Click Report.</li>";
    // Setting the Report instructions this really hackish way.
    var instructionsMobile = "<ol style='list-style: decimal;'>" + geoStepMobile + mobileStep + descriptionStep + reportStep + "</ol>";
    var instructionsOther = "<ol style='list-style: decimal;'>" + geoStepOther + descriptionStep + reportStep + "</ol>";
    
    if (md.mobile())
    {
        $('#instructions').hide().html(instructionsMobile).fadeIn(1000);
        var startItem;
    } else {
        $('#instructions').html(instructionsOther).fadeIn(1000);
    }
    var reportFill = new Fill({
        color: '#' + current_issue_color,
    });
    
    var reportStroke = new Stroke({
        color: 'rgba(0, 0, 0, 0.5)',
        width: 3
    });
    
    var styles = [
        new Style({
            image: new CircleStyle({
            radius: 8,
            fill: reportFill,
            stroke: reportStroke,
            }),
        }),
    ];
    
    var tLayer = new TileLayer({
        source: new OSM(),
    });
    
    var reportJSON = new VectorSource({
        format: new GeoJSON({
            defaultDataProjection: 'EPSG:4326' // added line
        }),
        url: '../data/reportJSON/'
    });
    
    var reportLayer = new VectorLayer({
        title: 'Report Data',
        source: reportJSON,
        visible: true,
        style: function (feature, resolution) {
        return [new Style({
        image: new CircleStyle({
                radius: 8,
                fill: new Fill({ color: '#' + feature.get('color') }),
                stroke: reportStroke
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

    var reportView = new View({
        center: transform([use_longitude, use_latitude], 'EPSG:4326', 'EPSG:3857'),
        zoom: 10,
    });
    
    var reportMap = new Map({
        layers: [tLayer, reportLayer],
        target: 'reportMap',
        view: reportView,
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
    var overlayFeatureIssue = document.querySelector('.report-issue');
    var overlayFeatureSolution = document.querySelector('.report-solution');
    
    const overlayLayer = new Overlay({
        element: overlayContainerElement,
        autoPan: true
    })

    reportMap.addOverlay(overlayLayer);

    reportMap.on("pointermove", function () {
        this.getTargetElement().style.cursor = 'pointer';
    });

    reportMap.on('singleclick', function (evt) {

        var bounds = transformExtent(reportMap.getView().calculateExtent(reportMap.getSize()), 'EPSG:3857','EPSG:4326');
        var coordinates = toLonLat(evt.coordinate);
        var latitude = coordinates[1];
        var longitude = coordinates[0];

        overlayLayer.setPosition(undefined);

        reportMap.forEachFeatureAtPixel(evt.pixel, function (feature, layer)
        {
            let clickedCoordinate = evt.coordinate;
            let color = '#' + feature.get('color');
            let socialCompass = feature.get('social-compass');
            let economicCompass = feature.get('economic-compass');
            let issue = decodeEntities(feature.get('issue'));
            let solution = decodeEntities(feature.get('solution'));
            // let view = reportMap.getView();
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
                return layerCandidate.get('title') === 'Report Data';
            }
        })
        

        reportMap.getLayers().forEach(layer => {
            if (layer && layer.get('name') === 'report') {
                reportMap.removeLayer(layer);
            }
        });
        var report = new VectorLayer({
            name: 'report',
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
        $('#report_flag').val(1);

        reportMap.addLayer(report);
        window.livewire.emit('set:map-attributes', $('#latitude').val(), $('#longitude').val(), $('#north_latitude').val(), $('#south_latitude').val(), $('#east_longitude').val(), $('#west_longitude').val());
    });
    window.addEventListener('duration', dur => {
        alert('Duration: ' + dur.detail);
    })
    reportMap.on('moveend', function () {
        var bounds = transformExtent(reportMap.getView().calculateExtent(reportMap.getSize()), 'EPSG:3857','EPSG:4326');
        $('#north_latitude').val(bounds[3]);
        $('#south_latitude').val(bounds[1]);
        $('#east_longitude').val(bounds[0]);
        $('#west_longitude').val(bounds[2]);
        window.livewire.emit('set:map-attributes', $('#latitude').val(), $('#longitude').val(), $('#north_latitude').val(), $('#south_latitude').val(), $('#east_longitude').val(), $('#west_longitude').val());
    });

    Livewire.on('saved', () => {
        
        reportMap.getLayers().forEach(layer => {
            if (layer && layer.get('title') === 'Report Data') {
                reportMap.removeLayer(layer);
            }
        });
        var reportJSON = new VectorSource({
            format: new GeoJSON({
                defaultDataProjection: 'EPSG:4326' // added line
            }),
            url: '../data/reportJSON/'
        });
        console.log(reportJSON);
        var reportLayer = new VectorLayer({
            title: 'Report Data',
            source: reportJSON,
            visible: true,
            style: function (feature, resolution) {
            return [new Style({
            image: new CircleStyle({
                    radius: 8,
                    fill: new Fill({ color: '#' + current_issue_color }),
                    stroke: reportStroke
                })
            })];
            }
        });
        reportMap.addLayer(reportLayer);
    })
    function updateCytoscape()
    {
        window.tempCytoscapeData = {};
        window.tempCytoscapeData['nodes'] = [];
        window.tempCytoscapeData['edges'] = [];
        window.tempCytoscapeData['nodes'].push({ data: { id: 'Issues' } });
        window.tempCytoscapeData['nodes'].push({ data: { id: 'Solutions' } });

        var issue_color = "#fff";
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

            var edge_data = { data: { source: 'I:' + issue_category[issue_entry], target: 'S:' + solution_category[solution_entry], color: '#' + current_issue_color, width: edge_width} }
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
            'haystack-radius' : .25,
            'curve-style': 'haystack'
            }
        }
        ],
        
        });
        var layout = cy.layout({
          name: 'fcose',
          animate: true,
        });
        layout.run();
    }
});