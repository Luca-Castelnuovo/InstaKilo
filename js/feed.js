function request(method, url) {
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState !== 4) return;
        return JSON.parse(xhr.responseText);
    };

    xhr.open(method, url);
    xhr.send();
}


function render_posts(data) {
    console.log('posts', data);
}


document.addEventListener('DOMContentLoaded', function() {
    console.log(request('GET', `/posts/actions/${CSRFtoken}/feed`));
    // render_posts(request('GET', `/posts/actions/${CSRFtoken}/feed`));
});
