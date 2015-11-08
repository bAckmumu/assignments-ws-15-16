/////////////////////////////////////////////////////////////
//
// Author Scott Herbert (www.scott-herbert.com)
//
// Version History 
// 1 (10-Feb-2013) Inital release on to GitHub.
//
// Download from http://adf.ly/IvElY

function getCookie(c_name)
{
var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++)
  {
  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  x=x.replace(/^\s+|\s+$/g,"");
  if (x==c_name)
    {
    return unescape(y);
    }
  }
}


function displayNotification(c_action)
{

// this sets the page background to semi-transparent black should work with all browsers
var message = "<div id='cookiewarning' >";

// center vert
message = message + "<div style='margin:0px;padding:30px;width:100%;height:100px;background:red;color:white'>";

// this is the message displayed to the user.
message = message + "In order for this site to work correctly, and for us to improve the site we need to store a small file (called a cookie) on your computer.<br/> Most every site in the world does this, however since the 25th of May 2011, by law we have to get your permission first.<br/> If you click agree below we will store cookies and you'll notice no diffence, if you click on I don't agree then this site won't work so we'll re-direct you to Google<br/>";
	
	
// Displays the I agree/disagree buttons.
// Feel free to change the address of the I disagree redirection to either a non-cookie site or a Google or the ICO web site 
    message = message + "<br /><INPUT TYPE='button' VALUE='I Agree' onClick='JavaScript:doAccept();' /> <INPUT TYPE='button' VALUE=\"I don't agree\" onClick='JavaScript:doNotAccept("
	message = message + c_action;
	message = message + ");' />";
	
// and this closes everything off.
message = message + "</div></div>";

document.writeln(message);
}

function doAccept() {
    setCookie("jsCookieCheck", null, 365);
    location.reload(true);
}

function doNotAccept(c_action) {

	if (c_action == 1) {
		setCookie("jsNoCookieCheck", null, 365);
		location.reload(true);
	} else {
		window.location.replace("https://www.google.com/");
	}
}

function setCookie(c_name,value,exdays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
document.cookie=c_name + "=" + c_value;

// set cookiewarning to hidden.
var cw = document.getElementById("cookiewarning");
cw.innerHTML = "";
}

function checkCookie(c_action) {

    var cookieName = "jsCookieCheck";
    var cookieNameNo = "jsNoCookieCheck";
    var cookieChk = getCookie(cookieName);
    var cookieChkNo = getCookie(cookieNameNo);
    if (cookieChk != null && cookieChk != "") {
        // the jsCookieCheck cookie exists so we can assume the person has read the notification
        // within the last year and has accepted the use of cookies

        setCookie(cookieName, cookieChk, 365); // set the cookie to expire in a year.
    }
    else if (cookieChkNo != null && cookieChkNo != "") {
        // the jsNoCookieCheck cookie exists so we can assume the person has read the notification
        // within the last year and has declined the use of cookies

        setCookie(cookieNameNo, cookieChkNo, 365); // set the cookie to expire in a year.
    }
    else {
        // No cookie exists, so display the lightbox effect notification.
        displayNotification(c_action);
    }
}

// blockOrCarryOn - 1 = Carry on, store a do not store cookies cookie and carry on
//					0 = Block, redirect the user to a different website (google for example)
var blockOrCarryOn = 1;
checkCookie(blockOrCarryOn);

