<h1>Welcome by the Awesomo 4000</h1>
<p>Login or <a href="/register">create a new account</a>!</p>

<form action="/handle-login" method="POST">
    <table>
        <tr>
            <td><input type="text" name="username" value="username" id="username"></td>
        </tr>

        <tr>
            <td><input type="password" name="password"></td>
        </tr>

        <tr>
            <td><input type="submit" name="Inloggen" value="Inloggen" label="Inloggen"></td>
        </tr>
    </table>
</form>

<script>
    $('#username').click( function() { if($(this).val() == 'username') { $(this).val(''); }});
    $('#username').blur( function() { if($(this).val() == '') { $(this).val('username'); }});
    
</script>