import api from "../../api"

export const setLeaves = (page = 1) => {
    return (dispatch) => {
        api.get(`/leaves/?page=${page}`)
            .then(success => {
                return { type: 'SET_LEAVES', payload: success.data }
            })
            .catch(failed => {
                
            });
    }
}

export const setSelectedLeave = (leave) => {
    return { type: 'SET_SELECTED_LEAVE', payload: leave }
}

export const deleteLeave = (id) => {
    return { type: 'DELTET_LEAVE', payload: id }
}
