<template>
   <div class="photo mb-1 upload-container" :style="style">
        <label class="btn btn-light">
            <input type="file" ref="photo" @change="upload">
            Загрузить фото
        </label>
    </div>
</template>

<script>
    export default {
        props: ['photo', 'edit'],
        computed: {
            style(){
                return this.photo ? { 'background-image': 'url('+this.photo+')'} : {}
            }
        },
        data(){
            return {
                errors: {},
                img: this.photo
            }
        },
        methods: {
            async upload(){
                this.errors = {}
                const formData = new FormData()
                formData.append('photo', this.$refs.photo.files[0])
                try{
                    const {data} = await axios.post('/profile/photo', formData)
                    this.photo = data
                }catch(e){
                    this.errors = e.response.data.errors
                }
            }
        }
    }
</script>
