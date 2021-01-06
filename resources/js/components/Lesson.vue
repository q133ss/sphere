<template>
    <div class="card">
		<div class="card-header py-2" v-if="lesson">
			{{lesson.subject.name}}
		</div>
        <div class="card-body">
			<div class="row">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header p-1">
							<!-- <button class="btn btn-sm btn-primary">Новая доска</button> -->
							<div class="float-left">
                                <button class="btn btn-secondary btn-sm mx-1" @click="clear" v-if="role == 'teacher'">Очистить</button>
                                <button class="btn btn-sm btn-primary" @click="showMaterialModal" v-if="role == 'teacher'"><i class="fa fa-plus"></i></button>
                                <div class="btn-group ml-2">
                                    <button class="btn btn-sm" @click="canvasUndo"><i class="fa fa-undo"></i></button>
                                    <button class="btn btn-sm" :class="{'btn-primary': canvasMode == 'draw'}" @click="setCanvasMode('draw')"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-sm" :class="{'btn-primary': canvasMode == 'select'}" @click="setCanvasMode('select')"><i class="fa fa-hand-pointer-o"></i></button>
                                    <button class="btn btn-sm" :class="{'btn-primary': canvasMode == 'write'}" @click="setCanvasMode('write')"><i class="fa fa-font"></i></button>
                                </div>
                            </div>
							<button class="float-right btn btn-sm btn-primary" @click="save" v-if="role == 'teacher'">Сохранить</button>
						</div>
						<div class="board-container" ref="boardContainer">
							<canvas class="board-canvas" ref="boardCanvas"></canvas>
						</div>
                        <div class="materials">
                            <div class="dropdown" v-for="file in lesson.files" :key="file.id">
                                <div class="card" data-toggle="dropdown" :style="{backgroundImage: 'url(/storage/' + file.src + ')'}"></div>
                                <div class="dropdown-menu dropup">
                                    <a href="" class="dropdown-item dropdown-item-action" @click.prevent="destroyFile(file)">Удалить</a>
                                    <a href="" class="dropdown-item dropdown-item-action" @click.prevent="imgToCanvas(file)">На доску</a>
                                </div>
                            </div>
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
										<i class="small">{{message.user.name}}</i> <time class="small">{{message.created_at | moment('DD.MM.YYYY HH:mm')}}</time><br>
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
        <div class="modal" tabindex="-1" role="dialog" id="modal-material">
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
                                <input v-model="materialModel.type" class="form-check-input" type="radio" name="type" id="t1" value="1">
                                <label class="form-check-label" for="t1">С компьютера</label>
                            </div>
                            <!-- <div class="form-check form-check-inline">
                                <input v-model="materialModel.type" class="form-check-input" type="radio" name="type" id="t2" value="2">
                                <label class="form-check-label" for="t2">Из библиотеки</label>
                            </div> -->
                        </div>
                        <div class="form-group" v-if="materialModel.type == 1">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input simple-file" :class="{'is-invalid' : errors.file}" id="materialFile" ref="input">
                                <label class="custom-file-label" for="materialFile">Загрузить</label>
                                <div class="invalid-feedback" v-if="errors.file">{{errors.file}}</div>
                            </div>
                        </div>
                        <div class="row" v-else-if="materialModel.type == 2">
                            <div class="col-md-6 form-group">
                                <select class="form-control" :class="{'is-invalid' : errors.material_id}" v-model="materialModel.material_id">
                                    <option value="undefined" disabled>Выберите материал из списка</option>
                                    <option :value="m.id" v-for="m in materials" :key="m.id">{{m.name}}</option>
                                </select>
                                <div class="invalid-feedback" v-if="errors.material_id">{{errors.material_id}}</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" v-model="materialModel.page" class="form-control" :class="{'is-invalid' : errors.page}" placeholder="Номер страницы">
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
            text: '',
            errors: {},
            materialModel: {},
			messages: [],
			messageChannel: false,
			boardChannel: false,
			boardData: null,
            canvas: false,
            width: 0,
			height: 555,
            loading: false,
            canvasMode: 'draw'
        }
    },
    methods: {
        showMaterialModal(){
            this.materialModel = {}
            $('#modal-material').modal('show')
        },
        setCanvasMode(mode){
            this.canvasMode = mode
            if(this.canvasMode == 'draw'){
                this.canvas.isDrawingMode = true
                this.canvas.selection = false
            }else if(this.canvasMode == 'select'){
                this.canvas.isDrawingMode = false
                this.canvas.selection = true
            }else if(this.canvasMode == 'write'){
                this.canvas.isDrawingMode = false
                this.canvas.selection = false
            }
        },
        canvasUndo(){
            var object = this.canvas.item(this.canvas.getObjects().length-1);
            this.canvas.remove(object);
            if(!this.remoteEvent){
                this.boardChannel.trigger('client-undo', {})
            }else{
                this.remoteEvent = false
            }
        },
        async destroyFile(file){},
        imgToCanvas(file){
            fabric.Image.fromURL('/storage/' + file.src, (img) => {
                const obj = img.set({ left: 5, top: 5});
                this.canvas.add(obj); 
            });
        },
        async addMaterial(){
            let valid = true
            const errors = {}
            if(!this.materialModel.type) return false
            if(this.materialModel.type == 1 && !this.$refs.input.files.length){
                this.errors.file = 'Ну выбран файл'
                valid = false
            }
            if(this.materialModel.type == 2 && !this.materialModel.material_id){
                this.errors.material_id = 'Не выбран материал'
                valid = false
            }
            if(this.materialModel.type == 2 && !this.materialModel.page){
                this.errors.material_id = 'Не указан номер страницы'
                valid = false
            }
            this.errors = errors
            if(!valid) return false
            const formData = new FormData()
            formData.append('type', this.materialModel.type)
            if(this.materialModel.type == 1){
                formData.append('file', this.$refs.input.files[0])
            }else{
                formData.append('material_id', this.materialModel.material_id)
                formData.append('page', this.materialModel.page)
            }
            try{
                const {data} = await axios.post('/lessons/' + this.lesson.id + '/addMaterial', formData)
                this.lesson.files.push(data)
                $('#modal-material').modal('hide')
            }catch(e){
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
                await axios.put('/lessons/' + this.lesson.id + '/saveBoard', { data: JSON.stringify(this.canvas)})
            }catch(e){}
		},
		clear(){
			this.canvas.clear()
			if(!this.remoteEvent) this.boardChannel.trigger('client-clear', {})
        }
	},
    async created(){
        const lesson = await axios.get('/lessons/' + this.lesson_id)
		this.lesson = lesson.data
        this.messages = this.lesson.messages
        const materials = await axios.get('/materials')
        this.materials = materials.data
        this.scroll();
        this.messageChannel = pusher.subscribe('lesson.' + this.lesson_id);
        this.messageChannel.bind('message', signal => {
            this.messages.push(signal.message)
            this.scroll();
		})
        // //////////////////////////////////////////////////
        this.width = $('.board-container').width()
        this.canvas = new fabric.Canvas(this.$refs.boardCanvas, { height: this.height,  width: this.width})
        // this.canvas.setOverlayColor({source: '/images/grid.jpg'}, this.canvas.renderAll.bind(this.canvas));
        // this.drawGrid()
        this.canvas.freeDrawingBrush = new fabric.PencilBrush(this.canvas)
        this.canvas.freeDrawingBrush.width = 4;
        this.canvas.freeDrawingBrush.color = '#ff00ff'
        this.setCanvasMode('draw')
        if(this.lesson.lesson_boards.length){
            this.canvas.loadFromJSON(this.lesson.lesson_boards[0].data, () => {
                this.canvas.renderAll();
            });
        }
        this.canvas.on('object:modified', obj => {
            if(!this.remoteEvent){
                this.boardChannel.trigger('client-modified', obj.target.toJSON())
            }else{
                this.remoteEvent = false
            }
        })
        this.canvas.on('mouse:down', data => {
            if(this.canvasMode == 'write'){
                const text = new fabric.Textbox('...', { left: data.absolutePointer.x, top: data.absolutePointer.y} )
                this.canvas.add(text)
            }
        })
        this.canvas.on('object:added', obj => {
            if(!this.remoteEvent){
                this.boardChannel.trigger('client-add', obj.target.toJSON())
            }else{
                this.remoteEvent = false
            }
        })
		this.boardChannel = pusher.subscribe('presence-lesson-channel-' + this.lesson_id)
		this.boardChannel.bind('client-clear', signal => {
			this.remoteEvent = true
			this.clear()
		})
        this.boardChannel.bind('client-add', obj => {
            this.remoteEvent = true;
            fabric.util.enlivenObjects([obj], objects => {
                var origRenderOnAddRemove = this.canvas.renderOnAddRemove
                this.canvas.renderOnAddRemove = false
                objects.forEach( o => { this.canvas.add(o) })
                this.canvas.renderOnAddRemove = origRenderOnAddRemove
                this.canvas.renderAll()
            })
        })
        this.boardChannel.bind('client-undo', obj => {
            this.remoteEvent = true;
            this.canvasUndo()
        })
        this.boardChannel.bind('client-modified', obj => {
            console.log(obj)
        })
    }
}
</script>
<style lang="scss">
.materials{
    overflow: auto;
    .card{
        width: 128px;
        height: 128px;
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
    }
}
</style>