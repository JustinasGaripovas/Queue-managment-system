class RegistrationRequestResponseController {

    constructor(path, data) {
        this.path = path;
        this.data = data;
    }

    ajaxSend() {
        let ajax = $.ajax({
            url: this.path,
            type: 'POST',
            data: this.data,
            dataType: 'json',
            async: false,
        });

        ajax.done(function (data) {
            if (data['response']['error_code'] === "00") {
                onSuccess(data['data']['queue_number']);
            } else {
                onFail(data['response']['error_message']);
            }
        }).fail(function () {
            onAjaxFail();
        });
    }
}

function onSuccess(queueNumber) {
    this.alert("none", `Your number is ${queueNumber}`)
}

function onFail(message) {
    this.alert('none', message)
}

function onAjaxFail() {
    this.alert('none', "Response failure")
}

alert = (label, message) => {
    alertify.alert()
        .setting({
            'message': `<h1 style="text-align: center; display: inline-block; vertical-align: middle; line-height: normal;">${message}<h1>`,
            'basic': true,
            'closable': false,
            'movable': false,
            'transition': 'zoom',
            'resizable': true
        }).resizeTo('50%', '50%').show();

    setTimeout(function () {
        if (alertify.alert().isOpen()) {
            alertify.closeAll()
        }
    }, 5000);
}
