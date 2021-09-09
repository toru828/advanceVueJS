<template>
    <v-row align="center" justify="center">
        <v-col cols="12" sm="8">
            <v-card class="elevation-12" color="cream">
                <v-toolbar color="primary" dark flat>
                    <v-toolbar-title prepend-icon="lock"
                        >Login form</v-toolbar-title
                    >
                </v-toolbar>
                <v-card-text>
                    <v-form>
                        <ValidationProvider
                            v-slot="{ errors }"
                            name="Email"
                            rules="required|email"
                        >
                            <v-text-field
                                v-model="item.email"
                                label="Email *"
                                required
                                autocomplete="off"
                                prepend-icon="mdi-account"
                                v-on:keyup.enter="onClickLoginButton"
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
                                label="Password *"
                                name="password"
                                prepend-icon="mdi-lock"
                                type="password"
                                v-model="item.password"
                                :error-messages="errors"
                                v-on:keyup.enter="onClickLoginButton()"
                                outlined
                            />
                        </ValidationProvider>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn
                        color="primary"
                        :disabled="isLoginBtnDisabled"
                        @click="onClickLoginButton"
                        :loading="isBtnLoading"
                    >
                        Login
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
    name: "Login",
    components: {
        ValidationProvider,
        ValidationObserver
    },
    data() {
        return {
            item: {
                email: "",
                password: ""
            },
            isOk: false,
            isBtnLoading: false,
            errorEmail: ""
        };
    },
    computed: {
        // a computed getter
        isLoginBtnDisabled() {
            if (!this.item.email || !this.item.password) {
                return true;
            }
            return false;
        }
    },
    methods: {
        async onClickLoginButton() {
            if (this.isLoginBtnDisabled === true) {
                return false;
            }
            this.isBtnLoading = true;
            const loginParam = {
                email: this.item.email,
                password: this.item.password
            };

            this.$store
                .dispatch("login", loginParam)
                .then(res => {
                    this.$router.push("/users");
                })
                .catch(function(error) {})
                .finally(() => {
                    this.isBtnLoading = false;
                });
        }
    }
};
</script>
