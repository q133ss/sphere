<template>
    <div class="card">
		<div class="card-header py-2" v-if="lesson">
            <div class="row">
                <div class="col-md-8 mb-1 mb-md-0">
                    {{lesson.subject.name}}
                    <div class="float-right">
                        <button class="btn btn-sm btn-icon btn-outline-secondary"><i class="fa fa-plus"></i></button>
                        <button class="btn btn-sm btn-icon btn-outline-secondary" @click="save" v-if="role == 'teacher'"><i class="fa fa-save"></i></button>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center">
                    <div class="w-100">
                        <div class="progress mb-1" style="height: 1px;">
                            <div class="progress-bar bg-warning" role="progressbar" :style="{width: 16.66 + '%'}"></div>
                        </div>
                        <div class="progress bg-success position-relative">
                            <div class="progress-bar" role="progressbar" :style="{width: progress + '%'}"></div>
                            <div class="text-light justify-content-center d-flex position-absolute w-100 align-items-center h-100">{{timeStr}}</div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
        <div class="card-body">
			<div class="row">
				<div class="col-md-8">
					<div class="card" ref="canvasScreen">
						<div class="card-header p-1">
                            <button class="btn btn-icon mr-1 btn-outline-secondary" @click="materialsListActive = !materialsListActive" v-if="role == 'teacher'"><i class="fa fa-plus text-primary"></i></button>
                            <button class="btn btn-icon mr-1 btn-outline-secondary" @click="zoom(true)"><i class="fa fa-search-plus text-info"></i></button>
                            <button class="btn btn-icon mr-1 btn-outline-secondary" @click="zoom(false)"><i class="fa fa-search-minus text-info"></i></button>
                            <button class="btn btn-icon mr-1 btn-outline-secondary" @click="clear" v-if="role == 'teacher'"><i class="fa fa-trash text-danger"></i></button>
                            <button class="btn btn-icon mr-1 btn-outline-secondary" :class="{'active': canvasMode == 'eraser'}" @click="setCanvasMode('eraser')"><i class="fa fa-eraser text-warning"></i></button>
                            <button class="btn btn-icon mr-1 btn-outline-secondary" @click="canvasUndo"><i class="fa fa-undo text-warning"></i></button>
                            <button class="btn btn-icon mr-1 btn-outline-secondary" :class="{'active': canvasMode == 'circle'}" @click="setCanvasMode('circle')"><i class="fa fa-circle-thin " :style="{color: canvasColor}"></i></button>
                            <button class="btn btn-icon mr-1 btn-outline-secondary" :class="{'active': canvasMode == 'rect'}" @click="setCanvasMode('rect')"><i class="fa fa-square-o " :style="{color: canvasColor}"></i></button>
                            <button class="btn btn-icon mr-1 btn-outline-secondary" :class="{'active': canvasMode == 'line'}" @click="setCanvasMode('line')"><i class="fa fa-minus " :style="{color: canvasColor}"></i></button>
                            <button class="btn btn-icon mr-1 btn-outline-secondary" :class="{'active': canvasMode == 'draw'}" @click="setCanvasMode('draw')"><i class="fa fa-pencil" :style="{color: canvasColor}"></i></button>
                            <button class="btn btn-icon mr-1 btn-outline-secondary" :class="{'active': canvasMode == 'write'}" @click="setCanvasMode('write')"><i class="fa fa-font" :style="{color: canvasColor}"></i></button>
                            <button class="btn btn-icon mr-1 btn-outline-secondary" :class="{'active': canvasMode == 'select'}" @click="setCanvasMode('select')"><i class="fa fa-arrows-h"></i></button>
                            <button class="btn btn-icon mr-1 btn-outline-secondary" @click="moveUp"><i class="fa fa-chevron-up"></i></button>
                            <button class="btn btn-icon mr-1 btn-outline-secondary" @click="moveDown"><i class="fa fa-chevron-down"></i></button>
                            <span>
                                <button class="btn btn-icon btn-outline-secondary" data-toggle="dropdown"><i class="fa fa-circle" :style="{color: canvasColor}"></i></button>
                                <div class="dropdown-menu">
                                    <button class="btn btn-sm btn-icon mx-1" v-for="color in canvasColors" :key="color" @click="setCanvasColor(color)" :style="{background: color}"></button>
                                    <span class="dropdown">
                                        <button class="btn btn-sm btn-icon mx-1" @click.stop="showMoreColors"><i class="fa fa-plus"></i></button>
                                        <div class="dropdown-menu" id="moreColors">
                                            <color-picker v-model="canvasColor" @input="moreColorClickHandler"/>
                                        </div>
                                    </span>
                                </div>
                            </span>
                            <span>
                                <button class="btn btn-icon btn-outline-secondary" data-toggle="dropdown">#</button>
                                <div class="dropdown-menu">
                                    <a href="#" class="dropdown-item" @click.prevent="setCanvasType('empty')">Чистый лист</a>
                                    <a href="#" class="dropdown-item" @click.prevent="setCanvasType('grid')">Клетка</a>
                                    <a href="#" class="dropdown-item" @click.prevent="setCanvasType('line')">Линейка</a>
                                </div>
                            </span>
                            <div class="float-right">
                                <button class="btn btn-icon btn-outline-secondary" @click="toggleFullScreen"><i class="fa fa-arrows-alt"></i></button>
                            </div>
						</div>
						<div class="board-container" ref="boardContainer">
                            <div class="materials-list d-flex align-items-center" :class="{active: materialsListActive}" v-if="lesson">
                                <button class="btn btn-primary btn-lg mx-3" @click="showUploadModal"><i class="fa fa-plus"></i></button>
                                <div class="card" :style="{backgroundImage: 'url(/storage/' + file.src + ')'}" v-for="file in lesson.files" :key="file.id">
                                    <div class="buttons">
                                        <button class="btn btn-sm btn-danger" @click.prevent="destroyFile(file)"><i class="fa fa-trash"></i></button>
                                        <button v-if="!file.category || file.category == 'book'" class="btn btn-sm btn-success" @click.prevent="imgToCanvas(file)"><i class="fa fa-plus"></i></button>
                                        <button v-if="file.category == 'media'" class="btn btn-sm btn-success" @click.prevent="play(file)"><i class="fa" :class="{'fa-play': !soundID, 'fa-pause': soundID == file.id}"></i></button>
                                    </div>
                                </div>
                            </div>
							<canvas class="board-canvas" ref="boardCanvas"></canvas>
						</div>
					</div>
				</div>
				<div class="col-md-4" v-if="lesson">
                    <video-chat v-if="lesson" :lesson_id="lesson.id" :user="role == 'teacher' ? lesson.student : lesson.teacher" :auth="role == 'teacher' ? lesson.teacher : lesson.student"/>
					<chat-room :user_id="lesson.teacher.id == user_id ? lesson.student.id : lesson.teacher.id" :auth="lesson.teacher.id == user_id ? lesson.teacher : lesson.student"/>
				</div>
			</div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="upload-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавить материал</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="save">
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input v-model="uploadModel.type" class="form-check-input" type="radio" name="type" id="t1" value="1">
                                <label class="form-check-label" for="t1">С компьютера</label>
                            </div>
                            <div class="form-check form-check-inline" v-if="lesson.activeSubscribe">
                                <input v-model="uploadModel.type" class="form-check-input" type="radio" name="type" id="t2" value="2">
                                <label class="form-check-label" for="t2">Из библиотеки</label>
                            </div>
                        </div>
                        <div class="form-group" v-if="uploadModel.type == 1">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input simple-file" :class="{'is-invalid' : errors.file}" id="materialFile" ref="input">
                                <label class="custom-file-label" for="materialFile">Загрузить</label>
                                <div class="invalid-feedback" v-if="errors.file">{{errors.file}}</div>
                            </div>
                        </div>
                        <div class="row" v-else-if="uploadModel.type == 2">
                            <div class="col-md-6 form-group">
                                <select class="form-control" :class="{'is-invalid' : errors.material_id}" v-model="uploadModel.material_id">
                                    <option value="undefined" disabled>Выберите материал из списка</option>
                                    <option :value="m.id" v-for="m in lesson.materials" :key="m.id">{{m.name}}</option>
                                </select>
                                <div class="invalid-feedback" v-if="errors.material_id">{{errors.material_id}}</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" v-model="uploadModel.page" class="form-control" :class="{'is-invalid' : errors.page}" placeholder="Номер страницы">
                                <div class="invalid-feedback" v-if="errors.page">{{errors.page}}</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Отмена</button>
                    <button class="btn btn-sm btn-primary" @click="addMaterial">Добавить</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { fabric } from "fabric";
