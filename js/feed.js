function render_posts(data) {
    const post_container = document.querySelector('#post_container');

    for (post of data['posts']) {
        render_post(post);
    }
}

function render_post(post) {
    if (post['comments'] !== null && post['comments_allowed']) {
        render_comments(post['comments']);
    }
}

function render_comments(comments) {
    for (comment of comments) {
        render_comment(comment)
    }
}

function render_comment(comment) {
    console.log(comment);

    if (comment['subcomment'] !== null) {
        render_comments(comment['subcomment']);
    }
}






function request(method, url, callback) {
    const xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState !== 4) return;
        callback(JSON.parse(xhr.responseText));
    };

    xhr.open(method, url);
    xhr.send();
}

document.addEventListener('DOMContentLoaded', function() {
    const CSRFtoken = 'test';

    request('GET', `https://instakilo.lucacastelnuovo.nl/posts/actions/${CSRFtoken}/feed`, function(response) {
        render_posts(response);
    });
});
