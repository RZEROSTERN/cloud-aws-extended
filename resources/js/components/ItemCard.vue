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
                <p class="item-name-label">{{itemName}}</p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['itemName'],
    data() {
        return {
            extensionsDictionary: {
                audio : ["mp3", "ogg"],
                video : ["mp4", "mkv"]
            },
            kind: null
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
        },
        checkContents() {
            if(this.kind === "folder") {
                alert("I should get new items from this folder");
            } else {
                alert("I should open or download the content");
            }
        }
    }
}
</script>