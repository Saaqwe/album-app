<template>
    <div>
        <div class="d-flex">
            <button v-on:click="openModal" type="button" class="d-flex btn btn-link">
                Sign up
            </button>
        </div>

        <div ref="login-modal" class="modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Sign up</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitForm" action="#" class="container-sm w-50 my-3">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input v-model="formData.email" type="text" name="email" class="form-control" placeholder="name@example.com">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input v-model="formData.password" type="password" name="password" class="form-control">
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
import { required, email, minLength, maxLength } from '@vuelidate/validators'

export default {
    name: "email",
    props: ['user-data'],
    setup: () => ({ v$: useVuelidate() }),
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
                }
            }
        }
    },

    data () {
        return {
            formData: {
                email: "",
                password: "",
            },
            loginModal: {},
        }
    },
    methods: {
        async submitForm() {
            let validated = await this.checkRules();
            if(validated) {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('/login', this.formData)
                        .then(response => {
                            this.closeModal();
                        })
                        .catch((error => {
                            if(error.response.status === 422) {
                                this.showError();
                            }
                            console.log(error.response.status);
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
        showError() {
            alert("Error");
        },
        async checkRules() {
            const result = await this.v$.$validate();
            if (!result) {
                console.log("invalid data");
                return false;
            }
            console.log("valid data");
            return true;
        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
