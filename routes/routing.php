<?php
session_start();
include '../config/config.php';
$actual_link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$request = str_replace($base_url, '', $actual_link);
switch ($request) {
	case '':
		session_destroy();
		include $site_url.'views/inc/header.html';
		include $site_url.'views/question_1.html';
		include $site_url.'/views/inc/footer.html';
		break;
	case '/':
		session_destroy();
		include $site_url.'views/inc/header.html';
		include $site_url.'views/question_1.html';
		include $site_url.'/views/inc/footer.html';
		break;
	case 'api/load_question':
		$q_no = $_POST['question_no'];
		include $site_url.'api/question_1.php';
		break;
	case 'api/question/save':
		include $site_url.'api/save_data.php';
		break;
	case 'api/save/test':
		include $site_url.'api/save_test.php';
		break;

	case 'admin':
		include $site_url.'views/inc/header.html';
		if(isset($_SESSION['username'])){
			include $site_url.'views/admin.html';
		}else{
			header('location:'.$base_url.'login');
			exit;
		}
		include $site_url.'views/inc/footer.html';
		break;

	case 'login':
		include $site_url.'views/inc/header.html';
		include $site_url.'views/login.html';
		include $site_url.'views/inc/footer.html';
		break;
	case 'api/check/login':
		unset($_SESSION['username']);
		if($_POST['username'] == 'admin' && $_POST['password'] == 'admin'){
			$data = ['code'=>200, 'msg'=>'success', 'href'=>$base_url.'admin'];
			$_SESSION['username'] = $_POST['username'];
		}else{
			$data = ['code'=>400, 'msg'=>'Invalid Credentials Provided'];
		}
		echo json_encode($data);
		break;

	case 'api/test/show':
		$json = file_get_contents($site_url.'json/results.json');
		echo $json;
		break;

	case 'animation':
		include $site_url.'views/inc/header.html';
		include $site_url.'views/dice_roll.html';
		include $site_url.'/views/inc/footer.html';
		break;


	
	default:
		echo "404 Page Not Found";
		break;
}