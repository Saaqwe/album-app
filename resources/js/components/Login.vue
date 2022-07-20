<template>
    <div>
        <form @submit.prevent="submitForm" action="#" class="container-sm w-50 my-3">
            <div class="mb-3">
                <label class="form-label">Login</label>
                <input v-model="formData.email" type="text" name="email" class="form-control" placeholder="name@example.com">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input v-model="formData.password" type="password" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <button v-on:click="testAuth">
            TEST AUTH 2
        </button>
    </div>

</template>

<script>
export default {
    name: "login",
    data () {
        return {
            formData: {
                email: "",
                password: ""
            },
        }
    },
    methods: {
        submitForm() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/login', this.formData).then(response => {
                   console.log(response);
                   this.checkProtection();
                });
            });
        },
        checkProtection() {
            axios.get(`api/projects/`).then(response => {
                console.log("project !!!")
                console.log(response);
            })
        },
        testAuth() {
            axios.get(`api/projects/`).then(response => {
                console.log("project !!!")
                console.log(response);
            })
        }
    }
}
</script>

<style scoped>

</style>
