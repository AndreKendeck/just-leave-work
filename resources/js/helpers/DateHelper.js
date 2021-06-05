import moment from "moment";


export const getJavascriptDateForCalendar = (date) => {
    const result = moment(date);
    if (result.isValid()) {
        return result.toDate();
    }
    return moment().toDate();
}
