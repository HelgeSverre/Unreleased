<template lang="html">
  <div class="card">
    <div class="card-header bg-dark text-white">
      <div class="row">
        <div class="col-md-4">
          <h1>Artists</h1>
        </div>
        <div class="col-md-6">
          <input type="text"  class="form-control"  v-model="search" placeholder="Filter artists on stage name"/>

        </div>
        <div class="col-md-2">
          <a class="btn btn-info"@click="createArtist">Create artist</a>
        </div>
      </div>
    </div>
    <div class="card-body" v-for="artist in filteredArtists" >

      <div class="media pointer" @click="clickedArtist(artist)">
        <img src="http://via.placeholder.com/80x80" alt="Generic placeholder image" class="mr-3">
        <div class="media-body">

          <h5 class="mt-0">{{ artist.stage_name}} - <small>{{artist.real_name}}</small> </h5>
          <strong>Bio:</strong> {{ getBio(artist) }}
        </div>
      </div>
    </div>

  </div>
</template>

<script>

export default {
  data() {
    return {
      artists: [],
      search: "",
    }
  },
  mounted() {
    axios.get("/api/artists")
        .then(response => (this.artists = response.data))
  },
  methods: {
    clickedArtist(artist) {
      window.location.href = '/artists/' + artist.id;
    },
    createArtist() {
      window.location.href = '/artists/create';
    },
    getBio (artist) {
        if(artist.bio){
            let bio = artist.bio;
            return bio.length > 200 ? bio.substring(0, 200) + '...' : bio;
          } else {
            return 'No bio'
          }
        },

  },
  computed: {
    filteredArtists: function() {
      return this.artists.filter((artist)=> {
        return (artist.stage_name.toLowerCase().match(this.search.toLowerCase()) || artist.real_name.toLowerCase().match(this.search.toLowerCase()));
      });
    }
  }
}
</script>

<style lang="css">
</style>
