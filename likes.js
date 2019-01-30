function mkObj(){
	var request;

	try{
		request = new XMLHttpRequest();
	} catch(e){
		try{
			request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch(e){
			try{
				request = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				alert("Your browser is weird");
				return false;
			}
		}
	}
	return request;
}

var butt = document.getElementById("like");
butt.addEventListener("click", poo, false);

function poo() {
	var request = mkObj();
	if (!request)
		return;
	else
	{
÷		// var like_views = document.getElementById('display_likes');
		request.onreadystatechange = function ()
		{
			if (request.readyState == 4 && request.status == 200)
			{
				let like_views = document.getElementById('display_likes');
				alert(request.responseText);
				like_views.innerHTML = "fuck off";
			}
		}
		request.open("post", "get_likes.php", true);
		// request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		request.send("like=" + butt.value);
		butt.stopPropagation();
	}
}

