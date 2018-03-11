<template>
    <div class="row px-3">        
        <div class="card-columns px-3 justify-content-center">
            <div class="card mb-3"  v-for="user, index in users">            
                    <div class="card-header text-center"><strong>{{ user.name }}</strong></div>
                    <img :src="user.profile.image" class="card-img p-3" />
                    <div class="card-body">
                        <div class="card-text">Amigos: {{ user.friends_count }}</div>
                        <div class="card-text">Publicaciones: {{ user.feeds_count }}</div>
                    </div>
                    <div class="card-footer">
                        <a :href="'/user/'+user.id" class="btn btn-link">Ver perfil</a>
                    </div>
            </div>       
        </div>
        <div class="col-12">            
            <pagination class="justify-content-center" v-bind:limit="2" :data="paginate" v-on:pagination-change-page="getResults"></pagination>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                users: [],
                paginate: {
                    current_page: 1
                }
            }
        },
        props: {
            auth: {
                type: Object,
                default: function (){
                    return {}
                }
            }
        },
        mounted() {
            this.getResults();
        },
        methods: {
            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                var app = this;
                axios.get('/users?page='+page)
                    .then(function (resp) {
                        app.users = resp.data.data;
                        app.paginate = resp.data;
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        app.$toastr.e("COULD NOT LOAD USERS"); 
                    });
            },
            destroy: function(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/friends/' + id)
                        .then(function (resp) {
                            app.friends.splice(index, 1);
                            app.$toastr.s("FRIEND DELETED"); 
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.$toastr.e("COULD NOT DELETE FRIEND"); 
                        });
                }
            }
        }
    }
</script>
