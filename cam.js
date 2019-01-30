function addSup(el) {
    var imageSrc = el.src;
    var sup = document.getElementById('supImage');
    // document.getElementById()
}

    var video = document.getElementById('video');
	var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');
    var sup = document.getElementById('supImage');
    var photo = document.getElementById('photo');
    
        let x = {
            video:{
                facingMode: "user",
                width: { min: 640, ideal: 1280, max: 1920 },
                height: { min: 480, ideal: 720, max: 1080 } 
            }
        };
        
if (navigator.mediaDevices === undefined){
    navigator.mediaDevices = {};
    navigator.mediaDevices.getUserMedia = function(x){
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia 
        || navigator.mozGetUserMedia || navigator.oGetUserMedia || navigator.msGetUserMedia;
        if (!getUserMedia){
            return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
        }
        return new Promise(function(resolve, reject) {
            getUserMedia.call(navigator, x, resolve, reject);
        });
    }
} else {
    navigator.mediaDevices.enumerateDevices();
}

navigator.mediaDevices.getUserMedia(x)
.then(function(mediaStreamObj) {
    video = document.querySelector('video');
    if ("srcObject" in video) {
        video.srcObject = mediaStreamObj;
    } else {
        video.src = window.URL.createObjectURL(mediaStreamObj);
    }
    video.play();
})

function mkObj() {
	var obj;
	try{
		obj = new XMLHttpRequest();
	} catch(e){
		try{
			obj = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e){
			try{
				obj = new ActiveXObject("Microsoft.XMLHTTP");
			} catch(e){
				alert("your browser is weird");	
				return false;
			}			
		}
	}
	return (obj);
}

 
function snap() {
	canvas.width = video.clientWidth;
	canvas.height = video.clientHeight;
	context.drawImage(video,0,0,canvas.width, canvas.height);

    // imh = canvas.toDataURL("image/png");
}
/*
    sticker locations x and y
    147,433
    436,429
    672,430
    120, 872
    429, 862
    673, 852
    441, 636
*/
drawnOn = 0;
x = 10;
y = 10; 
var master = document.querySelector("#stickers");
master.addEventListener("click", addSticker, false);

function addSticker(s) {
    if (s.target !== s.currentTarget)
    {
        var item = s.target.id;
        var pluck = document.getElementById(item);
        if (drawnOn === 0)
            context.drawImage(pluck, x, y, 100, 100);
        else
        {
            x += 100;
            context.drawImage(pluck, x, y, 100, 100);
        }
        drawnOn++;
    }
    s.stopPropagation();
}

function pushIt()
{  
    var imh = canvas.toDataURL("image/png");
    var poo = mkObj();

    if (!poo)
        return (false);
    else {
        var x = imh;
        poo.onreadystatechange = function (){
            if (poo.readyState == 4) {
				alert("image has been saved");
            }
        }
        poo.open("post", "pushimg.php", true);
        poo.send(x);
        // setTimeout("location.reload(true);", -1);
    }
}