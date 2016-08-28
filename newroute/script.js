var glomkarnURL = 'https://raw.githubusercontent.com/PTS-Int/webprog/master/newroute/geojson/';
var routeList = [];
var kml = [];
var map;
routeList[0] = [29, 34, '34E', 39, '39A', 52, 59, '59A', '59E', 95, '95A', 
                '106E', '107E', 126, '129E', 150, 154, 185, 187, 
                208, 209, 210, 227, 228, 229, 230, 231, 256,
                '504E', 510, '510E', 520, '522E', '524E', '538E', 543, '543A', '554E', '559E',
                'A1', 'A2'];
routeList[1] = [26, '26E', 27, 60, 71, 73, 92, 93, 94, 96, '96A',
                113, 115, 130, 131, 143, '143A', 144, 152, 168, 182, 190, 197, 198, 199,
                200, 212, 213, '213A', 215, 216, 217, 218, 219, 220, 224, 225, 226,
                501, '512E', 514, '514E', 517, 519, 525, 526, 527, 549 ,550];
routeList[2] = [2, '2E', '11A', 23, '23E', 25, '25E', 38, '45E', 46, 48,
                '102E', 116, 132, 133, '139E', '142E', 145, '145A', '145E', 162, '180E', '181E',
                207, 214, 222, 223, 232, 233, 234, 235,
                '511E', '513E', '536E', '537E', 548, 551, 552, 553];
routeList[3] = [1, 4, 12, 13, 14, 22, 36, 47, 62, 67, 72, 77, 78, 99,
                100, 136, 137, 176, 179, 195,
                205,
                518];
routeList[4] = [6, 15, 17, 20, '20A', 21, '21E', 35, 37, 42, 43, 68, 75, 76, 82, 85, 86, 87, 88,
                105, 108, 111, 120, '138E', '140E', '141E', 147, 167, '173E', '195A',
                '238E', 239, 268,
                529, '529E', '558E'];
routeList[5] = [7, 9 ,28, 40, 56, 57, 79, 80, '80A', 84, 89, '89A', 91,
                101, 118, 119, 121, 123, 124, '124A', 146, 149, 163, 164, 165, 169, 184, 189,
                201, 202,
                507, 509, 515, 539, 547, '556E'];
routeList[6] = [5, 16, 18, 30, 31, 32, 33, 50, 51, 53, '63E', 64, 66, 69, '69E', 70, 97, '97E',
                104, 112, 114, 127, 128, 134, 148, '166E', 175, 192, 194,
                203, '266E',
                '505E', 516, 528, 545,
                'C71', 'C75', 'X', 'XX', 'XXX'];
routeList[7] = [3, 8, 24, '36A', 44, 49, 54, 55, '73A',
                117, 122, 135, 153, 155, 156, 178, 191,
                204,
                '555E',
                'B', 'B1', 'B2', 'B3'];

function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
          center: {lat: 13.8478485, lng: 100.5558137}
        });

        for (var i = 0; i < routeList.length; i++) {
            kml[i] = [];
            for (var j = 0; j < routeList[i].length; j++) {
                kml[i][j] = new google.maps.Data();
                kml[i][j].loadGeoJson(glomkarnURL + routeList[i][j] + '.geojson');
                kml[i][j].setMap(map);
            }
        }
    }

$(document).ready(function() {
    var html = '<table col="5">';
    var counter = 0;
    for (var i = 0; i < routeList.length; i++) {
        html += '<tr id="' + (i + 1) + '"><td colspan="5"><label><input onclick="event.stopPropagation();" class="khet allKhet' + (i + 1) + '" type="checkbox" value="' + i + '" checked>เขต' + (i + 1) + '</label><button type="button" class="rowtoggle">Hide</button></td></tr>';
        for (var j = 0; j < routeList[i].length; j++) {
            if(j % 5 == 0) {
                html += '<tr class="rowChild' + (i + 1) + '">';
            }
            html += '<td><label><input type="checkbox" class="route khet' + (i + 1) + '" value="' + routeList[i][j] + '" checked>' + routeList[i][j] + '</label></td>';
            if(j % 5 == 4) {
                html += '</tr>';
            }
            counter++;
        }
        if(routeList[i].length % 5 != 0) {
            html += '</tr>';
        }
        html += '<tr></tr>';
    }
    html += '</table><br><div id="count">Current: ' + counter + ' / ' + counter + '</div>';
    $('#sideBar').html(html);

    $('.rowtoggle').on('click', function() {
        $('.rowChild'+$(this).parent().parent().attr('id')).toggle();
        if($(this).text() == 'Hide') {
            $(this).text('Show');
        }
        else {
            $(this).text('Hide');
        }
    });

    $('input[type=checkbox].khet').on('change', function() {
        if($(this).prop("checked")) {
            var khet = $(this).parent().parent().parent().attr('id');
            $(this).parent().parent().parent().parent().find('.khet' + khet).prop('checked', true);
            for (var i = 0; i < kml[khet - 1].length; i++) {
                kml[khet - 1][i].setMap(map);
            }
        } else {
            var khet = $(this).parent().parent().parent().attr('id');
            $(this).parent().parent().parent().parent().find('.khet' + khet).prop('checked', false);
            for (var i = 0; i < kml[khet - 1].length; i++) {
                kml[khet - 1][i].setMap(null);
            }
        }
    });

    $('input[type=checkbox].route').on('change', function() {
        var thisRoute = $(this).val();
        var found = false;
        for (var i = 0; i < routeList.length && !found; i++) {
            for (var j = 0; j < routeList[i].length; j++) {
                if(thisRoute == routeList[i][j]) {
                    if($(this).prop("checked")) {
                        for (var k = 1; k < 9; k++) {
                            if ($('.khet' + k + ':checked').length == $('.khet' + k).length) {
                                $('.allKhet' + k).prop('checked', true);
                            }
                        }
                        kml[i][j].setMap(map);
                    } else {
                        for (var k = 1; k < 9; k++) {
                            if ($('.khet' + k + ':checked').length != $('.khet' + k).length) {
                                $('.allKhet' + k).prop('checked', false);
                            }
                        }
                        kml[i][j].setMap(null);
                    }
                    found = true;
                    break;
                }   
            }
        }
        $('#count').text('Current: ' + $('.route:checked').length + " / " + $('.route').length);
    });

    $('#sideBar').resizable({
        handles: 'w,e',
        minWidth: 0.15*$(window).width(),
        maxWidth: 0.85*$(window).width()
    });

    $(window).resize(function() {
        google.maps.event.trigger(map, "resize");
    });
});