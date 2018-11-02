<template>
  <div>
    <h3>Create new Reciter</h3>
    <v-form enctype="multipart/form-data">
      <v-text-field
        label="Reciter Name"
        v-model="reciter.name"
        required
      ></v-text-field>
      <v-textarea
        label="Reciter description"
        v-model="reciter.description">
      </v-textarea>
      <input type="file" :multiple="false" @change="onFileChange">
      <br>
      <v-btn color="red white--text" @click="submit">submit</v-btn>
    </v-form>
  </div>
</template>

<script>
  export default {
    name: 'reciters-create',
    data() {
      return {
        reciter: {
          'name': null,
          'avatar': null,
          'description': null
        },
      };
    },
    methods: {
      submit() {
        const form = new FormData();
        form.append('name', this.reciter.name);
        form.append('avatar', this.reciter.avatar);
        form.append('description', this.reciter.description);
        this.$store.dispatch('reciters/storeReciter', form)
          .then(() => {
            this.$router.push('/reciters');
          })
      },
      clear() {
        this.reciter.name = null;
        this.reciter.avatar  = null;
        this.reciter.description = null;
      },
      onFileChange(e) {
        this.reciter.avatar = e.target.files[0];
      },
    }
  }
</script>