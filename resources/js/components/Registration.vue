<template>
    <div>
        <div class="d-flex">
            <button v-on:click="openModal" type="button" class="d-flex btn btn-link link-dark">
                Sign up
            </button>
        </div>

        <div ref="login-modal" class="modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Sign up</h5>
                        <button v-on:click.prevent="closeModal" type="button" class="btn-close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitForm" action="#" class="container-sm w-50 my-3">
                            <div v-for="(value, inputName) in formData" class="mb-3">
                                <label class="form-label">{{ capitalizeFirstLetter(inputName) }}</label>
                                <input
                                    :class="{
                                        'border-danger' : v.formData[inputName].$error
                                            || vuelidateExternalResults.formatData.password.length !== 0
                                    }"
                                    v-model="formData[inputName]"
                                    v-on:input="formInputChanged"
                                    :type='inputName'
                                    :name='inputName'
                                    class="form-control"
                                >
                                <div
                                    class="text-danger fs-7"
                                    v-if="v.formData[inputName].required.$invalid
                                        && v.formData[inputName].$dirty"
                                >
                                    <span>This field if required</span>
                                </div>
                                <div class="text-danger fs-7" v-else-if="v.formData[inputName].$error">
                                    Min length is {{ v.formData[inputName].minLength.$params.min }}
                                    and max length is {{ v.formData[inputName].maxLength.$params.max }}
                                </div>
                            </div>

                            <span
                                class="text-danger fs-7"
                                v-if="vuelidateExternalResults.formatData.password.length !== 0"
                            >
                                        {{ vuelidateExternalResults.formatData.password[0] }}
                            </span>

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
                name: {
                    required,
                    minLength: minLength(2),
                    maxLength: maxLength(24)
                },
                email: {
                    required,
                    minLength: minLength(2),
                    maxLength: maxLength(24)
                },
                login: {
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
                name: "",
                email: "",
                login: "",
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
                    axios.post('/registration', this.formData)
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
            for (const [key, value] of Object.entries(this.formData)) {
                this.formData[key] = '';
            }
            this.v.$reset();
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
        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    },
    mounted() {

    }
}
</script>

<style scoped>
</style>
