<?php
define('Imperial', true);
require_once 'system/core/start.php';

switch(ACTION) {
	default:

        $getPagesContent = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__pages`"));

        foreach ($getPagesContent AS $rowPage){
            $page[$rowPage['page_name']]['name'] = $rowPage['name'];
            $page[$rowPage['page_name']]['header'] = $rowPage['header'];
            $page[$rowPage['page_name']]['title'] = $rowPage['title'];
            $page[$rowPage['page_name']]['description'] = $rowPage['description'];
            $page[$rowPage['page_name']]['address'] = $rowPage['address'];
            $page[$rowPage['page_name']]['phone'] = $rowPage['phone'];
            $page[$rowPage['page_name']]['mails'] = $rowPage['mails'];
        }

        $tpl -> assign(array("page" => $page));
        $tpl -> display('index');
        break;

    case 'sendmail':
        $to = 'guper89@mail.ru';
        $subject = 'You subject';
        $headers = 'From: (Your site)' . "\r\n" . 'Content-type: text/html; charset=utf-8';
        $message = '
<html>
	<head>
		<title>Your Site Contact Form</title>
	</head>
	<body>
		<h3>Name: <span style="font-weight: normal;">' . $_POST['name'] . '</span></h3>
		<h3>Email: <span style="font-weight: normal;">' . $_POST['email'] . '</span></h3>
		<div>
			<h3 style="margin-bottom: 5px;">Comment:</h3>
			<div>' . $_POST['comment'] . '</div>
		</div>
	</body>
</html>';

        if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['comment'])) {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                mail($to, $subject, $message, $headers) or die('<span class="text-danger">Error sending Mail</span>');
                echo '<span class="text-success send-true">Your email was sent!</span>';
            }
        } else {
            echo '<span class="text-danger">All fields must be filled!</span>';
        }
        break;

    case 'subscribe':
        if ($_POST['']);
        if (!empty($_POST['email'])) {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

                $mysqli -> query("INSERT INTO `#__emails` SET
                    `emails` = '" . $var -> post('email') . "'");

                echo '<span class="text-success send-true">Ваш email отправлен</span>';
            } else {
                echo '<span class="text-danger">Неправильный адрес!</span>';
            }
        } else {
            echo '<span class="text-danger">Все поля должны быть заполнены!</span>';
        }
        break;

    case 'admin':
        if (isset($_GET['go'])) {
            if (empty($_GET['login'])) {
                echo 'Логин';
            } elseif (empty($_GET['password'])) {
                echo 'Пароль';
            } else {
                $accessToken = md5($_GET['login'] . $_GET['password']);
                $qAdmin = $mysqli->query("SELECT * FROM `#__admin` WHERE `access_token` = '" . $accessToken . "'")->fetch_assoc();
                if ($qAdmin['id']) {
                    setcookie('access_token', $accessToken, TIME + 60 * 60 * 24);
                    setcookie('id', $qAdmin['id'], TIME + 60 * 60 * 24);
                    $function -> location('admin/');
                } else {
                    echo 'access denied';
                    $tpl -> display('aut-admin');
                }
            }
        }

        $admin = $mysqli -> query("SELECT * FROM `#__admin` WHERE `id` = '" . $var -> cookie('id') . "'") -> fetch_assoc();
        $accessToken = md5($admin['login'].$admin['password']);
        $aut = ($var -> cookie('access_token') == $accessToken) ?  $admin : false;

        if ($aut){

            if (isset($_POST['page-name'])){

                echo '<br><br><br><br><br>';

                $getPages = $mysqli -> query("SELECT * FROM `#__pages` WHERE `page_name` = '" . $var -> post('page-name') . "'") -> fetch_assoc();

                if ($getPages['id']){
                    $mysqli -> query("UPDATE `#__pages` SET
                    `name` = '" . $var -> post('name') . "',
                    `header` = '" . $var -> post('header') . "',
                    `title` = '" . $var -> post('title') . "',
                    `description` = '" . $var -> post('description') . "',
                    `address` = '" . $var -> post('address') . "',
                    `phone` = '" . $var -> post('phone') . "',
                    `mails` = '" . $var -> post('mails') . "' WHERE `page_name` = '" . $var -> post('page-name') . "'");

                    $function -> location('admin/#' . $_POST['page-name']);
                } else {
                    $mysqli -> query("INSERT INTO `#__pages` SET
                    `page_name` = '" . $var -> post('page-name') . "',
                    `name` = '" . $var -> post('name') . "',
                    `header` = '" . $var -> post('header') . "',
                    `title` = '" . $var -> post('title') . "',
                    `description` = '" . $var -> post('description') . "',
                    `address` = '" . $var -> post('address') . "',
                    `phone` = '" . $var -> post('phone') . "',
                    `mails` = '" . $var -> post('mails') . "'");

                    $function -> location('admin/#' . $_POST['page-name']);
                }
            }

            $getPagesContent = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__pages`"));
            $subscribe = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__emails`"));

            foreach ($getPagesContent AS $rowPage){
                $page[$rowPage['page_name']]['name'] = $rowPage['name'];
                $page[$rowPage['page_name']]['header'] = $rowPage['header'];
                $page[$rowPage['page_name']]['title'] = $rowPage['title'];
                $page[$rowPage['page_name']]['description'] = $rowPage['description'];
                $page[$rowPage['page_name']]['address'] = $rowPage['address'];
                $page[$rowPage['page_name']]['phone'] = $rowPage['phone'];
                $page[$rowPage['page_name']]['mails'] = $rowPage['mails'];
            }

            $tpl -> assign(array("page" => $page, "subscribe" => $subscribe));
            $tpl -> display('index-admin');
        } else {
            $tpl -> display('aut-admin');
        }

        break;

    case 'exit':
        if ($_GET['exit'] == 'add'){
            unset($_COOKIE['access_token']);
            setcookie('access_token', null, -1, '/admin');
            unset($_COOKIE['id']);
            setcookie('id', null, -1, '/admin');
            $function -> location('admin/?exit=1');
        }
        break;
}