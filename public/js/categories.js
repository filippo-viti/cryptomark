function getByCategoryId(id) {
    if (parseInt(id) !== 0) {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                let algorithms = JSON.parse(this.responseText);
                let listItems = "";
                algorithms.forEach(algorithm => listItems +=
                    `<li class="list-group-item list-group-item">
                        <h4><a href="/algorithm/${algorithm.name}">${algorithm.name}</a></h4>
                        ${algorithm.shortDescription}
                    </li>`
                );
                document.getElementById("algorithms").innerHTML = listItems;
            }
        }
        xmlhttp.open("GET", "/category/" + id + "/algorithms", true);
        xmlhttp.send();
    } else {
        document.getElementById("algorithms").innerHTML = "";
    }
}