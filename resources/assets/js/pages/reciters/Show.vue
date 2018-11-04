<template>
  <div>
    <div class="reciter-hero">
      <div class="reciter-hero__ribbon"></div>
      <div class="reciter-hero__content">
        <v-card class="reciter-hero__card">
          <div class="reciter-hero__avatar">
            <v-avatar size="152px" class="white">
              <img :src="reciter.avatar" :alt="reciter.name" />
            </v-avatar>
          </div>
          <h4 class="reciter-hero__title">
            {{ reciter.name }}
          </h4>
          <p class="reciter-hero__bio">{{ reciter.description }}</p>
        </v-card>
      </div>
    </div>
    <section class="page-section" id="all-reciters-section">
      <h3>Albums</h3>
      <template v-for="album in albums">
        <album v-bind="album" :reciterSlug="reciter.slug" v-bind:key="album.id"></album>
      </template>
    </section>
  </div>
</template>

<script>
  import ReciterCard from '../../components/reciters/ReciterCard.vue';
  import Album from '../../components/reciters/Album.vue';

  export default {
    name: 'reciters-show',
    components: {
      ReciterCard,
      Album
    },
    created() {
      this.$store.dispatch('reciters/fetchReciter', { reciter: this.$route.params.reciter });
      this.$store.dispatch('albums/fetchAlbums', { reciter: this.$route.params.reciter });
    },
    computed: {
      reciter() {
        return this.$store.getters['reciters/reciter'];
      },
      albums() {
        return this.$store.getters['albums/albums'];
      }
    }
  }
</script>

<style lang="stylus" scoped>
  @import '../../styles/theme.styl'
  @import '../../styles/_variables.styl'

  .reciter-hero {
    .reciter-hero__ribbon {
      width: 100%;
      height: 220px;
      margin-bottom: -220px;
      background: linear-gradient(to bottom right, #E90500, #FA6000);
    }
    .reciter-hero__content {
      padding: 80px 120px 24px 120px;
    }
    .reciter-hero__avatar {
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      top: -80px;
      margin-bottom: -56px;

      .avatar {
        box-sizing: content-box;
        border: 5px solid white;
      }
    }
    .reciter-hero__card {
      margin-top: 36px;
      width: 100%;
      min-height: 20px;
      position: relative;
      padding: 0 36px 24px 36px;
    }
    .reciter-hero__title {
      font-family: 'Roboto Slab', sans-serif;
      font-weight: 600;
      color: #2e2e2e;
      text-align: center;
      margin: 0;
      padding: 0;
    }
    .reciter-hero__social {
      font-size: 140%;
      list-style: none;
      margin: 16px 0;
      padding: 0;
      text-align: center;

      li {
        display: inline;

        a {
          color: inherit;
          padding: 8px;
          will-change: color;
          transition: color $transition;
          &:hover {
            color: $theme.accent;
          }
        }
      }
    }
    .reciter-hero__bio {
      margin: 16px 0 0 0;
      padding: 0;
      max-height: 108px;
      overflow: hidden;
      position: relative;
    }
  }
</style>