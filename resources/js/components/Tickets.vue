<template>
    <div class="card">
        <div class="card-header">
            <span v-if="!admin">Мои вопросы</span>
            <span v-else>Список такетов</span>
            <button v-if="!admin" class="btn btn-sm btn-primary" @click="create">Новый тикет</button>
        </div>
        <div class="card-body">
            <form @submit.prevent="store" class="mb-3" v-if="model && !model.id">
                <div class="form-group">
                    <textarea rows="3" placeholder="Опишите вашу проблему" class="form-control" v-model="model.text"></textarea>
                </div>
                <button class="btn btn-sm btn-warning mr-2" type="button" @click="model = false">Отмена</button>
                <button class="btn btn-sm btn-primary">Задать вопрос</button>
            </form>
            <div class="card mb-3" v-else-if="model">
                <div class="card-header">
                    <button class="close" @click="model = false">&times;</button>
                    {{model.text}}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <form @submit.prevent="reply" class="mb-3" v-if="model && model.id">
                                <div class="form-group">
                                    <textarea rows="3" placeholder="Опишите вашу проблему" class="form-control" v-model="text"></textarea>
                                </div>
                                <button class="btn btn-sm btn-warning mr-2" type="button" @click="model = false">Отмена</button>
                                <button class="btn btn-sm btn-primary">Написать комментарий</button>
                            </form>
                        </div>
                        <div class="col-md-7">
                            <div class="clearfix alert w-75" :class="{'alert-success float-left': myid == message.user.id, 'float-right alert-info': myid != message.user.id}" v-for="message in messages" :key="message.id">
                                <img :src="message.user.avatar" class="avatar float-left mr-3" :alt="message.user.full_name">
                                <div>
                                    <p class="text-muted mb-0 small">{{message.created_at | moment('DD.MM.YYYY H:m')}}</p>
                                    {{message.text}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-muted" v-if="!tickets.length">Список пуст</p>
            <table class="table table-bordered table-striped" v-else>
                <tr>
                    <td width="150px">Статус</td>
                    <td width="150px">Дата</td>
                    <td class="text-truncate">Вопрос</td>
                </tr>
                <tr @click="loadTicket(ticket)" v-for="ticket in tickets" :key="ticket.id" :class="{'table-info': ticket.id == model.id}">
                    <td>
                        <span v-if="ticket.status == 'user'" class="text-light badge p-2 badge-warning">Ожидает ответа</span>
                        <span v-else-if="ticket.status == 'closed'" class="text-light badge p-2 badge-success">Закрыт</span>
                        <span v-else-if="ticket.status == 'admin'" class="text-light badge p-2 badge-info">Получен ответ</span>
                    </td>
                    <td>{{ticket.created_at | moment('DD.MM.YYYY HH:mm')}}</td>
                    <td>{{ticket.text}}</td>
                </tr>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    props: ['admin', 'myid'],
    data(){
        return {
            tickets: [],
            model: false,
            text: '',
            messages: []
        }
    },
    async created(){
        const {data} = await axios.get('/tickets')
        this.tickets = data
    },
    methods: {
        create(){
            this.model = {}
        },
        async loadTicket(ticket){
            try{
                const {data} = await axios.get('/tickets/'+ticket.id+'/getMessages')
                this.messages = data
                this.model = ticket
            }catch(e){}
        },
        async store(){
            if(!this.model.text) return false
            try{
                const {data} = await axios.post('/tickets', this.model)
                this.tickets.push(data)
                this.model = false
            }catch(e){}
        },
        async reply(){
            if(!this.text) return false
            try{
                const {data} = await axios.post('/tickets/' + this.model.id + '/reply', { text: this.text})
                this.model.status = this.admin ? 'admin' : 'user'
                this.messages.push(data)
                this.text = '';
            }catch(e){
                console.log(e)
            }
        }
    }
}
</script>