
export const setLeaves = (leaves = []) => {
    return { type: 'SET_LEAVES', payload: leaves };
}

export const setSelectedLeave = (leave) => {
    return { type: 'SET_SELECTED_LEAVE', payload: leave }
}

export const deleteLeave = (id) => {
    return { type: 'DELETE_LEAVE', payload: id }
}

export const approveLeave = (id) => {
    return { type: 'APPROVE_LEAVE', payload: id }
}