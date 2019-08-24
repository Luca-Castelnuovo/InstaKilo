function render_hashtags() {
    var captions = document.querySelectorAll(".post_caption");
    for (caption of captions) {
        caption.innerHTML = caption.innerHTML.replace(
            /(^|\s)(#[a-z\d-]+)/gi,
            "$1<span class='hash_tag'>$2</span>"
        );
    }

    var comments = document.querySelectorAll(".comment_body");
    for (comment of comments) {
        comment.innerHTML = comment.innerHTML.replace(
            /(^|\s)(#[a-z\d-]+)/gi,
            "$1<span class='hash_tag'>$2</span>"
        );
    }
}
