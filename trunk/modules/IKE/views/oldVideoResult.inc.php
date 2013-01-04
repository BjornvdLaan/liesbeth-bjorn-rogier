<tr style="width:150px;text-align:left;vertical-align:top;">
    <th>Related</th>
    <td><?php
foreach ($oModuleData->data->youtube->related as $entry) {
    echo $entry->getVideoTitle() . '<br>';
}
?></td>
</tr>
<?php if (!empty($oModuleData->data->xmas)) { ?>
    <tr style="width:150px;text-align:left;vertical-align:top;">
        <th>CHristmas</th>
        <td><?php
    foreach ($oModuleData->data->xmas as $entry) {
        echo $entry . '<br>';
    }
    ?></td><?php } ?>
</tr>
 <?php if (!empty($oModuleData->data->events)) { ?>
                <tr style="width:150px;text-align:left;vertical-align:top;">
                    <th id="events">Upcoming events</th>
                    <td id="eventsCollapse"><?php
            foreach ($oModuleData->data->events as $entry) {
                echo '<a href="' . $entry->uri . '">' . $entry->displayName . "</a><br>";
            }
                ?></td>
                </tr>
            <?php } ?>