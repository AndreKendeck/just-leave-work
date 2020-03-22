Vue.component("leave-card", {
    props: ["user", "currentweek"],
    name: "leave-card",
    data() {
        return {
            week: [0, 1, 2, 3, 4, 5, 6],
            leaves: null,
            loading: true
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
        hasLeaveOnDay(day) {
          
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
    mounted() {},
    template: `<div>
     <div class="bg-white rounded-lg p-2 lg:p-3 flex justify-between items-center my-1 lg:mx-2 lg:my-2 border-2">
     <vue-loader :active="loading"></vue-loader>
         <div class="flex flex-col items-center lg:mx-2">
             <a  v-bind:href="user.url"> 
                    <img
                    class="rounded-full w-8 md:w-10 lg:w-10"
                    v-bind:src="user.avatar_url.encoded"
                    v-bind:alt="user.name"
                    />
             </a>
         </div>
         <div class="flex justify-around flex-1">
             <span class="mx-1 md:mx-2 flex flex-col items-center" v-for="day in displayWeek" >
                 <span class="font-bold text-xs lg:text-sm whitespace-no-wrap text-center"> 
                    <span class="hidden lg:flex" > {{ day.format('MMM, D') }} </span>
                    <span class="lg:hidden"> {{ day.format('D/MM') }} </span>
                 </span>
                 {{ hasLeaveOnDay(day) }}
             </span>
         </div>
     </div>
 </div>`
});
