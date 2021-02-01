<template>
    <div class="row">
        <div class="col-md-4">
            <label>Поиск контактов</label>
            <input v-model="search" type="text" class="form-control" placeholder="Начните вводить имя">
            <hr>
            <div class="list-group users-list">
                <a href="#" @click="toggleChat(user)" class="list-group-item list-group-item-action" :class="{active: selected.id == user.id, online: online[user.id], hasmessage: newmessages[user.id]}" v-for="user in filteredUsers" :key="user.id">
                    <img class="avatar" :src="user.photo" :alt="user.full_name">
                    {{user.full_name}}
                </a>          
            </div>
        </div>
        <div class="col-md-8" v-if="selected">
            <label>Сообщения</label>
            <div class="card">
                <div class="card-body">
                    <div class="chat__messages" ref="chat">
                        <div class="w-75 d-flex" v-for="message in messages" :key="message.id" :class="{myMessage: message.author_id == auth.id}">
                            <div v-if="message.author_id == auth.id" class="pr-2"><img class="avatar" :src="message.author.photo"></div>
                            <div class="w-100">
                                {{message.author.full_name}}
                                <div class="alert mb-1">{{message.text}}</div>
                                <i class="text-muted small">{{message.created_at | moment('DD.MM.YYYY H:m')}}</i>
                            </div>
                            <div v-if="message.author_id != auth.id" class="pl-2"><img class="avatar" :src="message.author.photo"></div>
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
        </div>
    </div>
</template>

<script>
export default {
    props: ['auth', 'role'],
    data(){
        return {
            users: [],
            search: '',
            text: '',
            loading: false,
            selected: {},
            channel: false,
            newmessages: {},
            online: {},
            messages: []
        }
    },
    computed: {
        filteredUsers(){
            const str = this.search.toLowerCase();
            return this.users.filter( u => u.full_name.toLowerCase().indexOf(str) > -1);
        }
    },
    methods: {
        scroll(){
            setTimeout(() => {
                const chat = this.$refs.chat
                chat.scrollTop = chat.scrollHeight;
            }, 100)
        },
        async toggleChat(user){
            if(this.selected.id == user.id) return false
            const {data} = await axios.get('/chat/getMessages', { params: {
                id: user.id
            }});
            this.selected = user
            this.messages = data
            this.$set(this.newmessages, user.id, false)
            this.scroll()
        },
        async send(){
            if(!this.text) return false;
            try{
                const {data} = await axios.post('/chat/message', {
                    id: this.selected.id,
                    text: this.text
                });
                this.messages.push(data);
                this.scroll();
                this.channel.trigger('client-message', data);
                this.text = '';
            }catch(e){}
        }
    },
    async created(){
        const {data} = await axios.get('/chat/users')
        this.users = data
        this.channel = pusher.subscribe('presence-chat-channel')
        this.channel.bind('pusher:subscription_succeeded', data => {
            this.online = data.members
        })
        this.channel.bind('pusher_internal:member_removed', data => {
            this.$set(this.online, data.user_id, false)
        })
        this.channel.bind('pusher_internal:member_added', data => {
            this.$set(this.online, data.user_id, true)
        })
        
        this.channel.bind('client-message', message => {
            if(this.selected.id == message.author_id){
                this.messages.push(message)
                this.scroll()
            }else{
                this.$set(this.newmessages, message.author_id, true)
            }
        })
    }
}
</script>