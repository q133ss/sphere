<template>
    <div class="row">
        <div class="col-md-4">
            <label>Поиск контактов</label>
            <input v-model="search" type="text" class="form-control" placeholder="Начните вводить имя">
            <hr>
            <div class="list-group users-list">
                <a href="#" @click="toggleChat(user)" class="list-group-item list-group-item-action" :class="{active: selected.id == user.id, online: online[user.id] }" v-for="user in filteredUsers" :key="user.id">
                    <img class="avatar" :src="user.avatar" :alt="user.full_name">
                    {{user.full_name}}
                </a>          
            </div>
        </div>
        <div class="col-md-8" v-if="selected">
            <label>Сообщения</label>
            <chat-room v-if="selected.id" :user_id="selected.id" :auth="auth"/>
        </div>
    </div>
</template>

<script>
import ChatRoom from './ChatRoom'
export default {
    props: ['auth'],
    components: { ChatRoom },
    data(){
        return {
            users: [],
            search: '',
            selected: {},
            online: {},
        }
    },
    computed: {
        filteredUsers(){
            const str = this.search.toLowerCase();
            return this.users.filter( u => u.full_name.toLowerCase().indexOf(str) > -1);
        }
    },
    methods: {
        toggleChat(user){
            this.selected = user
        }
    },
    async created(){
        const {data} = await axios.get('/chat/users')
        this.users = data
        Echo.join('App.Chat')
        .here( users => {
            const online = {}
            users.forEach(user => {
                online[user.id] = user
            });
            this.online = online
        })
        .joining( user => {
            const online = Object.assign({}, this.online)
            online[user.id] = user
            this.online = online
        })
        .leaving( user => {
            const online = Object.assign({}, this.online)
            delete online[user.id]
            this.online = online
        })
    }
}
</script>