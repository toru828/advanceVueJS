<template>
    <div>
        <v-app-bar app clipped-left style="background-color: #39b704;">
            <v-col cols="2" class="ml-0 pl-0">
                <v-tabs background-color="#39b704" right dark>
                    <v-btn color="green">
                        <router-link
                            class="white--text"
                            style="text-decoration: none"
                            :to="{
                                name: 'AddForm'
                            }"
                        >Add User
                        </router-link>
                    </v-btn>
                </v-tabs>
            </v-col>
            <v-col cols="2" class="ml-0 pl-0">
                <v-tabs background-color="#39b704" right dark>
                    <v-btn color="green">
                        <router-link
                            class="white--text"
                            style="text-decoration: none"
                            :to="{
                                name: 'SearchForm'
                            }"
                        >Search User
                        </router-link>
                    </v-btn>
                </v-tabs>
            </v-col>
            <v-col cols="8">
                <v-tabs background-color="#39b704" right dark>
                    <v-tab @click="logout">
                        <v-icon>mdi-logout</v-icon> Logout
                    </v-tab>
                </v-tabs>
            </v-col>
        </v-app-bar>
        <v-col cols="12" style="padding-top: 0">
            <v-card cols="12" color="cream">
                <v-card color="cream" flat>
                    <v-card-text>
                        <h4>Users List</h4>
                        <hr />
                        <div>
                            <div class="row header">
                                <div
                                    class="col-2 card-title  text-bold"
                                    cols="2"
                                >
                                    Username
                                </div>
                                <div
                                    class="col-2 card-title  text-bold"
                                    cols="2"
                                >
                                    Email
                                </div>
                                <div
                                    class="col-2 card-title  text-bold"
                                    cols="2"
                                >
                                    Created At
                                </div>
                                <div
                                    class="col-2 card-title  text-bold"
                                    cols="2"
                                >
                                    Modified At
                                </div>
                                <div
                                    class="col-2 card-title  text-bold"
                                    cols="2"
                                >
                                    delete user
                                </div>
                                <div
                                    class="col-2 card-title  text-bold"
                                    cols="2"
                                >
                                    edit user
                                </div>
                            </div>
                            <div class="table-hover">
                                <div v-if="users.length == 0">
                                    There is no data.
                                </div>
                                <div
                                    v-else
                                    v-for="user in users"
                                    :key="user.id"
                                    class="row vertical-middle"
                                >
                                    <div class="col-2" cols="2">
                                        {{ user.name }}
                                    </div>
                                    <div class="col-2" cols="2">
                                        {{ user.email }}
                                    </div>
                                    <div class="col-2" cols="2">
                                        {{ dateFormat(user.created_at) }}
                                    </div>
                                    <div class="col-2" cols="2">
                                        {{ dateFormat(user.updated_at) }}
                                    </div>
                                    <div class="col-2" cols="2">
                                        <v-btn
                                            :userID="user.id"
                                            color="white"
                                            @click="
                                                onClickDeleteButton(user.id)
                                            "
                                            small
                                        >
                                            Delete
                                        </v-btn>
                                    </div>
                                    <div class="col-2" cols="2">
                                        <v-btn color="green" small
                                            ><router-link
                                                class="black--text"
                                                style="text-decoration: none"
                                                :to="{
                                                    name: 'EditForm',
                                                    params: { id: user.id }
                                                }"
                                                :userID="user.id"
                                                >Edit</router-link
                                            >
                                        </v-btn>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </v-card-text>
                </v-card>
            </v-card>
        </v-col>
    </div>
</template>

<script>
import dayjs from "dayjs";
import Vue from "vue";
export default {
    name: "UsersList",
    components: {
    },
    data() {
        return {
            users: []
        };
    },
    created() {
        this.getUsersList();
    },
    methods: {
        async getUsersList() {
            await axios.get("/api/users").then(res => {
                this.users = res.data;
            });
        },
        logout() {
            this.$store.dispatch("logout");
            this.$router.push("/");
        },
        dateFormat(date) {
            return dayjs(date).format("YYYY-MM-DD HH:mm:ss");
        },
        onClickDeleteButton(userID) {
            let check = window.confirm("Do you want to delete it?");
            if (check) {
                axios.delete("/api/users/" + userID).then(() => {
                    this.$router.go({ path: "/users", force: true });
                });
            }
        }
    }
};
</script>
<style>
.text-bold {
    font-weight: bold;
}
</style>