<html><body>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script type="text/javascript"> 
 function addField(){
  var newContent = "<input type='checkbox' name='checkboxcheck[]' value='checked'> \n";
  newContent += "Namespace  \n";
  newContent += "<input type='text' name='namespace[]'> \n";
  newContent += "<input type='text' name='namespacefull[]'> <br> \n";
  $("#morefields").append(newContent); 
  <?php $fieldcount += 1; 
  $_POST['fieldcount'] = $fieldcount;?>
 }
</script>

<form action="queryv2.php" method="post">
Select namespaces:<br>
<input type="checkbox" name="rdf" value="checked">
<label for="rdf">rdf:</label>

<input type="checkbox" name="rdfs" value="checked">
<label for="rdfs">rdfs:</label>

<input type="checkbox" name="owl" value="checked">
<label for="owl">owl:</label>

<input type="checkbox" name="foaf" value="checked">
<label for="foaf">foaf:</label>

<input type="checkbox" name="dc" value="checked">
<label for="dc">dc:</label>
<br>

<input type="checkbox" name="checkboxcheck[]" value="checked">
Namespace 
<input type="text" name="namespace[]">
<input type="text" name="namespacefull[]">
<br>
<input type="checkbox" name="checkboxcheck[]" value="checked">
Namespace 
<input type="text" name="namespace[]">
<input type="text" name="namespacefull[]">
<br>

<?php $fieldcount = 2; ?>

<div id="morefields"></div>
<a href='javascript:addField()'>add another namespace</a><br>

<label for="endpoint">Endpoint:</label>
<input type="text" name="endpoint"><br>
<label for="query">Query:</label><br>
<textarea name="query" rows="8" cols="100"></textarea><br>
<input type="submit" value="Query!">
</form>
</body></html>