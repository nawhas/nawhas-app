<template>
  <div>
    <div class="track-hero" :style="{'background-color': background, color: textColor}">
      <div class="track-hero__content">
        <div class="track-hero__left">
          <div class="track-hero__avatar">
            <v-avatar size="120px" class="white" tile>
              <img :src="track.album.artwork" :alt="track.album.name" />
            </v-avatar>
          </div>
          <div class="track-hero__text">
            <h4 class="track-hero__title">{{ track.name }}</h4>
            <div class="track-hero__meta">
              <p>{{ track.album.reciter.name }}</p>
              <p>{{ track.album.year }} &bull; {{ track.album.name }}</p>
            </div>
          </div>
        </div>
        <div class="track-hero__actions">
          <ul>
            <li><v-btn icon class="white--text"><v-icon>add_to_photos</v-icon></v-btn></li>
            <li><v-btn icon class="white--text"><v-icon>share</v-icon></v-btn></li>
            <li><v-btn icon class="white--text"><v-icon>print</v-icon></v-btn></li>
            <li><v-btn icon class="white--text"><v-icon>more_horiz</v-icon></v-btn></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="track-page-content">
      <v-container grid-list-xl>
        <v-layout row>
          <v-flex md7>
            <v-card class="track-page-content__card track-page-content__card--lyrics lyrics">
              <div class="lyrics__content" v-if="track.lyric">
                <v-tabs
                  v-model="active"
                  class="white" dark>
                  <v-tab
                    v-for="n in track.lyric"
                    :key="n.id"
                    ripple
                  >
                    {{ n.title }}

                  </v-tab>
                  <v-tab-item
                    v-for="n in track.lyric"
                    :key="n.id"
                  >
                    <v-card flat>
                      <v-card-text>
                        <p v-html="n.text"></p>
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                </v-tabs>
              </div>
              <div class="lyrics__empty" v-else>
                <div class="lyrics__empty-message">We don't have a write-up for this nawha yet.</div>
              </div>
            </v-card>
          </v-flex>
          <v-flex md5>
            <v-card class="track-page-content__card track-page-content__card--audio">
              Audio
              <section v-if="track.audio">
                <aplayer
                  :music="{
                         title: track.name,
                         artist: track.reciter.name,
                         src: track.audio,
                         pic: track.album.artwork
                         }"
                ></aplayer>
              </section>
              <section v-else>
                <p>There is no track available yet</p>
              </section>
            </v-card>
            <v-card class="track-page-content__card track-page-content__card--audio">
              Video
              <section v-if="track.video">
                <youtube player-width="100%" player-height="100%" :video-id="videoId"></youtube>
              </section>
              <section v-else>
                <p>There is no video available</p>
              </section>
            </v-card>
            <v-card class="track-page-content__card track-page-content__card--album">
              More
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </div>
  </div>
</template>

<script>
  import Aplayer from 'vue-aplayer';
  import Vibrant from 'node-vibrant';
  import HeroBanner from '../../components/HeroBanner.vue';
  import ReciterCard from '../../components/reciters/ReciterCard.vue';
  import TrackCard from '../../components/reciters/TrackCard.vue';
  import Album from '../../components/reciters/Album.vue';

  export default {
    name: 'track-show',
    components: { HeroBanner, TrackCard, ReciterCard, Album, Aplayer },
    data() {
      return {
//        track: { album: null, audio: null, created_at: null, id: null, language: null, links: null, lyric: null, name: null, number: null, reciter: null, slug: null, updated_at: null, video: null },
        background: '#222',
        textColor: '#fff',
        active: null,
        text: null,
        videoId: null,
        startTime: null
      };
    },
    created() {
      this.$store.dispatch('tracks/fetchTrack', { reciter: this.$route.params.reciter, album: this.$route.params.album, track: this.$route.params.track })
        .then(() => {
          if (this.track.video) {
            this.videoId = this.$youtube.getIdFromURL(this.track.video);
            this.startTime = this.$youtube.getTimeFromURL(this.track.video);
          } else {
            this.videoId = null;
            this.startTime = null;
          }
        });
    },
    computed: {
      track() {
        return this.$store.getters['tracks/track'];
      }
    },
  }
</script>

<style lang="stylus" scoped>
  @import '../../styles/theme.styl';
  @import '../../styles/_variables.styl';
  @import '../../../../../node_modules/vuetify/src/stylus/settings/_elevations.styl';

  .track-hero {
    width: 100%;
    padding-bottom: 80px;

    .track-hero__content {
      max-width: 1000px;
      padding: 24px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;

      .track-hero__left {
        display: flex;
        align-items: center;
      }
      .track-hero__avatar {
        border: 2px solid white;
        border-radius: 4px;
        overflow: hidden;
        elevation(2);
        margin-right: 24px;
      }
      .track-hero__title {
        font-family: 'Roboto Slab', sans-serif;
        font-weight: bold;
        font-size: 38px;
      }
      .track-hero__meta {
        p {
          font-size: 15px;
          margin: 0 0 6px 0;
          padding: 0;
        }
      }
      .track-hero__actions {
        ul {
          list-style: none;
          margin: 0;
          padding: 0;
          display: flex;
          flex-direction: column;

          li {
            margin: -2px 0 -2px 0;
            padding: 0;
          }
        }
      }
    }
  }
  .track-page-content {
    margin-top: -104px;
    padding: 0 8px;
    max-width: 1024px;
    margin-left: auto;
    margin-right: auto;

    .track-page-content__card {
      padding: 24px;
      margin-bottom: 24px;
      height: 200px;

      &--lyrics {

        .lyrics__empty {
          display: flex;
          justify-content: center;
          color: rgba(0,0,0,0.3);
          font-size: 20px;
          height: 400px;
          font-weight: 300;

          .lyrics__empty-message {
            display: flex;
            margin: auto;
            align-self: center;
          }
        }
      }
    }
  }

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