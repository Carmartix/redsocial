<template>
    <div class="card card-default">
        <div class="card-header">Perfil</div>
        <img class="card-img-top p-3" v-bind:src="user.image" />
        <div class="card-body">
            <div class="input-group mb-3" v-if="!editing">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" accept="images/*" id="inputGroupFile01" v-on:change="onFileChange"/>
                    <label class="custom-file-label" for="inputGroupFile01">Upload</label>
                </div>
            </div>
            <div class="card-title">
                <input type="text" class="form-control" name="name" v-model="user.name" v-bind:disabled="editing" />
            </div>
            <div class="card-text">
                <textarea class="form-control" v-model="user.profile.bio" placeholder="Biografia" v-bind:disabled="editing"></textarea>
            </div>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <input type="text" class="form-control" name="country" placeholder="País" v-bind:disabled="editing" v-model="user.profile.country" />
            </li>
            <li class="list-group-item">
                <input type="text" class="form-control" name="city" placeholder="Ciudad" v-bind:disabled="editing" v-model="user.profile.city" />
            </li>
            <li class="list-group-item">
                <input type="text" class="form-control" name="address" placeholder="Dirección" v-bind:disabled="editing" v-model="user.profile.address" />
            </li>
            <li class="list-group-item">
                <input type="text" class="form-control" name="phone" placeholder="Telefono" v-bind:disabled="editing" v-model="user.profile.phone" />
            </li>
        </ul>
        <div class="card-footer">
            <div v-if="id == auth.id">                
                <button type="button" v-on:click="editar" class="btn btn-outline-success btn-block" v-if="editing">Editar</button>
                <button type="button" v-on:click="save" class="btn btn-outline-primary btn-block" v-if="!editing">Guardar</button>
            </div>
            <div v-if="id != auth.id">  
                <div v-if="!canAccept">
                    <button type="button" v-on:click="addFriend" class="btn btn-primary btn-block" v-if="!isFriend">Agregar amigo/a</button>
                    <button type="button" v-on:click="deleteFriend" class="btn btn-danger btn-block" v-if="isFriend">Eliminar amigo/a</button>
                </div>              
                <button type="button" v-on:click="acceptFriend" class="btn btn-success btn-block" v-if="canAccept">Aceptar amigo/a</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                user: {
                    id: 1,
                    profile: {
                        image: 'images/user.png',
                        country: 'Venezuela',
                    },
                    name: 'Usuario xx1',
                    created_at: '8-03-2018 11:50am',
                },
                editing: true,
                canAccept: false,
                isFriend: false,
            }
        },  
        props: {
            id: {
                type: Number,
                default: 0,
            },
            auth: {
                type: Object,
                default: function() {
                    return { 
                        id: 0,
                    }
                }
            }
        },
        mounted() {
            var app = this;
            var url = '/user';
            if (app.auth.friends) this.checkUser();
            if (app.id != 0) {
                url = '/user/'+ app.id ;
            }
            axios.get(url)
                .then(function(resp) {
                    app.user = resp.data;
                    app.user.image = app.user.profile.image;
                })
                .catch(function(resp) {                    
                    console.log(resp);
                    app.$toastr.e("COULD NOT LOAD USER PROFILE"); 
                });
        },
        methods: {
            editar: function (event) {
                this.editing = false;
                console.log('Editing Profile');
                this.$toastr.s("EDITING PROFILE"); 
            },
            save: function(event) {
                console.log('Save user');
                var app = this;
                var user = this.user;
                axios.post('/user/profile', user )
                    .then(function(resp) {
                        app.user = resp.data;
                        app.user.image = app.user.profile.image;
                        app.editing = true;
                        app.$toastr.s("PROFILE UPDATE"); 
                    })
                    .catch(function(resp) {                    
                        console.log(resp);
                        app.$toastr.e("COULD NOT UPDATE USER PROFILE"); 
                    });
            },
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                var vm = this;
                if (!files.length)
                    return;
                vm.createImage(files[0]);
            },
            createImage(file) {
                var reader = new FileReader();
                var vm = this;
                reader.onload = (e) => {
                    vm.user.image = e.target.result;
                };
                reader.readAsDataURL(file);
                console.log('New File');
            },
            addFriend(){
                var app = this;
                axios.get('/user/'+app.id+'/friend')
                    .then(function(resp) {
                        app.$toastr.s("FRIEND INVITATION SENT"); 
                        app.$forceUpdate();
                    })
                    .catch(function(resp) {
                        console.log(resp);
                        app.$toastr.e("CAN'T SEND INVITATION FRIEND"); 
                    })
            },
            deleteFriend(){
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/friends/' + app.id)
                        .then(function (resp) {
                            app.auth.friends.forEach(function(friend, index) {
                                if (friend.id == app.id) {
                                    app.auth.friends.slice(index,1);
                                }
                            });
                            app.isFriend = app.canAccept = false;
                            app.$toastr.s("FRIEND DELETED"); 
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.$toastr.e("COULD NOT DELETE FRIEND"); 
                        });
                }
            },
            acceptFriend(){
                var app = this;
                axios.post('/imboxs', app.imbox)
                    .then(function(resp) {
                        app.auth.friends.push({ id: app.id });
                        app.canAccept = false;
                        app.isFriend = true;
                        app.$toastr.s("ACCEPTED NEW FRIEND"); 
                    })
                    .catch(function(resp) {
                        console.log(resp);
                        app.$toastr.e("COULD NOT ACCEPTED FRIEND"); 
                    });
            },
            checkUser() {
                var app = this;
                if (app.auth.friends.length > 0) { 
                    app.auth.friends.forEach(function(friend) {
                        if (friend.id == app.id) {
                            console.log('SOMOS AMIGOS');
                            app.isFriend = true;
                        }
                    });
                } 
                if (app.auth.imbox.length > 0) { 
                    app.auth.imbox.forEach(function(imbox) {
                        if (imbox.user2_id == app.id) {
                            console.log('TENGO SOLICITUD');
                            app.canAccept = true;
                            app.imbox = imbox;
                        }
                    });
                }
            },
        }
    }
</script>
