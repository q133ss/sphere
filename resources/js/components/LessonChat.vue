<template>
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
</template>
<script>
export default {
    props: ['lesson', 'user_id'],
    data(){
        return {
            text: '',
            channel: false,
            messages: this.lesson.messages,
            loading: false
        }
    },
    mounted(){
        this.scroll();
        this.channel = pusher.subscribe('lesson.' + this.lesson.id);
        this.channel.bind('message', message => {
            this.messages.push(message)
            this.scroll();
        })
    },
    methods: {
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
    }
}
</script>