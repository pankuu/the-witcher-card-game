import {fetchJson} from "./fetch_api";

export function getDecks() {
    return fetchJson('/api/decks')
        .then(data => data);
}

export function createDecks(cards) {
    return fetchJson('/api/decks', {
        method: 'POST',
        body: cards
    });
}

export function addCardToDeck(deck, cards) {
    return fetchJson(`/api/decks/${deck}`, {
        method: 'PUT',
        body: cards
    });
}

export function listDeck(name) {
    return fetchJson(`/api/decks/${name}`)
        .then(data => data);
}