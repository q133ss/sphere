<template>
    <div class="card">
		<div class="card-header py-2" v-if="lesson">
            <div class="row">
                <div class="col-md-8 mb-1 mb-md-0">
                    {{lesson.subject.name}}
                    <div class="float-right">
                        <button class="btn btn-sm btn-icon btn-outline-secondary"><i class="fa fa-plus"></i></button>
                        <button class="btn btn-sm btn-icon btn-outline-secondary" @click="save" v-if="role == 'teacher'"><i class="fa fa-save"></i></button>
                        <!-- <button class="btn btn-sm btn-success" @click="done" v-if="!lesson.done">Завершить урок</button> -->
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
                            <button class="btn btn-icon mr-1 btn-outline-secondary" :class="{'active': canvasMode == 'draw'}" @click="setCanvasMode('draw')"><i class="fa fa-pencil" :style="{color: canvasColor}"></i></button>
                            <button class="btn btn-icon mr-1 btn-outline-secondary" :class="{'active': canvasMode == 'write'}" @click="setCanvasMode('write')"><i class="fa fa-font" :style="{color: canvasColor}"></i></button>
                            <button class="btn btn-icon mr-1 btn-outline-secondary" :class="{'active': canvasMode == 'select'}" @click="setCanvasMode('select')"><i class="fa fa-arrows-h"></i></button>
                            <span>
                                <button class="btn btn-icon btn-outline-secondary" data-toggle="dropdown" ><i class="fa fa-circle" :style="{color: canvasColor}"></i></button>
                                <div class="dropdown-menu">
                                    <div class="dropdown-item">
                                        <button class="btn btn-sm btn-icon mx-1" v-for="color in canvasColors" :key="color" @click="setCanvasColor(color)" :style="{background: color}"></button>
                                    </div>
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
				<div class="col-md-4">
                    <video-chat v-if="lesson" :allusers="role == 'teacher' ? [lesson.student] : [lesson.teacher]" :authUserId="user_id"/>
					<div>
						<div class="card" id="lesson-chat-container" ref="chat">
							<ul v-if="messages.length">
								<li v-for="message in messages" :key="message.id" :class="{right: message.user.id == lesson.student_id}">
									<span>
										<p class="mb-1"><i class="small">{{message.user.name}}</i> <time class="small">{{message.created_at | moment('DD.MM.YYYY HH:mm')}}</time></p>
										{{message.text}}
									</span>
								</li>
							</ul>
							<p v-else class="text-center text-muted">Пока никто ничего не написал</p>
						</div>
						<form @submit.prevent="send" class="d-block">
							<div class="input-group">
								<input v-model="text" class="form-control" :disabled="loading" placeholder="Сообщение">
								<div class="input-group-append">
									<button class="btn btn-primary" :disabled="loading"><i v-if="!loading" class="fa fa-send"></i><i class="fa fa-spinner fa-spin" v-else></i></button>
								</div>
							</div>
						</form>
					</div>
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
export default {
    props: ['user_id', 'role', 'lesson_id'],
    data(){
        return {
            lesson: false,
            sound: false,
            soundID: false,
            played: false,
            text: '',
            errors: {},
            uploadModel: {},
			messages: [],
			messageChannel: false,
			boardChannel: false,
			boardData: null,
            canvas: false,
            width: 0,
			height: 555,
            loading: false,
            canvasMode: 'draw',
            canvasColors: [ 'black', 'blue', 'green', 'red', 'brown', 'pink', 'yellow', 'orange', 'teal'],
            canvasColor: 'black',
            lastTarget: false,
            selectedObject: false,
            materialsListActive: false,
            fullscreen: false,
            progress: 0,
            totalTime: 500,
            timeStr: ''
        }
    },
    methods: {
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
        calcCanvasSize(){
            const width = this.$refs.canvasScreen.clientWidth
            const height = this.fullscreen ? (this.$refs.canvasScreen.clientHeight - 46) : this.height;
            console.log(height)
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
                this.boardChannel.trigger('client-play', file)
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
            }
        },
        canvasUndo(){
            var object = this.canvas.item(this.canvas.getObjects().length-1);
            this.canvas.remove(object);
            // if(!this.remoteEvent){
            //     this.boardChannel.trigger('client-undo', {})
            // }else{
            //     this.remoteEvent = false
            // }
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
		async send(){
            if(!this.text) return false
            this.loading = true
            try{
                const {data} = await axios.post('/pusher/lessons/' + this.lesson.id + '/message', {text: this.text})
                this.text = ''
            }catch(e){}
            finally{ this.loading = false}
        },
        scroll(){
            setTimeout(() => {
                const chat = this.$refs.chat
                chat.scrollTop = chat.scrollHeight;
            }, 100)
        },
		async save(){
            try{
                await axios.put('/lessons/' + this.lesson.id + '/saveBoard', { data: JSON.stringify(this.canvas.toJSON())})
                this.$toast.success('Данные успешно сохранены')
            }catch(e){}
		},
		clear(){
			this.canvas.clear();
			this.boardChannel.trigger('client-clear', {});
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
        pusher.unsubscribe('presence-lesson-channel-' + this.lesson_id)
    },
    async created(){
        this.interval = setInterval( this.timer, 1000 )
        const lesson = await axios.get('/lessons/' + this.lesson_id)
		this.lesson = lesson.data
        this.messages = this.lesson.messages
        this.scroll();
        this.messageChannel = pusher.subscribe('lesson.' + this.lesson_id);
        this.messageChannel.bind('message', signal => {
            this.messages.push(signal.message)
            this.scroll();
		})
        // //////////////////////////////////////////////////
        this.width = $('.board-container').width()
        $(window).resize(this.calcCanvasSize);
        this.canvas = new fabric.Canvas(this.$refs.boardCanvas, { height: this.height,  width: this.width})
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
                this.boardChannel.trigger('client-modified', target.toObject(['name']))
            }else{
                this.remoteEvent = false
            }
        })
        this.canvas.on('mouse:down', (data) => {
            if(this.canvasMode === 'eraser' && data.target) this.canvas.remove(data.target);
            else if(this.canvasMode == 'write'){
                let text = new fabric.Textbox('', { left: data.absolutePointer.x, top: data.absolutePointer.y} );
                text.set({ fill: this.canvasColor });
                this.canvas.add(text);
                this.canvas.setActiveObject(text);
                text.enterEditing();
                text.hiddenTextarea.focus();
                this.setCanvasMode('select')
            }
        })
        this.canvas.on('object:added', ({target}) => {
            if(!this.remoteEvent){
                target.name = this.generateId();
                this.boardChannel.trigger('client-add', target.toObject(['name']))
            }else{
                this.remoteEvent = false
            }
        })
        this.canvas.on('object:removed', ({target}) => {
            if(!this.remoteEvent){
                this.boardChannel.trigger('client-removed', {
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
		this.boardChannel = pusher.subscribe('presence-lesson-channel-' + this.lesson_id)
		this.boardChannel.bind('client-clear', signal => {
			this.remoteEvent = true
			this.clear()
        })
        this.boardChannel.bind('client-play', file => {
            this.remoteEvent = true
            this.play(file)
        })
        this.boardChannel.bind('client-add', obj => {
            this.remoteEvent = true;
            this.addRemoteObj(obj)
        })
        this.boardChannel.bind('client-undo', obj => {
            this.remoteEvent = true;
            this.canvasUndo()
        })
        this.boardChannel.bind('client-removed', obj => {
            this.remoteEvent = true;
            this.canvas.getObjects().forEach(o => {
                if(o.name == obj.name) {
                    this.canvas.remove(o);
                }
            })
        })
        this.boardChannel.bind('client-modified', obj => {
            this.remoteEvent = true;
            this.canvas.getObjects().forEach(o => {
                if(o.name == obj.name) {
                    this.canvas.remove(o);
                    this.addRemoteObj(obj)
                }
            })
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