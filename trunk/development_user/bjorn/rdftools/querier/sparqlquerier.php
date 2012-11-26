<html><body>
<form action="query.php" method="post">
Selecteer namespaces:<br>
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
<input type="checkbox" name="checkbox1" value="checked">
<label for="checkbox1">Namespace 1</label>
<input type="text" name="namespace1">
<input type="text" name="namespace1full">
<br>
<input type="checkbox" name="checkbox2" value="checked">
<label for="checkbox2">Namespace 2</label>
<input type="text" name="namespace2">
<input type="text" name="namespace2full">
<br>
<input type="checkbox" name="checkbox3" value="checked">
<label for="checkbox3">Namespace 3</label>
<input type="text" name="namespace3">
<input type="text" name="namespace3full">
<br>
<form action="query.php" method="post">
<input type="checkbox" name="checkbox4" value="checked">
<label for="checkbox1">Namespace 4</label>
<input type="text" name="namespace4">
<input type="text" name="namespace4full">
<br>

<label for="endpoint">Endpoint:</label>
<input type="text" name="endpoint"><br>
<label for="query">Query:</label><br>
<textarea name="query" rows="8" cols="100"></textarea><br>
<input type="submit" value="Query!">
</form>
</body></html>