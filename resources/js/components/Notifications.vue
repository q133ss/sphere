<template>
    <div class="dropdown">
        <a class="nav-link" href="#" data-toggle="dropdown" @click.prevent="readAll"><i :class="{'has-notify':hasNew}" class="fa fa-bell-o"></i></a>
        <div v-if="!notifications.length" class="dropdown-menu notifications-menu">
            <li class="dropdown-item">Список уведомлений пуст</li>
        </div>
        <div v-else class="dropdown-menu notifications-menu">
            <li v-for="(notify, i) in notifications" :key="notify.id" class="dropdown-item d-flex justify-content-between align-items-center">
                <span>{{notify.text}}</span>
                <button class="btn btn-sm btn-danger" @click.stop="destroy(notify.id, i)"><i class="fa fa-trash"></i></button>
            </li>
        </div>
    </div>
</template>
<script>
export default {
    props: ['user_id'],
    data(){
        return {
            notifications: []
        }
    },
    computed:{
        hasNew(){
            return this.notifications.filter( n => !n.read ).length
        }
    },
    mounted(){
        window.channel.bind('new', notification => {
            this.notifications.push(notification)
        })
    },
    async created(){
        const {data} = await axios.get('/notifications')
        this.notifications = data
    },
    methods: {
        async readAll(){
            try{
                await axios.post('/notifications/read')
                this.notifications = this.notifications.map( n => { n.read = 1; return n})
            }catch(e){}
        },
        async destroy(id, i){
            try{
                await axios.delete('/notifications/' + id)
                this.notifications.splice(i, 1)
            }catch(e){}
        }
    }
}
</script>
<style lang="scss">
.notifications-menu{
    min-width: 350px;
}
</style>