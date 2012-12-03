<div class="container-fluid">
    <h1>Welcome by the Awesomo 4000.</h1>
    <form class="form-signin" action="/handle-login" method="POST">
        <h3 class="form-signin-heading">Login or <a href="/register">create a new account</a>!</h3>
        <div class="row-fluid">
            <input class="input-block-level" type="text" name="username" placeholder="Username" id="username" style="width:250px;">
        </div>
        <div class="row-fluid">
             <input class="input-block-level" type="password" name="password" placeholder="Password" style="width:250px;">
        </div>
        <input class="input-block-level" type="submit" name="Inloggen" value="Log in" label="Inloggen">

    </form>
</div>

<script type="text/javascript">
    $('#username').click( function() { if($(this).val() == 'username') { $(this).val(''); }});
    $('#username').blur( function() { if($(this).val() == '') { $(this).val('username'); }});
    
</script>