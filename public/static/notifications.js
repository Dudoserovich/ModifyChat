let toast_id = 1;

function getContainer() {
    let toast_container = document.getElementById('toast-container');
    if (toast_container != null)
        return toast_container;

    toast_container = document.createElement("div");
    toast_container.id = "toast-container";
    toast_container.classList = "toast-container position-fixed bottom-0 end-0 p-3";
    toast_container.setAttribute("style", "z-index: 11");
    document.body.appendChild(toast_container);
    return toast_container;
}

function createToast(color, color_text, id) {
    let newDiv = document.createElement("div");
    newDiv.classList.add('toast');
    newDiv.classList.add(color);
    newDiv.classList.add(color_text);
    newDiv.id = "toast-"+id;
    newDiv.setAttribute("role", "alert");
    newDiv.setAttribute("aria-live", "assertive");
    newDiv.setAttribute("aria-atomic", "true");
    return newDiv;
}

function createSnack(message, id) {
    let newDiv = document.createElement("div");
    newDiv.classList.add("toast-body");
    newDiv.classList.add("d-flex");
    newDiv.appendChild(createMessage(message, id));
    newDiv.appendChild(createCloseButton(id));
    return newDiv;
}

function createMessage(message, id) {
    let newDiv = document.createElement("div");
    newDiv.id = "message-"+id;
    newDiv.innerHTML = message;
    return newDiv;
}

function createCloseButton(id) {
    let newButton = document.createElement("button")
    newButton.classList.add("btn-close");
    newButton.classList.add("btn-close");
    newButton.classList.add("btn-close-white");
    newButton.classList.add("me-2");
    newButton.classList.add("m-auto");
    newButton.setAttribute("type", "button");
    newButton.setAttribute("data-bs-dismiss", "toast");
    newButton.setAttribute("aria-label", "Close");
    return newButton;
}

function displayNotification(message, color, time, hide){

    let color_text = 'text-white';

    switch(color) {
        case 'grey':
        case 'secondary':
            color = 'bg-secondary';
            color_text = 'text-white';
            break;
        case 'green':
        case 'success':
            color = 'bg-success';
            color_text = 'text-white';
            break;
        case 'red':
        case 'danger':
            color = 'bg-danger';
            color_text = 'text-white';
            break;
        case 'warning':
        case 'yellow':
            color = 'bg-warning';
            color_text = 'text-white';
            break;
        case 'white':
        case 'light':
            color = 'bg-light';
            color_text = 'text-dark';
            break;
        default:
            color = 'bg-primary';
            color_text = 'text-white';
            break;
    }

    if(time == null){
        time = 2500;
    }

    if(hide == null){
        hide = true;
    }

    let option =
        {
            delay: time,
            autohide: hide
        };

    let toast_container = getContainer();
    let toast = createToast(color, color_text, toast_id);
    toast_container.appendChild(toast);
    toast.appendChild(createSnack(message, toast_id));

    let Toast = new bootstrap.Toast(toast, option);
    Toast.show();

    toast_id = toast_id + 1;
}