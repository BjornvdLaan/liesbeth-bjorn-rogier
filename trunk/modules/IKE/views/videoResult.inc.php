<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript">
    google.load("swfobject", "2.1");
</script>    
<script type="text/javascript">
    /*
     * Change out the video that is playing
     */
      
    // Update a particular HTML element with a new value
    function updateHTML(elmId, value) {
        document.getElementById(elmId).innerHTML = value;
    }
      
    // Loads the selected video into the player.
    function loadVideo() {
        var selectBox = document.getElementById("videoSelection");
        var videoID = selectBox.options[selectBox.selectedIndex].value
        
        if(ytplayer) {
            ytplayer.loadVideoById(videoID);
        }
    }
      
    // This function is called when an error is thrown by the player
    function onPlayerError(errorCode) {
        alert("An error occured of type:" + errorCode);
    }
      
    // This function is automatically called by the player once it loads
    function onYouTubePlayerReady(playerId) {
        ytplayer = document.getElementById("ytPlayer");
        ytplayer.addEventListener("onError", "onPlayerError");
    }
      
    // The "main method" of this sample. Called when someone clicks "Run".
    function loadPlayer() {
        // The video to load
        var videoID = "<?= $oModuleData->data->link ?>"
        // Lets Flash from another domain call JavaScript
        var params = { allowScriptAccess: "always" };
        // The element id of the Flash embed
        var atts = { id: "ytPlayer" };
        // All of the magic handled by SWFObject (http://code.google.com/p/swfobject/)
        swfobject.embedSWF("http://www.youtube.com/v/" + videoID + 
            "?version=3&enablejsapi=1&playerapiid=player1", 
        "videoDiv", "480", "295", "9", null, null, params, atts);
    }
    function _run() {
        loadPlayer();
    }
    
    $(document).ready(function(){
        $("#abstract").click(function(){
            $("#abstractreadmore").toggle();
        })
    
        $("#events").click(function(){
            $("#eventsCollapse").toggle();
        })
    }
)
    
    google.setOnLoadCallback(_run);
</script>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <span class="span6">
                <form class="navbar-form pull-left" action="/video" method="GET">
                    <input class="span4" type="text" name="link" value="<?= $oModuleData->data->URL ?>" id="link" style="width:350px;">
                    <button class="btn" name="Go Go Gadget!" type="submit">play</button>
                </form>
            </span>
            <span class="span4">
                <a class="brand pull-right">You are currently logged in as: <?= ucfirst($oModuleData->data->user->getUsername()) ?></a>
            </span>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="hero-unit" style="min-height: 250px; margin-top:20px">
            <div class="span6">
                <div id="videoDiv">Loading video. Please wait...</div>
            </div>

            <div class="span5" >
                <div class="row-fluid">
                    <div class="span4">
                        <div class="row-fluid"><h4>Video artist:</h4></div>
                        <div class="row-fluid"><h4>Video Title:</h4></div>
                    </div>
                    <div class="span6">
                        <div class="row-fluid"><h4><a href="<?= $oModuleData->data->spotifyLinkArtist ?>" target="_blank"><?= $oModuleData->data->song->artist ?></a> </h4></div>
                        <div class="row-fluid"><h4><a href="<?= $oModuleData->data->spotifyLinkTrack ?>" target="_blank"><?= ucwords($oModuleData->data->song->name) ?></a></h4></div>
                    </div>
                </div>


            </div>
            <div>&nbsp;</div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="hero-unit" style="padding-top:20px; padding-bottom:0">
            <h4>Recommended songs:</h4>
            <ul class="thumbnails">
                <?php
                for ($i = 0; isset($oModuleData->data->recommendations[$i]); $i++) {
                    $curr = $oModuleData->data->recommendations[$i];
                    ?>
                    <li class="span2">
                        <a href ="http://<?= IKE_APP_URI ?>/video?link=http://www.youtube.com/watch?v=<?= $curr->youtube_id ?>" class="thumbnail"  style="background-color:white">
                            <img data-src="holder.js/160x120" alt="160x120" style="width: 160px; height: 120px;" src="http://img.youtube.com/vi/<?= $curr->youtube_id ?>/0.jpg">
                            <div class="caption">
                                <p><?= $curr->artist ?> - <?= $curr->name ?></p>
</div>
                        </a>
                        <img style="width:50px;margin:7px;float:right;cursor:pointer" src="/content/img/dislike.png" class="dislike" youtube_id="<?= $curr->youtube_id ?>">
                    </li>
                <?php } ?>
            </ul>

        </div>
    </div>
    <div class="row-fluid">

        <div class="span3">
            <h3>Upcoming events</h3>
            <?php
            if (!empty($oModuleData->data->events)) {
                $amount = 0;
                foreach ($oModuleData->data->events as $entry) {
                    $amount++;
                    echo '<a href="' . $entry->uri . '">' . $entry->displayName . "</a><br>";
                    if(amount > 10){
                        break;
                    }
                }
            }
            else{
                echo'<p>Sorry, no upcoming events found.</p>';
            }
            ?>
        </div>
        <div class="span6">
            <h2 > About <?= $oModuleData->data->song->artist ?></h2>

            <p><?php
                $abstract = Echonest::$wikipedia->text;
                $first = strpos($abstract, CHAR_NL);
                $intro = nl2br(htmlentities(substr($abstract, 0, $first)), false);
                $readmore = nl2br(htmlentities(substr($abstract, $first)), false);
                echo $intro;
                ?>
                    <span id="abstractreadmore" class="hide">
                        <?= $readmore ?>
                    </span>
                <br>
                <a id="abstract" class="btn">Read more</a>
            </p>    
        </div>
        <div class="span3">
            <div class="row-fluid">
                <h3>On Spotify</h3>
                <a href="<?= $oModuleData->data->song->spotify_id ?>">Find <?= ucwords($oModuleData->data->song->name) ?></a><br>
                <a href="<?= $oModuleData->data->spotifyArtistId ?>">Find <?= $oModuleData->data->song->artist ?></a><br>
                Spotify populariteit: <?= $oModuleData->data->song->popularity ?>
            </div>
            <div class="row-fluid">
                <h3>Buy this track</h3>
                <?php if (!empty(Echonest::$itunes->url)) { ?><a href="<?= Echonest::$itunes->url ?>"><img src="/content/img/itunes.png"></a> <?php } ?>
                <?php if (!empty(Echonest::$amazon->url)) { ?><a href="<?= Echonest::$amazon->url ?>"><img src="/content/img/amazon.gif"></a><br><?php } ?>
                <?php if (!empty($oModuleData->data->spotifyLink)) { ?><a href="<?= $oModuleData->data->spotifyLinkArtist ?>"><img src="/content/img/spotify.png"></a> <?php } ?>
            </div>
            <div class="row-fluid">
                <h3>Other songs from <?= $oModuleData->data->song->artist ?></h3>
                <?php
                $count = 0;
                foreach ($oModuleData->data->allsongs as $entry) {
                    $count++;
                    echo $entry . '<br>';
                    if($count > 10){
                        break;
                    }
                } ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#link').click( function() { if($(this).val() == '<?= $oModuleData->data->URL ?>') { $(this).val(''); }});
    $('#link').blur( function() { if($(this).val() == '') { $(this).val('<?= $oModuleData->data->URL ?>'); }});
 
</script>
