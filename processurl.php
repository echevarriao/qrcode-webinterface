<?php

declare(strict_types=1);

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use App\QR\Image\QRImageWithLogo;
use App\QR\Options\LogoOptions;

require_once('vendor/autoload.php');

function qrDebug($data = "") {

if($data) {

print $data;

} else {

print "Here";

}

}

$url = $_REQUEST['url'];
$uselogo = $_REQUEST['uselogo'];
$fileseed = null;
$qr_url = "";
$qrOutputInterface = null;
$qrcode = null;
$options = null;

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Create QR Codes in PHP</title>
  <link rel="stylesheet" href="/css/styles.min.css">
</head>
<body>
<h1>Creating QR Codes in PHP</h1>
<div class = "container">
<?php if(filter_var($url, FILTER_VALIDATE_URL)) { ?>
<?php


$qr_url = 'qr-' . sha1($url . time()) . '.png';

?>
<?php 	if($uselogo == 1) {

$options = new LogoOptions(
  [
    'eccLevel' => QRCode::ECC_H,
    'imageBase64' => true,
    'logoSpaceHeight' => 17,
    'logoSpaceWidth' => 17,
    'scale' => 10,
    'version' => 7,
  ]
);

$qrOutputInterface = new QRImageWithLogo($options, (new QRCode($options))->getMatrix($url) );

$qrcode = $qrOutputInterface->dump($qr_url,  __DIR__ . '/logo/qr-husky-icon.png');

?>
<a href = "<?php print $qr_url; ?>"><img src='<?php print $qr_url ?>' alt='QR Code' width='800' height='800' /></a>
<?php

	} else {

$options = new LogoOptions(
  [
    'eccLevel' => QRCode::ECC_H,
    'imageBase64' => true,
    'logoSpaceHeight' => 1,
    'logoSpaceWidth' => 1,
    'scale' => 10,
    'version' => 7,
  ]
);

$qrOutputInterface = new QRImageWithLogo($options, (new QRCode($options))->getMatrix($url) );

$qrcode = $qrOutputInterface->dump($qr_url,  __DIR__ . '/logo/qr-blank-icon.png');

?>
  <a href = "<?php print $qr_url ?>"><img src='<?php print $qr_url ?>' alt='QR Code' width='800' height='800'></a>
<?php	} ?>

<?php } else { ?>

<p><b>invalid url</b></p>

<?php } ?>
</div>
</body>
</html>
