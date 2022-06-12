window.onbeforeunload = function () {//Prevent Ctrl+W
    break;
};

document.onkeydown = function (e) {
    e = e || window.event;//Get event
    if (e.ctrlKey) {
        var c = e.which || e.keyCode;//Get key code
        switch (c) {
            case 83://Block Ctrl+S
            case 87://Block Ctrl+Ws
                e.preventDefault();     
                e.stopPropagation();
            break;
        }
    }
};