<template>
  <div>
    <section>
      <v-layout row>
        <v-flex xs12 sm6 offset-sm3>
          <h2>Add Track {{ album.name }} | {{ album.year }} | {{ reciter.name }}</h2>
        </v-flex>
      </v-layout>
      <v-form enctype="multipart/form-data">
        <v-layout row>
          <v-flex>
            <v-text-field
              label="Track Name"
              v-model="track.name"
              required
            ></v-text-field>
          </v-flex>
        </v-layout>
        <v-layout row>
          <v-flex>
            <v-text-field
              label="Track Number"
              v-model="track.trackNumber"
              required
            ></v-text-field>
          </v-flex>
        </v-layout>
        <v-layout row>
          <v-flex>
            <v-select
              v-model="track.language"
              :items="languages"
              item-text="name"
              item-value="slug"
              label="Select Nawha Language"
              multiple
              persistent-hint
              return-object
              single-line
              required
            ></v-select>
          </v-flex>
        </v-layout>
        <v-layout row>
          <v-flex>
            Audio File
            <input
              type="file"
              @change="onFileChange"
              name="audio"
            >
          </v-flex>
        </v-layout>
        <v-layout row>
          <v-flex>
            <v-text-field
              label="YouTube Link To Video"
              v-model="track.video"
            ></v-text-field>
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
  import axios from 'axios';

  export default {
    name: 'tracks-create',
    created() {
      this.$store.dispatch('reciters/fetchReciter', { reciter: this.$route.params.reciter });
      this.$store.dispatch('albums/fetchAlbum', { reciter: this.$route.params.reciter, album: this.$route.params.album } );
      axios.get('/v1/languages')
        .then((response) => {
          this.languages = response.data.data;
        });
    },
    computed: {
      reciter() {
        return this.$store.getters['reciters/reciter'];
      },
      album() {
        return this.$store.getters['albums/album'];
      }
    },
    data() {
      return {
        track: {'name': null, 'video': null, 'audio': null, 'trackNumber': null, 'language': null},
        languages: [],
      };
    },
    methods: {
      uploadForm() {
        const form = new FormData();
        form.append('audio', this.track.audio);
        form.append('video', this.track.video);
        form.append('name', this.track.name);
        form.append('trackNumber', this.track.trackNumber);
        const formLanguages = [];
        for (let i = 0; i < this.track.language.length; i++) {
          formLanguages.push(this.track.language[i].slug);
        }
        form.append('language', formLanguages);
        this.$store.dispatch('tracks/storeTrack', { reciter: this.$route.params.reciter, album: this.$route.params.album, form: form } )
          .then(() => {
            this.$router.push(`/reciters/${this.reciter.slug}`);
          });
      },
      onFileChange(e) {
        if (e.target.name === 'audio') {
          this.track.audio = e.target.files[0];
        } else if (e.target.name === 'video') {
          this.track.video = e.target.files[0];
        }
      },
    },
  };
</script>
