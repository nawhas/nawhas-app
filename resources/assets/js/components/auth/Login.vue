<template>
  <div>
    <v-form>
      <v-text-field
        v-model="form.email"
        label="E-mail"
        required
      ></v-text-field>
      <v-text-field
        v-model="form.password"
        label="Password"
        required
      ></v-text-field>
      <v-btn @click.prevent="authenticate">Login</v-btn>
    </v-form>
  </div>
</template>

<script>
  import { login } from '../../helpers/auth';

  export default {
    name: 'login',
    data() {
      return {
        form: {
          email: null,
          password: null,
        }
      }
    },
    methods: {
      authenticate() {
        this.$store.dispatch('auth/login');
        login(this.$data.form)
          .then(res => {
            this.$store.commit('auth/loginSuccess', res);
            this.$router.push('/');
          })
          .catch(error => {
            this.$store.commit('auth/loginFailed', error);
          });
      }
    }
  }
</script>

<style>

</style>