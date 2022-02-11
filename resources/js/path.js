var introJs = require('intro.js');
var MobileDetect = require('mobile-detect');

var md = new MobileDetect(window.navigator.userAgent);
$('.tutorial').click(function()
{
    introJs().setOptions({
        steps: [{
          intro: "Hello world!"
        }, {
          element: document.querySelector('.browseMap'),
          intro: "Pinch to zoom in!"
        }]
      }).start();
});
