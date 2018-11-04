<template>
  <div>
    <section>
      <v-layout row>
        <v-flex xs12 sm6 offset-sm3>
          <h3>Edit Reciter {{ reciter.name }}</h3>
        </v-flex>
      </v-layout>
      <v-form enctype="multipart/form-data">
        <v-layout row>
          <v-flex>
            <v-text-field
              label="Reciter Name"
              v-model="reciter.name"
              required
            ></v-text-field>
          </v-flex>
        </v-layout>
        <v-layout row>
          <v-flex>
            <v-textarea
              label="Reciter description"
              v-model="reciter.description">
            </v-textarea>
          </v-flex>
        </v-layout>
        <v-layout row>
          <v-flex>
            <input
              type="file"
              @change="onFileChange"
            >
            <img v-if="!this.reciter.updatedAvatar" :src="this.reciter.avatar" height="100"width="100">
          </v-flex>
        </v-layout>
        <v-layout row>
          <v-flex xs12 sm1 offset-sm11>
            <v-btn @click="submitForm">Submit</v-btn>
          </v-flex>
        </v-layout>
      </v-form>
    </section>
  </div>
</template>

<script>
  export default {
    name: 'reciters-update',
    created() {
      this.$store.dispatch('reciters/fetchReciter', { reciter: this.$route.params.reciter });
    },
    computed: {
      reciter() {
        return this.$store.getters['reciters/reciter'];
      }
    },
    methods: {
      submitForm() {
        const form = new FormData();
        form.append('name', this.reciter.name);
        form.append('avatar', this.reciter.avatar);
        if (this.reciter.updatedAvatar) {
          form.append('updatedAvatar', this.reciter.updatedAvatar);
        }
        form.append('description', this.reciter.description);
        this.$store.dispatch('reciters/updateReciter', { reciter: this.reciter, form: form })
          .then(() => {
            this.$router.push('/reciters');
          });
      },
      onFileChange(e) {
        this.reciter.updatedAvatar = e.target.files[0];
      },
    }
  }
</script>