import {fetchJson} from "./fetch_api";

export function play(data) {
    return fetchJson('/api/games', {
        method: 'POST',
        body: data
    });
}