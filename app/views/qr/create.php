<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>QRCode HTML Example</title>
	<style>
		div.qrcode{
			margin: 1em;
		}

		/* rows */
		div.qrcode > div {
			height: 10px;
		}

		/* modules */
		div.qrcode > div > span {
			display: inline-block;
			width: 10px;
			height: 10px;
		}
	</style>
</head>
<body>
<?php echo $qr_code; ?>
</body>
</html>