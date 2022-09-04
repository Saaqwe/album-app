<template>
    <div>
        <div class="d-flex">
            <button v-on:click="openModal" class="btn btn-light" type="button">
                <i class="bi bi-plus-lg"></i>
                Create
            </button>
        </div>
        <div ref="article-modal" class="modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-container container-lg">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div ref="article-body" class="modal-body article-body">
                            <div class="label-in-textarea article-title" >
                                <textarea
                                    v-on:keydown="disableTextAreaNewLines($event)"
                                    rows="1"
                                    class="article-area"
                                    required
                                    v-model="formData.title"
                                ></textarea>
                                <label>Article title</label>
                            </div>
                            <div class="position-relative mt-3 mb-3">
                                <img id="image-preview"
                                     src="https://via.placeholder.com/400"
                                     style="width:calc(100% - 18px); display: none; margin-left: 18px"
                                     class="position-relative" alt="placeholder"
                                     ref="img-ref"
                                >
                                <input
                                    class="form-control form-control-sm custom-file-input"
                                    ref="file-input"
                                    type="file"
                                    id="formFileLg"
                                    @input="selectImgFile($event)">
                            </div>
                            <div class="label-in-textarea" >
                                <textarea
                                    v-on:keyup="textAreaHeightAdjust($event.target)"
                                    contenteditable class="article-area"
                                    required
                                    v-model="formData.text"
                                ></textarea>
                                <label>Text...</label>
                            </div>
                            <button v-on:click="publishArticle" ref="publish-btn" class="article-btn">
                                Publish
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ArticleAddModal",
    data() {
        return {
            articleModal: {},
            blockTest: [],
            counter: 0,
            image: null,
            formData: {
                image: null,
                title: "",
                text: "",
            }
        }
    },
    methods: {
        openModal() {
            const options = {};
            this.articleModal = new bootstrap.Modal(this.$refs["article-modal"], options);
            this.articleModal.show();
        },
        disableTextAreaNewLines(event) {
            if(event.keyCode === 13 && ! event.shiftKey) {
                event.preventDefault();
            }
        },
        textAreaHeightAdjust(element) {
            element.style.height = "1px";
            element.style.height = (25+element.scrollHeight)+"px";
            this.$refs["article-body"].scrollTop = 25+element.scrollHeight;
        },
        selectImgFile(event) {
            let file = event.target.files[0];
            this.formData.image = file;
            let reader = new FileReader();
            let img = this.$refs["img-ref"];
            img.style.display = 'block';
            reader.readAsDataURL(file);
            reader.onload = function () {
                img.src = reader.result;
            }
        },

        publishArticle() {
            let formData = new FormData;
            // let reader = new FileReader();
            // formData.append('image', reader.readAsDataURL(img))
            formData.append('image', this.formData.image);
            formData.append('title', this.formData.title);
            formData.append('main_text', this.formData.text);
            axios.post('/api/articles', formData
                // {
                // title : this.formData.title,
                // image : ,
                // main_text : this.formData.text,
            // }
            ).then(res => {
                console.log("success");
                console.log(res);
                console.log(res['data']);

            })
            .catch((error) => {
                console.log("Error");
                console.log(error)
            })


        },
    }
}
</script>

<style scoped lang="scss">
    $text-area-title-size: 26px;
    $text-area-primary-size: 18px;
    //$text-area-
    .modal-container{
        //width: 1000px;
    }

    .article-body{
        display: flex;
        flex-direction: column;
        min-height: 80vh;

        .article-title{
            .article-area{
                white-space: nowrap;
                overflow: hidden;
                padding: $text-area-title-size;
                padding-left: $text-area-primary-size;
                font-size: $text-area-title-size;
                & + label{
                    font-size: $text-area-title-size;
                    top: $text-area-title-size;
                    left: $text-area-primary-size;
                }
            }
        }
        .article-area{
            padding: $text-area-primary-size $text-area-primary-size 56px;
            width: 100%;
            text-align: left;
            outline: none;
            border: none Transparent;
            font-size: $text-area-primary-size;
            overflow: hidden;
            min-height: 5em;
            resize:none;
            & + label{
                font-size: $text-area-primary-size;
                top: $text-area-primary-size;
                left: $text-area-primary-size;
            }

            &:valid + label{
                display: none;
            }
            &:focus + label{
                display: none;
            }
        }
        .label-in-textarea {
            position: relative;
            height: 80px;

            & > label{
                position: absolute;
                color: #868686;
                pointer-events: none;
            }
        }
        .article-btn{
            position: fixed;
            bottom: 9vh;
            width: fit-content;
            margin-left: $text-area-primary-size;
            padding: 6px 16px;
            outline: none;
            border: none;
            border-radius: 5px;
            color: #3e3e3e;
            transition: background-color 0.5s ease-out;
            &:hover{
                background: #afafaf;
                transition: background-color 0.5s ease-in-out;
            }
        }
        .custom-file-input{
            position: relative;
            width: fit-content !important;
            margin-left: $text-area-primary-size;
        }

    }
</style>
