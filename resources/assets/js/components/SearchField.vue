<template>
    <div class="search-field">

        <a class="nav-link pointer"  ref="input" v-on:click.prevent @click="toggleSearch">
          <i class="fas fa-fw fa-search"></i> Search
        </a>

        <div class=" list-group-dropdown shadow-sm" ref="dropdown" v-show="isOpen" @mouseleave="closeSearchIfEmpty">
            <ul class="list-group">
                <li class="list-group-item">
                    <input type="text" class="form-control" placeholder="Search for tracks, genres or artists" autofocus="autofocus" v-model="search">
                </li>
                <li class="list-group-item text-center" v-show="loading">
                    <i class="fas fa-fw fa-cog fa-spin"></i> Searching
                </li>
                <li class="list-group-item" v-if="genres.length">
                  <small>Genres</small>
                </li>
                <li class="list-group-item d-flex align-items-center justify-content-between pointer"
                    @click="selectGenre(genre)" v-for="genre in genres" v-if="genres.length">
                    <strong>{{ genre.name }}</strong>
                </li>
                <li class="list-group-item" v-if="artists.length">
                  <small>Artists</small>
                </li>
                <li class="list-group-item d-flex align-items-center justify-content-between pointer"
                    @click="selectArtist(artist)" v-for="artist in artists" v-if="artists.length">
                    <strong>{{ artist.stage_name }}</strong>
                    <small>{{ artist.real_name }}</small>
                </li>
                <li class="list-group-item" v-if="tracks.length">
                  <small>Tracks</small>
                </li>
                <li class="list-group-item d-flex align-items-center justify-content-between pointer"
                    @click="selectTrack(track)" v-for="track in tracks" v-if="tracks.length">
                    <strong>{{ track.title }}</strong>
                </li>
            </ul>
        </div>
    </div>
</template>
<style>
    .list-group-dropdown {
        z-index: 100;
    }
</style>
<script>
    export default {
        data() {
            return {
                isOpen: false,
                minLength: 3,
                loading: false,
                search: "",
                resultGenre: null,
                resultArtist: null,
                resultTrack: null,
                genres: [],
                artists: [],
                tracks: [],
            }
        },
        mounted() {
            new Popper(this.$refs.input, this.$refs.dropdown, {
                placement: 'bottom',
                modifiers: {
                    offset: {
                        enabled: true,
                        offset: '-200,10'
                    }
                }
            });
        },

        methods: {
            toggleSearch() {
                this.isOpen = !this.isOpen;
                this.search = "";
            },
            closeSearchIfEmpty() {
                if(this.search === ""){
                  this.isOpen = false;
                }
            },
            selectGenre(genre) {
                window.location.href = '/genres/' + genre.id;
            },
            selectArtist(artist) {
              window.location.href = '/artists/' + artist.id;
            },
            selectTrack(track) {
              window.location.href = '/artists/' + track.artist_id;
            },
            searchForGenres: _.debounce(function () {
                this.loading = true;
                axios
                    .get("/api/genres", {
                        params: {
                            q: this.search
                        }
                    })
                    .then(response => {
                        this.genres = response.data;
                        this.loading = false;
                        if(this.search === ""){
                          this.genres= []
                        }
                    });
            }, 250),
            searchForArtists: _.debounce(function () {
                this.loading = true;
                axios
                    .get("/api/artists", {
                        params: {
                            q: this.search
                        }
                    })
                    .then(response => {
                        this.artists = response.data;
                        this.loading = false;
                        if(this.search === ""){
                          this.artists = []
                        }
                    });
            }, 250),
            searchForTracks: _.debounce(function () {
                this.loading = true;
                axios
                    .get("/api/tracks", {
                        params: {
                            q: this.search
                        }
                    })
                    .then(response => {
                        this.tracks = response.data;
                        this.loading = false;
                        if(this.search === ""){
                          this.tracks = []
                        }
                    });
            }, 250),
        },
        watch: {
            search(newValue, oldValue) {
              this.searchForGenres();
              this.searchForArtists();
              this.searchForTracks();
            }
        },
    }
</script>
