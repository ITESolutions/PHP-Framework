<!DOCTYPE html>
<html>
    <head>
        <title>ERROR</title>
    </head>
    <body style="background: #003399; color: #FFFFFF;">
        <h1>Oops!</h1>
        <p><?php echo "<strong>{$string}</strong><br /> in <em>{$file}</em> on line <em>{$line}</em>."; ?></p>
        <pre><?php var_dump($context); ?></pre>
    </body>
</html>