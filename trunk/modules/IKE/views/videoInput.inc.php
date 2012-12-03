<form class="form-actions" action="/video" method="POST">
    <p>Copy your music link here:</p>
    <input class="input-block-level" type="text" name="link" value="<?= $oModuleData->data->URL ?>" id="link" style="width:350px;">
    <br>
    <input class="input-block-level" type="submit" name="Go Go Gadget!" value="Go Go Gadget!">
</form>

<script type="text/javascript">
    $('#link').click( function() { if($(this).val() == '<?= $oModuleData->data->URL ?>') { $(this).val(''); }});
    $('#link').blur( function() { if($(this).val() == '') { $(this).val('<?= $oModuleData->data->URL ?>'); }});
 
</script>