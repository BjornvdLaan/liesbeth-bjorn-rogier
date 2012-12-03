<div class="container-fluid">
    <h4>Your registration completed successfully.</h4>
    <form class="form-signin" action="/handle-login" method="POST">
        <h3 class="form-signin-heading">Login with your new account!</h3>
        <input class="input-block-level" type="text" name="username" placeholder="Username" id="username">

        <input class="input-block-level" type="password" name="password" placeholder="Password">

        <input class="input-block-level" type="submit" name="Inloggen" value="Log in">

    </form>
</div>

<script type="text/javascript">
    $('#username').click( function() { if($(this).val() == 'username') { $(this).val(''); }});
    $('#username').blur( function() { if($(this).val() == '') { $(this).val('username'); }});
    
</script>
