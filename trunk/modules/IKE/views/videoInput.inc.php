<form action="/video" method="POST">
    <input type="text" name="link" value="<?=$oModuleData->data->URL?>" id="link" style="width:250px;">
    <br>
    <input type="submit" name="Go Go Gadget!" value="Go Go Gadget!" label="Go Go Gadget!">
</form>

<script>
    $('#link').click( function() { alert($(this).val() == '<?=$oModuleData->data->URL?>'); if($(this).val() == '<?=$oModuleData->data->URL?>') { $(this).val(''); }});
    $('#link').blur( function() { if($(this).val() == '') { $(this).val('<?=$oModuleData->data->URL?>'); }});
 
</script>