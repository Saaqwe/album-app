<template>
    <div>
        <div class="d-flex">
            <a v-on:click="openModal" href="#" class="btn btn-primary">Eddit album</a>
        </div>
        <div ref="album-modal" class="modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-container container-lg">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
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
                                    <button v-on:click="editModal" type="submit" class="btn btn-primary m-auto">
                                        Update album data
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AlbumEditModal",
    props: ['oldTitle', 'oldImageSrc', 'oldAuthor', 'oldDescription', 'id'],
    data() {
        return {
            title: "",
            imageSrc: "",
            author: "",
            description: "",
            isAlbumFounded: false
        }
    },
    methods: {
        openModal() {
            const options = {};
            this.articleModal = new bootstrap.Modal(this.$refs["album-modal"], options);
            this.articleModal.show();
        },
        getDataFromLastFM() {
            this.albumCreated = true;
            this.showCreatedMessgae = false;
            axios.post('/api/album_info', {
                'album_name': this.title
            })
                .then(res => {
                    let albumData = res['data']['results']['albummatches']['album'][0];
                    if(albumData !== undefined) {
                        this.author = albumData['artist'];
                        this.imageSrc = albumData['image'][3]['#text'];
                        this.isAlbumFounded = true;
                        // console.log(albumData);
                    } else {
                        this.resetData();
                        this.isAlbumFounded = false;
                    }

                })
                .catch(error => {
                    this.isAlbumFounded = false;
                })
        },
        editModal() {
            axios.put(`/api/albums/${this.id}`, {
                'title' : this.title,
                'artist' : this.author,
                'image_src' : this.imageSrc,
                'description' : this.description,
            })
            .then(response => {
                alert("Album uodated");
                this.$emit("album-update", {
                    'title' : this.title,
                    'author' : this.author,
                    'imageSrc' : this.imageSrc,
                    'description' : this.description,
                    'id' : this.id
                });
            })
            .catch(error => {
                alert("Update error");
                console.log(error);
            })
        }

    },
    mounted() {
        this.title = this.oldTitle;
        this.imageSrc = this.oldImageSrc;
        this.author = this.oldAuthor;
        this.description = this.oldDescription;
    }
}
</script>

<style scoped>
.image-wrapper{
    width: 300px;
    height: 300px;
    background-color: #d0d0d0;
    margin: auto;
}

</style>
