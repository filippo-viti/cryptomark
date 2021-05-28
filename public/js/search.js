function showSuggestions(keyword) {
    if (keyword.length === 0) {
        document.getElementById("suggestions").innerHTML = "";
        return;
    }
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let algorithms = JSON.parse(this.responseText);
            let listItems = "";
            algorithms.forEach(algorithm => listItems +=
                `<a href="/algorithm/${algorithm.name}" class="list-group-item list-group-item-action">
                    ${algorithm.name}
                </a>`
            )
            document.getElementById("suggestions").innerHTML = listItems;
        }
    }
    xmlhttp.open("GET", "/algorithm/search/" + keyword, true);
    xmlhttp.send();
}