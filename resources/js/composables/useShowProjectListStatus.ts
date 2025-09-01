export function getShowProjectListStatus() {
    const val = localStorage.getItem('showProjectList');
    if (val === null) {
        return true;
    }
    return val === 'true' ? true : false;
}

export function useShowProjectListStatus() {
    return { getShowProjectListStatus };
}
