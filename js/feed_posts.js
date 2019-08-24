function feed_render_posts(data, loadMore = false) {
    if (!loadMore) {
        setInterval(feed_check_posts, 60000);
    }

    if (!data.success) {
        if (loadMore) {
            return false;
        }

        return `
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h4>You don't have any posts.</h4>
                </div>
                <div class="card-action center">
                    <div class="row mb-0">
                        <a href="/posts/add" class="btn waves-effect waves-light blue accent-4 col s12">Create a post</a>
                    </div>
                </div>
            </div>
        </div>
        `;
    }

    if (!loadMore) {
        delete data.CSRFtoken;
        localStorage.setItem("posts", JSON.stringify(data));
    }

    var posts_array = [];

    for (post of data.posts) {
        posts_array.push(feed_render_post(post));
    }

    return posts_array.join("");
}

function feed_render_posts_profile(data) {
    if (!data.success) {
        return `
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h4>This user doesn't have any posts.</h4>
                </div>
            </div>
        </div>
        `;
    }

    var posts_array = [];

    for (post of data.posts) {
        posts_array.push(feed_render_post(post, true));
    }

    return posts_array.join("");
}

function feed_check_posts() {
    GETrequest(
        `https://instakilo.lucacastelnuovo.nl/posts/actions/feed`,
        function(response) {
            delete response.CSRFtoken;
            if (JSON.stringify(response) !== localStorage.getItem("posts")) {
                M.Toast.dismissAll();
                M.toast({
                    html: '<span>You have new posts!</span><button class="btn-flat toast-action blue-text accent-4" onclick="location.reload()">Load Posts</button>'
                });
            }
        }
    );
}

function feed_like_post(post_id) {
    GETrequest(
        `https://instakilo.lucacastelnuovo.nl/posts/actions/like/${CSRFtoken}/${post_id}`,
        function(response) {
            if (response.success) {
                const likes = document.querySelector(`#post-${post_id} .post_likes`);
                likes.innerHTML = response.likes + " likes";

                const like_function = document.querySelector(`#post-${post_id} a`);
                like_function.setAttribute(
                    "onClick",
                    `feed_undo_like_post(${post_id})`
                );

                const like_icon = document.querySelector(`#post-${post_id} a i`);
                like_icon.innerHTML = "favorite";

                M.Toast.dismissAll();
                M.toast({
                    html: "Liked"
                });

                var storageJSON = JSON.parse(localStorage.getItem("posts"));
                var storageJSONUpdated = storageJSON.posts.map(function(post) {
                    if (post.id == post_id) {
                        post.liked = true;
                        post.likes++;
                        post.likes = `${post.likes}`;
                    }

                    return post;
                });

                storageJSON.posts = storageJSONUpdated;
                localStorage.setItem("posts", JSON.stringify(storageJSON));
            }
        }
    );
}

function feed_undo_like_post(post_id) {
    GETrequest(
        `https://instakilo.lucacastelnuovo.nl/posts/actions/undo_like/${CSRFtoken}/${post_id}`,
        function(response) {
            if (response.success) {
                const likes = document.querySelector(`#post-${post_id} .post_likes`);
                likes.innerHTML = response.likes + " likes";

                const like_function = document.querySelector(`#post-${post_id} a`);
                like_function.setAttribute("onClick", `feed_like_post(${post_id})`);

                const like_icon = document.querySelector(`#post-${post_id} a i`);
                like_icon.innerHTML = "favorite_border";

                M.Toast.dismissAll();
                M.toast({
                    html: "Like removed"
                });

                var storageJSON = JSON.parse(localStorage.getItem("posts"));
                var storageJSONUpdated = storageJSON.posts.map(function(post) {
                    if (post.id == post_id) {
                        post.liked = false;
                        post.likes--;
                        post.likes = `${post.likes}`;
                    }

                    return post;
                });

                storageJSON.posts = storageJSONUpdated;
                localStorage.setItem("posts", JSON.stringify(storageJSON));
            }
        }
    );
}

function feed_comment_post(formElement) {
    var formData = new FormData(formElement);

    if (formData.get("comment")
        .length > 200) {
        M.Toast.dismissAll();
        M.toast({
            html: "Comment too long"
        });
        return false;
    }

    if (formData.get("comment")
        .length < 1) {
        M.Toast.dismissAll();
        M.toast({
            html: "Comment too short"
        });
        return false;
    }

    formData.append("CSRFtoken", CSRFtoken);
    var post_id = formData.get("post_id");

    FORMrequest("/posts/actions/", formData, function(response) {
        if (response.success) {
            const text_input = document.querySelector(`#form_comment-${post_id}`);
            text_input.value = "";
            let new_comment = document.createElement("div");
            new_comment.innerHTML = feed_render_comment(response.new_comment, post_id);
            const comment_container = document.querySelector(
                `#comment-container-${post_id}`
            );

            comment_container.appendChild(new_comment);

            M.Toast.dismissAll();
            M.toast({
                html: "Comment sent"
            });

            var storageJSON = JSON.parse(localStorage.getItem("posts"));
            var storageJSONPosts = storageJSON.posts;
            var storageJSONPostsUpdated = storageJSONPosts.map(function(post) {
                if (post.id == post_id) {
                    post.comments = response.comments;
                }

                return post;
            });

            storageJSON.posts = storageJSONPostsUpdated;
            localStorage.setItem("posts", JSON.stringify(storageJSON));

            render_hashtags();
        }
    });
}

