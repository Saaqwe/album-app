<template>
    <div>
        <div class="d-flex">
            <button v-on:click="openModal" type="button" class="d-flex btn btn-link link-dark">
                Login in
            </button>
        </div>

        <div ref="login-modal" class="modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Login in</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitForm" action="#" class="container-sm w-50 my-3">
                            <div class="mb-3">
                                <label class="form-label">Login</label>
                                <input
                                    v-model="formData.email"
                                    :class="{
                                        'border-danger' : v.formData.email.$error
                                            || vuelidateExternalResults.formatData.password.length !== 0
                                    }"
                                    type="text" name="email"
                                    class="form-control"
                                    placeholder="name@example.com"
                                    v-on:input="formInputChanged"
                                >
                                <div class="text-danger fs-7" v-if="v.formData.email.required.$invalid">
                                    <span>This field if required</span>
                                </div>
                                <div class="text-danger fs-7" v-else-if="v.formData.email.$error">
                                    Min length is {{ v.formData.email.minLength.$params.min }}
                                    and max length is {{ v.formData.email.maxLength.$params.max }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input
                                    :class="{
                                        'border-danger' : v.formData.password.$error
                                            || vuelidateExternalResults.formatData.password.length !== 0
                                    }"
                                    v-model="formData.password"
                                    v-on:input="formInputChanged"
                                    type="password"
                                    name="password"
                                    class="form-control"
                                >
                                <div class="text-danger fs-7" v-if="v.formData.password.required.$invalid">
                                    <span>This field if required</span>
                                </div>
                                <div class="text-danger fs-7" v-else-if="v.formData.password.$error">
                                    Min length is {{ v.formData.password.minLength.$params.min }}
                                    and max length is {{ v.formData.password.maxLength.$params.max }}
                                </div>
                                <span
                                    class="text-danger fs-7"
                                    v-if="vuelidateExternalResults.formatData.password.length !== 0"
                                >
                                        {{ vuelidateExternalResults.formatData.password[0] }}
                                </span>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import useVuelidate from '@vuelidate/core'
import { required,  email, minLength, maxLength } from '@vuelidate/validators'


export default {
    name: "Login",
    props: ['user-data'],
    setup: () => ({
        v: useVuelidate()
    }),
    validations () {
        return {
            formData: {
                email: {
                    required,
                    minLength: minLength(2),
                    maxLength: maxLength(24)
                },
                password: {
                    required,
                    minLength: minLength(4),
                    maxLength: maxLength(40)
                },
            },

        }
    },

    data () {
        return {
            formData: {
                email: "",
                password: "",
            },
            loginModal: {},
            vuelidateExternalResults: {
                formatData: {
                    password: []
                },
            }
        }
    },
    methods: {
        async submitForm() {
            let validated = await this.v.$validate();
            if(validated) {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('/login', this.formData)
                        .then(response => {
                            this.closeModal();
                            window.location.reload();
                        })
                        .catch((error => {
                            if(error.response.status === 422) {
                                this.showServerValidationError();
                            }
                        }));
                });
            }
        },
        openModal() {
            const options = {};
            this.loginModal = new bootstrap.Modal(this.$refs["login-modal"], options);
            this.loginModal.show();
        },
        closeModal() {
            this.loginModal.hide();
        },
        showServerValidationError() {
            const errors = {
                formatData: {
                    password: ['Login or password is incorrect']
                }
            };
            Object.assign(this.vuelidateExternalResults, errors)
        },
        formInputChanged () {
            this.v.$clearExternalResults();
        },
    },
    mounted() {

    }
}
</script>

<style scoped>
</style>
