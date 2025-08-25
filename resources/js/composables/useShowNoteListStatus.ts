export function getShowNoteListStatus() {
    const val = localStorage.getItem('showNoteList');
    if (val === null) {
        return true;
    }
    return val === 'true' ? true : false;
}

export function useShowNoteListStatus() {
    return { getShowNoteListStatus };
}
