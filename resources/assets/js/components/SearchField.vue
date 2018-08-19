<template>
    <div class="search-field">

        <button type="button" ref="input" class="btn btn-block text-left" @click="toggleSearch">
            Search
        </button>

        <div class=" list-group-dropdown shadow-sm" ref="dropdown" v-show="isOpen">
            <ul class="list-group">
                <li class="list-group-item">
                    <input type="text" class="form-control" placeholder="Search for genres or artists" v-model="search">
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
                    <strong>{{ artist.real_name }}</strong>
                </li>
            </ul>
        </div>
    </div>
</template>
<style>
    .genre-selector {
        position: relative;
    }

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
                genres: [],
                artists: [],
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
            },
            openSearch() {
                this.isOpen = true;
            },
            closeSearch() {
                this.isOpen = false;
            },
            selectGenre(genre) {
                window.location.href = '/genres/' + genre.id;

            },
            selectArtist(artist) {
              window.location.href = '/artists/' + artist.id;

            },
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
            }, 250)
        },
        watch: {
            search(newValue, oldValue) {
              this.searchForArtists();
              this.searchForGenres();
            }
        },
    }
</script>