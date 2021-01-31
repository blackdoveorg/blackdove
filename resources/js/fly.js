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
import {Circle as CircleStyle, Fill, Stroke, Style, Text} from 'ol/style';
import GeoJSON from 'ol/format/GeoJSON';
import {Cluster} from 'ol/source';
import { getValueType } from 'ol/style/expressions';
import { debounce } from 'lodash';
import fcose from 'cytoscape-fcose';

$(function() {
  var closer = document.getElementById('popup-closer');

    cytoscape.use( fcose );


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
    
    window.flyJSON = new VectorSource({
        format: new GeoJSON({
            defaultDataProjection: 'EPSG:4326' // added line
        }),
        url: '../data/flyJSON/'
    });

    var clusterSource = new Cluster({
        distance: 50,
        source: flyJSON,
      });
      var styleCache = {};
      var clusters = new VectorLayer({
        source: clusterSource,
        style: function (feature) {
          var size = feature.get('features').length;
          var style = styleCache[size];
          if (!style) {
            style = new Style({
              image: new CircleStyle({
                radius: 10,
                stroke: new Stroke({
                  color: '#000',
                  width: '2'
                }),
                fill: new Fill({
                  color: '#808000',
                }),
              }),
              text: new Text({
                text: size.toString(),
                fill: new Fill({
                  color: '#fff',
                }),
              }),
            });
            styleCache[size] = style;
          }
          return style;
        },
      });

    var ip_latitude = $('#ip_latitude').val();
    var ip_longitude = $('#ip_longitude').val();

    var flyView = new View({
        center: transform([ip_longitude, ip_latitude], 'EPSG:4326', 'EPSG:3857'),
        zoom: 10,
    });
    
    window.flyMap = new Map({
        layers: [tLayer, clusters],
        renderer: 'canvas',
        target: 'flyMap',
        view: flyView,
    });

    function updateCytoscape()
    {
      window.tempCytoscapeData = {};
      window.tempCytoscapeData['nodes'] = [];
      window.tempCytoscapeData['edges'] = [];
      window.tempCytoscapeData['nodes'].push({ data: { id: 'Issues' } });
      window.tempCytoscapeData['nodes'].push({ data: { id: 'Solutions' } });
      var extent = flyMap.getView().calculateExtent(flyMap.getSize());
      flyJSON.forEachFeatureInExtent(extent, function(feature){
          var issue_color = feature.get('color');
          console.log(issue_color);
          var issue_category = feature.get('issue_category');
          for (const issue_entry in issue_category) {
            var issue_node_data = { data: { parent: 'Issues', id: 'I:' + issue_category[issue_entry], weight: 1} };
            window.tempCytoscapeData['nodes'].push(issue_node_data);
          }
          var solution_category = feature.get('solution_category');
          for (const solution_entry in solution_category) {
            var solution_node_data = { data: { parent: 'Solutions', id: 'S:' + solution_category[solution_entry], weight: 1} };
            window.tempCytoscapeData['nodes'].push(solution_node_data);
          }
          for (var issue_entry in issue_category) {
            for (var solution_entry in solution_category) {
              var edge_data = { data: { source: 'I:' + issue_category[issue_entry], target: 'S:' + solution_category[solution_entry], color: '#' + issue_color, width: 2} }
              window.tempCytoscapeData['edges'].push(edge_data);
            }
          }

      }); 
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
          css: {
            'background-opacity': 0.333
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
    

    function decodeEntities(encodedString) {
        var textArea = document.createElement('textarea');
        textArea.innerHTML = encodedString;
        return textArea.value;
    }

    var overlayContainerElement = document.querySelector('.overlay-container');
    var overlayFeatureCompass = document.querySelector('.compass-color');
    var overlayFeatureSocialCompass = document.querySelector('.social-compass');
    var overlayFeatureEconomicCompass = document.querySelector('.economic-compass');
    var overlayFeatureIssue = document.querySelector('.fly-issue');
    var overlayFeatureSolution = document.querySelector('.fly-solution');
    var clusterContainerElement = document.querySelector('.cluster-container');
    var clusterFeatureData = document.querySelector('.cluster-data');
    var overlayContainerElementCloser = document.getElementById('overlay-popup-closer');
    var clusterContainerElementCloser = document.getElementById('cluster-popup-closer');

    const overlayLayer = new Overlay({
        element: overlayContainerElement,
        autoPan: true
    })

    const clusterLayer = new Overlay({
        element: clusterContainerElement,
        autoPan: true
    })

    overlayContainerElementCloser.onclick = function () {
      overlayLayer.setPosition(undefined);
      return false;
    };

    clusterContainerElementCloser.onclick = function () {
      clusterLayer.setPosition(undefined);
      return false;
    };
    flyMap.addOverlay(overlayLayer);
    flyMap.addOverlay(overlayLayer);

    flyMap.addOverlay(clusterLayer);

    flyMap.on("pointermove", function () {
        this.getTargetElement().style.cursor = 'pointer';
    });

    clusterSource.on("change", _.debounce(updateCytoscape, 1500));
    
    flyJSON.on('change', function(evt) {
      var source = evt.target;
      if(source.getState() === 'ready'){
        updateCytoscape();
      }
    });
    flyMap.on('click', function (evt) {
        var coordinates = toLonLat(evt.coordinate);

        overlayLayer.setPosition(undefined);
        clusterLayer.setPosition(undefined);
        
        flyMap.forEachFeatureAtPixel(evt.pixel, function (feature, layer)
        {
            // console.log('clicked');

            if (feature)
            {
                console.log(feature);
                let clickedCoordinate = evt.coordinate;
                if (typeof feature.get('features') === 'undefined') {
                    overlayFeatureIssue.innerHTML = '';
                    overlayFeatureSolution.innerHTML = '';
                } else {
                    var cfeatures = feature.get('features');

                    if (cfeatures.length > 1) {
                      clusterFeatureData.innerHTML = 'There are ' + cfeatures.length + ' Perches in this area.<br/>Please zoom in to see more detailed information.';
                      clusterLayer.setPosition(clickedCoordinate);
                    } else if (cfeatures.length === 1) {
                      overlayFeatureIssue.innerHTML = cfeatures[0].get('issue');
                      overlayFeatureSolution.innerHTML = cfeatures[0].get('solution');
                      overlayFeatureCompass.style.backgroundColor = '#' + cfeatures[0].get('color');
                      overlayFeatureSocialCompass.innerHTML = cfeatures[0].get('social-compass');
                      overlayFeatureEconomicCompass.innerHTML = cfeatures[0].get('economic-compass');
                      overlayLayer.setPosition(clickedCoordinate);
                    }
                }   
            }
        })
    });
    window.fixContentHeight = function(){
      var viewHeight = $(window).height();
      var header = $("header");
      var navbar = $("nav");
      var content = $("#flyMap");
      var chart = $('#charts');
      var contentHeight = viewHeight - header.outerHeight() - navbar.outerHeight() - 50;
      content.height(contentHeight);
      chart.height(contentHeight);
      flyMap.updateSize();
  }
  fixContentHeight();

    $(window).resize(function(){
        fixContentHeight();
    });
});