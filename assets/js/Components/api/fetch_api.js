export function fetchJson(url, options) {
    let headers = {
        'Content-Type': 'application/json',
    };

    if (options && options.headers) {
        headers = {...options.headers, ...headers};
        delete options.headers;
    }

    let target = {
        credentials: 'same-origin',
        headers: headers,
    }

    if (options && ('DELETE' !== options.method) && ('PUT' !== options.method)) {
        target.mode = 'no-cors';
    }

    return fetch(url, Object.assign(target, options))
        .then(checkStatus)
        .then(response => {
            // decode JSON, but avoid problems with empty responses
            return response.text()
                .then(text => text ? JSON.parse(text) : '')
        });
}

function checkStatus(response) {
    if (response.status >= 200 && response.status < 400) {
        return response;
    }

    const error = new Error(response.statusText);
    error.response = response;

    throw error
}