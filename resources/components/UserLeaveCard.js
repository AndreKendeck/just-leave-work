export default Vue.component("user-leave-card", {
    props: ["leave"],
    name: "user-leave-card",
    data() {
        return {};
    },
    methods: {
        selected() {
            this.$emit("selected", this.leave);
        },
        formatDate(date) {
            return moment(date).format("ll");
        },
        formatDateMobile(date) {
            return moment(date).format("MMM D");
        }
    },
    template: `<a v-on:click="selected()" class="flex w-full bg-white p-3 my-2 rounded-lg shadow-lg items-center justify-between hover:bg-gray-200 cursor-pointer">
    <div class="flex flex-col items-center">
      <span class="text-xs text-gray-600 mb-2 text-green-600"> Requester </span>
            <div>
            <img
            class="rounded-full w-8 md:w-10 lg:w-10"
            v-bind:src="leave.user.has_avatar ? leave.user.avatar_url : leave.user.avatar_url.encoded"
            alt="leave.user.name" />
        <span class="text-xs text-gray-600 mt-2"> {{ leave.user.name.substring(0,12) }}  </span>
            </div>
    </div>

    <div v-if="leave.pending" class="bg-blue-200 text-blue-800 rounded px-2 text-xs ">
          Pending
    </div>

     <div v-if="leave.approved" class="bg-green-200 text-green-800 rounded px-2 text-xs ">
          Approved
     </div>

     <div v-if="leave.denied" class="bg-red-200 text-red-800 rounded px-2 text-xs ">
          Denied
     </div>

    <div class="flex flex-col">
      <p class="text-gray-600 text-sm"> From </p>
      <span class="text-sm hidden md:block"> {{ formatDate(leave.from) }} </span>
      <span class="text-sm md:hidden"> {{ formatDateMobile(leave.from) }} </span>
    </div>

    <div class="flex flex-col ">
      <svg version="1.1" class="stroke-current h-6 w-6 text-gray-600" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                 <g stroke-linecap="round" stroke-width="2" fill="none" stroke-linejoin="round">
                      <path d="M19,12h-14"></path>
                      <path d="M14,17l5,-5"></path>
                      <path d="M14,7l5,5"></path>
                 </g>
            </svg>
    </div>

    <div class="flex flex-col">
      <p class="text-gray-600 text-sm"> Until </p>
      <span class="text-sm hidden md:block"> {{ formatDate(leave.until) }} </span>
      <span class="text-sm md:hidden"> {{ formatDateMobile(leave.until) }} </span>
    </div>

    <div class="flex flex-col items-center ">
          <span v-html="leave.reason.tag"></span>
    </div>

</a>
`
});
