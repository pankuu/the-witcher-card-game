import {fetchJson} from "./fetch_api";

export function getDecks() {
    return fetchJson('/api/decks')
        .then(data => data);
}

export function createDecks(cards) {
    return fetchJson('/api/decks', {
        method: 'POST',
        body: cards,
        mode: 'no-cors',
    });
}

export function listDeck(name) {
    return fetchJson(`/api/decks/${name}`)
        .then(data => data);
}