<template>
    <div>
        <div class="image-wrapper">
            <img :src="imageSrc">
        </div>
        <div class="mb-3">
            <label for="albumTitle" class="form-label">Album title</label>
            <input v-on:change="getDataFromLastFM" v-model="title" class="form-control" id="albumTitle">
        </div>
        <div class="mb-3">
            <label for="albumAuthor" class="form-label">Artist</label>
            <input v-model="author" class="form-control" id="albumAuthor">
        </div>
        <div class="mb-3">
            <label for="albumDescription" class="form-label">Description</label>
            <input v-model="description" class="form-control" id="albumDescription">
        </div>
        <div class="mb-3 m-auto">
            <button v-on:click="addAlbum" type="submit" class="btn btn-primary m-auto">Add album</button>
        </div>
        <div v-if="! isAlbumFounded" class="alert alert-danger" role="alert">
            Album not found in last.fm api.
        </div>
        <div v-if="! albumCreated" class="alert alert-danger" role="alert">
            Album creating error
        </div>
        <div v-if="showCreatedMessgae" class="alert alert-success" role="alert">
            Album created
        </div>
    </div>
</template>

<script>
export default {
    name: "AlbumCreateForm",
    props: ['userAuthenticated'],
    data() {
        return {
            title: "",
            imageSrc: "",
            author: "",
            description: "",
            isAlbumFounded: true,
            albumCreated: true,
            showCreatedMessgae: false,
        }
    },
    mounted() {
    },
    methods: {
        getDataFromLastFM() {
            this.albumCreated = true;
            this.showCreatedMessgae = false;
            axios.post('api/album_info', {
                'album_name': this.title
            })
            .then(res => {
                let albumData = res['data']['results']['albummatches']['album'][0];
                if(albumData !== undefined) {
                    this.author = albumData['artist'];
                    this.imageSrc = albumData['image'][3]['#text'];
                    this.isAlbumFounded = true;
                } else {
                    this.resetData();
                    this.isAlbumFounded = false;
                }

            })
            .catch(error => {
                this.resetData();
                this.isAlbumFounded = false;
            })
        },
        resetData() {
            this.imageSrc = "";
            this.author = "";
        },
        addAlbum() {
            let formData = new FormData;
            formData.append('title', this.title);
            formData.append('artist', this.author);
            formData.append('image_src', this.imageSrc);
            formData.append('description', this.description);
            axios.post("api/albums", formData)
            .then(res => {
                this.title = "";
                this.imageSrc = "";
                this.author = "";
                this.description = "";
                this.showCreatedMessgae = true;
                this.albumCreated = true;
                console.log(res);
            })
            .catch(error => {
                this.albumCreated = false;
            })
        }
    },
    watch: {

    }
}
</script>

<style scoped lang="scss">

.image-wrapper{
    width: 300px;
    height: 300px;
    background-color: #d0d0d0;
    margin: auto;
}

</style>
