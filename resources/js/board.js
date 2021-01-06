import { fabric } from "fabric";
let boardHeight = 555;
let boardWidth = 0;
$(document).ready(function(){ 
   if($('#boardCanvas').length) fabricInit()
})

function fabricInit(){
    boardWidth = $('#board-container').width()
    var canvas = new fabric.Canvas(boardCanvas,{ selection: false, height: boardHeight,  width: boardWidth}),
    options = {
        distance: 20,
        width: canvas.width,
        height: canvas.height,
        param: {
            stroke: '#ebebeb',
            strokeWidth: 1,
            selectable: false
        }
    },
    gridLen = options.width / options.distance;    
    for (var i = 0; i < gridLen; i++) {
        var distance   = i * options.distance,
            horizontal = new fabric.Line([ distance, 0, distance, options.width], options.param),
            vertical   = new fabric.Line([ 0, distance, options.width, distance], options.param);
        canvas.add(horizontal);
        canvas.add(vertical);
        if(i%5 === 0){
            horizontal.set({stroke: '#cccccc'});
            vertical.set({stroke: '#cccccc'});
        };
    };
    canvas.isDrawingMode = true;
    canvas.freeDrawingBrush = new
    fabric.PencilBrush(canvas); 
    canvas.freeDrawingBrush.width = 4;
    canvas.freeDrawingBrush.color = '#ff00ff';
}