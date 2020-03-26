<?php
/*
@Author : Iansangaji
@Date   : 18-01-2020
*/

include 'config.php';

if(isset($_POST['update'])){
	if($_POST['deplo_life'] && !empty($_POST['deplo_life'])){
		$dir_life = trim($_POST['deplo_life']);
		$conf = 'config.php';
		$content = file_get_contents($conf);
		$content = str_replace($target_dir, $dir_life, $content);
		file_put_contents($conf, $content);
		header("Refresh:0");
	}

	if($_POST['work_life'] && !empty($_POST['work_life'])){
		$dir_life = trim($_POST['work_life']);
		$conf = 'config.php';
		$content = file_get_contents($conf);
		$content = str_replace($remote_add, $dir_life, $content);
		file_put_contents($conf, $content);
		header("Refresh:0");
	}
}

if(isset($_POST['pull'])){
	if (!is_dir(TMP_DIR)) {
		$commands = sprintf(
			'git clone --depth=1 --branch %s %s %s'
			, BRANCH
			, REMOTE_REPOSITORY
			, TMP_DIR
		);
		exec($commands);
	}

	$exclude = '';
	foreach (unserialize(EXCLUDE) as $exc) {
		$exclude .= ' --exclude='.$exc;
	}

	$commands_ = sprintf(
		'rsync -rltgoDzvO %s %s %s %s'
		, TMP_DIR
		, TARGET_DIR
		, (DELETE_FILES) ? '--delete-after' : ''
		, $exclude
	);
	$out = exec($commands_);
	exec('cd '.DELETE_REPO.';rm -rf * ');	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>GIT Auto Deploy</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Electrolize&amp;display=swap" rel="stylesheet">
</head>
<body>

<div class="jumbotron text-center" style="font-family: 'Electrolize'">
  <h1>Auto Deploy</h1>
  <p>Made with <img src="https://i.giphy.com/media/LpDmM2wSt6Hm5fKJVa/giphy.webp" width="25px" height="25px"> by <a href="//sangaji.co">Iansangaji</a></p>
</div>
  
<div class="container" style="font-family: 'Electrolize'">
  <div class="row">
  	<form method="post" action="">
  		<div class="col-sm-3">
  			<label>Git Remote Address:</label>
  			<input type="text" value="<?php print_r(REMOTE_REPOSITORY); ?>" class="form-control" readonly="">
  		</div>
  		<div class="col-sm-3">
  			<label>Branch:</label>
  			<input type="text" value="<?php print_r(BRANCH); ?>" class="form-control" readonly="">
  		</div>
  		<div class="col-sm-3">
  			<label>Deployment path:</label>
  			<input type="text" value="<?php print_r(TARGET_DIR); ?>" class="form-control" readonly="">
  		</div>
  		<div class="col-sm-3">

  			<div class="col-sm-6">
  				<label>Pull:</label>
  				<button class="btn btn-success form-control" name="pull">PULL</button>
  			</div>
  			<div class="col-sm-6">
  				<label>Refs:</label>
  				<button class="btn btn-info form-control" onClick="window.location='/';">Refresh</button>
  			</div>
  		</div>
  	</form>

  	<form method="post" action="">
  		<div class="col-sm-3">
  			<br/>
  			<label>Git Remote Address:</label>
  			<input type="text" name="work_life" class="form-control">
  		</div>
  		<div class="col-sm-3">
  			<br/>
  			<label>Deployment path:</label>
  			<input type="text" name="deplo_life" class="form-control">
  		</div>
  		<div class="col-sm-3">
  			<br/>
  			<label>Update:</label>
  			<button class="btn btn-danger form-control" name="update">Update</button>
  		</div>
  	</form>
	<?php if(isset($_POST['pull'])){ ?>
	<div class="col-sm-12">
		<br/>
  		<textarea class="form-control" readonly=""><?php print_r($out); ?></textarea>
  	</div>
  	<? } ?>
  </div>
</div>

</body>
</html>
