<template>
    <div class="justify-content-center mb-3">         
        <div class="card card-default">
            <div class="card-header">Solicitudes de Amistad</div>
            <ul class="list-group">
                <li class="list-group-item" v-for="imbox, index in imboxs">
                    <img :src="imbox.user2.profile.image" style="vertical-align: bottom" class="rounded d-inline-block" width="40" height="40">
                    <div class="d-inline-block">
                        <small class="d-block"><a :href="'/user/'+imbox.user2.id">{{ imbox.text }}</a></small>
                        <div>
                            <button class="btn btn-sm btn-success" @click="accept(imbox, index)" type="button">Aceptar</button>
                            <button class="btn btn-sm btn-outline-danger" @click="destroy(imbox.id, index)" type="button">Eliminar</button>
                        </div>
                    </div>
                </li>
                <li class="list-group-item" v-if="imboxs.length < 1">
                    No tiene solicitud de Amistad
                </li>
                <pagination class="justify-content-center my-2" v-bind:limit="1" :data="paginate" v-on:pagination-change-page="getResults"></pagination>                    
            </ul>
        </div>       
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                imboxs: [],
                paginate: {
                    current_page: 1
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
                axios.get('/imboxs?page='+page)
                    .then(function (resp) {
                        app.imboxs = resp.data.data;
                        app.paginate = resp.data;
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        app.$toastr.e("COULD NOT LOAD IMBOX"); 
                    });
            },
            destroy(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/imboxs/' + id)
                        .then(function (resp) {
                            app.imboxs.splice(index, 1);
                            app.getResults(app.paginate.current_page);
                            app.$toastr.s("DELETED IMBOX MESSAGE"); 
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.$toastr.e("CAN'T DELETED IMBOX MESSAGE"); 
                        });
                }
            },
            accept(imbox, index) {
                var app = this;
                axios.post('/imboxs', imbox)
                    .then(function(resp) {
                        app.imboxs.splice(index, 1);
                        app.getResults(app.paginate.current_page);
                        app.$toastr.s("ACCEPTED NEW FRIEND"); 
                    })
                    .catch(function(resp) {
                        console.log(resp);
                        app.$toastr.e("COULD NOT ACCEPTED FRIEND"); 
                    });
            }
        }
    }
</script>
