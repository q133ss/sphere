<template>
  <button :disabled="closed" @click="open" class="btn btn-primary btn-sm btn-block">
      <span v-if="closed">Урок завершен</span>
      <span v-else-if="status == 'progress'">Урок начался</span>
      <span v-else>До начала {{time}}</span>
  </button>
</template>

<script>
export default {
    props: ['href', 'user', 'lesson'],
    data(){
        return {
            closed: false,
            status: false,
            timer: null,
            time: ''
        }
    },
    created(){
        this.checkStatus()
        this.updateTime()
        this.timer = setInterval( () => {
            this.updateTime()
            this.checkStatus()
        }, 60*1000)
    },
    methods: {
        open(){
            location.href = this.href
        },
        updateTime(){
            const start = moment(this.lesson.start)
            this.time = moment.duration(start.diff(moment())).humanize()
        },
        checkStatus(){
            if(this.lesson.status == 'canceled') this.status = 'canceled'
            else if(this.lesson.status == 'success') this.status = 'success'
            else if(this.lesson.status == 'future' && moment().isBefore(this.lesson.start)) this.status = 'future'
            else if(this.lesson.status == 'future' && moment().isBefore(moment(this.lesson.start).add('hours', 1))) this.status = 'progress'
            else this.status = 'done'
            if(['done', 'success', 'canceled'].indexOf(this.status) > -1){
                this.closed = true;
            }
        },
    }
}
</script>

<style>

</style>