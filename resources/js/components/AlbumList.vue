<template>
    <div class="container-lg">
        <div class="container d-flex flex-column mt-5">
            <div class="mt-3">
                <h2 class="text-center">Albums list</h2>
            </div>
            <div class="row mt-4 row-cols-1 row-cols-md-4 g-4">
                <div  v-for="(album, index) in albumArray"  class="col">
                    <div class="card" style="width: 16rem;">
                        <img :src="album.imageSrc" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Album name: {{ album.title }}</h5>
                            <h6 class="card-title">Artist name: {{ album.author }}</h6>
                            <p class="card-text">{{ album.description }}</p>
                            <div class="d-flex">
                                <album-edit-modal
                                    :old-author="album.author"
                                    :old-title="album.title"
                                    :old-image-src="album.imageSrc"
                                    :old-description="album.description"
                                    :id="album.id"
                                    v-on:album-update="albumUpdate($event)"
                                    v-if="userAuthenticated"
                                ></album-edit-modal>
                                <div class="d-flex ms-1">
                                    <a v-if="userAuthenticated" v-on:click="deleteAlbum(album.id, index)" href="#" class="btn btn-primary">Delete</a>
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
import AlbumEditModal from "./AlbumEditModal";
export default {
    name: "AlbumList",
    props: ['userAuthenticated'],
    components: {AlbumEditModal},
    data() {
        return {
            albumArray: [
            ],
            currentOffset: 0,
        }
    },
    mounted() {

        axios.post('/api/albums/all').then(res => {
            res['data'].forEach((album) => {
                this.albumArray.push({
                    title: album.title,
                    author: album.artist,
                    description: album.description,
                    imageSrc: album.image_src,
                    id: album.id
                });
            })
        })
        .catch(error => {
        });
    },
    methods: {
        albumUpdate(data) {
            let chnagedAlbum = this.albumArray.find(album => album.id === data.id);
            chnagedAlbum.description = data.description;
            chnagedAlbum.title = data.title;
            chnagedAlbum.author = data.author;
            chnagedAlbum.imageSrc = data.imageSrc;
        },
        deleteAlbum(id, index) {
            axios.delete(`/api/albums/${id}`).then(res => {
                // let chnagedAlbum = this.albumArray.find(album => album.id === data.id);
                // let chnagedAlbum = myArray.filter(function( obj ) {
                //     return obj.id !== id;
                // });
                // this.albumArray = chnagedAlbum;
                this.albumArray.splice(index,1);


            })
            .catch(error => {
            });
        }
    },
    albumUpdate() {
        alert("HAAAAAAAAAy");
    }
}
</script>

<style scoped>

</style>
