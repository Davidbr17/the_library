<template>
    <b-modal id="addBook" hide-footer centered :title='action != "Update" ? "Add new book" : "Update " + row.name + " book"'>
       <b-form>
            <b-form-group
                label="Name:"
            >
                <b-form-input
                    id="input-1"
                    type="text"
                    v-model.trim="$v.name.$model"
                    :state="$v.name.required"
                    placeholder="Enter a name"
                ></b-form-input>
                <div class="error" v-if="!$v.name.required">Field is required</div>
                <div class="error" v-if="!$v.name.minLength">Name must have at least {{$v.name.$params.minLength.min}} letters.</div>
            </b-form-group>

            <b-form-group
                label="Author:"
            >
                <b-form-input
                    id="input-1"
                    v-model.trim="$v.author.$model"
                    type="text"
                    :state="$v.author.required"
                    placeholder="Enter an author"
                ></b-form-input>
                <div class="error" v-if="!$v.author.required">Field is required</div>
                <div class="error" v-if="!$v.author.minLength">Name must have at least {{$v.author.$params.minLength.min}} letters.</div>
            </b-form-group>

            <b-form-group
                label="Category:"
            >
                <b-form-select :state="$v.category_id.required" v-model.trim="$v.category_id.$model" :options="categories"></b-form-select>
                <div class="error" v-if="!$v.category_id.required">Field is required</div>
            </b-form-group>
            
            <b-button class="mt-2 w-100" @click="action != 'Update' ? store() : update()" :disabled="$v.$invalid" variant='success'>Save</b-button>
        </b-form>
    </b-modal>
</template>

<script>
import Vue from 'vue'
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)
import { required, minLength } from 'vuelidate/lib/validators'
export default {
    props:['categories','row','action'],
    data () {
        return {
                name:null,
                author:null,
                category_id:null
        }
    },
    computed:{
    },
    validations: {
        name: {
            required,
            minLength: minLength(4)
        },
        author: {
            required,
            minLength: minLength(4)
        },
        category_id:{
            required
        }
    },
    watch:{
        action(nV){
            if(nV ==='Update'){
                this.name = this.row.name
                this.author = this.row.author
                this.category_id = this.row.category_id
            }else{
                this.name = null
                this.author = null
                this.category_id = null
            }
        }
    },
    methods:{
        store(){
            let name = this.name
            let author = this.author
            let category_id = this.category_id
            axios.post("/books",{name,author,category_id}
            ).then(response => {
                if(response.data.success){
                    this.$store.commit('increment')
                    this.$bvModal.hide('addBook')	
                }
            })
        },
        update(){
            let name = this.name
            let author = this.author
            let category_id = this.category_id
            axios.put("/books/" + this.row.id,
            {name,author,category_id}
            ).then(response => {
                if(response.data.success){
                    this.$store.commit('increment')
                    this.$bvModal.hide('addBook')	
                }
            })
        }
    },
    components:{
    },
    mounted() {
    }
}
</script>