import { Swatches } from 'vue-color'
import ChatRoom from './ChatRoom'
export default {
    props: ['user_id', 'role', 'lesson_id'],
    components: {
        'color-picker': Swatches,
        ChatRoom
    },
    data(){
        return {
            lesson: false,
            sound: false,
            soundID: false,
            played: false,
            text: '',
            errors: {},
            uploadModel: {},
			channel: false,
			boardData: null,
            canvas: false,
            width: 0,
			height: 555,
            loading: false,
            canvasMode: 'draw',
            canvasColors: [ 'black', 'blue', 'green', 'red', 'brown', 'pink', 'yellow', 'orange', 'teal'],
            canvasColor: 'black',
            canvasType: 'empty',
            lastTarget: false,
            materialsListActive: false,
            fullscreen: false,
            progress: 0,
            totalTime: 500,
            timeStr: '',
            isDown: false,
            drawingObject: false,
            origX: 0,
            origY: 0
        }
    },
    methods: {
        moveUp(){
            this.canvas.bringForward(this.canvas.getActiveObject())
        },
        moveDown(){
            this.canvas.sendBackwards(this.canvas.getActiveObject())
        },
        showMoreColors(){
            $('#moreColors').addClass('show');
        },
        moreColorClickHandler(color){
            this.canvasColors.push(color.hex)
            this.setCanvasColor(color.hex)
        },
        toggleFullScreen(){
            if(this.fullscreen){
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) { /* Safari */
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) { /* IE11 */
                    document.msExitFullscreen();
                }
            }else{
                const elem = this.$refs.canvasScreen;
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.webkitRequestFullscreen) { /* Safari */
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) { /* IE11 */
                    elem.msRequestFullscreen();
                }
            }
            this.fullscreen = !this.fullscreen
            this.calcCanvasSize()
        },
        setCanvasType(type){
            this.canvasType = type
            if(type == 'empty')
                this.canvas.setBackgroundColor('rgba(255, 255, 255, 1)', this.canvas.renderAll.bind(this.canvas));
            else if(type == 'grid')
                this.canvas.setBackgroundColor({source: '/images/patterns/2.png'}, this.canvas.renderAll.bind(this.canvas));
            else if(type == 'line')
                this.canvas.setBackgroundColor({source: '/images/patterns/1.png'}, this.canvas.renderAll.bind(this.canvas));
            
        },
        calcCanvasSize(){
            const width = this.$refs.canvasScreen.clientWidth
            const height = this.fullscreen ? (this.$refs.canvasScreen.clientHeight - 46) : this.height;
            this.canvas.setWidth( width );
            this.canvas.setHeight( height );
            this.canvas.calcOffset();
        },
        zoom(flag){
            let zoom = this.canvas.getZoom();
            const delta = 50
            zoom = !flag ? zoom * (0.999 ** delta) : zoom / (0.999 ** delta);
            if (zoom > 20) zoom = 20;
            if (zoom < 0.01) zoom = 0.01;
            this.canvas.setZoom(zoom);
        },
        play(file){
            if(file.id == this.soundID){
                if(this.played) {
                    this.sound.pause()
                    this.played = false
                }else{
                    this.played = true
                    this.sound.play()
                }
            }else{
                this.soundID = file.id
                this.sound = new Audio('/storage/' + file.src)
                this.sound.play()
                this.played == true
            }
            if(this.remoteEvent){
                this.remoteEvent = false
            }else{
                this.boardChannel.trigger('play', file)
            }
        },
        async done(){
            try{
                await axios.post('/lessons/' + this.lesson.id + '/done')
                this.$set(this.lesson, 'done', 1)
                alert('Урок успешно завершен')
            }catch(e){}
        },
        showUploadModal(){
            this.uploadModel = {}
            $('#upload-modal').modal('show')
        },
        setCanvasColor(color){
            this.canvasColor = color;
            this.canvas.freeDrawingBrush.color = color
        },
        setCanvasMode(mode){
            this.canvasMode = mode
            if(this.canvasMode == 'draw'){
                this.canvas.isDrawingMode = true
                this.canvas.selection = false
            }else if(this.canvasMode == 'select'){
                this.canvas.hoverCursor = 'pointer';
                this.canvas.isDrawingMode = false
                this.canvas.selection = true
            }else if(this.canvasMode == 'write'){
                this.canvas.isDrawingMode = false
                this.canvas.selection = false
            }else if(this.canvasMode == 'eraser'){
                this.canvas.hoverCursor = 'no-drop';
                this.canvas.isDrawingMode = false
                this.canvas.selection = false
            }else if(this.canvasMode == 'circle' || this.canvasMode == 'line' || this.canvasMode == 'rect'){
                this.canvas.hoverCursor = 'pointer';
                this.canvas.isDrawingMode = false
                this.canvas.selection = false
            }
        },
        canvasUndo(){
            var object = this.canvas.item(this.canvas.getObjects().length-1);
            this.canvas.remove(object);
        },
        async destroyFile(file){
            try{
                await axios.delete('/lessons/deleteFile/' + file.id)
                this.lesson.files.splice(this.lesson.files.findIndex( f => f.id == file.id), 1)
                this.$toast.success('Файл успешно удален')
            }catch(e){}
        },
        imgToCanvas(file){
            fabric.Image.fromURL('/storage/' + file.src, obj => {
                obj.scaleToWidth(this.width/2);
                obj.set({ left: 5, top: 5});
                this.canvas.add(obj);
                this.canvas.sendToBack(obj)
                this.materialsListActive = false
            });
        },
        async addMaterial(){
            let valid = true
            const errors = {}
            if(!this.uploadModel.type) return false
            if(this.uploadModel.type == 1 && !this.$refs.input.files.length){
                this.errors.file = 'Не выбран файл'
                valid = false
            }
            if(this.uploadModel.type == 2 && !this.uploadModel.material_id){
                this.errors.material_id = 'Не выбран материал'
                valid = false
            }
            if(this.uploadModel.type == 2 && !this.uploadModel.page){
                this.errors.material_id = 'Не указан номер страницы'
                valid = false
            }
            this.errors = errors
            if(!valid) return false
            const formData = new FormData()
            formData.append('type', this.uploadModel.type)
            if(this.uploadModel.type == 1){
                formData.append('file', this.$refs.input.files[0])
            }else{
                formData.append('material_id', this.uploadModel.material_id)
                formData.append('page', this.uploadModel.page)
            }
            try{
                const {data} = await axios.post('/lessons/' + this.lesson.id + '/addMaterial', formData)
                this.$set(this.lesson, 'files', data)
                $('#upload-modal').modal('hide')
            }catch(e){
                console.log(e);
                this.errors = e.response.data.errors
            }
        },
		async save(){
            try{
                await axios.put('/lessons/' + this.lesson.id + '/saveBoard', { data: JSON.stringify(this.canvas.toJSON())})
                this.$toast.success('Данные успешно сохранены')
            }catch(e){}
		},
		clear(){
			this.canvas.clear();
            this.setCanvasType(this.canvasType)
			this.boardChannel.trigger('clear', {});
        },
        generateId(){
            return `f${(~~(Math.random()*1e8)).toString(16)}`;
        },
        addRemoteObj(data){
            this.remoteEvent = true;
            fabric.util.enlivenObjects([data], objects => {
                const obj = objects[0];
                obj.id = data.id;
                var origRenderOnAddRemove = this.canvas.renderOnAddRemove;
                this.canvas.renderOnAddRemove = false;
                this.canvas.add(obj);
                this.canvas.renderOnAddRemove = origRenderOnAddRemove;
                this.canvas.renderAll();
            });
        },
        timer(){
            this.totalTime ++
            this.progress = Math.floor(this.totalTime * 100 / 3600)
            let minuts = parseInt(this.totalTime / 60 )
            if(minuts < 10) minuts = '0' + minuts
            let seconds = this.totalTime - minuts * 60 
            if(seconds < 10) seconds = '0' + seconds
            this.timeStr = minuts + ':' + seconds
            if(this.totalTime == 3600 ){
                clearInterval(this.interval)
                this.$swal({
                    text: 'Урок завершен',
                    icon: 'success',
                });
            }
        }
    },
    async beforeRouteLeave (to, from , next) {
        const {isConfirmed} = await this.$swal({
            text: 'Урок еще не закончен, вы уверены, что хотите покинуть его?',
            icon: 'info',
            showDenyButton: true,
            confirmButtonText: 'Подтвердить',
            denyButtonText: 'Отмена',
        });
        next(isConfirmed);
    },
    beforeDestroy(){
        Echo.leave('App.Models.Lesson.' + this.lesson.id)
    },
    async created(){
        this.interval = setInterval( this.timer, 1000 )
        const lesson = await axios.get('/lessons/' + this.lesson_id)
		this.lesson = lesson.data
        this.channel = Echo.join('App.Models.Lesson.' + this.lesson_id)
		.listenForWhisper('clear', signal => {
			this.remoteEvent = true
			this.clear()
        })
        .listenForWhisper('play', file => {
            this.remoteEvent = true
            this.play(file)
        })
        .listenForWhisper('add', obj => {
            this.remoteEvent = true;
            this.addRemoteObj(obj)
        })
        .listenForWhisper('undo', obj => {
            this.remoteEvent = true;
            this.canvasUndo()
        })
        .listenForWhisper('removed', obj => {
            this.remoteEvent = true;
            this.canvas.getObjects().forEach(o => {
                if(o.name == obj.name) {
                    this.canvas.remove(o);
                }
            })
        })
        .listenForWhisper('modified', obj => {
            this.remoteEvent = true;
            this.canvas.getObjects().forEach(o => {
                if(o.name == obj.name) {
                    this.canvas.remove(o);
                    this.addRemoteObj(obj)
                }
            })
        })
        // //////////////////////////////////////////////////
        this.width = $('.board-container').width()
        $(window).resize(this.calcCanvasSize);
        this.canvas = new fabric.Canvas(this.$refs.boardCanvas, { height: this.height,  width: this.width, preserveObjectStacking: true})
        this.canvas.freeDrawingBrush = new fabric.PencilBrush(this.canvas)
        this.canvas.freeDrawingBrush.width = 4;
        this.canvas.freeDrawingBrush.color = 'black'
        this.setCanvasMode('select')
        if(this.lesson.lesson_boards.length){
            this.canvas.loadFromJSON(this.lesson.lesson_boards[0].data, () => {
                this.canvas.renderAll();
            });
        }
        this.canvas.on('object:modified', ({target}) => {
            if(!this.remoteEvent){
                this.channel.whisper('modified', target.toObject(['name']))
            }else{
                this.remoteEvent = false
            }
        })
        this.canvas.on('mouse:move', (data) => { 
            if(this.isDown && this.drawingObject){
                if(this.canvasMode == 'circle'){
                    this.drawingObject.set({
                        radius: Math.abs(this.origX - data.absolutePointer.x)
                    });
                }else if(this.canvasMode == 'line'){
                    this.drawingObject.set({
                       x2: data.absolutePointer.x,
                       y2: data.absolutePointer.y
                    });
                }else if(this.canvasMode == 'rect'){
                    this.drawingObject.set({
                       width: Math.abs(this.origX - data.absolutePointer.x),
                       height: Math.abs(this.origY - data.absolutePointer.y)
                    });
                }
                this.canvas.renderAll();
            }
        })
        this.canvas.on('mouse:up', (data) => {
            this.isDown = false
            if(['circle', 'line', 'rect'].indexOf(this.canvasMode) > -1){
                if(this.drawingObject) this.drawingObject.setCoords();
                this.drawingObject.name = this.generateId();
                this.channel.whisper('add', this.drawingObject.toObject(['name']))
                this.drawingObject = false   
            }
        })
        this.canvas.on('mouse:down', (data) => {
            if(['circle', 'line', 'rect'].indexOf(this.canvasMode) > -1){
                this.isDown = true;
            }
            this.origX = data.absolutePointer.x;
            this.origY = data.absolutePointer.y;
            if(this.canvasMode === 'eraser' && data.target){
                this.canvas.remove(data.target);
            } else if(this.canvasMode == 'write'){
                let text = new fabric.Textbox('', { left: data.absolutePointer.x, top: data.absolutePointer.y} );
                text.set({ fill: this.canvasColor });
                this.canvas.add(text);
                this.canvas.setActiveObject(text);
                text.enterEditing();
                text.hiddenTextarea.focus();
                this.setCanvasMode('select')
            } else if(this.canvasMode == 'circle'){
                this.drawingObject = new fabric.Circle({
                    left: data.absolutePointer.x,
                    top: data.absolutePointer.y,
                    radius: 0,
                    stroke: this.canvasColor,
                    strokeWidth: 3,
                    fill: ''
                });
                this.canvas.add(this.drawingObject);
                this.canvas.setActiveObject(this.drawingObject);
            } else if(this.canvasMode == 'line'){
                this.drawingObject = new fabric.Line([data.absolutePointer.x, data.absolutePointer.y, data.absolutePointer.x + 1, data.absolutePointer.y + 1],{
                    left: data.absolutePointer.x,
                    top: data.absolutePointer.y,
                    stroke: this.canvasColor,
                    strokeWidth: 3,
                    fill: ''
                });
                this.canvas.add(this.drawingObject);
                this.canvas.setActiveObject(this.drawingObject);
            } else if(this.canvasMode == 'rect'){
                this.drawingObject = new fabric.Rect({
                    left: data.absolutePointer.x,
                    top: data.absolutePointer.y,
                    width: 2,
                    height: 2,
                    fill: 'transparent',
                    stroke: this.canvasColor,
                    strokeWidth: 3,
                });
                this.canvas.add(this.drawingObject);
                this.canvas.setActiveObject(this.drawingObject);
            }
        })
        this.canvas.on('object:added', ({target}) => {
            if(!this.remoteEvent && !this.isDown){
                target.name = this.generateId();
                this.channel.whisper('add', target.toObject(['name']))
            }else{
                this.remoteEvent = false
            }
        })
        this.canvas.on('object:removed', ({target}) => {
            if(!this.remoteEvent){
                this.channel.whisper('removed', {
                    name: target.name
                })
            }else{
                this.remoteEvent = false
            }
        })
        this.canvas.on('mouse:wheel', opt => {
            var delta = opt.e.deltaY;
            var zoom = this.canvas.getZoom();
            zoom *= 0.999 ** delta;
            if (zoom > 20) zoom = 20;
            if (zoom < 0.01) zoom = 0.01;
            this.canvas.setZoom(zoom);
            opt.e.preventDefault();
            opt.e.stopPropagation();
        })
    }
}
</script>
<style lang="scss">
.materials-list{
    height: 0;
    overflow: auto;
    transition: 0.3s height;
    white-space: nowrap;
    &.active{
        height:128px;
    }
    .card{
        padding: 0;
        margin: 0 3px;
        width: 100px;
        height: 100px;
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        position: relative;
        .buttons{
            position: absolute;
            top: 5px;
            right: 5px;
        }
    }
}
</style>