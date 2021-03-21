<template>
<div class="card">
    <div class="card-body">
        <div class="chat__messages" ref="chat">
            <div class="w-75 d-flex" v-for="message in messages" :key="message.id" :class="{myMessage: message.author_id == auth.id}">
                <div v-if="message.author_id == auth.id" class="pr-2"><img class="avatar" :src="message.author.avatar"></div>
                <div class="w-100">
                    {{message.author.full_name}}
                    <div class="alert mb-1">{{message.text}}</div>
                    <i class="text-muted small">{{message.created_at | moment('DD.MM.YYYY H:m')}}</i>
                </div>
                <div v-if="message.author_id != auth.id" class="pl-2"><img class="avatar" :src="message.author.avatar"></div>
            </div>
        </div>
        <form class="input-group" @submit.prevent="send">
            <input v-model="text" class="form-control" :disabled="loading" placeholder="Сообщение">
            <div class="input-group-append">
                <button class="btn btn-primary" :disabled="loading"><i v-if="!loading" class="fa fa-send"></i><i class="fa fa-spinner fa-spin" v-else></i></button>
            </div>
        </form>
    </div>
</div>  
</template>

<script>
export default {
    props: ['auth', 'user_id'],
    data(){
        return {
            messages: [],
            loading: false,
            text: '',
            hash: '',
            channel: false
        }
    },
    watch: { 
        user_id: function(newVal, oldVal) {
            this.connect()
        }
    },
    async created(){
        this.connect()
    },
    methods: {
        scroll(){
            setTimeout(() => {
                const chat = this.$refs.chat
                chat.scrollTop = chat.scrollHeight;
            }, 100)
        },
        async connect(){
            const {data} = await axios.get('/chat/getMessages', { params: {
                id: this.user_id
            }});
            this.messages = data
            this.scroll()
            if(this.channel) this.channel.leave('App.Chat.Message.' + this.hash)
            this.hash = Math.min(this.auth.id, this.user_id) + '_' + Math.max(this.auth.id, this.user_id)
            this.channel = Echo.join('App.Chat.Message.' + this.hash)
            .listen('ChatMessage', data => {
                this.messages.push(data.message)
                this.scroll()
            })
        },
        async send(){
            if(!this.text) return false;
            this.loading = true
            try{
                const {data} = await axios.post('/chat/message', {
                    id: this.user_id,
                    text: this.text
                });
                this.text = '';
            }catch(e){}
            finally{ this.loading = false }
        }
    }
}
</script>
