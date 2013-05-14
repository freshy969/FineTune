<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>FineTune | A radio knob, but with a keyboard</title>
        <link rel="shortcut icon" href="http://kenlauguico.com/favicon.ico" type="image/x-icon"/>
        <link rel="icon" href="http://kenlauguico.com/favicon.ico" type="image/x-icon"/>
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <style>
            html, body {
                height: 100%;
                /* The html and body elements cannot have any padding or margin. */
            }
            ul.typeahead {
                text-align: left !important;
            }
            .brand, #songsearch {
                display: none;
            }
            
            /* BG FIXED */
            .front-bg {
                position: fixed;
                display: none;
                width: 200%;
                height: 200%;
                left: -50%;
                top: -15%;
                z-index: -1;
                opacity: .75;
                filter:alpha(opacity=75);
            }
            .front-img {
                display: block;
                width: auto;
                margin: auto;
                min-width: 50%;
                min-height: 50%;
            }
            
            /* STICKY FOOTER */
            #wrap {
                min-height: 100%;
                height: auto !important;
                height: 100%;
                /* Negative indent footer by it's height */
                margin: 0 auto -60px;
            }
            #footer {
                height: 60px;
                margin-top: -60px;
                background-color: #f5f5f5;
            }
            .container .credit {
                margin: 20px 0;
            }
            
            #nowplaying {
                white-space: nowrap;
                display: block;
                position: relative;
                overflow: hidden;
                width: 430px;
                max-height: 20px;
                text-align: left;
            }
            
            .custom-tweet-button,
            .custom-follow-button {
              width: 200px;
              margin: 1em auto 2em;
            }  
            .custom-tweet-button a {
              position: relative;
              display: inline-block;
              height: 16px;
              padding: 2px;
              border: 1px solid #ccc;
              font-size: 11px;
              color: #333;
              text-decoration: none;
              text-shadow: 0 1px 0 rgba(255, 255, 255, .5);
              font-weight: bold;
              background-color: #F8F8F8;
              background-image: -webkit-gradient(linear,left top,left     bottom,from(#FFF),to(#DEDEDE));
              background-image: -moz-linear-gradient(top,#FFF,#DEDEDE);
              background-image: -o-linear-gradient(top,#FFF,#DEDEDE);
              background-image: -ms-linear-gradient(top,#FFF,#DEDEDE);
              border: #CCC solid 1px;
              -moz-border-radius: 3px;
              -webkit-border-radius: 3px;
              border-radius: 3px;
              cursor: pointer;
              overflow: hidden;
            }
            .custom-tweet-button a:hover  {
              border-color: #BBB;
              background-color: #F8F8F8;
              background-image: -webkit-gradient(linear,left top,left bottom,from(#F8F8F8),to(#D9D9D9));
              background-image: -moz-linear-gradient(top,#F8F8F8,#D9D9D9);
              background-image: -o-linear-gradient(top,#F8F8F8,#D9D9D9);
              background-image: -ms-linear-gradient(top,#F8F8F8,#D9D9D9);
              background-image: linear-gradient(top,#F8F8F8,#D9D9D9);
              -webkit-box-shadow: none;
              -moz-box-shadow: none;
              box-shadow: none;
            }
            .custom-tweet-button a .btn-icon {
              position: absolute;
              width: 16px;
              height: 13px;
              top: 50%;
              left: 3px;
              margin-top: -6px;
              background: url('https://twitter.com/favicons/favicon.ico') 1px center no-repeat;
            }
            .custom-tweet-button a .btn-text {
              display: block;
              padding: 0px 3px 0 20px;
              margin-top: -2px;
            }
            
            /* BOOKMARKLET */
            .bookmarklet {
                position: absolute;
                top: 10px;
                right: 10px;
                width: 200px;
                text-align: right;
            }
            .bookmarklet small {
                visibility: hidden;
            }
            
            .bookmarklet:hover small {
                visibility: visible;
            }
            
        </style>
    </head>
    <body>
        <div id="wrap">
            <div class="container" style="text-align: center;">
                <div class="brand" style="padding-top: 150px; padding-bottom: 20px;"><a class="ft" href="#"><img src="img/finetune.png"></a></div>
                <input id="songsearch" type="text" data-provide="typeahead" placeholder="Tune in as you type..." autocomplete="off" style="width: 70%; border: 5px solid gray; border-radius: 10px; padding: 5px;" value="<?php echo $_GET["q"]; ?>" autofocus="autofocus" />
                <div class="share" style="display: none; padding-top: 10px;">
                    <div class="custom-tweet-button">
                      <a href="https://twitter.com/intent/tweet?url=<?php echo "http://kenlauguico.com/ft"; if($_GET["q"]!="") echo "?q=".urlencode($_GET["q"]); ?>&amp;text=%23NowPlaying" target="_blank" alt="Tweet #NowPlaying">
                        <i class="btn-icon"></i>
                        <span class="btn-text">Tweet #NowPlaying</span>
                      </a>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer">
            <div class="container">
                <div class="muted credit">Created by <a href="http://kenlauguico.com">Ken Lauguico</a> with <a href="http://developers.soundcloud.com/">SoundCloud API</a> and <a href="http://en.wikipedia.org/wiki/Magic_(paranormal)">Magic</a>. <div id="nowplaying" class="pull-right" style="display: none;"></div></div>
            </div>
        </div>
        <div class="front-bg">
            <img class="front-img" alt="">
        </div>
        <div class="bookmarklet">
            <a class="btn btn-mini" href='javascript:(function(){var t=window.getSelection?window.getSelection().toString():document.selection.createRange().text;window.open("http://finetune.me/?q="+encodeURIComponent(t),"_blank");})()'>FineTune Now</a>
            <p>
                <small>Drag this to your bookmarks bar to create the FineTune bookmarklet!<br>(Just make sure text is selected before you use it!)</small>
            </p>
        </div>
        <div id="player" style="position: absolute; top: -300%; left: 0;"></div>
        <script src="http://connect.soundcloud.com/sdk.js"></script>
        <script src="https://w.soundcloud.com/player/api.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="js/bootstrap-typeahead.js"></script>
        <script src="js/finetune.js" type="text/javascript"></script>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        <!-- Start of StatCounter Code for Default Guide -->
        <script type="text/javascript">
        var sc_project=8894826; 
        var sc_invisible=1; 
        var sc_security="2dc5300c"; 
        var scJsHost = (("https:" == document.location.protocol) ?
        "https://secure." : "http://www.");
        document.write("<sc"+"ript type='text/javascript' src='" +
        scJsHost+
        "statcounter.com/counter/counter.js'></"+"script>");
        </script>
        <noscript><div class="statcounter"><a title="hits counter"
        href="http://statcounter.com/free-hit-counter/"
        target="_blank"><img class="statcounter"
        src="http://c.statcounter.com/8894826/0/2dc5300c/1/"
        alt="hits counter"></a></div></noscript>
        <!-- End of StatCounter Code for Default Guide -->
    </body>
</html>