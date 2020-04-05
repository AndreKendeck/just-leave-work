export default Vue.component("UserComment", {
    props: ["comment"],
    name: "user-comment",
    data: () => {
        return {
            is_editing: false,
            sending: false,
            successMessage: null,
            errors: []
        };
    },
    methods: {
        selected() {
            return this.$emit("selected", this.comment);
        },
        deleteComment() {
            axios.post(`/comment/delete/${this.comment.id}`).then(response => {
                return this.$emit("deleted");
            });
        },
        update() {
            this.sending = true;
            this.errors = [];
            this.successMessage = null;
            axios
                .post(`/comment/update/${this.comment.id}`, {
                    text: this.comment.text
                })
                .then(response => {
                    this.successMessage = response.data.message;
                    this.comment = response.data.comment;
                    this.sending = false; 
                    this.is_editing = false; 
                })
                .catch(failed => {
                    this.errors = collect(failed.response.data.errors)
                        .flatten()
                        .all();
                    this.sending = false;
                });
        },
        toReadableTime(date) {
            return moment(date).fromNow();
        }
    },
    template: `<div class="rounded-lg bg-gray-100 p-4 flex flex-col w-full my-2 animated fadeInDown">
     <div class="flex justify-between w-full">
          <div class="flex items-center">
               <img class="rounded-full h-5 w-5"
                    v-bind:src="comment.user.has_avatar ? comment.user.avatar_url : comment.user.avatar_url.encoded"
                    alt="comment.user.name" />
               <span class="text-xs text-gray-400 ml-1">{{ comment.user.name.substr(0,12)  }}</span>
          </div>
          <div class="flex">
               <span class="text-xs text-gray-400 ml-1">{{ toReadableTime(comment.created_at) }}
               </span>
               <span v-if="comment.was_edited" class="text-xs text-gray-400 ml-1"> &bull; edited
               </span>
          </div>
     </div>
     <div class="text-gray-600 text-sm mt-4">
          <span v-if="!is_editing"> {{ comment.text }} </span>
          <div class="flex flex-col w-full my-2" v-if="is_editing">
          
               <div class="flex w-full my-1">
               <input type="text" class="mx-1 w-full p-0" v-model="comment.text" >
               <vue-loader :active="sending" spinner="ring"></vue-loader>
               <button class="bg-gray-200 hover:bg-gray-300 p-0"  v-on:click="update()" >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" class="feather feather-save stroke-current h-8 w-8 text-gray-600 p-2">
                         <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z">
                         </path>
                         <polyline points="17 21 17 13 7 13 7 21"></polyline>
                         <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
               </button>
               <button class="bg-gray-200 hover:bg-gray-300 p-0 ml-1" v-on:click="is_editing = false">
                    <svg version="1.1" class="h-8 w-8 stroke-current text-gray-600 p-2" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                         <g fill="none">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                   d="M8,8l8,8">
                              </path>
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                   d="M16,8l-8,8">
                              </path>
                         </g>
                    </svg>
               </button>
               </div>


          <div class="flex justify-end mx-2 py-1 mt-2 items-center" v-for="(error,idx) in errors"
               :key="idx">
               <svg id="warning" xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                    viewBox="0 0 15 15">
                    <path id="Path_41" data-name="Path 41" d="M0,0H15V15H0Z" fill="none" />
                    <path id="Path_42" data-name="Path 42"
                         d="M8.625,3h0A5.625,5.625,0,0,1,14.25,8.625h0A5.625,5.625,0,0,1,8.625,14.25h0A5.625,5.625,0,0,1,3,8.625H3A5.625,5.625,0,0,1,8.625,3Z"
                         transform="translate(-1.125 -1.125)" fill="none" stroke="#c81d25"
                         stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                    <path id="Path_43" data-name="Path 43" d="M12,10.625V7.5"
                         transform="translate(-4.5 -2.813)" fill="none" stroke="#c81d25"
                         stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                    <path id="Path_44" data-name="Path 44"
                         d="M11.906,16a.156.156,0,1,0,.157.156A.155.155,0,0,0,11.906,16"
                         transform="translate(-4.406 -6)" fill="none" stroke="#c81d25" stroke-linecap="round"
                         stroke-linejoin="round" stroke-width="1.5" />
               </svg>
               <span class="text-red-600 text-xs mx-1">{{ error }}</span>
          </div>

          <div class="flex justify-end mx-2 py-1 mt-2 items-center" v-if="successMessage">
               <svg version="1.1" class="stroke-current w-3 h-3 text-green-600" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g fill="none">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12,21v0c-4.971,0 -9,-4.029 -9,-9v0c0,-4.971 4.029,-9 9,-9v0c4.971,0 9,4.029 9,9v0c0,4.971 -4.029,9 -9,9Z">
                         </path>
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16,10l-5,5l-3,-3"></path>
                    </g>
               </svg>
               <span class="text-green-600 text-xs mx-1">{{ successMessage }}</span>
          </div>

          </div>
     </div>
     <div class="flex w-full justify-end">
          <button v-if="comment.can_edit && !is_editing && comment.is_editable" class="bg-gray-200 hover:bg-gray-300 p-0" v-on:click="is_editing = true" >
               <svg version="1.1" class="stroke-current h-8 w-8 text-gray-600 p-2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g stroke-linecap="round" stroke-width="2" fill="none" stroke-linejoin="round">
                         <path
                              d="M21,11v8c0,1.105 -0.895,2 -2,2h-14c-1.105,0 -2,-0.895 -2,-2v-14c0,-1.105 0.895,-2 2,-2h8">
                         </path>
                         <path
                              d="M20.707,6.121l-10.879,10.879h-2.828v-2.828l10.879,-10.879c0.391,-0.391 1.024,-0.391 1.414,8.88178e-16l1.414,1.414c0.391,0.391 0.391,1.024 -3.55271e-15,1.414Z">
                         </path>
                         <path d="M16.09,5.09l2.82,2.82"></path>
                    </g>
               </svg>
          </button>

          <button v-if="comment.can_edit && comment.is_deletable" class="bg-gray-200 hover:bg-gray-300 p-0 ml-1" v-on:click="deleteComment()" >
               <svg version="1.1" class="stroke-current h-8 w-8 text-gray-600 p-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g stroke-linecap="round" stroke-width="1.5"  fill="none"
                         stroke-linejoin="round">
                         <path d="M18,6.53h1"></path>
                         <path d="M9,10.47v6.06"></path>
                         <path d="M12,9.31v8.27"></path>
                         <path d="M15,10.47v6.06"></path>
                         <path
                              d="M15.795,20.472h-7.59c-1.218,0 -2.205,-0.987 -2.205,-2.205v-11.739h12v11.739c0,1.218 -0.987,2.205 -2.205,2.205Z">
                         </path>
                         <path
                              d="M16,6.528l-0.738,-2.305c-0.133,-0.414 -0.518,-0.695 -0.952,-0.695h-4.62c-0.435,0 -0.82,0.281 -0.952,0.695l-0.738,2.305">
                         </path>
                         <path d="M5,6.53h1"></path>
                    </g>
               </svg>
          </button>
     </div>
</div>`
});
