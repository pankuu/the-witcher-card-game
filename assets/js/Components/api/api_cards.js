import {fetchJson} from "./fetch_api";

export function getCards(uri = null) {
    let url = '/api/cards';
    if (uri) url = url + uri;

    return fetchJson(url)
        .then(data => data);
}

export function deleteCards(title) {
    return fetchJson(`/api/cards/${title}`, {
        method: 'DELETE'
    });
}

export function createCards(cards) {
    return fetchJson('/api/cards', {
        method: 'POST',
        body: cards
    });
}