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
                <div class="card-body">
                    <button class="close" @click="model = false">&times;</button>
                    <div class="row">
                        <div class="col-md-4">
                            <p>{{model.text}}</p>
                        </div>
                        <div class="col-md-8">
                            <div v-for="message in messages" :key="message.id">
                                {{message.text}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-muted" v-if="!tickets.length">Список пуст</p>
            <table class="table table-bordered table-ыекшзув" v-else>
                <tr>
                    <td width="150px">Статус</td>
                    <td width="150px">Дата</td>
                    <td class="text-truncate">Вопрос</td>
                </tr>
                <tr @click="model=ticket" v-for="ticket in tickets" :key="ticket.id">
                    <td>
                        <span v-if="ticket.status == 'user'" class="text-light badge p-2 badge-warning">Ожидает ответа</span>
                        <span v-else-if="ticket.status == 'closed'" class="text-light badge p-2 badge-success">Закрыт</span>
                        <span v-else-if="ticket.status == 'admin'" class="text-light badge p-2 badge-info">Отвечен</span>
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
    props: ['admin'],
    data(){
        return {
            tickets: [],
            model: false
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
        async store(){
            if(!this.model.text) return false
            try{
                const {data} = await axios.post('/tickets', this.model)
                this.tickets.push(data)
                this.model = false
            }catch(e){}
        }
    }
}
</script>