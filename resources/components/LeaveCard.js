export default Vue.component("leave-card", {
    props: ["user", "currentweek"],
    name: "leave-card",
    data() {
        return {
            week: [0, 1, 2, 3, 4, 5, 6],
            leaves: [],
            loading: true,
            showName: false
        };
    },
    methods: {
        getLeavesForCurrentWeek() {
            this.loading = true;
            axios
                .get(
                    `/leaves-on-week/${this.user.id}/${moment()
                        .set("week", this.currentweek)
                        .startOf("week")
                        .format("YYYY-MM-DD")}/${moment()
                        .set("week", this.currentweek)
                        .endOf("week")
                        .format("YYYY-MM-DD")}`
                )
                .then(response => {
                    this.leaves = collect(response.data).toArray();
                    this.loading = false;
                });
        },
        // complex stuff
        isOnLeave(leave, day) {
            return (
                moment(leave.from).isSame(day, "day") ||
                moment(leave.until).isSame(day, "day") ||
                day.isBetween(moment(leave.from), moment(leave.until))
            );
        }
    },
    computed: {
        displayWeek() {
            this.getLeavesForCurrentWeek();
            return this.week.map((value, key) => {
                return moment()
                    .set("week", this.currentweek)
                    .startOf("week")
                    .add(value, "d");
            });
        }
    },
    template: `<div class="flex flex-col mt-3">
     <div class="flex items-center md:hidden">
         <a v-bind:href="user.url" class="mx-1">
             <img
                 class="rounded-full w-6"
                 v-bind:src="user.has_avatar ? user.avatar_url : user.avatar_url.encoded"
                 v-bind:alt="user.name"
             />
         </a>
         <span class="text-center text-sm tracking-widest text-jean ml-2">{{
             user.name
         }}</span>
     </div>

     <div
         class="bg-white rounded-lg p-2 lg:p-3 flex justify-between items-center my-1 lg:mx-2 lg:my-2 border-2"
     >
         <vue-loader :active="loading" spinner="ring" ></vue-loader>
         <a v-bind:href="user.url" class="hidden md:flex flex-col mx-1 items-center justify-between relative">
             <img
                v-on:mouseenter="showName = true" v-on:mouseleave="showName = false"
                 class="rounded-full w-8 md:w-10 lg:w-10"
                 v-bind:src="user.has_avatar ? user.avatar_url : user.avatar_url.encoded"
                 v-bind:alt="user.name"
             />
             <span class="px-3 text-xs bg-jean mt-1 text-white rounded-md name-badge absolute z-10 shadow whitespace-no-wrap" v-bind:class="{ 'hidden' : !showName , 'flex' : showName }" > {{ user.name }} </span>
         </a>
         <div class="flex justify-around flex-1">
             <span
                 class="md:mx-2 flex flex-col items-center"
                 :key="idx"
                 v-for="(day, idx) in displayWeek"
             >
                 <span class="mx-1 text-gray-600 text-xs lg:text-sm lg:whitespace-no-wrap text-center">
                     <span class="hidden lg:flex">{{
                         day.format("MMM, D")
                     }}</span>
                     <span class="text-xs lg:hidden">{{
                         day.format("D/MM")
                     }}</span>
                 </span>
                 <div v-if="leaves.length > 0" v-for="(leave , idx) in leaves" :key="idx" >
                     <span v-if="isOnLeave(leave,day)" v-html="leave.reason.tag" >  </span>
                 </div>
             </span>
         </div>
     </div>
 </div>`
});
