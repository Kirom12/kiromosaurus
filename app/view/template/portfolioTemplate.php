<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="js/jquery.js"></script>
    <?php echo \Core\Tools\Debug::renderBar(true) ?>
</head>
<body>
    <?php echo $content; ?>
    <?php echo \Core\Tools\Debug::renderBar() ?>
</body>
</html>