<template>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Поиск репетитора</span>
        <div style="width: 350px">
            <multiselect
                v-model="subject"
                :options="subjects"
                @select="find"
                trackBy="id"
                searchable
                label="name"
                :show-labels="false"
                placeholder="Выберите предмет">
            </multiselect>
        </div>
    </div>
    <div class="card-body">
        <div class="row teachers-list" v-if="teachers.data && filteredTeachers.length">
            <div class="col-md-3" v-for="teacher in teachers.data" :key="teacher.id">
                <a :href="'/student_dashboard/teachers/'+teacher.id" class="card">
                    <label class="my-teacher" v-if="my.indexOf(teacher.id) > -1">Мой преродаватель</label>
                    <div class="teachers-list__photo-container">
                    <div class="teachers-list__photo" :style="{ backgroundImage: 'url('+teacher.avatar+')'}"></div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">{{teacher.full_name}}</h5>
                    </div>
                </a>
            </div>
        </div>
        <div v-else>Репетиторы не найдены</div>
    </div>
</div>
</template>

<script>
export default {
    props: ['my', 'subjects'],
    data(){
        return {
            teachers: {},
            subject_id: false,
            subject: false
        }
    },
    computed: {
        filteredTeachers(){
            return this.teachers.data.filter( t => !this.subject_id || t.subjects.filter( s => s.id == this.subject_id).length > 0 )
        }
    },
    async created(){
        const {data} = await axios.get('/student_dashboard/teachers')
        this.teachers = data
    },
    methods: {
        find(val){
            this.subject_id = val.id;
        }
    }
}
</script>