var map;
var marker = [];
var curData = -1;
var markerPass = [];

function initMap() {
	map = new google.maps.Map(document.getElementById('map'), {
		  center: {lat: 13.7158627, lng: 100.533302},
		  zoom: 12
		});
	
	initMarker();
	}

function initMarker() {
    var image = "http://maps.google.com/mapfiles/markerP.png";
	marker[0] = new google.maps.Marker({
    	position: {lat:13.632189, lng:100.506187},
    	map: map,
        icon: image,
    	animation: google.maps.Animation.BOUNCE,
    	title:"Home"
	});
    markerPass[0] = false;

	marker[1] = new google.maps.Marker({
    	position: {lat:13.740388, lng:100.532430},
    	map: map,
        icon: image,
    	animation: google.maps.Animation.DROP,
    	title:"High School"
	});
    markerPass[1] = false;

    marker[2] = new google.maps.Marker({
        position: {lat:13.756755, lng:100.532583},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP,
        title:"O-Net"
    });
    markerPass[2] = false;

	marker[3] = new google.maps.Marker({
    	position: {lat:13.737053, lng:100.533202},
    	map: map,
        icon: image,
    	animation: google.maps.Animation.DROP,
    	title:"University"
	});
    markerPass[3] = false;

    marker[4] = new google.maps.Marker({
        position: {lat:13.735574, lng:100.530980},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP,
        title:"Chess"
    });
    markerPass[4] = false;

    marker[5] = new google.maps.Marker({
        position: {lat:37.367637, lng:-121.918128},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP,
        title:"Battle Town"
    });
    markerPass[5] = false;

    marker[6] = new google.maps.Marker({
        position: {lat:34.048713, lng:-118.444870},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP,
        title:"PONG"
    });
    markerPass[6] = false;

    marker[7] = new google.maps.Marker({
        position: {lat:13.652033, lng:100.496916},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP,
        title:"Sparta"
    });
    markerPass[7] = false;

    marker[8] = new google.maps.Marker({
        position: {lat:13.746301, lng:100.498528},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP,
        title:"Line Tracking Car"
    });
    markerPass[8] = false;

    marker[9] = new google.maps.Marker({
        position: {lat:13.735954, lng:100.533877},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP,
        title:"PlanetWar"
    });
    markerPass[9] = false;

    marker[10] = new google.maps.Marker({
        position: {lat:13.650464, lng:100.488245},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP,
        title:"Speech recognition Chess"
    });
    markerPass[10] = false;

    marker[11] = new google.maps.Marker({
        position: {lat:13.739022, lng:100.527643},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP,
        title:"Gender Detection"
    });
    markerPass[11] = false;

	marker[12] = new google.maps.Marker({
    	position: {lat:13.726938, lng:100.531594},
    	map: map,
        icon: image,
    	animation: google.maps.Animation.DROP,
    	title:"Internship"
	});
    markerPass[12] = false;

    marker[13] = new google.maps.Marker({
        position: {lat:13.735898, lng:100.525421},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP,
        title:"Software Engineering"
    });
    markerPass[13] = false;
	
	marker[14] = new google.maps.Marker({
    	position: {lat:18.809349, lng:100.792244},
    	map: map,
        icon: image,
    	animation: google.maps.Animation.DROP,
    	title:"Bitbyte Camp"
	});
    markerPass[14] = false;

    marker[15] = new google.maps.Marker({
        position: {lat:13.760378, lng:100.537899},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP,
        title:"King Power"
    });
    markerPass[15] = false;

    marker[16] = new google.maps.Marker({
        position: {lat:13.738715, lng:100.529623},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP,
        title:"Senior Project"
    });
    markerPass[16] = false;

    marker[17] = new google.maps.Marker({
        position: {lat:13.738789, lng:100.529125},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP,
        title:"Transcript"
    });
    markerPass[17] = false;

	marker[18] = new google.maps.Marker({
    	position: {lat:13.743942, lng:100.562809},
    	map: map,
        icon: image,
    	animation: google.maps.Animation.DROP,
    	title:"English"
	});
    markerPass[18] = false;

	marker[19] = new google.maps.Marker({
    	position: {lat:13.767015, lng:100.573756},
    	map: map,
        icon: image,
    	animation: google.maps.Animation.DROP,
    	title:"Maps"
	});
    markerPass[19] = false;

	for (var i = 0; i < marker.length; i++) {
		with ({j:i}) {
			marker[i].addListener('click',function() {
				return displayContent(j);
			});
		}
	}
}

function displayContent(i) {
    curData = i;
	map.panTo(marker[i].position);
	map.setZoom(16);
    for (var j = 0; j < marker.length; j++) {
        if(i!=j) marker[j].setAnimation(null);
    }
    marker[i].setAnimation(google.maps.Animation.BOUNCE);
    markerPass[i] = true;
    $("#sideBar").animate({
        left: "0px"
    }, 700);
    $("#sideBar").html("");
	loadDoc(i);
}

function loadDoc(i) {
	  var xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	     document.getElementById("sideBar").innerHTML = xhttp.responseText;
	    }
	  };
	  xhttp.open("GET", "data/data"+i+".html", true);
	  xhttp.send();
}

$(document).ready(function() {
    $("#sideBar").on("click", ".close", function(){
        $("#sideBar").animate({
            left: "-400px"
        }, 700);
        marker[curData].setIcon("http://maps.google.com/mapfiles/marker.png");
        marker[curData].setAnimation(null);
        bounce();
    });
    $("#sideBar").on("click", ".next", function(){
        marker[curData].setIcon("http://maps.google.com/mapfiles/marker.png");
        marker[curData].setAnimation(null);
        displayContent(curData+1);
    });
    $("#sideBar").on("click", ".previous", function(){
        marker[curData].setIcon("http://maps.google.com/mapfiles/marker.png");
        marker[curData].setAnimation(null);
        displayContent(curData-1);
    });
})

function bounce(){
    for (var i = 0; i < markerPass.length; i++) {
        if(!markerPass[i]) {
            marker[i].setAnimation(google.maps.Animation.BOUNCE);
            break;
        }
    }
}