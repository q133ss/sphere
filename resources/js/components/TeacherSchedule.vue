<template>
    <div>
        <!-- <gmt></gmt> -->
        <FullCalendar :options="calendarOptions">
            <template #eventContent="{ timeText, event }">
                <b>{{ timeText }}</b>
                <div v-if="event.extendedProps.subject">
                    <span class="badge badge-success">{{event.extendedProps.subject.name}}</span>
                </div>
            </template>
        </FullCalendar>
        <div class="modal" tabindex="-1" role="dialog" id="event-dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Управление уроком</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="save">
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" @click="destroy">Удалить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="model = {}">Закрыть</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'
import '@fullcalendar/core/locales/ru'
import gmt from './Gmt';
export default {
    props: ['teacher_id', 'gmt'],
    components: { FullCalendar, gmt },
    data() {
        return {
            model: {},
            calendarApi: false,
            channel: false,
            calendarOptions: {
                locale: 'ru',
                firstDay: 1,
                buttonText: {
                    today:    'Сегодня',
                    month:    'Месяц',
                    week:     'Неделя',
                    day:      'День',
                    list:     'Мои занятия'
                },
                plugins: [ dayGridPlugin, timeGridPlugin, interactionPlugin, listPlugin ],
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek' //listWeek
                },
                noEventsContent: 'На указанный период занятий не запланировано',
                initialView: 'timeGridWeek',
                eventDidMount: function(info) {
                    if(info.event.extendedProps.student_id) info.el.className += ' fc-subscribe'
                },
                allDaySlot: false,
                events: [],
                editable: false,
                selectable: true,
                selectMirror: false,
                dayMaxEvents: false,
                weekends: true,
                select: this.save,
                eventClick: this.showEvent,
                eventChange: this.save,
            }
        }
    },
    async created(){
        await this.fetchEvents({
            startStr: moment().startOf('week').format(),
            endStr: moment().endOf('week').format()
        })
    },
    mounted(){
        // this.channel = window.Echo.join("presence-schedule-channel-" + this.teacher_id);
        // Echo.private("presence-schedule-channel-" + this.teacher_id)
        // .listen('store', data => {
        //     console.log(data);
        // });
        // this.channel = pusher.subscribe('schedule.' + this.teacher_id);
        // this.channel.bind('event', signal => {
        //     if(signal.type == 'update') this.$set(this.calendarOptions.events, this.calendarOptions.events.findIndex( e => e.id == signal.event.id), signal.event )
        // })
    },
	methods: {
        test(data){
            console.log(data);
        },
        
        async destroy(){
            if(!confirm('Подтвердите удаление')) return false;
            try{
                await axios.delete('/teacher_dashboard/schedule/' + this.model.id)
                this.calendarOptions.events.splice(this.calendarOptions.events.findIndex( e => e.id == this.model.id), 1)
                $('#event-dialog').modal('hide')
            }catch(e){}
        },
        async save(info){
            const start = moment(info.event ? info.event.start : info.start).format('YYYY-MM-DD HH:mm:00')
            const end = moment(info.event ? info.event.end : info.end).format('YYYY-MM-DD HH:mm:00')
            const model = { start, end }
            try{
                if(info.event) await axios.put('/teacher_dashboard/schedule/' + info.event.id, model)
                else{
                    const {data} = await axios.post('/teacher_dashboard/schedule', model)
                    this.calendarOptions.events = [...this.calendarOptions.events, ...data]
                }
            }catch(e){}
            finally{ this.model = {}}
        },
        showEvent(info) {
            if(!info.event.student_id) return false
            this.model = {
                id: info.event.id,
                title: info.event.title,
                start: info.event.startStr,
                end: info.event.endStr,
                student_id: info.event.extendedProps.student_id,
                teacher_id: info.event.extendedProps.teacher_id,
                subject_id: info.event.extendedProps.subject_id,
                student: info.event.extendedProps.student,
                teacher: info.event.extendedProps.teacher,
                subject: info.event.extendedProps.subject,
            }
            $('#event-dialog').modal('show')
        },
        async fetchEvents(info){
            const {data} = await axios.get('/teacher_dashboard/schedule', { params: { start: info.startStr, end: info.endStr}})
            this.calendarOptions.events = data
        }
    }
}
</script>