const msgForm = document.querySelector('.chat-user__form');
const msgField = msgForm.querySelector('.chat-user__form__input');
const msgBtn = msgForm.querySelector('button');
const msgChat = document.querySelector('.chat-user__messages');

msgForm.onsubmit = (e) => {
    e.preventDefault();
}

msgBtn.onclick = () => {
    let xhr = new XMLHttpRequest();

    xhr.open("POST", "layouts/components/insert-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                msgField.value = '';
            }
        }
    }

    let formData = new FormData(msgForm);
    xhr.send(formData);
}

setInterval(() => {
    let xhr = new XMLHttpRequest();

    xhr.open("POST", "layouts/components/get-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                msgChat.innerHTML = xhr.response;
            }
        }
    }

    let formData = new FormData(msgForm);
    xhr.send(formData);
}, 1000)
