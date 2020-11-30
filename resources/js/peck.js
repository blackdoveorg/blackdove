import ApexCharts from 'apexcharts'

$(function() {
    const canvas = document.querySelector('.box')
    const ctx = canvas.getContext('2d')

    const canvasDraw = document.querySelector('.draw')
    const ctxDraw = canvasDraw.getContext('2d')

    //Variables
    rect = {},
    drag = false;

    function init() {
        canvasDraw.addEventListener('mousedown', mouseDown, false);
        canvasDraw.addEventListener('mouseup', mouseUp, false);
        canvasDraw.addEventListener('mousemove', mouseMove, false);
    }

    function mouseDown(e) {
        rect.startX = e.pageX - this.offsetLeft;
        rect.startY = e.pageY - this.offsetTop;
        drag = true;
    }

    function mouseUp() {
        drag = false;
    }

    function mouseMove(e) {
        if (drag) {
            rect.w = (e.pageX - this.offsetLeft) - rect.startX;
            rect.h = (e.pageY - this.offsetTop) - rect.startY ;
            ctxDraw.clearRect(0,0,canvasDraw.width,canvasDraw.height);
            draw();
        }
    }
    function draw() {
        console.log(rect.startX, rect.startY, rect.w, rect.h);
        $('.bbox').css({
            'border' : '1px solid #f5f5f5',
            'position' : 'relative',
            'top' : rect.startY-350,
            'left' : rect.startX,
            'width' : rect.w,
            'height' : rect.h

        })
        //ctxDraw.fillRect(rect.startX, rect.startY, rect.w, rect.h);
    }

    // For drawing colors in corners of canvas element.
    const interpolate = (value, start, end) => (end - start) * value + start

    const interpolateRGB = (value, start, end) => {
    return {
        r: interpolate(value, start.r, end.r),
        g: interpolate(value, start.g, end.g),
        b: interpolate(value, start.b, end.b)
    }
    }

    const calcColor = (point, topLeft, topRight, bottomLeft, bottomRight) => {
    const top = interpolateRGB(point.x, topLeft, topRight)
    const bottom = interpolateRGB(point.x, bottomLeft, bottomRight)
    const result = interpolateRGB(point.y, top, bottom)
    return result
    }

    const drawCanvas = () => {
    const imageData = ctx.createImageData(canvas.width, canvas.height)
    for (let y = 0; y < canvas.height; y += 1) {
        for (let x = 0; x < canvas.width; x += 1) {
        const colors = [
            { r: 0, g: 179 , b: 255 },
            { r: 255, g: 59, b: 0 },
            { r: 0, g: 0, b: 0 },
            { r: 34, g: 230, b: 92 }
        ]
        const color = calcColor({ x: x / (canvas.width - 1), y: y / (canvas.height- 1) }, ...colors)
        imageData.data[(y * canvas.width + x) * 4] = color.r
        imageData.data[(y * canvas.width + x) * 4 + 1] = color.g
        imageData.data[(y * canvas.width + x) * 4 + 2] = color.b
        imageData.data[(y * canvas.width + x) * 4 + 3] = 255
        }
    }
    ctx.putImageData(imageData, 0, 0)
    }

    const resizeCanvas = (width, height) => {
        canvas.width = 350
        canvas.height = 350
        drawCanvas();
    }

    resizeCanvas(window.innerWidth, window.innerHeight);

    init();
    
    // $('.box').click(function(e){ e.stopPropagation();});
    window.addEventListener('resize', () => resizeCanvas(window.innerWidth, window.innerHeight))
    var options = {
        series: [{
        name: "SAMPLE A",
        data: [
        [16.4, 5.4], [21.7, 2], [25.4, 3], [19, 2], [10.9, 1], [13.6, 3.2], [10.9, 7.4], [10.9, 0], [10.9, 8.2], [16.4, 0], [16.4, 1.8], [13.6, 0.3], [13.6, 0], [29.9, 0], [27.1, 2.3], [16.4, 0], [13.6, 3.7], [10.9, 5.2], [16.4, 6.5], [10.9, 0], [24.5, 7.1], [10.9, 0], [8.1, 4.7], [19, 0], [21.7, 1.8], [27.1, 0], [24.5, 0], [27.1, 0], [29.9, 1.5], [27.1, 0.8], [22.1, 2]]
      },{
        name: "SAMPLE B",
        data: [
        [36.4, 13.4], [1.7, 11], [5.4, 8], [9, 17], [1.9, 4], [3.6, 12.2], [1.9, 14.4], [1.9, 9], [1.9, 13.2], [1.4, 7], [6.4, 8.8], [3.6, 4.3], [1.6, 10], [9.9, 2], [7.1, 15], [1.4, 0], [3.6, 13.7], [1.9, 15.2], [6.4, 16.5], [0.9, 10], [4.5, 17.1], [10.9, 10], [0.1, 14.7], [9, 10], [12.7, 11.8], [2.1, 10], [2.5, 10], [27.1, 10], [2.9, 11.5], [7.1, 10.8], [2.1, 12]]
      },{
        name: "SAMPLE C",
        data: [
        [21.7, 3], [23.6, 3.5], [24.6, 3], [29.9, 3], [21.7, 20], [23, 2], [10.9, 3], [28, 4], [27.1, 0.3], [16.4, 4], [13.6, 0], [19, 5], [22.4, 3], [24.5, 3], [32.6, 3], [27.1, 4], [29.6, 6], [31.6, 8], [21.6, 5], [20.9, 4], [22.4, 0], [32.6, 10.3], [29.7, 20.8], [24.5, 0.8], [21.4, 0], [21.7, 6.9], [28.6, 7.7], [15.4, 0], [18.1, 0], [33.4, 0], [16.4, 0]]
      }],
        chart: {
        height: 350,
        type: 'scatter',
        zoom: {
          enabled: true,
          type: 'xy'
        }
      },
      xaxis: {
        tickAmount: 10,
        labels: {
          formatter: function(val) {
            return parseFloat(val).toFixed(1)
          }
        }
      },
      yaxis: {
        tickAmount: 7
      }
      };

      var chart = new ApexCharts(document.querySelector("#chart"), options);
      chart.render();
    
});