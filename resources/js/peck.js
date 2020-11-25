$(function() {
    const canvas = document.querySelector('#box')
    const ctx = canvas.getContext('2d')

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
        canvas.width = width
        canvas.height = height
        drawCanvas();
    }

    resizeCanvas(window.innerWidth, window.innerHeight);

    //Variables
    var canvasx = $('#box').offset().left;
    var canvasy = $('#box').offset().top;
    var last_mousex = last_mousey = 0;
    var mousex = mousey = 0;
    var mousedown = false;

    //Mousedown
    $('#box').on('mousedown', function(e) {
        last_mousex = parseInt(e.clientX-canvasx);
        last_mousey = parseInt(e.clientY-canvasy);
        mousedown = true;
    });

    //Mouseup
    $('#box').on('mouseup', function(e) {
        mousedown = false;
    });

    //Mousemove
    $('#box').on('mousemove', function(e) {
        mousex = parseInt(e.clientX-canvasx);
        mousey = parseInt(e.clientY-canvasy);
        if(mousedown) {
            //ctx.clearRect(0,0,canvas.width,canvas.height); //clear canvas
            ctx.beginPath();
            var width = mousex-last_mousex;
            var height = mousey-last_mousey;
            ctx.rect(last_mousex,last_mousey,width,height);
            ctx.strokeStyle = 'black';
            ctx.lineWidth = 2;
            ctx.stroke();
        }
        //Output
        $('#output').html('current: '+mousex+', '+mousey+'<br/>last: '+last_mousex+', '+last_mousey+'<br/>mousedown: '+mousedown);
    });

    window.addEventListener('resize', () => resizeCanvas(window.innerWidth, window.innerHeight))
});