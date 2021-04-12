import {fetchJson} from "./fetch_api";

export function getCards() {
    return fetchJson('/api/cards')
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