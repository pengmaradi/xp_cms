<html>
<head>
<title>Upload Form</title>
</head>
<body>

<h3>Your file was successfully uploaded!</h3>
<img src="http://localhost/xp_cms/public_html/xp/xp_cms/images/<?php echo $upload_data['file_name'] ; ?>" />
<ul>
<?php foreach ($upload_data as $item => $value):?>
<li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>
</ul>

<p><?php echo anchor('fileupload', 'Upload Another File!'); ?></p>

</body>
</html>