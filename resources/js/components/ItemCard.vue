<template>
    <div class="col-xs-6 col-sm-3 col-md-2" @click="checkContents">
        <div class="card">
            <div class="card-body text-center">
                <svg class="c-icon c-icon-4xl" v-if="kind === 'folder'">
                    <use xlink:href="../../../node_modules/@coreui/icons/sprites/free.svg#cil-folder"></use>
                </svg>
                <svg class="c-icon c-icon-4xl" v-if="kind === 'audio'">
                    <use xlink:href="../../../node_modules/@coreui/icons/sprites/free.svg#cil-volume-high"></use>
                </svg>
                <svg class="c-icon c-icon-4xl" v-if="kind === 'video'">
                    <use xlink:href="../../../node_modules/@coreui/icons/sprites/free.svg#cil-video"></use>
                </svg>
                <svg class="c-icon c-icon-4xl" v-if="kind === null">
                    <use xlink:href="../../../node_modules/@coreui/icons/sprites/free.svg#cil-file"></use>
                </svg>
                <img :src="imgUri" :alt="itemName" v-if="kind === 'image'" class="image-thumbnail">
                <p class="item-name-label">{{itemName}}</p>
            </div>
        </div>
    </div>
</template>
<script>
import store from "../store";
import axios from 'axios';

export default {
    props: ['itemName'],
    data() {
        return {
            extensionsDictionary: {
                audio : ["mp3", "ogg"],
                video : ["mp4", "mkv"],
                image : ["JPG", "png"]
            },
            kind: null,
            imgUri: null
        }
    },
    mounted() {
        if(this.itemName.search("/") === -1){
            this.lookForExtensions(this.itemName);
        } else {
            this.kind = "folder"
        }
    },
    methods: {
        lookForExtensions(itemName) {
            this.extensionsDictionary.audio.forEach(element => {
                if(this.itemName.search(element) !== -1) {
                    this.kind = "audio"
                    return
                }
            });

            this.extensionsDictionary.video.forEach(element => {
                if(this.itemName.search(element) !== -1) {
                    this.kind = "video"
                    return
                }
            });

            this.extensionsDictionary.image.forEach(element => {
                if(this.itemName.search(element) !== -1) {
                    this.kind = "image"
                    this.getContentUri();
                    return
                }
            });
        },
        checkContents() {
            if(this.kind === "folder") {
                store.dispatch("changePrefix", this.itemName);
            } else {
                this.getContentUri()
            }
        },
        getContentUri() {
            let uriStr = ""
                
            if(this.$store.state.prefix !== null){
                uriStr = `${this.$store.state.prefix}${this.itemName}`
            } else {
                uriStr = `${this.itemName}`
            }

            const config = { uri: uriStr, bucket: this.$store.state.bucket }

            axios.post(process.env.MIX_API_URL + "s3/item",config).then((response) => {
                if(this.kind === 'image') {
                    this.imgUri = response.data.path
                }
            }).catch((error) => {
                console.log(error)
            })
        }
    }
}
</script>