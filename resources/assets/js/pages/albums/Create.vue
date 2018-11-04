<template>
  <div>
    <section>
      <v-layout row>
        <v-flex xs12 sm6 offset-sm3>
          <h2>Add Album To {{ reciter.name }}'s Collection</h2>
        </v-flex>
      </v-layout>
      <v-form enctype="multipart/form-data">
        <v-layout row>
          <v-flex>
            <v-text-field
              label="Album Name"
              v-model="album.name"
              required
            ></v-text-field>
          </v-flex>
        </v-layout>
        <v-layout row>
          <v-flex>
            <v-text-field
              label="Album year"
              v-model="album.year"
              required
            ></v-text-field>
          </v-flex>
        </v-layout>
        <v-layout row>
          <v-flex>
            <input
              type="file"
              @change="onFileChange">
          </v-flex>
        </v-layout>
        <v-layout row>
          <v-flex xs12>
            <v-btn @click="uploadForm()">Submit</v-btn>
          </v-flex>
        </v-layout>
      </v-form>
    </section>
  </div>
</template>

<script>
  export default {
    name: 'album-create',
    created() {
      this.$store.dispatch('reciters/fetchReciter', { reciter: this.$route.params.reciter });
    },
    computed: {
      reciter() {
        return this.$store.getters['reciters/reciter'];
      }
    },
    methods: {
      uploadForm() {
        const form = new FormData();
        form.append('name', this.album.name);
        if (this.album.artwork === undefined) {
          form.append('artwork', null);
        } else {
          form.append('artwork', this.album.artwork);
        }
        form.append('year', this.album.year);
        this.$store.dispatch('albums/storeAlbum', { reciter: this.$route.params.reciter, form: form });
        /*client.post(`/api/reciters/${this.reciter.slug}/albums`, form).then(() => {
          this.$router.push(`/reciters/${this.reciter.slug}`);
        });*/
      },
      onFileChange(e) {
        this.album.artwork = e.target.files[0];
      },
    },
    data() {
      return {
        album: {'name': null, 'artwork': null, 'year': null},
      };
    }
  };
</script>
