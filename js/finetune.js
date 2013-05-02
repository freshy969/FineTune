SC.initialize({
    client_id: 'c767f9cf0126a3eff8bbfacbd44d0508'
});
var search;
var autocomTracks = [];
$('#songsearch')
    .keyup(function (e) {
        function searchNow(box) {
            if (search != box.val().trim() && box.val().trim() != "") {
                search = box.val();
                searchChange();
                clearTimeout(timer);
            }
        }
        if (e.keyCode == 32) { // when space is pressed
            searchNow($(this));
        } else if (e.keyCode == 13) { // when enter is pressed
            search = $(this).val();
            setTimeout(function () {
                location = "?q=" + search.replace(/\s/g,"+");
            }, 300);

        }
        clearTimeout(timer);
        timer = window.setTimeout(searchNow($(this)), 800);
    })
    .change(function () {
        if (search != $(this).val().trim()) {
            search = $(this).val();
            searchChange();
        }
    });

function searchChange() {
    SC.get('/tracks', { q: search, order: "hotness", type: "original" }, function (tracks) {
        loadAndPlay(tracks[0].title, tracks[0].permalink_url);
        $.getJSON('d', { id: tracks[0].id })
        .done(function (data) {
            $('.ft').attr('href', data);
        });
        for (var i = 0; i < 6; i++) {
            autocomTracks.push(tracks[i].title);
        }
        $.unique(autocomTracks);
    });
}
var prev_track_url;
function loadAndPlay(title, track_url) {
    if (prev_track_url == track_url)
        return;
    prev_track_url = track_url;
    SC.oEmbed(track_url, { auto_play: true, iframe: true }, function (oEmbed) {
        document.getElementById('player').innerHTML = oEmbed.html;
        iframeElement   = document.querySelector('iframe');
        iframeElementID = iframeElement.id;
        widget1         = SC.Widget(iframeElement);
        widget2         = SC.Widget(iframeElementID);
        // widget1 === widget2
    });
    showPlaying(title, track_url);
}
var timer;
function showPlaying(name, url) {
    $('#nowplaying').fadeOut();
    clearTimeout(timer);
    timer = window.setTimeout($('#nowplaying')
        .html('Now playing: <a href="' + url + '" target="_new">' + name + '</a><div style="position:absolute; right: 0px; top: 0px;display: block;width: 50px;height: 100%;background-image: -webkit-linear-gradient(right, #F5F5F4, rgba(245, 245, 245, 0.67), rgba(245, 245, 245, 0));"></div>')
        .fadeIn(300), 3000);
    tweetHref = "https://twitter.com/intent/tweet?url=http://kenlauguico.com/ft/?q="+search.replace(/\s/g,'%2B')+"&text=%23NowPlaying " + name;
    $('.custom-tweet-button a').attr('href', tweetHref);
}

$(document).ready(function () {
    $('#songsearch').typeahead({ source: autocomTracks, items: 6, minLength: 4 });
    $('.brand').delay(200).fadeIn();
    //$('.front-bg').delay(600).fadeIn('slow');
    $('#songsearch').delay(600).fadeIn().delay(50).focus();
    $('.share').delay(600).fadeIn();
    if ($('#songsearch').val() != '') {
        search = $('#songsearch').val();
        searchChange();
    } /* else {
        $('#songsearch').val("coachella 2013");
        search = $('#songsearch').val();
        searchChange();
    }*/
});

var iframeElement, iframeElementID, widget1, widget2;