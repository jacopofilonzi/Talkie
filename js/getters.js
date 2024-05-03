function getQuery() {
    let query = {};
    
    for (const keyval of window.location.search.substring(1).split("&")) {
        let [key, val] = keyval.split("=");
        query[key] = val;
    }

    return query
}

function getCookies() {
    let cookies = {};

    for (const keyval of document.cookie.split("; ")) {
        let [key, val] = keyval.split("=");
        cookies[key] = val;
    }

    return cookies;
}

function getAnchors() {
    let anchors = {};

    for (const keyval of window.location.hash.substring(1).split("#")) {
        let [key, val] = keyval.split("=");
        anchors[key] = val;
    }

    return anchors;
}
