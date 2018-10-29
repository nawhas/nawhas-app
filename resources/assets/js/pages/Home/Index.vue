<template>
  <div>
    <hero-banner :background="require('../../assets/imam-hussain-header.jpg')" class="mb-4">
      <hero-quote author="Imam Jafar Sadiq (a.s.)">
        The murder of Hussain has lit a fire in the hearts of the believers which will never extinguish.
      </hero-quote>
    </hero-banner>
  </div>
</template>

<script>
  import HeroBanner from '../../components/HeroBanner.vue';
  import HeroQuote from '../../components/HeroQuote.vue';

  export default {
    name: 'home-index',
    components: {
      HeroBanner,
      HeroQuote,
    },
  }
</script>

<style>

</style>