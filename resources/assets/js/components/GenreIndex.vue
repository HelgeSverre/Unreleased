<template>
  <div class="genre-index">

    <a class="nav-link pointer"  ref="input" v-on:click.prevent @click="toggleView">
      <i class="fas fa-fw fa-music"></i> Genres
    </a>

    <div class=" list-group-dropdown shadow-sm" ref="dropdown" v-show="isOpen">
      <ul class="list-group">
        <li class="list-group-item">
          <input type="text"  class="form-control"  v-model="search" placeholder="Filter genres on name"/>
        </li>
        <li class="list-group-item text-center active" v-show="hiding_some">
            <i class="fas fa-book"></i> {{hidden}} genres are hidden. Filter names to find
        </li>

        <li class="list-group-item d-flex align-items-center justify-content-between pointer"
        @click="selectGenre(genre)" v-for="genre in filteredGenres.slice(0, maxShow)">
        <strong>{{ genre.name }}</strong>
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
      loading: false,
      search: "",
      resultGenre: null,
      genres: [],
      hidden: 0,
      hiding_some: false,
      maxShow: 15

    }
  },
  mounted() {
    axios.get("/api/genres")
    .then(response => (this.genres = response.data));

    new Popper(this.$refs.input, this.$refs.dropdown, {
      placement: 'bottom',
      modifiers: {
        offset: {
          enabled: true,
          offset: '-200,8'
        }
      }
    });

  },
  methods: {
    toggleView() {
      this.isOpen = !this.isOpen;
      this.search = "";
    },
    selectGenre(genre) {
      window.location.href = '/genres/' + genre.id;
    },
    checkHidden(){
      if(this.filteredGenres.length > this.maxShow) {
        this.hiding_some = true;
        this.hidden = this.filteredGenres.length - this.maxShow;
      } else {
        this.hiding_some = false;
      };
    }
  },
  watch: {
      search(newValue, oldValue) {
          this.checkHidden();
      }
  },
  computed: {
    filteredGenres: function() {
      return this.genres.filter((genre)=> {
        return genre.name.toLowerCase().match(this.search.toLowerCase());
      });

    },

  },
  updated: function() {
    this.checkHidden();
  }
}
</script>
