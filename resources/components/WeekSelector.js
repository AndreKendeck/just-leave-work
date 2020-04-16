export default Vue.component("week-selector", {
    name: "week-selector",
    data() {
        return {
            currentWeek: moment().week(),
            currentMonth: moment().format("MMMM"),
            currentYear: moment().format("Y"),
            numberOfWeeksInYear: moment().weeksInYear()
        };
    },
    methods: {
        changeWeek() {
            this.currentMonth = moment()
                .set("week", this.currentWeek)
                .format("MMMM");
        },
        timePeriod(week) {
            return (
                moment()
                    .set("week", week)
                    .startOf("week")
                    .format("MMM") +
                " " +
                moment()
                    .set("week", week)
                    .startOf("week")
                    .format("DD") +
                ` - ` +
                moment()
                    .set("week", week)
                    .endOf("week")
                    .format("MMM") +
                " " +
                moment()
                    .set("week", week)
                    .endOf("week")
                    .format("DD")
            );
        }
    },
    template: `<select v-model="currentWeek" class="form-select mx-3" v-on:change="changeWeek()"
    placeholder="Week">
    <option v-bind:selected="weekNumber == currentWeek" v-bind:value="weekNumber"
         v-for="weekNumber in numberOfWeeksInYear">
         {{  timePeriod(weekNumber)  }}
    </option>
</select>`
});
