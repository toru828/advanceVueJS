<template>
    <v-row align="center" justify="center">
        <v-col cols="12" sm="8">
            <v-card class="elevation-12" color="cream">
                <v-toolbar color="primary" dark flat>
                    <v-toolbar-title prepend-icon="lock"
                        >Search form</v-toolbar-title
                    >
                </v-toolbar>
                <v-card-text>
                    <v-form>
                        <ValidationProvider
                            v-slot="{ errors }"
                            name="Name"
                            rules="required"
                        >
                            <v-text-field
                                v-model="user.name"
                                label="Search Name *"
                                required
                                autocomplete="off"
                                prepend-icon="mdi-account"
                                v-on:keyup.enter="onClickSearchButton"
                                :error-messages="errors"
                                outlined
                                class="pt-8"
                            ></v-text-field>
                        </ValidationProvider>

                        <ValidationProvider
                            v-slot="{ errors }"
                            name="Email"
                            rules="required|email"
                        >
                            <v-text-field
                                v-model="user.email"
                                label="Search Email *"
                                required
                                autocomplete="off"
                                prepend-icon="mdi-email"
                                v-on:keyup.enter="onClickSearchButton"
                                :error-messages="errors"
                                outlined
                                class="pt-8"
                            ></v-text-field>
                            <span
                                style="color: #ff5252; font-size: 12px; padding-left: 33px;"
                                >{{ errorEmail }}</span
                            >
                        </ValidationProvider>

                        <ValidationProvider
                            v-slot="{ errors }"
                            name="created_at"
                            rules="required"
                        >
                            <v-text-field
                                id="created_at"
                                label="Search created_at *"
                                name="created_at"
                                prepend-icon="mdi-lock"
                                type="created_at"
                                v-model="user.created_at"
                                :error-messages="errors"
                                v-on:keyup.enter="onClickSearchButton"
                                outlined
                                required
                                autocomplete="off"
                            />
                        </ValidationProvider>
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
    </v-row>
</template>

<script>
import {
    ValidationProvider,
    ValidationObserver
} from "vee-validate/dist/vee-validate.full";
export default {
    name: "SearchForm",
    components: {
        ValidationProvider,
        ValidationObserver
    },
    data() {
        return {
            user: {
                name: "",
                email: "",
                created_at: ""
            },
            isBtnLoading: false,
            errorEmail: "",
            answers: []
        };
    },
    created() {
        axios.get("/api/search").then(res => {
            this.users = res.data;
        });
    },
    computed: {
        isSearchBtnDisabled() {
            if (!this.user.name || !this.user.created_at || !this.user.email) {
                return true;
            } else {
                return false;
            }
        }
    },
    methods: {
        async onClickSearchButton() {
            if (this.isSearchBtnDisabled === true) {
                return false;
            }

            this.isBtnLoading = true;

            await axios.get("/api/search", this.user).then(res => {
                this.answers = res.data;
            });
            console.log(this.answers);
            // this.$router.push("/users")
            // .catch(function (error) {
            // })
            // .finally(() => {
            //     this.isBtnLoading = false;
            // });
        }
    }
};
</script>