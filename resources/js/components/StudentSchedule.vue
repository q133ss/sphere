<template>
    <div>
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
                    <h5 class="modal-title">{{model.id ? 'Редактирование события': 'Новое событие'}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select :disabled="model.student_id" required class="form-control" v-model="model.subject_id">
                            <option selected disabled value="null">Выберите предмет</option>
                            <option :value="subject.id" v-for="subject in teacher.subjects" :key="subject.id">{{subject.name}}</option>
                        </select>
                    </div>
                    <p class="text-danger" v-if="!model.student_id && balance < teacher.lesson_price">Вы не можете записаться на урок, для продолжения пополните ваш счет на сумму {{Math.floor(teacher.lesson_price - balance)}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" @click="model = {}">Закрыть</button>
                    <button v-if="!model.student_id" :disabled="balance < teacher.lesson_price" type="button" class="btn btn-sm btn-primary" @click="save(1)">Записаться</button>
                    <button class="btn btn-sm btn-warning" v-if="(!model.lesson || model.lesson.status == 'new') && model.student_id == user_id" @click="save(0)">Отписаться</button>
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

export default {
    props: ['teacher_id', 'teacher', 'balance', 'user_id'],
    components: { FullCalendar },
    data() {
        return {
            model: {},
            calendarApi: false,
            currentTime: '',
            channel: false,
            zones: moment.tz.names(),
            zone: 'Europe/Moscow',
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
                    right: 'dayGridMonth,timeGridWeek'
                },
                noEventsContent: 'На указанный период занятий не запланировано',
                initialView: 'timeGridWeek',
                eventDidMount: info => {
                    if(info.event.extendedProps.student_id == this.user_id) info.el.className += ' fc-subscribe'
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
                eventContent: (event) => {
                    return event.timeText
                }
            }
        }
    },
    async created(){
        this.updateCurrentTime()
        setInterval(this.updateCurrentTime, 60 * 1000);
        await this.fetchEvents({
            startStr: moment().startOf('week').format(),
            endStr: moment().endOf('week').format()
        })
    },
    mounted(){
        Echo.private("schedule-channel-" + this.teacher_id)
        .listen('TeacherScheduleEvent', data => {
            if(data.type == 'store') this.calendarOptions.events = [...this.calendarOptions.events, ...data.events ]
            else if(data.type == 'update') this.$set(this.calendarOptions.events, this.calendarOptions.events.findIndex( e => e.id == data.event.id), data.event )
            else if(data.type == 'destroy') this.calendarOptions.events.splice(this.calendarOptions.events.findIndex( e => e.id == data.event.id), 1 )
        });
    },
	methods: {
        updateCurrentTime() {
            this.currentTime = moment.tz(this.zone).format("HH:mm");
        },
        async save(flag){
            if(!this.model) return false
            try{
                if(flag) await axios.post('/student_dashboard/teachers/' + this.teacher_id + '/subscribe', this.model)
                else await axios.post('/student_dashboard/teachers/' + this.teacher_id + '/unsubscribe', this.model)
                location.reload();
            }catch(e){
            }finally{ this.model = {}}
        },
        showEvent(info) {
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
                lesson: info.event.extendedProps.lesson
            }
            $('#event-dialog').modal('show')
        },
        async fetchEvents(info){
            const {data} = await axios.get('/student_dashboard/teachers/'+this.teacher_id+'/getSchedule', { params: { start: info.startStr, end: info.endStr}})
            this.calendarOptions.events = data
        }
    }
}
</script>