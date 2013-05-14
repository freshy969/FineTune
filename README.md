# FineTune

[FineTune](http://finetune.me) is a website that enables you to listen to music as you type for it. Inspired by Google's Instant Search and Feross' [YTinstant](http://ytinstant.com). Built using the SoundCloud API in about 3 hours.

## The Bookmarklet

Now instant music just got even more instant. With this bookmarklet, you can simply play any song currently highlighted on the page.

With the script below, add a Bookmark "FineTune Now", via the bookmarks bar.

    javascript:(function(){var t=window.getSelection?window.getSelection().toString():document.selection.createRange().text;window.open("http://finetune.me/?q="+encodeURIComponent(t),"_blank");})()
    
Before clicking the bookmarklet, just make sure you have text selected. Happy FineTuning!
