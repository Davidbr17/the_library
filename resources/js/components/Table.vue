<template>
    <b-card>
       <b-button class="float-right" v-b-modal.addBook variant='success'>Add Book</b-button>
       <v-client-table :columns="columns" :data='data' :options="options" :theme="theme">
           <span slot="available" slot-scope="props" :class="props.row.available != 0 ? 'text-success': 'text-danger'">
                {{props.row.available != 0 ? 'Available' : 'Unavailable'}}
           </span>
           <b-button slot="update" variant="primary" slot-scope="props" @click="actionControl('Update',props.row)">
               <b-icon-pencil-square/>
           </b-button>

           <b-button v-if='props.row.available === 1' slot="lend" v-b-modal.lendBook variant="success" slot-scope="props" @click="actionControl('Lend',props.row)">
               Lend
           </b-button>

           <b-button v-else slot="lend" variant="secondary" slot-scope="props" @click="actionControl('unLend',props.row)">
               Return
           </b-button>

           <b-button  slot="delete" variant="danger" slot-scope="props" @click="actionControl('delete',props.row)">
               <b-icon-dash-circle/>
           </b-button>

       </v-client-table>
       <AddBookModal :categories='categories' :row='row' :action='action'/>
       <LendBookModal :users='users' :row='row'/>
    </b-card>
</template>

<script>
import {ClientTable} from 'vue-tables-2' 
import AddBookModal from './AddBookModal.vue'
import LendBookModal from './LendBook.vue'
Vue.use(ClientTable)
export default {
    props:['books','categories','users'],
    data () {
        return {
            data:[],
            row:null,
            action:null,
            actions:['Update','Lend','Delete','Give back'],
            columns: ['id','name','author','category.name','borrowed_user.name','published_date','available','lend','update','delete'],
            options: {
                headings: {
                    'category.name' : 'category',
                    'borrowed_user.name' : 'Borrowed user'
                },
                sortable: ['id','name','author','category.name','borrowed_user.name','published_date','available'],
                filterable: ['id','name','author','category.name','borrowed_user.name','published_date','available'],
                sortIcon: { base:'fa', up:'fa-sort-asc', down:'fa-sort-desc', is:'fa-sort' },
                pagination: {
                    chunk: 5,
                    edge: false,
                    nav: 'scroll'
                },
            },
            theme: 'bootstrap4',
            template: 'default'
        }
    },
    computed:{
      update(){
          return this.$store.state.update
      }
    },
    watch:{
       update(nV){
           this.get()
           this.action = null
       }
    },
    methods:{
        actionControl(action,row){
           switch (action) {
               case 'Update':
                     this.action = action
                     this.row = row
                     this.$bvModal.show('addBook')	
                   break;
                case 'Lend':
                     this.row = row
                   break;
                case 'unLend':
                    this.$swal.fire({
                        title: 'Are you sure?',
                        text: "Only accept if the user was already returned the book.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Accept'
                    }).then((result) => {
                        if (result.value) {
                            this.returnBook(row.id)
                        }
                    })
                    break;
                case 'delete':
                    this.$swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Accept'
                    }).then((result) => {
                        if (result.value) {
                            this.destroy(row.id)
                        }
                    })
                    break;    
               default:
                   break;
           }
        },
        get(){
            axios.get("/books"
            ).then(response => {
                if(response.data.success){
                    this.data = response.data.data
                }
            })
        },
        destroy(id){
            axios.delete("/books/" + id
            ).then(response => {
                if(response.data.success){
                    this.get()
                }
            })
        },
        returnBook(id){
            axios.put("/unlend_book",{id}
            ).then(response => {
                if(response.data.success){
                    this.get()
                }
            })
        }
    },
    components:{
        AddBookModal,
        LendBookModal
    },
    mounted() {
        this.data = [...this.books]
    }
}
</script>
