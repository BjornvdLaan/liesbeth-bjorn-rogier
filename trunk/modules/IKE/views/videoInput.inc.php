<form action="/video" method="POST">
    <input type="text" name="link" value="e.g. http://www.youtube.com/......." id="link" style="width:250px;">
    <br>
    <input type="submit" name="Go Go Gadget!" value="Go Go Gadget!" label="Go Go Gadget!">
</form>

<script>
    $('#link').click( function() { if($(this).val() == 'e.g. http://www.youtube.com/.......') { $(this).val(''); }});
    $('#link').blur( function() { if($(this).val() == '') { $(this).val('e.g. http://www.youtube.com/.......'); }});
 
</script>