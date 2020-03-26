<?php
/*
@Author : Iansangaji
@Date   : 18-01-2020
*/

$target_dir = 'Path_Live_Web';
$remote_add = 'git@github.com:username/ex.git';

define('REMOTE_REPOSITORY', $remote_add);
define('BRANCH', 'master');
define('TARGET_DIR', $target_dir);
define('TMP_DIR', '/tmp/repo_git/repo-'.md5(REMOTE_REPOSITORY).'/');
define('DELETE_REPO', '/tmp/repo_git/');
define('DELETE_FILES', true);
define('EXCLUDE', serialize(array(
	'.git',
)));

?>