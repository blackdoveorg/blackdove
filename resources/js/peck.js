import ApexCharts from 'apexcharts'

$(function() {

  var options = {
      series: [],
      chart: {
      height: 400,
      type: 'scatter',
      zoom: {
        enabled: true,
        type: 'xy'
      }, 
      animations: {
        enabled: false,
      }
    },
    xaxis: {
      min: -10,
      max: 10,
      tickAmount: 20,
      labels: {
        formatter: function(val) {
          return parseFloat(val).toFixed(0)
        }
      }
    },
    yaxis: {
      min: -10,
      max: 10,
      tickAmount: 20,
      labels: {
        formatter: function(val) {
          return parseFloat(val).toFixed(0)
        }
      }
    },
    grid: {
      xaxis: {
        lines: {
          show: true
        }
      },
      yaxis: {
        lines: {
          show: true
        }
      },
    },
    noData: {
      text: 'Loading...'
    },
  };

    var chart = new ApexCharts(document.querySelector("#chart"), options);

    chart.render();

    var url = '/data/peckJSON';

    $.getJSON(url, function(response) {

      chart.appendSeries(response);
      chart.updateOptions({
        xaxis: {
          categories: chart.w.globals.labels
        }
      })
    });

});

