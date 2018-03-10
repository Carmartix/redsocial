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
            <button type="button" v-on:click="editar" class="btn btn-outline-success btn-block" v-if="editing && !id!=0">Editar</button>
            <button type="button" v-on:click="save" class="btn btn-outline-primary btn-block" v-if="!editing">Guardar</button>
            <button type="button" v-on:click="addFriend" class="btn btn-primary btn-block" v-if="id!=0">Agregar amigo/a</button>
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

            }
        },  
        props: {
            id: {
                type: Number,
                default: 0,
            }
        },
        mounted() {
            var app = this;
            var url = '/user';
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
                    alert("Could not load user profile");
                });
        },
         methods: {
            editar: function (event) {
                this.editing = false;
                console.log('Editing Profile');
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
                        alert("Profile Update");
                    })
                    .catch(function(resp) {                    
                        console.log(resp);
                        alert("Could not update user profile");
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
            addFriend(id){
                var app = this;
                axios.get('/user/'+app.id+'/friend')
                    .then(function(resp) {
                        console.log('Friend add');
                        vm.$forceUpdate();
                    })
                    .catch(function(resp) {
                        console.log(resp);
                        alert("Could not add friend");
                    })
            }

        }
    }
</script>
