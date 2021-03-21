<template>
    <div>
        <div class="card">
            <div class="card-header d-flex justify-content-start align-items-center">
                <span class="mr-4">Расписание</span>
                <button class="btn btn-success mr-2" @click="prev" :disable="!canPrev"><i class="fa fa-chevron-left"></i></button>
                <VueCtkDateTimePicker style="width: 300px; margin: 0" @input="fetchEvents" v-model="date" :auto-close="true" :no-button-now="true" :only-date="true" :formatted="format" :output-format="format" :format="format" label="Выберите дату" locale="ru"/>
                <button class="btn btn-success ml-2" @click="next"><i class="fa fa-chevron-right"></i></button>
            </div>
            <div class="card-body">
                <div class="card mb-2" v-for="item in events" :key="item.id" :class="{'bg-success text-white': item.student_id && item.student_id == user_id, 'bg-danger text-white': item.student_id && item.student_id != user_id}" @click="showEvent(item)">
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{item.start | moment('HH:mm')}}</span>
                            <span class="badge badge-info text-white px-2">{{item.subject.name}}</span>
                        </div>
                        <span class="badge badge-success text-white text-uppercase px-3" v-if="item.student">{{item.student.full_name}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="event-dialog">
            <div class="modal-dialog" v-if="event">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Запись на {{event.subject.name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Урок состоится {{event.start | moment('DD.MM.YYYY')}} в {{event.start | moment('HH:mm')}}</p>
                    <p>Стоимость урока {{teacher.lesson_price}} рублей</p>
                    <p class="text-danger" v-if="!event.student_id && balance < teacher.lesson_price">Вы не можете записаться на урок, для продолжения пополните ваш счет на сумму {{Math.floor(teacher.lesson_price - balance)}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button v-if="!event.student_id" :disabled="balance < teacher.lesson_price" type="button" class="btn btn-sm btn-primary" @click="save(1)">Записаться</button>
                    <button class="btn btn-sm btn-warning" v-if="(!event.lesson || event.lesson.status == 'new') && event.student_id == user_id" @click="save(0)">Отписаться</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    props: ['teacher_id', 'teacher', 'balance', 'user_id'],
    data() {
        return {
            event: false,
            events: [],
            format: 'DD.MM.YYYY',
            date: moment().format('DD.MM.YYYY')
        }
    },
    async created(){
        await this.fetchEvents()
    },
    computed: {
        canPrev(){
            return moment(this.date, this.format).isAfter(moment());
        }
    },
    mounted(){
        Echo.join("App.Schedule." + this.teacher_id)
        .listen('ScheduleUpdate', async (data) => {
            await this.fetchEvents()
        });
    },
	methods: {
        async prev(){
            this.date = moment(this.date, this.format).subtract(1, 'days').format(this.format)
            await this.fetchEvents()
        },
        async next(){
            this.date = moment(this.date, this.format).add(1, 'days').format(this.format)
            await this.fetchEvents()
        },
        async save(flag){
            if(!this.event) return false
            try{
                let balance;
                if(flag) balance = await axios.post('/student_dashboard/teachers/' + this.teacher_id + '/subscribe', this.event)
                else balance = await axios.post('/student_dashboard/teachers/' + this.teacher_id + '/unsubscribe', this.event)
                this.balance = balance.data
                this.$toast.success(flag ? 'Вы успешно записались на урок' : 'Вы отписались от урока')
                $('#event-dialog').modal('hide')    
                await this.fetchEvents()
            }catch(e){
            }finally{ this.event = {}}
        },
        showEvent(event) {
            this.event = event
            $('#event-dialog').modal('show')
        },
        async fetchEvents(){
            const {data} = await axios.get('/student_dashboard/teachers/'+this.teacher_id+'/getSchedule', { params: { date: this.date}})
            this.events = data
        }
    }
}
</script>