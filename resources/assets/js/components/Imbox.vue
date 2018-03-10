<template>
    <div class="justify-content-center mb-3">         
        <div class="card card-default">
            <div class="card-header">Solicitudes de Amistad</div>
            <ul class="list-group">
                <li class="list-group-item" v-for="imbox, index in imboxs">
                    <img :src="imbox.user2.profile.image" style="vertical-align: baseline" class="rounded d-inline-block" width="40" height="40">
                    <div class="d-inline-block">
                        <small class="d-block">{{ imbox.text }}</small>
                        <div>
                            <button class="btn btn-sm btn-success" @click="accept(imbox, index)" type="button">Aceptar</button>
                            <button class="btn btn-sm btn-outline-danger" @click="destroy(imbox.id, index)" type="button">Eliminar</button>
                        </div>
                    </div>
                </li>
                <li class="list-group-item" v-if="imboxs.length < 1">
                    No tiene solicitud de Amistad
                </li>
            </ul>
        </div>       
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                imboxs: []
            }
        },            
        mounted() {
            var app = this;
            axios.get('/imboxs')
                .then(function (resp) {
                    app.imboxs = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load imbox");
                });
        },
        methods: {
            destroy(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/imboxs/' + id)
                        .then(function (resp) {
                            app.imboxs.splice(index, 1);
                            alert("imbox Delete");
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Could not delete imbox");
                        });
                }
            },
            accept(imbox, index) {
                var app = this;
                axios.post('/imboxs', imbox)
                    .then(function(resp) {
                        app.imboxs.splice(index, 1);
                        alert("Friend accepted");
                    })
                    .catch(function(resp) {
                        console.log(resp);
                        alert("Could not accept friend");
                    });
            }
        }
    }
</script>
