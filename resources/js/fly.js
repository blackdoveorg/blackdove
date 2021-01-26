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
    
    window.flyJSON = new VectorSource({
        format: new GeoJSON({
            defaultDataProjection: 'EPSG:4326' // added line
        }),
        url: '../data/flyJSON/'
    });

    var clusterSource = new Cluster({
        distance: 40,
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
        zoom: 1,
    });
    
    var flyMap = new Map({
        layers: [tLayer, clusters],
        renderer: 'canvas',
        target: 'flyMap',
        view: flyView,
    });

    flyJSON.on('change', function(evt) {
    var source = evt.target;
    if(source.getState() === 'ready'){
        window.cytoscapeData = {};
        window.cytoscapeData['nodes'] = [];
        window.cytoscapeData['edges'] = [];
        var features = flyJSON.getFeatures();
        var feature;
        for (var i = 0, ii = features.length; i < ii; ++i) {
          feature = features[i];
          var issue_category = feature.get('issue_category');
          for (const issue_entry in issue_category) {
            var issue_node_data = { data: { id: issue_category[issue_entry], weight: 1} };
            window.cytoscapeData['nodes'].push(issue_node_data);
          }
          var solution_category = feature.get('solution_category');
          for (const solution_entry in solution_category) {
            var solution_node_data = { data: { id: solution_category[solution_entry], weight: 1} };
            window.cytoscapeData['nodes'].push(solution_node_data);
          }
          for (var issue_entry in issue_category) {
            for (var solution_entry in solution_category) {
              var edge_data = { data: { source: issue_category[issue_entry], target: solution_category[solution_entry], width: 5} }
              window.cytoscapeData['edges'].push(edge_data);
            }
          }
        }
        console.log(cytoscapeData);
        var cy = cytoscape({

          container: document.getElementById('cy'), // container to render in
          
          elements: cytoscapeData,

          style: [ // the stylesheet for the graph
          {
              selector: 'node',
              style: {
              'background-color': '#666',
              'label': 'data(id)'
              }
          },

          {
              selector: 'edge',
              style: {
              'width': 'data(width)',
              'line-color': '#ccc',
              'target-arrow-color': '#ccc',
              'target-arrow-shape': 'triangle',
              'curve-style': 'bezier'
              }
          }
          ],

          });
          var layout = cy.layout({
          name: 'circle'
          });
          layout.run();
      }
      
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
    var overlayFeatureIssue = document.querySelector('.fly-issue');
    var overlayFeatureSolution = document.querySelector('.fly-solution');
    
    const overlayLayer = new Overlay({
        element: overlayContainerElement,
        autoPan: true
    })

    flyMap.addOverlay(overlayLayer);

    flyMap.on("pointermove", function () {
        this.getTargetElement().style.cursor = 'pointer';
    });

    flyMap.on('click', function (evt) {
        var coordinates = toLonLat(evt.coordinate);

        overlayLayer.setPosition(undefined);
        
        flyMap.forEachFeatureAtPixel(evt.pixel, function (feature, layer)
        {
            // console.log('clicked');

            if (feature)
            {
                // console.log(feature);
                let clickedCoordinate = evt.coordinate;
                if (typeof feature.get('features') === 'undefined') {
                    overlayFeatureIssue.innerHTML = '';
                    overlayFeatureSolution.innerHTML = '';
                } else {
                    var cfeatures = feature.get('features');
                    //console.log(cfeatures);
                    // if (cfeatures.length > 1) {
                    //     popup_content.innerHTML = '<h5><strong>all "Sub-Features"</strong></h5>';
                    //     for (var i = 0; i < cfeatures.length; i++) {
                    //         $(popup_content).append('<article><strong>' + cfeatures[i].get('name') + '</article>');
                    //     }
                    // }

                    if (cfeatures.length === 1) {
                        overlayFeatureIssue.innerHTML = cfeatures[0].get('issue');
                        overlayFeatureSolution.innerHTML = cfeatures[0].get('solution');
                        overlayFeatureCompass.style.backgroundColor = '#' + cfeatures[0].get('color');
                        overlayFeatureSocialCompass.innerHTML = cfeatures[0].get('social-compass');
                        overlayFeatureEconomicCompass.innerHTML = cfeatures[0].get('economic-compass');
                    }
                }
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