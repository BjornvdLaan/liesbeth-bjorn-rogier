<?php
$youtuberelated;

for($j = 0; $j <5; $j++){
    $youtuberelated[$j] = $oModuleData->data->youtube->related[$j];
}

for ($i = 5; $i < 10 && isset($oModuleData->data->recommendations[$i]); $i++) {
    $youtuberelated[$i] = $oModuleData->data->recommendations[$i-5]; 
}

$test = shuffle($youtuberelated);

 for ($i = 0; $i < 5 && isset($test[$i]); $i++) {
                    $curr = $test[$i];
                    ?>
                    <li class="span2" style="background-color:white">
                        <a href ="http://<?= IKE_APP_URI ?>/video?link=http://www.youtube.com/watch?v=<?= $curr->youtube_id ?>" class="thumbnail">
                            <img data-src="holder.js/160x120" alt="160x120" style="width: 160px; height: 120px;" src="http://img.youtube.com/vi/<?= $curr->youtube_id ?>/0.jpg">
                            <div class="caption">
                                <p><?= $curr->artist ?> - <?= $curr->name ?></p>

                            </div>
                        </a></li>
  <?php                      
}
?>
