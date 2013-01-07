<div class="container-fluid">
    <h1>Dear <?= ucfirst($oModuleData->data->user->getUsername()) ?>,</h1>

    <h2>Welcome to Awesomo 4000, where a simple video turns into so much more.</h2>

    <?php include('videoInput.inc.php'); ?>
</div>