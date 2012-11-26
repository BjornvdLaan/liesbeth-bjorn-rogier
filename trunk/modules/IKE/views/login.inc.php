<div class="container-fluid">
    <h1>Welcome by the Awesomo 4000.</h1>
    
    <div class="container">
        <form class="form-signin" action="/handle-login" method="POST">
            <h3 class="form-signin-heading">Login or <a href="/register">create a new account</a>!</h2>
                <input class="input-block-level" type="text" name="username" placeholder="Username" id="username">

                <input class="input-block-level" type="password" name="password" placeholder="Password">

                <input type="submit" name="Inloggen" value="Log in" label="Inloggen">

        </form>
    </div>
</div>

<script>
    $('#username').click( function() { if($(this).val() == 'username') { $(this).val(''); }});
    $('#username').blur( function() { if($(this).val() == '') { $(this).val('username'); }});
    
</script>