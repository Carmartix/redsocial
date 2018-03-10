<template>
    <div class="justify-content-center">         
        <div class="card card-default">
            <div class="card-header">Amigos</div>
            <ul class="list-group">
                <a :href="'/user/' + friend.id" class="list-group-item" v-for="friend, index in friends">
                    <img :src="friend.profile.image" style="vertical-align: baseline" class="rounded d-inline-block" width="40" height="40">
                    <div class="d-inline-block">
                        <strong class="d-block">{{ friend.name }}</strong>
                        <small>{{ friend.pivot.created_at  | moment("from") }}</small>
                    </div>
                    <div class="d-inline-block float-right">
                        <button class="btn btn-danger" @click="destroy(friend.id, index)">X</button>
                    </div>
                </a>
            </ul>
        </div>       
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                friends: []
            }
        },            
        mounted() {
            var app = this;
            axios.get('/friends')
                .then(function (resp) {
                    app.friends = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    app.$toastr.e("COULD NOT LOAD FRIENDS"); 
                });
        },
        methods: {
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
