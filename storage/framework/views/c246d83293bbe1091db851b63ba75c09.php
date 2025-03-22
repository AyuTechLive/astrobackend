<!DOCTYPE html>
<html>
<head>
    <title>How to Create Multi Language Website in Laravel - ItSolutionStuff.com</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">

        <h1>How to Create Multi Language Website in Laravel - ItSolutionStuff.com</h1>
        <?php
        use Symfony\Component\HttpFoundation\Session\Session;
             $session = new Session();
            $locale = $session->get('locale');

        ?>
        <div class="row">
            <div class="col-md-2 col-md-offset-6 text-right">
                <strong>Select Language: </strong>
            </div>
            <div class="col-md-4">
                <select class="form-control changeLang">
                    <option value="en" <?php echo e($locale == 'en' ? 'selected' : ''); ?>>English</option>
                    <option value="fr" <?php echo e($locale == 'fr' ? 'selected' : ''); ?>>France</option>
                    <option value="es" <?php echo e($locale == 'es' ? 'selected' : ''); ?>>Spanish</option>
                </select>
            </div>
        </div>

        <h1><?php echo e(__('messages.title')); ?></h1>

    </div>
</body>

<script type="text/javascript">

    var url = "<?php echo e(route('changeLang')); ?>";

    $(".changeLang").change(function(){
        window.location.href = url + "?lang="+ $(this).val();
    });

</script>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/resources/views/lang.blade.php ENDPATH**/ ?>