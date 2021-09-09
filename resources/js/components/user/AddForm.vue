<template>
    <v-row align="center" justify="center">
        <v-col cols="12" sm="8">
            <v-card class="elevation-12" color="cream">
                <v-toolbar color="primary" dark flat>
                    <v-toolbar-title prepend-icon="lock"
                        >Add form</v-toolbar-title
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
                                label="Add Name *"
                                required
                                autocomplete="off"
                                prepend-icon="mdi-account"
                                v-on:keyup.enter="onClickAddButton"
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
                                label="Add Email *"
                                required
                                autocomplete="off"
                                prepend-icon="mdi-email"
                                v-on:keyup.enter="onClickAddButton"
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
                            name="Password"
                            rules="required"
                        >
                            <v-text-field
                                id="password"
                                label="Add Password *"
                                name="password"
                                prepend-icon="mdi-lock"
                                type="password"
                                v-model="user.password"
                                :error-messages="errors"
                                v-on:keyup.enter="onClickAddButton"
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
                        :disabled="isAddBtnDisabled"
                        @click="onClickAddButton"
                        :loading="isBtnLoading"
                    >
                        Add User
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
    name: "AddForm",
    components: {
        ValidationProvider,
        ValidationObserver
    },
    data() {
        return {
            user: {
                name: "",
                email: "",
                password: ""
            },
            isBtnLoading: false,
            errorEmail: ""
        };
    },
    created() {
        axios.get("/api/users").then(res => {
            this.users = res.data;
        });
    },
    computed: {
        isAddBtnDisabled() {
            if (!this.user.name || !this.user.password || !this.user.email) {
                return true;
            }
                return false;
        }
    },
    methods: {
        async onClickAddButton() {
            if (this.isAddBtnDisabled === true) {
                return false;
            }

            this.isBtnLoading = true;

            await axios.post("/api/users", this.user);
            this.$router.push("/users")
            .catch(function (error) {
            })
            .finally(() => {
                this.isBtnLoading = false;
            });
        }
    }
};
</script>
