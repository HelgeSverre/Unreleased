<template>
    <div class="genre-selector">

        <input type="hidden" name="genre_id" :value="selectedGenre.id" v-if="selectedGenre">

        <button type="button" ref="input" class="btn btn-block text-left" @click="toggleSearch">
            {{ buttonText }}
        </button>

        <div class="w-100 list-group-dropdown shadow-sm" ref="dropdown" v-show="isOpen">
            <ul class="list-group">
                <li class="list-group-item">
                    <input type="text" class="form-control" placeholder="Search for genre..." v-model="search">
                </li>
                <li class="list-group-item text-center" v-show="loading">
                    <i class="fas fa-fw fa-cog fa-spin"></i> Searching
                </li>

                <li class="list-group-item d-flex align-items-center justify-content-between pointer"
                    @click="selectGenre(genre)" v-for="genre in genres" v-if="genres.length">
                    <strong>{{ genre.name }}</strong>
                </li>
                <li class="list-group-item d-flex align-items-center justify-content-between pointer"
                    @click="createNewGenre" v-if="search.length > minLength">
                    <span>Create new genre "<strong>{{ search }}</strong>"..</span>
                    <i class="fas fa-fw fa-plus-circle"></i>
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
                selectedGenre: null,
                genres: [],
            }
        },
        props: ['preselected_genre'],
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
            if(!(this.preselected_genre === undefined)) {
              this.selectedGenre = JSON.parse(this.preselected_genre)
            }
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
                this.selectedGenre = genre;
                this.search = "";
                this.closeSearch();
            },
            createNewGenre() {
                this.loading = true;
                axios
                    .post("/api/genres", {
                        name: this.search
                    })
                    .then(response => {
                        this.selectGenre(response.data);
                        this.loading = false;
                    });
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
                    });
            }, 250)
        },
        watch: {
            search(newValue, oldValue) {
                this.searchForGenres();
            }
        },
        computed: {
            buttonText() {
                if (this.selectedGenre) {
                    return this.selectedGenre.name;
                }

                return "Select genre";
            }
        }
    }
</script>
