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
            <v-col cols="10">
                <v-tabs background-color="#39b704" right dark>
                    <v-tab @click="logout">
                        <v-icon>mdi-logout</v-icon> Logout
                    </v-tab>
                </v-tabs>
            </v-col>
        </v-app-bar>
        <v-col cols="12">
            <v-card class="elevation-12" color="cream">
                <v-card-text>
                    <v-form>
                            <v-text-field
                                v-model="user.name"
                                label="Search Name *"
                                autocomplete="off"
                                prepend-icon="mdi-account"
                                v-on:keyup.enter="onClickSearchButton"
                                outlined
                                class="pt-8"
                            ></v-text-field>
                            <v-text-field
                                v-model="user.email"
                                label="Search Email *"
                                autocomplete="off"
                                prepend-icon="mdi-email"
                                v-on:keyup.enter="onClickSearchButton"
                                outlined
                                class="pt-8"
                            ></v-text-field>
                            <v-row>
                            <v-col
                                cols="12"
                                sm="6"
                            >
                            <v-text-field
                                label="Search Created date from *"
                                prepend-icon="mdi-calendar"
                                v-model="user.from"
                                v-on:keyup.enter="onClickSearchButton"
                                outlined
                                type="date"
                                autocomplete="off"
                                class="pt-8"
                            />
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                            >
                            <v-text-field
                                label="Search Created date to *"
                                v-model="user.to"
                                v-on:keyup.enter="onClickSearchButton"
                                outlined
                                type="date"
                                autocomplete="off"
                                class="pt-8"
                            />
                            </v-col>
                            </v-row>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn
                        color="primary"
                        :disabled="isSearchBtnDisabled"
                        @click="onClickSearchButton"
                        :loading="isBtnLoading"
                    >
                        Search User
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-col>
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
      <div class="text-center">
        <v-pagination
          v-model="page"
          :length="length"
          :total-visible="9"
          @input = "pageChange"
        ></v-pagination>
      </div>     
    </div>
</template>

<script>
import dayjs from "dayjs";
export default {
    name: "UsersList",
    components: {
    },
    data() {
        return {
            user: {
                name: "",
                email: "",
                from: "",
                to: "",
            },
            isBtnLoading: false,
            users: [],
            page: 1,
            length: 0,
            current_page: 1,
            last_page: "",
        };
    },
    created() {
        this.getUsersList();
    },
    methods: {
        async onClickSearchButton() {
            if (this.isSearchBtnDisabled === true) {
                return false;
            }
            this.isBtnLoading = true;
            await axios.get("/api/users", {params: this.user})
            .then(res => {
                this.users = res.data.data;
            })
            .catch(function (error) {
            })
            .finally(() => {
                this.isBtnLoading = false;
            });
        },
        async getUsersList() {
            await axios.get(`/api/users?page=${this.current_page}`).then(res => {
                this.users = res.data.data;
                this.current_page = res.data.current_page;
                this.length = res.data.last_page;
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
        },
        async pageChange(pageNumber) {
            this.current_page = pageNumber;
            await axios.get(`/api/users?page=${this.current_page}`).then(res => {
                this.users = res.data.data;
                this.current_page = res.data.current_page;
            });
        }
    },
    computed: {
        isSearchBtnDisabled() {
            if (!this.user.name && !this.user.email && !this.user.from && !this.user.to) {
                return true;
            }
            if (this.user.from && !this.user.to) {
                return true;
            }
            if (!this.user.from && this.user.to) {
                return true;
            }
                return false;
        }
    },
};
</script>
<style>
.text-bold {
    font-weight: bold;
}
</style>