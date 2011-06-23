<!DOCTYPE html>
<html>
	<head>
		<meta charset=utf-8 />
		<title>pdfMerger @ bad-science.net</title>
		<link rel="stylesheet" type="text/css" media="screen" href="file-uploader/client/fileuploader.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="file-uploader/client/fileuploader.js"></script>
		<script type="text/javascript">
			function createUploader() {
				var uploader = new qq.FileUploader({
					element: document.getElementById('file-uploader'),
					action: 'file-uploader/server/php.php', // path to server-side upload script
					debug: true
				});
			}
			window.onload = createUploader;

			$(document).ready(function() {
				$('#mergebutton').click(function() {
					var dataString=$('form').serialize();
					$.ajax({
						url: 'merge.php',
						data: dataString,
						success: function(data) {
							$('#info').html(data);
						},
						error: function() {
							alert('some kind of error occured');
						}
					});				
				});
			});
		</script>
		<style type="text/css">
			* { list-style-type: none }
		</style>
	</head>
	<body>
		<div id="info">
		</div>
		<div id="file-uploader">       
			<noscript><p>Please enable JavaScript to use file uploader.</p></noscript>         
		</div>
		<div id="filesOnServer">
		<form id="filesToMerge">
		<ul>
			<?php
			$i = 0;
			if ($handle = opendir('uploads')) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != "..") {
						echo "<li><input type=\"checkbox\" name=\"file_{$i}\" value=\"{$file}\" />{$file}</li>";
						$i++;
					}
				}
				closedir($handle);
			}
			?>
		</ul>
		<input type="button" id="mergebutton" value="merge">
		</div>
	</body>
</html>
