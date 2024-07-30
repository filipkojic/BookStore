async function ajaxGet(url) {
    const response = await fetch(url);
    return response.json();
}

async function ajaxPost(url, data) {
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
    return response.json();
}

async function ajaxDelete(url) {
    const response = await fetch(url, {
        method: 'DELETE'
    });
    return response.json();
}

async function ajaxPut(url, data) {
    const response = await fetch(url, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
    return response.json();
}

async function ajaxPatch(url, data) {
    const response = await fetch(url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
    return response.json();
}