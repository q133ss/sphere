<template>
    <div>
        <p class="text-danger"><i class="fa fa-info f-lg"></i> Обратите внимание на текущее время {{currentTime}}, если оно не соответствует вашему часовому поясу, то выберите его из списка</p>
        <select class="form-control col-md-3 mb-3" @change="updateCurrentTime" v-model="zone">
            <option v-for="zone in zones" :key="zone" :value="zone">{{zone}}</option>
        </select>
    </div>
</template>
<script>
export default {
    data(){
        return {
            currentTime: '',
            zones: moment.tz.names(),
            zone: 'Europe/Moscow',
        }
    },
    created(){
        this.updateCurrentTime()
        setInterval(this.updateCurrentTime, 60 * 1000);
    },
    methods: {
        updateCurrentTime() {
            this.currentTime = moment().format("HH:mm");
        },
    }
}
</script>