<?php echo '<?xml version="1.0" encoding="ISO-8859-1" ?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>phpIPTC - Demo</title>
    </head>
    <body>
<?php

require (dirname (__FILE__) . "/phpIPTCcounter.php");

$conf = array (
    'file' => 'counter.jpg',
    'background' => '000000',
    'color' => 'FFFFFF',
);
$counter = new phpIPTCcounter ($conf);

?>
        <h1>Simpler Counter</h1>
        <img src="<?php print $counter->get (); ?>" />
<?php

print_r ($counter);

?>
    </body>
</html>
