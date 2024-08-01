document.addEventListener("DOMContentLoaded", function() {
    var currentURL = window.location.href;
    console.log("Current URL: " + currentURL);

    if (currentURL.match(/\/ref\/.*/)) {
        console.log("Matched /ref/ pattern, redirecting to: https://www.fastforexfunding.com/");
        window.location.href = "https://www.fastforexfunding.com/";
    } else if (currentURL.indexOf("?ref=") !== -1) {
        console.log("Matched ?ref= pattern, redirecting to: https://www.fastforexfunding.com/");
        window.location.href = "https://www.fastforexfunding.com/";
    }
});
