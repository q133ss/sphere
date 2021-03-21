<template>
<div class="card">
    <div class="card-header d-flex justify-content-start align-items-center">
        <span class="mr-4">Мое расписание</span>
        <button class="btn btn-primary mr-4" @click="showEvent"><i class="fa fa-plus"></i></button>
        <button class="btn btn-success mr-2" @click="prev" :disable="!canPrev"><i class="fa fa-chevron-left"></i></button>
        <VueCtkDateTimePicker style="width: 300px; margin: 0" @input="fetchEvents" v-model="date" :auto-close="true" :no-button-now="true" :only-date="true" :formatted="format" :output-format="format" :format="format" label="Выберите дату" locale="ru"/>
        <button class="btn btn-success ml-2" @click="next"><i class="fa fa-chevron-right"></i></button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4" v-for="key in dates" :key="key">
                <div class="card">
                    <div class="card-header">{{key}}</div>
                    <div class="card-body">
                        <div class="card mb-2" v-for="item in events[key]" :key="item.id" :class="{'bg-info text-white': item.student_id}" @click="showEvent(item)">
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
            </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="event-dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{event.id ? 'Управление уроком' : 'Добавить уроки'}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="save">
                        <div class="form-group">
                            <multiselect value="id" selectedLabel="Выбрано" deselectLabel="Enter для удаления" selectLabel="Enter для выбора" placeholder="Выберите предмет" label="name" v-model="event.subject" :options="subjects"></multiselect>
                        </div>
                        <div class="form-group">
                            <VueCtkDateTimePicker v-model="event.start" format="DD.MM.YYYY HH:mm" label="Начало" locale="ru" :no-button-now="true" :min-date="minDate"/>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" v-model="event.repeat" id="repeat">
                                <label class="form-check-label" for="repeat">Повторять ежедневно</label>
                            </div>
                        </div>
                        <div class="form-grop">
                            <VueCtkDateTimePicker v-if="event.repeat" @input="fetchEvents" v-model="event.repeatEnd" :auto-close="true" :no-button-now="true" :only-date="true" :formatted="format" :output-format="format" :format="format" label="Повторять до" locale="ru"/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="event = {}">Закрыть</button>
                    <button class="btn btn-danger" v-if="event.id" @click="destroy">Удалить</button>
                    <button class="btn btn-primary" @click="save">Сохранить</button>
                </div>
                </div>
            </div>
        </div>  
    </div>
</div>
</template>
<script>
export default {
    props: ['teacher_id'],
    data() {
        return {
            channel: false,
            events: [],
            format: 'DD.MM.YYYY',
            date: moment().format('DD.MM.YYYY'),
            event: {},
            subjects: [],
            minDate: moment().format('DD.MM.YYYY')
        }
    },
    computed: {
        dates(){
            return [
                moment(this.date, this.format).format(this.format),
                moment(this.date, this.format).add(1, 'days').format(this.format),
                moment(this.date, this.format).add(2, 'days').format(this.format)
            ]
        },
        canPrev(){
            return moment(this.date, this.format).isAfter(moment());
        }
    },
    async created(){
        await this.fetchEvents()
        const {data} = await axios.get('/subjects')
        this.subjects = data
    },
    mounted(){
        this.channel = Echo.join("App.Schedule." + this.teacher_id)
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
        async destroy(){
            if(!confirm('Подтвердите удаление')) return false;
            try{
                await axios.delete('/teacher_dashboard/schedule/' + this.event.id)
                this.calendarOptions.events.splice(this.calendarOptions.events.findIndex( e => e.id == this.event.id), 1)
                $('#event-dialog').modal('hide')
            }catch(e){}
        },
        async save(){
            try{
                this.event.subject_id = this.event.subject ? this.event.subject.id : false
                await axios.post('/teacher_dashboard/schedule', this.event)
                $('#event-dialog').modal('hide');
                await this.fetchEvents()
            }catch(e){}
        },
        showEvent(info) {
            $('#event-dialog').modal('show')
        },
        async fetchEvents(){
            const {data} = await axios.get('/teacher_dashboard/schedule', { params: { date: this.date }})
            this.events = data
        }
    }
}
</script>