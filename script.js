//main
var ts = 30;

function setZoom(){
    var s = ts+'px';
    var x = document.getElementsByTagName("td");
    var i;
    for (i = 0; i < x.length; i++) {
        x[i].style.height = s;
        x[i].style.minWidth = s;
    }
}

function zoomIn(){
    if (ts < 128){
        ts += 2;
        setZoom();
    }
}

function zoomOut(){
    if (ts > 8){
        ts -= 2;
        setZoom();
    }
}

function createListener(){
    document.body.addEventListener("scroll", function() {checkTop()});
}

function checkTop(){
    var position = document.body.scrollTop;
    if (position == 0){
        document.getElementById('menuBar').style.backgroundColor = 'rgba(50,150,0,1)';
    } else{
        document.getElementById('menuBar').style.backgroundColor = 'rgba(50,150,0,0.7)';
    }
}

//home
function showHideCustom(){
	if (document.getElementById('mapTypeBox').value == '1'){
		document.getElementById('aValue').value = 6;
		document.getElementById('bValue').value = 4;
		document.getElementById('cValue').value = 3;
		document.getElementById('dValue').value = 0;
		document.getElementById('eValue').value = 0;
		document.getElementById('fValue').value = 0;
		document.getElementById('landRadio').checked = true;
		document.getElementById('waterRadio').checked = false;
	} else if (document.getElementById('mapTypeBox').value == '2'){
		document.getElementById('aValue').value = 5;
		document.getElementById('bValue').value = 4;
		document.getElementById('cValue').value = 2;
		document.getElementById('dValue').value = 0;
		document.getElementById('eValue').value = 0;
		document.getElementById('fValue').value = 0;
		document.getElementById('landRadio').checked = true;
		document.getElementById('waterRadio').checked = false;
	} else if (document.getElementById('mapTypeBox').value == '3'){
		document.getElementById('aValue').value = 6;
		document.getElementById('bValue').value = 4;
		document.getElementById('cValue').value = 3;
		document.getElementById('dValue').value = 0;
		document.getElementById('eValue').value = 0;
		document.getElementById('fValue').value = 0;
		document.getElementById('landRadio').checked = false;
		document.getElementById('waterRadio').checked = true;
	} else if (document.getElementById('mapTypeBox').value == '4'){
		document.getElementById('aValue').value = "";
		document.getElementById('bValue').value = "";
		document.getElementById('cValue').value = "";
		document.getElementById('dValue').value = "";
		document.getElementById('eValue').value = "";
		document.getElementById('fValue').value = "";
		document.getElementById('landRadio').checked = false;
		document.getElementById('waterRadio').checked = false;
	}
}

//password
function showHidePassword(){
	if (document.getElementById('passwordButton').innerHTML == '<i class="fa fa-eye-slash"></i>'){
		document.getElementById('passwordButton').innerHTML = '<i class="fa fa-eye"></i>';
		document.getElementById('passwordBox').type = 'text';
	} else if (document.getElementById('passwordButton').innerHTML == '<i class="fa fa-eye"></i>'){
		document.getElementById('passwordButton').innerHTML = '<i class="fa fa-eye-slash"></i>';
		document.getElementById('passwordBox').type = 'password';
	}
}

//message
var boxOpacity = 1;

function hideMessage(){
	setTimeout(hide,5000);
}

function hide(){
	setInterval(decreaseOpacity, 50);
}

function decreaseOpacity(){
	if (boxOpacity > 0){
		boxOpacity -= 0.03;
		document.getElementById('messageBox').style.opacity = boxOpacity;
	} else {
		document.getElementById('messageBox').style.display = 'none';
		clearInterval();
	}
}