<template>
  <div>
    <hero-banner :background="require('../../assets/imam-hussain-header.jpg')" class="mb-4">
      <hero-quote author="Imam Jafar Sadiq (a.s.)">
        The murder of Hussain has lit a fire in the hearts of the believers which will never extinguish.
      </hero-quote>
    </hero-banner>
    <section class="page-section" id="top-reciters-section">
      <h2>Top Reciters</h2>
      <v-container grid-list-lg class="pa-0" fluid>
        <v-layout row wrap>
          <v-flex xs12 sm6 md4 v-for="reciter in popularReciters" :key="reciter.id">
            <reciter-card featured v-bind="reciter" />
          </v-flex>
        </v-layout>
      </v-container>
    </section>
  </div>
</template>

<script>
  import HeroBanner from '../../components/HeroBanner.vue';
  import HeroQuote from '../../components/HeroQuote.vue';
  import ReciterCard from '../../components/reciters/ReciterCard.vue';

  export default {
    name: 'home-index',
    components: {
      HeroBanner,
      HeroQuote,
      ReciterCard
    },
    created() {
      this.$store.dispatch('reciters/fetchPopularReciters');
    },
    computed: {
      popularReciters() {
        return this.$store.getters['reciters/popularReciters'];
      }
    }
  }
</script>

<style>

</style>