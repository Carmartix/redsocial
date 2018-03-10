<template>
    <div class="justify-content-center">         
        <div class="card card-default">
            <div class="card-header">Amigos</div>
            <ul class="list-group">
                <li class="list-group-item" v-for="friend, index in friends">
                    <img :src="friend.profile.image" style="vertical-align: baseline" class="rounded d-inline-block" width="40" height="40">
                    <div class="d-inline-block">
                        <strong class="d-block">{{ friend.name }}</strong>
                        <small>{{ friend.pivot.created_at  | moment("from") }}</small>
                    </div>
                    <div class="d-inline-block float-right">
                        <button class="close" @click="destroy(friend.id, index)"></button>
                    </div>
                </li>
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
                    alert("Could not load friends");
                });
        },
        methods: {
            destroy: function(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/friends/' + id)
                        .then(function (resp) {
                            app.friends.splice(index, 1);
                            alert("Friend Delete");
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Could not delete friend");
                        });
                }
            }
        }
    }
</script>
