const userList = document.querySelector('.user-list');

setInterval(() => {
    let xhr = new XMLHttpRequest();

    xhr.open("GET", "layouts/components/user-list.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                userList.innerHTML = data;
            }
        }
    }

    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send();
}, 1000)
