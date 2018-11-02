<template>
  <div>
    <div id="top-reciters-section">
      <h5>Top Reciters</h5>
      <v-container grid-list-lg class="pa-0" fluid>
        <v-layout row wrap>
          <v-flex xs12 sm6 md4 v-for="reciter in popularReciters" :key="reciter.id">
            <reciter-card featured v-bind="reciter" />
          </v-flex>
        </v-layout>
      </v-container>
    </div>
    <div id="all-reciters-section">
      <h5>All Reciters</h5>
      <v-card>
        <v-container class="pa-0" fluid>
          <v-layout row wrap>
            <v-flex v-for="reciter in reciters" :key="reciter.id" xs12 sm6 md4 lg3>
              <reciter-card v-bind="reciter" />
            </v-flex>
          </v-layout>
        </v-container>
      </v-card>
    </div>
  </div>
</template>

<script>
  import ReciterCard from '../../components/reciters/ReciterCard.vue';

  export default {
    name: 'reciters-index',
    created() {
      this.$store.dispatch('reciters/fetchReciters');
      this.$store.dispatch('reciters/fetchPopularReciters');
    },
    components: {
      ReciterCard,
    },
    computed: {
      reciters() {
        return this.$store.getters['reciters/reciters'];
      },
      popularReciters() {
        return this.$store.getters['reciters/popularReciters'];
      }
    }
  }
</script>