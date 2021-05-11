
export const setTeam = (team) => {
    return { type: 'TEAM_SET', payload: team };
}

export const unsetTeam = () => {
    return { type: 'TEAM_UNSET' };
}