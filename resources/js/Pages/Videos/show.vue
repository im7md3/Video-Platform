<template>
    <main-layout>
        <div class="container">
            <div class="row">
                <div class="mx-auto col-9">
                    <input id="videoId" type="hidden" value="{{ video.id }}">

                    <div class='vidcontainer'>

                        <video v-for="video_converted in video.convertedvideos" :key="video_converted.id"
                            id="videoPlayer" controls style="width: 100%; height: 90%;" @ended="onEnd">

                            <source v-if="video.quality==1080" id="webm_source"
                                :src="$page.props.asset+video_converted.webm_Format_1080" type="video/webm">
                            <source v-if="video.quality==1080" id="mp4_source"
                                :src="$page.props.asset+video_converted.mp4_Format_1080" type="video/mp4">

                            <source v-if="video.quality==720" id="webm_source"
                                :src="$page.props.asset+video_converted.webm_Format_720" type="video/webm">
                            <source v-if="video.quality==720" id="mp4_source"
                                :src="$page.props.asset+video_converted.mp4_Format_720" type="video/mp4">

                            <source v-if="video.quality==480" id="webm_source"
                                :src="$page.props.asset+video_converted.webm_Format_420" type="video/webm">
                            <source v-if="video.quality==480" id="mp4_source"
                                :src="$page.props.asset+video_converted.mp4_Format_480" type="video/mp4">

                            <source v-if="video.quality==360" id="webm_source"
                                :src="$page.props.asset+video_converted.webm_Format_360" type="video/webm">
                            <source v-if="video.quality==360" id="mp4_source"
                                :src="$page.props.asset+video_converted.mp4_Format_360" type="video/mp4">

                            <source v-if="video.quality==240" id="webm_source"
                                :src="$page.props.asset+video_converted.webm_Format_240" type="video/webm">
                            <source v-if="video.quality==240" id="mp4_source"
                                :src="$page.props.asset+video_converted.mp4_Format_240" type="video/mp4">

                        </video>

                    </div>
                    <select id='qualityPick' @change="changeQulity">
                        <option value="1080" :selected="video.quality==1080" :hidden="video.quality<1080">1080p</option>
                        <option value="720" :selected="video.quality==720" :hidden="video.quality<720">720p</option>
                        <option value="480" :selected="video.quality==480" :hidden="video.quality<480">480p</option>
                        <option value="360" :selected="video.quality==360" :hidden="video.quality<240">360p</option>
                        <option value="240" :selected="video.quality==240">240p</option>
                    </select>
                    <div class="title mt-3">
                        <h5>
                            {{ video.title }}
                        </h5>
                    </div>

                    <div class="interaction text-center mt-5">
                        <a href="#" class="like ml-3" @click.prevent="like()">

                            <span v-if="myLike.length>0">

                                <span v-if="myLike[0].like==1" id="likeNumber">
                                    <i class="far fa-thumbs-up fa-2x liked"></i>
                                    {{ countLike }}
                                </span>

                                <span v-if="myLike[0].like!=1" id="likeNumber">
                                    <i class="far fa-thumbs-up fa-2x"></i>
                                    {{ countLike }}
                                </span>

                            </span>

                            <span v-else>
                                <i class="far fa-thumbs-up fa-2x"></i> <span id="likeNumber">{{ countLike }}</span>
                            </span>

                        </a> |

                        <a href="#" class="like mr-3" @click.prevent="dislike()">

                            <span v-if="myLike.length>0">

                                <span v-if="myLike[0].like==0" id="dislikeNumber">
                                    <i id="like_down" class="far fa-thumbs-down fa-2x liked text-danger"></i>
                                    {{ countDislike }}
                                </span>

                                <span v-if="myLike[0].like!=0" id="dislikeNumber">
                                    <i id="like_down" class="far fa-thumbs-down fa-2x"></i> {{ countDislike }}
                                </span>

                            </span>

                            <span v-else>
                                <i id="like_down" class="far fa-thumbs-down fa-2x"></i> <span
                                    id="dislikeNumber">{{ countDislike }}</span>
                            </span>
                        </a>

                        <!-- @foreach($video->views as $view) -->
                        <span class="float-right">عدد المشاهدات <span class="viewsNumber">{{ view }}</span></span>
                        <!-- @endforeach -->

                        <div class="loginAlert mt-5 alert alert-danger" v-if="msgAlert!==''">
                            {{ msgAlert }}
                        </div>
                    </div>

                    <div class="mt-4 px-2">
                        <div class="comments">
                            <div class="mb-3">
                                <span>التعليقات</span>
                            </div>
                            <div>
                                <textarea class="form-control" id="comment" name="comment" rows="4"
                                    placeholder="إضافة تعليق عام" v-model="form.body"></textarea>
                                <small class="font-bold text-danger d-block my-2"
                                    v-if="form.errors.body">{{ form.errors.body }}</small>
                                <button class="btn btn-info mt-3 saveComment"
                                    @click.prevent="addComment()">تعليق</button>

                                <div class="commentAlert mt-5 alert alert-info" v-if="commentAlert!==''">
                                    {{ commentAlert }}
                                </div>

                                <div class="commentBody">

                                    <div v-for="comment in video.comments" :key="comment.id" class="card mt-5 mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-2">
                                                    <img v-if="comment.user.profile_photo_path" width="100" height="100"
                                                        :src="comment.user.profile_photo_url "
                                                        class="rounded-full" />
                                                    <img v-else :src="comment.user.profile_photo_url" width="100" height="100"
                                                        class="rounded-full" />
                                                </div>
                                                <div  class="col-10">
                                                    <span v-if="$page.props.user">
                                                        <span v-if="comment.user_id==$page.props.user.id">
                                                            <button @click="deleteComment(comment)" type="submit"
                                                                class="float-left"><i
                                                                    class="far fa-trash-alt text-danger fa-lg"></i></button>

                                                            <button class="float-left" @click="editComment(comment)"><i class="far fa-edit text-success fa-lg ml-3"></i></button>
                                                        </span>
                                                    </span>
                                                    <p class="mt-3 mb-2"><strong>{{ comment.user.name }}</strong></p>
                                                    <i class="far fa-clock"></i> <span
                                                        class="comment_date text-secondary">{{ comment.created_at }}</span>
                                                    <span v-if="this.editingComment==comment">
                                                    <textarea class="mt-3 w-100 d-block bg-white px-2 py-1 border border-dark"   v-model="formEdit.body"></textarea>
                                                    <button class="btn btn-info mt-2" @click="submitEdit(comment)">تعديل</button>
                                                </span>
                                                    <p v-else class="mt-3" >{{ comment.body }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </main-layout>
</template>

<script>
    import mainLayout from "@/Layouts/main";
    import {
        Inertia
    } from '@inertiajs/inertia'
    export default {
        components: {
            mainLayout,
        },
        props: {
            video: Object,
            videoCountDislike: Number,
            videoCountLike: Number,
            userLike: Array,
            viewCount: Number
        },
        data() {
            return {
                editingComment:null,
                myLike: this.userLike,
                countLike: this.videoCountLike,
                countDislike: this.videoCountDislike,
                msgAlert: '',
                view: this.viewCount,
                likeAlert: '',
                commentAlert: '',
                form: Inertia.form({
                    video_id: this.video.id,
                    body: "",
                    user_id:this.video.user_id
                }),
                formEdit: Inertia.form({
                    body: "",
                    _method: 'put',
                }),
            }
        },
        methods: {
            changeQulity() {
                var video = document.getElementById("videoPlayer");
                var curTime = video.currentTime;
                var selected = document.getElementById("qualityPick").value;

                if (selected == '1080') {
                    var source = document.getElementById("webm_source").src =
                        this.$page.props.asset + this.video.convertedvideos[0].webm_Format_1080;
                    var source = document.getElementById("mp4_source").src =
                        this.$page.props.asset + this.video.convertedvideos[0].mp4_Format_1080;
                } else if (selected == '720') {
                    var source = document.getElementById("webm_source").src =
                        this.$page.props.asset + this.video.convertedvideos[0].webm_Format_720;
                    var source = document.getElementById("mp4_source").src =
                        this.$page.props.asset + this.video.convertedvideos[0].mp4_Format_720;
                } else if (selected == '480') {
                    var source = document.getElementById("webm_source").src =
                        this.$page.props.asset + this.video.convertedvideos[0].webm_Format_480;
                    var source = document.getElementById("mp4_source").src =
                        this.$page.props.asset + this.video.convertedvideos[0].mp4_Format_480;
                } else if (selected == '360') {
                    var source = document.getElementById("webm_source").src =
                        this.$page.props.asset + this.video.convertedvideos[0].webm_Format_360;
                    var source = document.getElementById("mp4_source").src =
                        this.$page.props.asset + this.video.convertedvideos[0].mp4_Format_360;
                } else if (selected == '240') {
                    var source = document.getElementById("webm_source").src =
                        this.$page.props.asset + this.video.convertedvideos[0].webm_Format_240;
                    var source = document.getElementById("mp4_source").src =
                        this.$page.props.asset + this.video.convertedvideos[0].mp4_Format_240;
                }

                video.load();
                video.play();
                video.currentTime = curTime;

            },
            like() {
                if(this.$page.props.user.block==1){
                    this.msgAlert = "أنت ممنوع من الإعجاب"
                    return
                }
                axios.post(route('like'), {
                    video_id: this.video.id,
                    user_id: this.video.user_id
                }).then(res => {
                    this.countLike = res.data.likeCount
                    this.countDislike = res.data.dislikeCount
                    this.myLike = res.data.userLike
                    this.msgAlert = res.data.alertLogin
                })
            },
            dislike() {
                if(this.$page.props.user.block==1){
                    this.msgAlert = "أنت ممنوع من الإعجاب"
                    return
                }
                axios.post(route('dislike'), {
                    video_id: this.video.id,
                }).then(res => {
                    this.countLike = res.data.likeCount
                    this.countDislike = res.data.dislikeCount
                    this.myLike = res.data.userLike
                    this.msgAlert = res.data.alertLogin

                })
            },

            onEnd() {
                axios.post(route('addView'), {
                    video_id: this.video.id,
                }).then(res => {
                    this.view = res.data
                })
            },
            addComment() {
                this.form.clearErrors()
                if(this.$page.props.user.block==1){
                    this.commentAlert = "أنت ممنوع من التعليق"
                    return
                }
                if (this.form.body !== '') {
                    this.commentAlert = ''
                    this.form.post(route('comment.store'), {
                        preserveScroll: true,
                        onSuccess: res => {
                            this.form.reset();
                            
                        }
                    });
                } else {
                    this.commentAlert = "يجب كتابة تعليق"
                }
            },
            deleteComment(comment){
                this.$inertia.delete(route('comment.destroy',comment.id),{
                    preserveScroll: true,
                }) 
            },
            editComment(comment){
                this.editingComment=comment;
                this.formEdit.body=comment.body
            },
            submitEdit(comment){
                this.formEdit.put(route('comment.update',comment.id),{
                    preserveScroll: true
                })
            }
        },



    }

</script>
