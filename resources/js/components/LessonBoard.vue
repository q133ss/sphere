<template>
    <div class="board-container" ref="boardContainer">
        <button class="btn btn-secondary btn-sm" @click="clear">Очистить</button>
        <canvas class="board-canvas" ref="boardCanvas"></canvas>
        {{width}}
    </div>
</template>
<script>
import { fabric } from "fabric";
export default {
    props: ['board_id', 'lesson_id'],
    data(){
        return {
            boardData: null,
            canvas: false,
            width: 0,
            height: 555,
            channel: false,
            remoteAdd: false
        }
    },
    mounted(){
        this.width = this.$refs.boardContainer.offsetWidth
        this.canvas = new fabric.Canvas(this.$refs.boardCanvas,{ selection: false, height: this.height,  width: this.width})
        // this.canvas.setOverlayColor({source: '/images/grid.jpg'}, this.canvas.renderAll.bind(this.canvas));
        // this.drawGrid()
        this.canvas.isDrawingMode = true
        this.canvas.freeDrawingBrush = new fabric.PencilBrush(this.canvas)
        this.canvas.freeDrawingBrush.width = 4;
        this.canvas.freeDrawingBrush.color = '#ff00ff'
        this.canvas.on('object:added', obj => {
            if(!this.remoteAdd){
                this.channel.trigger('client-add', obj.target.toJSON())
            }else{
                this.remoteAdd = false
            }
        })
        this.channel = pusher.subscribe('presence-lesson-channel-' + this.lesson_id)
        this.channel.bind('client-add', obj => {
            this.remoteAdd = true;
            fabric.util.enlivenObjects([obj], objects => {
                var origRenderOnAddRemove = this.canvas.renderOnAddRemove
                this.canvas.renderOnAddRemove = false
                objects.forEach( o => { this.canvas.add(o) })
                this.canvas.renderOnAddRemove = origRenderOnAddRemove
                this.canvas.renderAll()
            })
        })
    },
    async created(){

    },
    methods: {
        drawGrid(){
            const options = {
                distance: 20,
                width: this.canvas.width,
                height: this.canvas.height,
                param: {
                    stroke: '#ebebeb',
                    strokeWidth: 1,
                    selectable: false
                }
            },
            gridLen = options.width / options.distance
            for (var i = 0; i < gridLen; i++) {
                var distance   = i * options.distance,
                    horizontal = new fabric.Line([ distance, 0, distance, options.width], options.param),
                    vertical   = new fabric.Line([ 0, distance, options.width, distance], options.param)
                this.canvas.add(horizontal)
                this.canvas.add(vertical)
                if(i%5 === 0){
                    horizontal.set({stroke: '#cccccc'})
                    vertical.set({stroke: '#cccccc'})
                };
            };
        },
        clear(){
            this.canvas.clear()
            this.handleMouseUp()
            // this.drawGrid()
        }
    }
}
</script>