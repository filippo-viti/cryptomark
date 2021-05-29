function loadRootComments(algorithmId) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let comments = JSON.parse(this.responseText);
            let html = "";
            comments.forEach(rootComment => {
                    if (rootComment.parent == null) {
                        html += renderComment(rootComment)
                    }
                }
            )
            document.getElementById("comments").innerHTML = html;
            document.getElementById("showComments").hidden = true;
        }
    }
    xmlhttp.open("GET", "/algorithm/comments/" + algorithmId, true);
    xmlhttp.send();
}

function renderComment(comment) {
    let html = `<div id="commentId${comment.id}" class="p-4 mb-2 border border-3 rounded">`;
    let profilePicturePath = "/img/users/";
    if (comment.user.profilePicture != null) {
        profilePicturePath += comment.user.profilePicture;
    } else {
        profilePicturePath += "default.png";
    }
    html +=
        `<div class="row">
            <div class="col">
                <img class="rounded-circle" src="${profilePicturePath}" width="32px" height="32px">
                <b>${comment.user.username}</b>
            </div>
        </div>
        <div class="row">
            ${comment.text}
        </div>
        <div class="row">
            <div class="col">
                <i class="bi bi-arrow-up-circle"></i>
                ${comment.upvotes}
                <i class="bi bi-arrow-down-circle"></i>
            </div>
        </div>`;
    if (comment.children.length !== 0) {
        html +=
            `<div class="row">
                <button class="btn btn-link">
                    <i class="bi bi-caret-down-fill"></i>
                    Show replies
                </button>
            </div>`;
    }
    html += `</div>`;
    return html;
}