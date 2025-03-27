// yummie-overview.js

document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);

    function updateButton(filterName, defaultText) {
        const button = document.getElementById("dropdown" + filterName.charAt(0).toUpperCase() + filterName.slice(1));
        if (!button) return;
        button.innerText = defaultText;
    }

    // Initialiseer dropdown-knoppen
    updateButton("duration", urlParams.get("duration") ?? "Duration");
    updateButton("open_time", urlParams.get("open_time") ?? "Open time");
    updateButton("cuisine", urlParams.get("cuisine") ?? "Cuisine");
    updateButton("rating", urlParams.get("rating") ?? "Rating");
    updateButton("cost", urlParams.get("cost") ?? "Cost");

    window.applyFilter = function (filterName, value) {
        const url = new URL(window.location.href);
        url.searchParams.set(filterName, value);
        history.pushState({}, "", url.toString());

        fetch(url.pathname + "?" + url.searchParams.toString(), {
            method: "GET",
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
            .then(response => response.text())
            .then(html => {
                document.getElementById("restaurant-list").innerHTML = html;
            })
            .catch(error => console.error("Error:", error));

        updateButton(filterName, value);
    };
});
