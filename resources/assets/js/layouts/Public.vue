<template>
  <v-app>
    <nprogress-container></nprogress-container>
    <v-navigation-drawer v-model="drawer" app>
      <v-toolbar flat>
        <v-list>
          <v-list-tile>
            <img src="./../assets/nawhas-logo-wordmark-vector.svg" height="38"
                 onerror="this.src='./../assets/nawhas-logo-wordmark-48.png'" alt="Nawhas.com">
          </v-list-tile>
        </v-list>
      </v-toolbar>
      <v-divider></v-divider>
      <div v-for="(item, index) in navigation" :key="item.group">
        <v-list>
          <v-list-tile v-for="link in item.children" :key="link.to" :to="link.to" :exact="link.exact">
            <v-list-tile-action>
              <v-icon>{{ link.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>{{ link.title }}</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
        <v-divider v-if="index < navigation.length - 1"></v-divider>
      </div>
      <v-divider v-if="index < navigation.length - 1"></v-divider>
    </v-navigation-drawer>
    <v-toolbar app>
      <v-toolbar-side-icon
        class="hidden-md-and-up"
        @click="drawer = !drawer"></v-toolbar-side-icon>
      <v-spacer></v-spacer>
      <v-toolbar-items>
        <template v-if="currentUser">
          <v-btn flat @click="logout()">Logout</v-btn>
        </template>
        <template v-else>
          <v-btn flat @click="$router.push({ name: 'login'})">Login</v-btn>
          <v-btn flat>Sign Up</v-btn>
        </template>
      </v-toolbar-items>
    </v-toolbar>
    <v-content>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-content>
    <v-footer app></v-footer>
  </v-app>
</template>

<script>
  import NprogressContainer from 'vue-nprogress/src/NprogressContainer';

  export default {
    components: {
      NprogressContainer
    },
    computed: {
      currentUser() {
        return this.$store.getters['auth/currentUser'];
      },
      navigation() {
        // return filtered nav list based on role
        const items = [];
        const role = this.$store.getters['auth/userRole'];

        this.items.forEach((group) => {
          if (role) {
            if (group.role && group.role !== role.role) {
              return;
            }
          }

          const children = [];
          group.children.forEach((child) => {
            if (child.role && child.role !== role) {
              return;
            }
            children.push(child);
          });
          group.children = children;

          if (group.children.length > 0) {
            items.push(group);
          }
        });

        return items;
      }
    },
    methods: {
      logout() {
        this.$store.commit('auth/logout');
        this.$router.push('/login');
      }
    },
    data() {
      return {
        drawer: true,
        right: null,
        items: [
          {
            group: 'main',
            children: [
              {
                icon: 'home',
                title: 'Home',
                exact: true,
                to: '/',
              },
              {
                icon: 'people',
                title: 'Reciters',
                exact: false,
                to: '/reciters',
              },
              {
                icon: 'label',
                title: 'Topics',
                exact: false,
                to: '/topics',
                role: 'admin'
              },
              {
                icon: 'library_books',
                title: 'My Library',
                exact: false,
                to: '/library',
                role: 'admin'
              }
            ]
          },
          {
            group: 'trending',
            children: [
              {
                icon: 'trending_up',
                title: 'Top Charts',
                exact: true,
                to: '/charts',
                role: 'admin'
              },
              {
                icon: 'whatshot',
                title: 'Trending',
                exact: false,
                to: '/trending',
                role: 'admin'
              },
              {
                icon: 'date_range',
                title: 'New Releases',
                exact: false,
                to: '/new-releases',
                role: 'admin'
              }
            ]
          },
          {
            group: 'manage',
            children: [
              {
                icon: null,
                title: 'Users',
                exact: true,
                to: '/users',
                role: 'admin',
              },
              {
                icon: 'file_upload',
                title: 'Upload',
                exact: true,
                to: '/upload',
                role: 'admin',
              },
              {
                icon: 'settings',
                title: 'Settings',
                exact: false,
                to: '/settings',
                role: 'admin',
              }
            ]
          }
        ]
      };
    },
  }
</script>

<style lang="stylus" scoped>
  @import '../styles/theme';
</style>