function feed_delete_comment(post_id, comment_id) {
    if (!confirm("Are you sure?")) {
        return false;
    }

    GETrequest(
        `https://instakilo.lucacastelnuovo.nl/posts/actions/delete_comment/${CSRFtoken}/${post_id}&comment_id=${comment_id}`,
        function(response) {
            if (response.success) {
                var comment = document.querySelector(`#comment-${post_id}-${comment_id}`);
                comment.parentNode.removeChild(comment);

                M.Toast.dismissAll();
                M.toast({
                    html: "Comment deleted"
                });

                var storageJSON = JSON.parse(localStorage.getItem("posts"));
                var storageJSONUpdated = storageJSON.posts.map(function(post) {
                    if (post.id == post_id) {
                        post.comments = post.comments.filter(function(obj) {
                            return obj.id !== comment_id;
                        });
                    }

                    return post;
                });

                storageJSON.posts = storageJSONUpdated;
                localStorage.setItem("posts", JSON.stringify(storageJSON));
            }
        }
    );
}

function feed_render_post(post, profile = false) {
    var comments;
    var comments_form;

    if (post.comments_allowed) {
        comments = feed_render_comments(post.comments, profile, post.id);
        comments_form = `
            <form action="/posts/actions" method="POST" onsubmit="event.preventDefault(); feed_comment_post(this);">
                <div class="row mb-0">
                    <div class="col s10">
                        <div class="input-field">
                            <label for="form_comment-${post.id}">Comment</label>
                            <textarea id="form_comment-${post.id}" class="materialize-textarea counter" name="comment" data-length="200"></textarea>
                        </div>
                    </div>
                    <div class="input-field col s2">
                        <input type="hidden" name="post_id" value="${post.id}">
                        <button type="submit" class="btn-floating btn waves-effect waves-light blue accent-4">
                            <i class="material-icons">send</i>
                        </button>
                    </div>
                </div>
            </form>
        `;
    } else {
        comments = '<li class="collection-item">Comments are disabled</li>';
        comments_form = "";
    }

    var like_icon = post.liked ? "favorite" : "favorite_border";
    var like_function = post.liked ?
        `feed_undo_like_post(${post.id})` :
        `feed_like_post(${post.id})`;

    return `
        <div class="col s12 ${profile ? "m6 l4" : ""}">
            <div class="card mt-0">
                <div class="card-image"><img id="post_image" class="materialboxed lazy" data-caption="${post.caption}" data-src="${post.img_url}" src="https://via.placeholder.com/150.jpg"></div>
                <div class="card-content">
                    <p>
                        <span class="bold"><a href="/u/${post.username}">${post.username}</a></span> <span class="post_caption">${post.caption}</span>
                        ${post.user_is_owner ? `<a href="/posts/edit/${post.id}" class="secondary-content tooltipped" data-position="right" data-tooltip="Edit post"><i class="material-icons blue-icon">edit</i></a>` : ""}
                    </p>
                </div>
                <div class="card-action">
                    <div class="row likes" id="post-${post.id}">
                        <a onclick="${like_function}" class="mr-6"><i class="material-icons blue-icon">${like_icon}</i></a> <span class="post_likes">${post.likes} likes</span>
                    </div>
                    ${profile ? `` : `<div class="row mb-0">
                        <h6>Comments:</h6>
                        <ul id="comment-container-${post.id}" class="collection">
                            ${comments}
                        </ul>
                            ${comments_form}
                    </div>`}
                </div>
            </div>
        </div>
    `;
}

function feed_render_comments(comments, profile, post_id) {
    var comments_array = [];

    if (profile) {
        comments = comments.slice(0, 3);
    }

    for (comment of comments) {
        comments_array.push(feed_render_comment(comment, post_id));
    }

    return comments_array.join("");
}

function feed_render_comment(comment, post_id) {
    return `
        <li class="collection-item avatar comment_container" id="comment-${post_id}-${comment.id}">
            <a href="/u/${comment.username}" class="blue-text">
                <img src="https://via.placeholder.com/25.jpg" data-src="${comment.profile_picture}" onerror="this.src='https://cdn.lucacastelnuovo.nl/general/images/profile_picture.png'" class="circle lazy" />
                <span class="title tt-none">${comment.username}</span>
            </a>
            <p class="truncate comment_body">${comment.body}</p>
            ${comment.user_is_owner ? `<a href="#!" onclick="feed_delete_comment('${post_id}', '${comment.id}')" class="secondary-content tooltipped comment_delete_btn" data-position="right" data-tooltip="Delete comment"><i class="material-icons blue-icon">delete</i></a>` : ""}
        </li>
    `;
}
