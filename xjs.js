
function assertPassword()
{
	var pwd = document.getElementById("password");
	var re_pwd = document.getElementById("passwd_verify");
	if (pwd.value !== re_pwd.value)
	{
		re_pwd.setCustomValidity("these passwords are not the same");
	}
	else
	{
		re_pwd.setCustomValidity("");
	}
}

function loginSpam() {
	var request = mkObj();
	if (!request)
		return (false);
	else {
		var user = document.getElementById("uname");
		request.onreadystatechange = function() {
			if (request.readyState == 4){
				if (request.responseText === "fuckoff"){
					user.setCustomValidity("account hasn't been activated");
				}
				else if (request.responseText === "letthemin"){
					user.setCustomValidity("");
				}      
				else {
					user.setCustomValidity("lol");
				}
			}            
		}
	}
	request.open("GET", "./check.php?login=yes&username=" + user.value , true);
	request.send();
}

function enterState() {
	var x = mkObj();
	
	if (!x)
		return (false);
	else {
		var uname = document.getElementById("uname");
		var pwd = document.getElementById("pwd");
		x.onreadystatechange = function () {
			if (x.readyState == 4)
			{
				if (x.responseText === "invalid combo")
				{
					uname.setCustomValidity("invalid username/password");
					preventDefault();
				}
				else if (x.responseText === "login")
				{
					uname.setCustomValidity("");
				}
				else if (x.responseText === "account hasn't been activated")
				{
					uname.setCustomValidity("account hasn't been activated");
					preventDefault();
				}
			}
		};
		x.open("POST", "window.location.PathName", true);
		x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		x.send("username=" + uname.value + "&password=" + pwd.value);
	}
}

function handle_response() {
	var obj = mkObj();

	if (!obj)
		return (false);
	else {
		var field = document.getElementById("uname");
		obj.onreadystatechange = function() {
			if (obj.readyState == 4) {				
				if (obj.responseText === "found") {
					field.setCustomValidity("username has been taken");
					preventDefault();
				}					
				else{
					field.setCustomValidity("");
				}					
			}
		}
		obj.open("GET", "http://localhost:8080/camagru/check.php?login=no&username=" + field.value, true);
		obj.send();
	}
}

function getData(username){
	var dataR = mkObj();
	// var username = $_GET['login'];

	if (!dataR)
		return (false);
	else {
		// var uname, pwd, email;
		// uname = document.getElementById("uname");
		// pwd = document.getElementById("pwd");
		// email = document.getElementById("email");
		// aler t("dead inside");
		dataR.onreadystatechange = function() {
			if (dataR.readyState == 4) {
				// alert("i live");
				if (dataR.responseText) {
					var x = JSON.parse(dataR.responseText);
					for (var property in x)
					{
						var p = document.createElement("span");
						var q = document.createTextNode(" " + x[property]);
						p.appendChild(q);
						document.getElementById(property).appendChild(p);
					}		
				}
			}
		}
		dataR.open("GET","http://localhost:8080/camagru/check.php?details=view&username="+username ,true);
		dataR.send();	
	}
}

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

