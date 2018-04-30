(function() {

    $("a.scrollto").click(function() {
        var elementClick = $(this).attr("href")
        var destination = $(elementClick).offset().top;
        jQuery("html:not(:animated),body:not(:animated)").animate({
            scrollTop: destination
        }, 800);
        return false;
    });

    $( "#channeldisplayname1" ).hover(function() {
      $("#channelalt1").style="display: block";
    });
    $( "#channeldisplayname2" ).hover(function() {
      $("#channelalt2").style="display: block";
    });
    $( "#channeldisplayname3" ).hover(function() {
      $("#channelalt3").style="display: block";
    });

    function matchBetClose(){
        document.getElementById("match_bet").style="display: none";
    }

    function channelSwitch1(){
        document.getElementById("image").style="margin-left: -100%";
    }
    function channelSwitch2(){
        document.getElementById("image").style="margin-left: -200%";
    }
    function channelSwitch3(){
        document.getElementById("image").style="margin-left: -300%";
    }

    $(document).ready(function(){
        var url = "https://api.twitch.tv/kraken/streams/ESL_SC2?client_id=v1gmd0bdz5l8hbzzg9cbm624tf3c4h";
        $.getJSON(url).done(function(data){
            if(data.stream === null) {
                $('#channelstatus').html('OFFLINE');
            } else {
                $('#channelstatus').html('ONLINE');
            }
        });
    });

});

