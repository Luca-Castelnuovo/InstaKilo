function feed_render_messages(data) {
    // Currently disabled due to unifished function
    // setInterval(feed_check_messages, 30000);

    if (!data.success) {
        return `
            <li class="collection-item">
                You don't have any messages.
            </li>
        `;
    }

    delete data.CSRFtoken;
    localStorage.setItem("messages", JSON.stringify(data));

    var messages_array = [];

    for (message of data.messages) {
        messages_array.push(feed_render_message(message));
    }

    var messages_box = new Sticky("#messages_box");

    return messages_array.join("");
}

function feed_check_messages() {
    GETrequest(`https://instakilo.lucacastelnuovo.nl/messages/actions`, function(
        response
    ) {
        delete response.CSRFtoken;
        if (JSON.stringify(response) !== localStorage.getItem("messages")) {
            M.Toast.dismissAll();
            M.toast({
                html: '<span>You have new messages!</span><button class="btn-flat toast-action blue-text accent-4" onclick="location.reload()">Load messages</button>'
            });
        }
    });
}

function feed_render_message(message) {
    return `
        <li class="collection-item avatar">
            <a href="/u/${message.username}" class="blue-text">
                <img src="${message.profile_picture}" onerror="this.src='https://cdn.lucacastelnuovo.nl/general/images/profile_picture.png'" class="circle" />
                <span class="title">${message.username}</span>
            </a>
            <p class="truncate">${message.body}</p>
            <a href="/messages/#reply_to=${message.username}" class="secondary-content tooltipped" data-position="right" data-tooltip="Reply"><i class="material-icons blue-icon">reply</i></a>
        </li>
    `;
}
