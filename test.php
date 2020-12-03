<?php
/**
 * IF
 *
 * @author     ByVlad <oslife@i.ua>
 * @framework  Imperial Framework
 * @category   Application
 * @copyright  2011
 */
define('Imperial', true);
require_once 'system/core/start.php';
$timeAut = 3600;
$head = $mysqli -> query("SELECT * FROM `#__head` WHERE `id` = '".$var -> cookie('id')."'") -> fetch_assoc();
$accessToken = md5($head['login'].$head['password']);
$aut = ($var -> cookie('access_token') == $accessToken) ?  $head : false;

setcookie('urla', $_SERVER['REQUEST_URI'], TIME+80000);
/*if ($var -> cookieNotIsset('update_password')){
    setcookie('update_password', 'yes', TIME+3600);
            unset($_COOKIE['access_token']);
            setcookie('access_token', null, -1, '/');
            unset($_COOKIE['admin']);
            setcookie('admin', null, -1, '/');
            unset($_COOKIE['id']);
            setcookie('id', null, -1, '/');
            $function -> location('?exit=1');
}*/

switch(ACTION) {
    default:
        if ($_POST['ping'] and $aut['time'] >= TIME-$timeAut){
            echo json_encode(array("info" => "Ок", "code" => "200"));exit();
        }
        if (!empty($_POST['login']) and !empty($_POST['password'])){
            $loginpassword = $mysqli -> query("SELECT * FROM `#__head` WHERE `login` = '".$var -> post('login')."' AND `password` = '".$var -> post('password')."'") -> fetch_assoc();
            if ($loginpassword['id']){
                $accessToken = md5($_POST['login'].$_POST['password']);
                setcookie('access_token', $accessToken, TIME+$timeAut);
                setcookie('id', $loginpassword['id'], TIME+$timeAut);
                if ($loginpassword['login'] == 'secur' or $loginpassword['id'] == '12'){
                    setcookie('admin', '1');
                }
                $mysqli -> query("UPDATE `#__head` SET `time` = '".TIME."' WHERE `id` = '".$loginpassword['id']."'");
                $function -> location('?aut=1');
            } else {
                $function -> location('?aut=error not user');
            }
        }
        if ($_GET['weekCount'] == 'add'){
            setcookie('weekCount', '1');
            $function -> location('?addweekCount=1');
        }
        if ($_GET['weekCount'] == 'del'){
            setcookie('weekCount');
            $function -> location('?delweekCount=1');
        }
        if ($_GET['admin'] == 'add' and $aut['admin'] == 1){
            setcookie('admin', '1');
            $function -> location('?addadminCount=1');
        }
        if ($_GET['admin'] == 'del' and $aut['admin'] == 1){
            setcookie('admin');
            $function -> location('?deladminCount=1');
        }
        if ($aut['id'] and $aut['time'] >= TIME-$timeAut || $aut['api'] == 1){
            //$y = ($var -> get('navweek')) ? $var -> get('year') : date('Y', TIME);
            $y = date('Y', TIME);
            $weekHash = (isset($_GET['navweek'])) ? $var -> get('navweek') : date('W', TIME)+($var -> cookie('weekCount')).$y;
            $department = $mysqli -> cycle($mysqli -> query("SELECT `department` FROM `#__users` GROUP BY `department`"));
            $position = $mysqli -> cycle($mysqli -> query("SELECT `position` FROM `#__users` GROUP BY `position`"));
            $reportsGroup = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__reports` GROUP BY `week`"));
            $reports = $mysqli -> query("SELECT * FROM `#__reports` WHERE `week` = '".$weekHash."' and `boss` = '".$aut['id']."'") -> fetch_assoc();
            $reportsall = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__reports` WHERE `week` = '".$weekHash."'"));
            if (!empty($_GET['departmentreg'])){
                $mysqli -> query("UPDATE `#__head` SET `department` = '".$var -> get('departmentreg')."' WHERE `id` = '".$aut['id']."'");
                $function -> location('?depadd=1');
            }
            if ($_POST['add'] == 'add'){
                if (!$reports['id']){
                    $mysqli -> query("INSERT INTO `#__reports` SET
                                `week` = '".$weekHash."',
                                `department` = '".$var -> post('department-reg')."',
                                `boss` = '".$var -> post('boss')."',
                                `array` = '".serialize($_POST['week'])."'");
                    if ($_POST['format'] == 'json'){
                        echo json_encode(array("info" => "Записаны"));
                    } else {
                        $function -> location('?insert=1');exit();
                    }
                } else {
                    $mysqli -> query("UPDATE `#__reports` SET
                                `week` = '".$weekHash."',
                                `department` = '".$var -> post('department-reg')."',
                                `boss` = '".$var -> post('boss')."',
                                `array` = '".serialize($_POST['week'])."' WHERE `week` = '".$weekHash."' and `boss` = '".$aut['id']."'");
                    if ($_POST['format'] == 'json'){
                        echo json_encode(array("info" => "Обновлены"));exit();
                    } else {
                        $function -> location('?update=1');
                    }
                }
            }
            if ($_GET['adduser'] == 'add'){
                $mysqli -> query("INSERT INTO `#__users` SET
                                `surname` = '".$var -> get('surname')."',
                                `name` = '".$var -> get('name')."',
                                `secondname` = '".$var -> get('secondname')."',
                                `position` = '".$var -> get('secondname')."',
                                `department` = '".$aut['department']."',
                                `code` = '".$var -> get('code')."'");
                $function -> location('?insert=1');
            }
            if ($_GET['deluser'] and $aut["id"] == '2'){
                $mysqli -> query("UPDATE `#__users` SET `del` = 1 WHERE `id` = '".$var -> get('deluser')."'");
                $function -> location('?delete='.$var -> get('deluser'));
            }
            if ($_GET['setNoCheck'] and $aut["id"] == '3'){
                $mysqli -> query("UPDATE `#__users` SET `status` = 1 WHERE `id` = '".$var -> get('setNoCheck')."'");
                $function -> location('?setNoCheckadd='.$var -> get('setNoCheck'));
            }
            if ($_GET['setCheck'] and $aut["id"] == '3'){
                $mysqli -> query("UPDATE `#__users` SET `status` = 0 WHERE `id` = '".$var -> get('setCheck')."'");
                $function -> location('?setCheckadd='.$var -> get('setCheck'));
            }
            $weekDay = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
            $foodDay = array("0" => array("name" => "Завтрак", "nameEn" => "breakfast", "time" => array("in" => "07:15:00", "end" => "08:30:00")),
                "1" => array("name" => "Обед", "nameEn" => "lunch", "time" => array("in" => "12:50:00", "end" => "14:06:00")),
                "2" => array("name" => "Ужин", "nameEn" => "dinner", "time" => array("in" => "18:50:00", "end" => "20:30:00"))
            );
            $unfNameDay = array("Monday" => array("name" => "Понедельник", "short" => "Пн", "foodDay" => $foodDay),
                "Tuesday" => array("name" => "Вторник", "short" => "Вт", "foodDay" => $foodDay),
                "Wednesday" => array("name" => "Среда", "short" => "Ср", "foodDay" => $foodDay),
                "Thursday" => array("name" => "Четверг", "short" => "Чт", "foodDay" => $foodDay),
                "Friday" => array("name" => "Пятница", "short" => "Пт", "foodDay" => $foodDay),
                "Saturday" => array("name" => "Суббота", "short" => "Сб", "foodDay" => $foodDay),
                "Sunday" => array("name" => "Воскресенье", "short" => "Вс", "foodDay" => $foodDay)
            );
            $users = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__users` WHERE `department` = '".$aut['department']."' or `id` = '".$aut['hid']."' or `department` = '".$aut['subdepartment']."' ORDER BY `surname` ASC"));

            foreach($weekDay AS $nameDayValue => $nameDay){
                foreach($reportsall AS $row){
                    $array = unserialize($row['array']);
                    foreach($unfNameDay[$nameDay]['foodDay'] AS $rowNameWeek){
                        foreach($array[$nameDay][$rowNameWeek['nameEn']] AS $foodIDuser){
                            $userse = $mysqli -> query("SELECT * FROM `#__users` WHERE `id` = '".$foodIDuser."'") -> fetch_assoc();
                            if ($userse['status'] != 1){$counterNos[$rowNameWeek['nameEn']][$nameDay]++;$n++;} else {$counterNosElite[$rowNameWeek['nameEn']][$nameDay]++;}
                        }
                    }
                }
            }
            if ($_GET['api'] == 1){
                $mysqli -> query("UPDATE `#__head` SET `time` = '".TIME."' WHERE `id` = '".$aut['id']."'");
                echo json_encode(array('counterNos' => $counterNos, 'counterNosElite' => $counterNosElite)); exit();
            }
            //print_r($counterNos);exit();

            $tpl -> assign(array(
                'aut' => $aut,
                'department' => $department,
                'position' => $position,
                'users' => $users,
                'reports' => unserialize($reports['array']),
                'reportsall' => $reportsall,
                'weekDay' => $weekDay,
                'unfNameDay' => $unfNameDay,
                'reportsGroup' => $reportsGroup,
                'counterNos' => $counterNos,
                'counterNosElite' => $counterNosElite,
                'weekHash' => $weekHash,
                'timeAut' => $timeAut));

            $tpl -> display('index');
        } else {
            if ($_POST['format'] == 'json'){
                echo json_encode(array("info" => "Нет авторизации", "code" => "401"));
            } else {
                $tpl -> display('aut');
            }
        }
        break;
    case 'load':
        $check = json_decode(file_get_contents('http://bitrix-kontinent.ru:5228/fb/index.php?password=Vfhnbyb123&datestart='.date("Y-m-d", TIME).'%2006:00:00&datestop='.date("Y-m-d", TIME).'%2023:00:00'));
        //print_r($check);
        //echo json_encode($check);
        //http://bitrix-kontinent.ru:5228/fb/index.php?password=Vfhnbyb123&datestart=2019-09-01%2000:00:00&datestop=2019-09-19%2023:00:00
        //$check = json_decode(file_get_contents('http://bitrix-kontinent.ru:5228/fb/index.php?password=Vfhnbyb123&datestart=2020-06-01%2000:00:00&datestop=2020-06-03%2023:00:00'));
        /**/
        foreach ($check AS $row){
            $convertDate = strtotime($row->date);
            $checkdate = $mysqli -> query("SELECT * FROM `#__logs` WHERE `time` = '".$convertDate."'") -> fetch_assoc();
            if (!$checkdate['id'] and !empty($row->code)){
                $isrt = $mysqli -> query("INSERT INTO `#__logs` SET
                                `sid` = '".$row->sid."',
                                `code` = '".$row->code."',
                                `time` = '".$convertDate."'");
                $info = json_encode(array("id" => ''));
            }
        }
        echo $info;
        break;
    case 'loadall':
        $check = json_decode(file_get_contents('http://bitrix-kontinent.ru:5228/fb/index.php?password=Vfhnbyb123&datestart='.date("Y-m-d", TIME).'%2000:01:00&datestop='.date("Y-m-d", TIME).'%2023:00:00&dvs=1'));
        foreach ($check AS $row){
            $convertDate = strtotime($row->date);
            $checkdate = $mysqli -> query("SELECT * FROM `#__logs_all` WHERE `sid` = '".$row->sid."' and `time` = '".$convertDate."'") -> fetch_assoc();

            if (!$checkdate['id'] and $row->event->code == 30 || $row->event->code == 50 and $row->dvs != "000B3A0043D9"){
                $isrt = $mysqli -> query("INSERT INTO `#__logs_all` SET
                                `sid` = '".$row->sid."',
                                `code` = '".$row->code."',
                                `dvs` = '".$row->dvs."',
                                `event` = '".$row->event->code."',
                                `time` = '".$convertDate."'");
                $info = json_encode(array("id" => ''));
                /*echo $checkdate['sid'] .' == '. $row->sid . ' ' . $row->event->code . ' ' . $row->date . '<br />';*/
            }
        }
        echo $info;
        break;
    case 'addadmin':
        /*
                        if ($_GET['addadmin'] == 'Vfhnbyb123'){
                            $mysqli -> query("INSERT INTO `#__head` SET
                                    `login` = '".$var -> get('login')."',
                                    `password` = '".$var -> get('password')."',
                                    `surname` = '".$var -> get('surname')."',
                                    `name` = '".$var -> get('name')."',
                                    `secondname` = '".$var -> get('secondname')."',
                                    `department` = '".$var -> get('department')."'");
                                    $function -> location('?insert=1');
                        }
        $tpl -> display('reg');*/

        break;

    case 'my':
        /*$users = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__users` WHERE `department` = 'Руководство'"));
        foreach ($users AS $row){
            $Alogin = array($function -> translit(mb_strtolower($row['surname'])), $function -> translit(mb_strtolower($row['name'])), $function -> translit(mb_strtolower($row['secondname'])));
            $login = $Alogin[0]{0}.$Alogin[1]{0}.$Alogin[2]{0};
            $password = $Alogin[0]{0}.$Alogin[1]{0}.$Alogin[2]{0}.'qwe';
                    $mysqli -> query("INSERT INTO `#__head` SET
                                    `hid` = '".$row['id']."',
                                    `login` = '".$login."',
                                    `password` = '".$password."',
                                    `surname` = '".$row['surname']."',
                                    `name` = '".$row['name']."',
                                    `secondname` = '".$row['secondname']."'");

        }*/

        break;

    case 'updateusers':
        $users = json_decode(file_get_contents('http://bitrix-kontinent.ru:5228/fb/users.php?password=Vfhnbyb123'));
        $usersDel = json_decode(file_get_contents('http://bitrix-kontinent.ru:5228/fb/users-del.php?password=Vfhnbyb123'));
        foreach ($users AS $row){
            $checuser = $mysqli -> query("SELECT * FROM `#__users` WHERE `sid` = '".$row->sid."'") -> fetch_assoc();
            $checuserName = $mysqli -> query("SELECT * FROM `#__users` WHERE `surname` = '".$row->surname."' and `name` = '".$row->name."' and `secondname` = '".$row->secondname."' and `status` = '0' and `sid` = '0'") -> fetch_assoc();
            if ($checuser['id']){
                $mysqli -> query("UPDATE `#__users` SET
                                `surname` = '".$row->surname."',
                                `name` = '".$row->name."',
                                `secondname` = '".$row->secondname."',
                                `position` = '".$row->position."',
                                `department` = '".$row->department."',
                                `code` = '".$row->code."' WHERE `id` = '".$checuser['id']."'");
            } elseif ($checuserName['id']){
                $mysqli -> query("UPDATE `#__users` SET
                                `sid` = '".$row->sid."',
                                `surname` = '".$row->surname."',
                                `name` = '".$row->name."',
                                `secondname` = '".$row->secondname."',
                                `position` = '".$row->position."',
                                `department` = '".$row->department."',
                                `code` = '".$row->code."' WHERE `id` = '".$checuserName['id']."'");
            } else {
                $mysqli -> query("INSERT INTO `#__users` SET
                                `sid` = '".$row->sid."',
                                `surname` = '".$row->surname."',
                                `name` = '".$row->name."',
                                `secondname` = '".$row->secondname."',
                                `position` = '".$row->position."',
                                `department` = '".$row->department."',
                                `code` = '".$row->code."'");
            }
        }

        foreach ($usersDel AS $rowDel){
            $checuserDel = $mysqli -> query("SELECT * FROM `#__users` WHERE `sid` = '".$rowDel->ID."' and `del` != '1'") -> fetch_assoc();
            if ($checuserDel['id']){
                //$mysqli -> query("UPDATE `#__users` SET `del` = '1', `code` = '0' WHERE `id` = '".$checuserDel['id']."'");
                $mysqli -> query("UPDATE `#__users` SET `del` = '1' WHERE `id` = '".$checuserDel['id']."'");
            }
        }

        break;

    case 'exit':
        if ($_GET['exit'] == 'add'){
            unset($_COOKIE['access_token']);
            setcookie('access_token', null, -1, '/');
            unset($_COOKIE['admin']);
            setcookie('admin', null, -1, '/');
            unset($_COOKIE['id']);
            setcookie('id', null, -1, '/');
            $function -> location('?exit=1');
        }
        break;

    case 'android':
        echo 'and';
        echo file_get_contents('http://bitrix-kontinent.ru:5228/ip/');
        //echo json_encode($_POST);
        /*$usersa = json_decode(file_get_contents('http://bitrix-kontinent.ru:5228/fb/users.php?password=Vfhnbyb123'));
        foreach ($usersa AS $row){
            $json['users'][] = $row;
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);*/
        //echo file_get_contents('android/users.json');
        //$parsr = file_get_contents('android/base.json');
        //echo $parsr;
        //print_r(json_decode($parsr, JSON_UNESCAPED_UNICODE));
        /*for ($i = 1; $i<9; $i++){
            $parsr[$i] = json_decode(file_get_contents('android/json/json'.$i.'.json'));
        }
        //echo $parsr;
        //print_r($parsr);
                echo '
                <table class="table table-bordered table-hover">
                <thead>
                   <tr>
                      <td>Имя</td>
                      <td>Тел</td>
                      <td>Адрес</td>
                      <td>mail</td>
                   </tr>
                   </thead>
                   <tbody>';
        foreach($parsr AS $rows){
            foreach($rows AS $row){
               echo '<tr>
                      <td>'.$row[1].'</td>
                      <td>'.$row[4].'</td>
                      <td>'.$row[5].'</td>
                      <td>'.$row[6].'</td>
                    </tr>';
            }
        }
        echo '</tbody></table>';

            "329",
            "Ялтинский городской пансионат",
            "3",
            "1",
            "+7 (978) 934-49-25; +7 (3654) 26-03-69",
            "Россия, Крым, г. Ялта, ул. Щербака, 11",
            "yalta012015@mail.ru",
            "",
            "Муниципальное предприятие. Состав: - Дом творчества писателей им.Чехова; - бывший санаторий им.Куйбышева. +4",
            "0",
            "0"
        */
        break;

    case 'graph':
        //if ($_GET['secur'] == 1){
        if ($aut['id']){
            $department = $mysqli -> cycle($mysqli -> query("SELECT `department` FROM `#__users` GROUP BY `department`"));
            $users = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__users` WHERE `department` = '".$aut['department']."' or `id` = '".$aut['hid']."' or `department` = '".$aut['subdepartment']."'  ORDER BY `sort` ASC"));
            $today = date('dmY', TIME);
            $dateT = date('Y-m-d', TIME);
            $checkMountEdit = (isset($_GET['mount']) and time() < TIME) ? 1 : 200;
            $secur = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__graph` WHERE `day` = '".$today."' and `types-exits-id` = '1'"));
            $departmentGet = (isset($_GET['department'])) ? ' and `department` = "'.$var -> get('department').'"' : '';
            $departmentGetSub = (isset($_GET['departmentsub'])) ? ' and `department` = "'.$var -> get('departmentsub').'"' : '';
            $TypesExitsGetSub = (isset($_GET['types'])) ? ' and `types-exits-id` = "'.$var -> get('types').'"' : '';
            $hr = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__graph` WHERE `day` = '".$today."'".$departmentGet." and `types-exits-id` IN (1,2)"));
            //echo "SELECT * FROM `#__graph` WHERE `day` = '".$today."'".$departmentGet." and `types-exits-id` = '1' or `types-exits-id` = '2'"; exit();
            $hrToday = (isset($_GET['hrSubToday'])) ? "" : " and `day` = '".$today."'";
            $hrSub = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__graph_sub` WHERE `accept` = '0'".$hrToday."".$departmentGetSub."".$TypesExitsGetSub.""));
            $rkSub = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__graph_sub` WHERE `accept` = '0' and `types-exits-id` = '10' and `department` = '".$aut['department']."'"));

            $dayofmonth = date('t', TIME);
            $month = date('mY', TIME);
            $nameMonth = array("0" => "Пусто", "1" => "Январь", "2" => "Февраль", "3" => "Март", "4" => "Апрель", "5" => "Май", "6" => "Июнь", "7" => "Июль", "8" => "Август", "9" => "Сентябрь", "10" => "Октябрь", "11" => "Ноябрь", "12" => "Декабрь");
            $NameDay = array(
                "1" => array("name" => "Понедельник", "short" => "Пн"),
                "2" => array("name" => "Вторник", "short" => "Вт"),
                "3" => array("name" => "Среда", "short" => "Ср"),
                "4" => array("name" => "Четверг", "short" => "Чт"),
                "5" => array("name" => "Пятница", "short" => "Пт"),
                "6" => array("name" => "Суббота", "short" => "Сб"),
                "7" => array("name" => "Воскресенье", "short" => "Вс")
            );
            $TypesExits = array(
                "1" => array("id" => "1", "code" => "Р", "name" => "выход, стандартная смена"),
                "2" => array("id" => "2", "code" => "0,5", "name" => "выход, половина стандартной  смены"),
                "3" => array("id" => "3", "code" => "Ст", "name" => "стажировка"),
                "4" => array("id" => "4", "code" => "К", "name" => "командировка"),
                "5" => array("id" => "5", "code" => "В", "name" => "выходной по графику"),
                "6" => array("id" => "6", "code" => "ОТ", "name" => "отпуск"),
                "7" => array("id" => "7", "code" => "ДО", "name" => "отпуск за свой счет"),
                "8" => array("id" => "8", "code" => "Т", "name" => "отсутствие по состоянию здоровья"),
                "9" => array("id" => "9", "code" => "Пр", "name" => "прогул"),
                "10" => array("id" => "10", "code" => "Ш", "name" => "штраф"),
                "11" => array("id" => "11", "code" => "УВ", "name" => "уволнение")
            );
            $userSet = array(
                "0" => "Не проживает",
                "1" => "Общага",
                "2" => "Частный сектор",
                "3" => "Асоль",
                "4" => "Кураж"
            );
            if (isset($_GET['typeJson'])){
                echo json_encode($TypesExits);exit();
            }
            if (isset($_GET['sortJson'])){
                $expSepor = explode('-', $_GET['id']);
                if ($_GET['preuid'] == 0){
                    $mysqli -> query("DELETE FROM `#__sepor` WHERE `preuid` = '0'");
                    echo json_encode(array("status" => "DELS", "msg" => $var -> get('preuid')));
                }
                if ($expSepor[1] == 'new'){
                    if (is_numeric($_GET['preuid'])){
                        $mysqli -> query("INSERT INTO `#__sepor` SET `aid` = '".$aut['id']."', `preuid` = '".$var -> get('preuid')."'");
                        echo json_encode(array("status" => "INSS", "msg" => $var -> get('preuid')));
                    } else {echo json_encode(array("status" => "NONUM", "msg" => $_GET['preuid']));}
                }
                if ($expSepor[1] == 'upd'){
                    if (is_numeric($_GET['preuid'])){
                        $mysqli -> query("UPDATE `#__sepor` SET `preuid` = '".$var -> get('preuid')."' WHERE `preuid` = '".$expSepor[2]."'");
                        echo json_encode(array("status" => "UPDS", "msg" => $var -> get('preuid')));
                    } else {echo json_encode(array("status" => "NONUM", "msg" => $_GET['preuid']));}
                } else {
                    $mysqli -> query("UPDATE `#__users` SET `sort` = '".$var -> get('sort')."' WHERE `id` = '".$var -> get('id')."'");
                    echo json_encode(array("status" => "UPDU", "msg" => $var -> get('id')));
                }
                exit();
            }
            if (isset($_POST['argue'])){
                //`id`, `uid`, `month`, `day`, `time-from`, `time-to`, `types-exits-id`, `arg-day`
                //print_r($_POST);exit();
                $argDay = (isset($_POST['argue']['formWorkDay'])) ? '1' : '0';
                $dateSetLimit = strtotime('01.' . date('m.Y', TIME));

                if ($_GET['nocheck'] == 'no'){
                    $table = 'graph'; //для отладки...
                } else {
                    $table = ($dateSetLimit > time()) ? 'graph' : 'graph_sub'; //без константы, здесь время не должно меняться...
                }


                foreach ($_POST['where'] as $row){
                    $checGraph = $mysqli -> query("SELECT * FROM `#__".$table."` WHERE `uid` = '".$var -> post('uid')."' and `month` = '".$month."' and `day` = '".$row."'") -> fetch_assoc();
                    if ($checGraph['id']){
                        $updateSubExtis = ($table == 'graph_sub') ? '`accept` = "0",' : '';
                        $mysqli -> query("UPDATE `#__".$table."` SET
                                    `day` = '".$row."',
                                    `time-from` = '".$var -> clean($_POST['argue']['formWorkTimeFrom'])."',
                                    `time-to` = '".$var -> clean($_POST['argue']['formWorkTimeTo'])."',
                                    `types-exits-id` = '".$var -> clean($_POST['argue']['TypesExitsRowId'])."',
                                    `arg-day` = '".$argDay."',
                                    ".$updateSubExtis."
                                    `department` = '".$aut['department']."' WHERE `uid` = '".$var -> post('uid')."' and `month` = '".$month."' and `day` = '".$row."'");
                        $log[] = $row.' - UPDATE | '.'01.' . date('m.Y', TIME);
                    } else {
                        $mysqli -> query("INSERT INTO `#__".$table."` SET
                                    `uid` = '".$var -> post('uid')."',
                                    `month` = '".$month."',
                                    `day` = '".$row."',
                                    `time-from` = '".$var -> clean($_POST['argue']['formWorkTimeFrom'])."',
                                    `time-to` = '".$var -> clean($_POST['argue']['formWorkTimeTo'])."',
                                    `types-exits-id` = '".$var -> clean($_POST['argue']['TypesExitsRowId'])."',
                                    `arg-day` = '".$argDay."',
                                    `department` = '".$aut['department']."'");
                        $log[] = $row.' - INSERT | '.'01.' . date('m.Y', TIME);
                    }
                }
                echo json_encode(array("log" => $log)); exit();
            }
            /* не забудь закрыть доступ, открыть только персонажам и рк */
            if (isset($_POST['accept']) and isset($_POST['id'])){
                $graphUpdateWhere = $mysqli -> query("SELECT * FROM `#__graph_sub` WHERE `id` = '".$var -> post('id')."'") -> fetch_assoc();
                $fine = $mysqli -> query("SELECT * FROM `#__fine` WHERE `uid` = '".$graphUpdateWhere['uid']."' and `month` = '".$graphUpdateWhere['month']."' and `day` = '".$graphUpdateWhere['day']."'") -> fetch_assoc();
                if ($fine['id']){$mysqli -> query("UPDATE `#__fine` SET `status` = '3' WHERE `id` = '".$fine['id']."'");}
                $delGraphSub['updateBD'] = ($mysqli -> query("UPDATE `#__graph_sub` SET `accept` = '1' WHERE `id` = '".$var -> post('id')."'")) ? array("status" => "200") : array("status" => "error ".$_POST['id']);

                $checGraph = $mysqli -> query("SELECT * FROM `#__graph` WHERE `uid` = '".$graphUpdateWhere['uid']."' and `month` = '".$graphUpdateWhere['month']."' and `day` = '".$graphUpdateWhere['day']."'") -> fetch_assoc();

                if ($checGraph['id']){
                    $mysqli -> query("UPDATE `#__graph` SET 
                                                    `day` = '".$graphUpdateWhere['day']."',
                                                    `time-from` = '".$graphUpdateWhere['time-from']."',
                                                    `time-to` = '".$graphUpdateWhere['time-to']."',
                                                    `types-exits-id` = '".$graphUpdateWhere['types-exits-id']."',
                                                    `arg-day` = '".$graphUpdateWhere['arg-day']."',
                                                    `department` = '".$graphUpdateWhere['department']."',
                                                    `up` = '1' WHERE `uid` = '".$graphUpdateWhere['uid']."' and `month` = '".$graphUpdateWhere['month']."' and `day` = '".$graphUpdateWhere['day']."'");
                } else {
                    $mysqli -> query("INSERT INTO `#__graph` SET
                                    `uid` = '".$graphUpdateWhere['uid']."',
                                    `month` = '".$graphUpdateWhere['month']."',
                                    `day` = '".$graphUpdateWhere['day']."',
                                    `time-from` = '".$graphUpdateWhere['time-from']."',
                                    `time-to` = '".$graphUpdateWhere['time-to']."',
                                    `types-exits-id` = '".$graphUpdateWhere['types-exits-id']."',
                                    `arg-day` = '".$graphUpdateWhere['arg-day']."',
                                    `department` = '".$graphUpdateWhere['department']."'");
                }
                $delGraphSub['updateGR'] = ($updateGraphAccept) ? array("status" => "200") : array("status" => "error ".$_POST['id']);
                echo json_encode($delGraphSub);exit();
            }
            /* не забудь закрыть доступ, открыть только персонажам и рк*/
            if (isset($_POST['reject']) and isset($_POST['id'])){
                $graphDeleteWhere = $mysqli -> query("SELECT * FROM `#__graph_sub` WHERE `id` = '".$var -> post('id')."'") -> fetch_assoc();
                $delGraphSub = ($mysqli -> query("DELETE FROM `#__graph_sub` WHERE `id` = '".$var -> post('id')."'")) ? json_encode(array("status" => "200")) : json_encode(array("status" => "error ".$_POST['id']));
                $fine = $mysqli -> query("SELECT * FROM `#__fine` WHERE `uid` = '".$graphDeleteWhere['uid']."' and `month` = '".$graphDeleteWhere['month']."' and `day` = '".$graphDeleteWhere['day']."'") -> fetch_assoc();
                if ($fine['id']){$mysqli -> query("UPDATE `#__fine` SET `status` = '2' WHERE `id` = '".$fine['id']."'");}
                echo $delGraphSub;exit();
            }
            if (isset($_POST['acceptrk']) and isset($_POST['id'])){
                $mysqli -> query("UPDATE `#__fine` SET `rk` = '1', `summ` = '".$var -> post('summ')."' WHERE `id` = '".$var -> post('id')."'");
                echo json_encode(array("status" => "1"));exit();
            }
            if (isset($_POST['rejectrk']) and isset($_POST['id'])){
                $mysqli -> query("UPDATE `#__fine` SET `rk` = '2' WHERE `id` = '".$var -> post('id')."'");
                echo json_encode(array("status" => "2"));exit();
            }

            if (isset($_POST['settings']) and isset($_POST['id'])){
                $mysqli -> query("UPDATE `#__users` SET `sett` = '" . $var -> post('settings') . "' WHERE `id` = '".$var -> post('id')."'");
                echo json_encode(array("status" => "2"));exit();
            }

            $tpl -> assign(array(
                'dayofmonth' => $dayofmonth,
                'users' => $users,
                'NameDay' => $NameDay,
                'month' => $month,
                'nameMonth' => $nameMonth,
                'secur' => $secur,
                'hr' => $hr,
                'hrSub' => $hrSub,
                'rkSub' => $rkSub,
                'dateT' => $dateT,
                'department' => $department,
                'TypesExits' => $TypesExits,
                'checkMountEdit' => $checkMountEdit,
                'aut' => $aut,
                'userSet' => $userSet,
                'var' => $var
            ));


            if ($_GET['secur'] == 1){/* не забудь закрыть доступ, открыть только сикурити */
                $tpl -> display('graph-secur');
            } elseif ($_GET['hr'] == 1){/* не забудь закрыть доступ, открыть только персонажам */
                $tpl -> display('graph-hr');
            } elseif ($_GET['hr'] == 2){/* не забудь закрыть доступ, открыть только персонажам */
                $tpl -> display('graph-hr-2');
            } elseif ($_GET['hr'] == 22){/* не забудь закрыть доступ, открыть только персонажам */
                $tpl -> display('graph-hr-dep');
            } elseif ($_GET['buh'] == 1){/* не забудь закрыть доступ, открыть только бухгалтерии */
                $tpl -> display('graph-buh');
            } else {
                $tpl -> display('graph');
            }
        } else {
            $tpl -> display('aut');
        }
        break;

    case 'chengeDep':
        /*
            $userDep = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__users` WHERE `department` = 'Ресторан'"));
            foreach ($userDep AS $rowUsDep){
                echo $rowUsDep['name'] . '<br />';
                $mysqli -> query("UPDATE `#__graph` SET `department` = 'Ресторан' WHERE `uid` = '".$rowUsDep['id']."'");
                $mysqli -> query("UPDATE `#__graph_sub` SET `department` = 'Ресторан' WHERE `uid` = '".$rowUsDep['id']."'");
            }*/
        break;

    case 'apigraph':
        $json = file_get_contents('http://bitrix-kontinent.ru:5228/fb/index.php?password=Vfhnbyb123&datestart='.$_GET['datestart'].'%2000:00:00&datestop='.$_GET['datestop'].'%2023:59:59&sid='.$_GET['sid'].'&dvs=123');
        echo $json;
        break;
    case 'stat':
        $weekGet = explode('-', $_GET['w']);
        $weekHashStat = $weekGet[0] . '' . $weekGet[1];
        $nameRUfood = array("breakfast" => "Завтрак", "lunch" => "Обед", "dinner" => "Ужин");
        if ($_GET['update'] == 'update'){
            $weekNumDay = array("Monday" => "1", "Tuesday" => "2", "Wednesday" => "3", "Thursday" => "4", "Friday" => "5", "Saturday" => "6", "Sunday" => "7");
            $foodDay = array("breakfast" => array("name" => "Завтрак", "nameEn" => "breakfast", "time" => array("in" => "07:15:00", "end" => "08:15:00")),
                "lunch" => array("name" => "Обед", "nameEn" => "lunch", "time" => array("in" => "12:50:00", "end" => "14:06:00")),
                "dinner" => array("name" => "Ужин", "nameEn" => "dinner", "time" => array("in" => "18:50:00", "end" => "20:05:00"))
            );
            $reportsGroup = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__reports` GROUP BY `week`"));
            //print_r(unserialize($reportsStat[0]['array']));
            foreach($reportsGroup AS $weekBD){
                $reportsStat = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__reports` WHERE `week` = '".$weekBD['week']."'"));
                $weekStatBD = str_replace(substr($weekBD['week'], -4), '', $weekBD['week']);
                $yearStatBD = substr($weekBD['week'], -4);
                foreach($reportsStat AS $report){
                    foreach(unserialize($report['array']) AS $dayRowName => $dayRow){
                        $dateStat = strtotime($yearStatBD.'-W'.$function -> numWeekZero($weekStatBD).'-'.$weekNumDay[$dayRowName]);
                        $dc = 0;
                        foreach($dayRow AS $foodRowName => $foodRow){
                            //print_r($foodRow);
                            $c = 0;
                            $e = 0;
                            $p = 0;
                            $s = 0;
                            foreach($foodRow AS $cntUsr){
                                //$dateIN = strtotime(date('d.m.Y', $dateStat). ' '. $foodDay[$foodRowName]['time']['in']);
                                //$dateEND = strtotime(date('d.m.Y', $dateStat). ' '. $foodDay[$foodRowName]['time']['end']);
                                $user = $mysqli -> query("SELECT * FROM `#__users` WHERE `id` = '".$cntUsr."'") -> fetch_assoc();
                                //$check = $mysqli -> query("SELECT * FROM `#__logs` WHERE `time` > '".$dateIN."' and `time` < '".$dateEND."' and `sid` = '".$user['sid']."'") -> fetch_assoc();

                                //if ($check['id'] || $user['status'] == 1){
                                //$e++;
                                //} else {
                                if ($user['stat'] == 0){
                                    $c++;
                                } elseif ($user['stat'] == 1){
                                    $p++;
                                } elseif ($user['stat'] == 2){
                                    $s++;
                                }
                                //}
                            }
                            //echo $report['week'] . ' ' . $dayRowName . ' ' . $foodRowName . ' ' . $c . '<br />'; "$day + $week week $year"
                            //date('d/m/Y', $week_number * 7 * 86400 + strtotime('1/1/' . $year) - date('w', strtotime('1/1/' . $year)) * 86400 + 86400*$i);
                            //date("d.m.Y", strtotime($dayRowName.' '.$weekGet[0].' week '.$weekGet[1], mktime(0, 0, 0, 1, 1, $weekGet[1])))
                            $arrayCnt[$weekBD['week']][$dayRowName]['date'] = date('d.m.Y', $dateStat);
                            $arrayCnt[$weekBD['week']][$dayRowName]['time'] = $dateStat;
                            //$arrayCnt[$dayRowName]['food']['check'][$foodRowName] += $e;
                            $arrayCnt[$weekBD['week']][$dayRowName]['food'][$foodRowName] += $c;
                            $arrayCnt[$weekBD['week']][$dayRowName]['foodp'][$foodRowName] += $p;
                            $arrayCnt[$weekBD['week']][$dayRowName]['foods'][$foodRowName] += $s;
                        }
                    }
                }
            }
            //echo date('d.m.Y', strtotime("2020-W01-1"));
            //print_r($arrayCnt);exit();
            foreach ($arrayCnt AS $weekArray){
                foreach ($weekArray AS $dayArray){
                    /*echo $dayArray['time'] .'<br/>';*/
                    $checkBDstat = $mysqli -> query("SELECT * FROM `#__stat` WHERE `time` = '".$dayArray['time']."'") -> fetch_assoc();
                    if ($checkBDstat['id']){
                        $mysqli -> query("UPDATE `#__stat` SET
                                        `foodstat` = '".serialize($dayArray['food'])."',
                                        `foodstatp` = '".serialize($dayArray['foodp'])."',
                                        `foodstats` = '".serialize($dayArray['foods'])."',
                                        `time` = '".$dayArray['time']."' WHERE `time` = '".$checkBDstat['time']."'");
                    } else {
                        $mysqli -> query("INSERT INTO `#__stat` SET
                                        `foodstat` = '".serialize($dayArray['food'])."',
                                        `foodstatp` = '".serialize($dayArray['foodp'])."',
                                        `foodstats` = '".serialize($dayArray['foods'])."',
                                        `time` = '".$dayArray['time']."'");
                    }
                }
            }
            exit();
        }
        if (isset($_GET['dateIn']) and isset($_GET['dateOut'])){
            $dateIn = strtotime($var -> get('dateIn'));
            $dateOut = strtotime($var -> get('dateOut'));
            $statistic = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__stat` WHERE `time` >= '".$dateIn."' and `time` <= '".$dateOut."' ORDER BY `time` ASC"));
        } else {
            $statistic = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__stat` ORDER BY `time` ASC"));
        }
        $tpl -> assign(array(
            'statistic' => $statistic,
            'nameRUfood' => $nameRUfood
        ));
        $tpl -> display('statfood');
        break;

    case 'statusers':
        $weekNumDay = array("Monday" => "1", "Tuesday" => "2", "Wednesday" => "3", "Thursday" => "4", "Friday" => "5", "Saturday" => "6", "Sunday" => "7");
        $foodDay = array("breakfast" => array("name" => "Завтрак", "nameEn" => "breakfast", "time" => array("in" => "07:15:00", "end" => "08:15:00")),
            "lunch" => array("name" => "Обед", "nameEn" => "lunch", "time" => array("in" => "12:50:00", "end" => "14:06:00")),
            "dinner" => array("name" => "Ужин", "nameEn" => "dinner", "time" => array("in" => "18:50:00", "end" => "20:05:00"))
        );
        $nameRUfood = array("breakfast" => "Завтрак", "lunch" => "Обед", "dinner" => "Ужин");
        if ($_GET['update'] == 'update'){
            $reportsGroup = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__reports`  WHERE `department` = 'Служба безопасности' GROUP BY `week`"));
            foreach($reportsGroup AS $weekBD){
                $reportsStat = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__reports` WHERE `week` = '".$weekBD['week']."'"));
                $weekStatBD = str_replace(substr($weekBD['week'], -4), '', $weekBD['week']);
                $yearStatBD = substr($weekBD['week'], -4);
                foreach($reportsStat AS $report){
                    foreach(unserialize($report['array']) AS $dayRowName => $dayRow){
                        $dateStat = strtotime($yearStatBD.'-W'.$function -> numWeekZero($weekStatBD).'-'.$weekNumDay[$dayRowName]);
                        $dc = 0;
                        foreach($dayRow AS $foodRowName => $foodRow){
                            //print_r($foodRow);
                            $c = 0;
                            $e = 0;
                            foreach($foodRow AS $cntUsr){
                                //$dateIN = strtotime(date('d.m.Y', $dateStat). ' '. $foodDay[$foodRowName]['time']['in']);
                                //$dateEND = strtotime(date('d.m.Y', $dateStat). ' '. $foodDay[$foodRowName]['time']['end']);
                                if ($cntUsr == '83' || $cntUsr == '82' || $cntUsr == '180'){
                                    $user = $mysqli -> query("SELECT * FROM `#__users` WHERE `id` = '".$cntUsr."'") -> fetch_assoc();
                                    //$check = $mysqli -> query("SELECT * FROM `#__logs` WHERE `time` > '".$dateIN."' and `time` < '".$dateEND."' and `sid` = '".$user['sid']."'") -> fetch_assoc();
                                    $log[$weekBD['week']][$report['id']]['name'] = $report['department'];
                                    $log[$weekBD['week']][$report['id']][$dayRowName]['date'] = date('d.m.Y', $dateStat);
                                    $log[$weekBD['week']][$report['id']][$dayRowName][$foodRowName][$cntUsr] = $user['surname'].' '.$user['name'].' '.$user['secondname'].' '.$c;
                                    $count[$dateStat]['time'] = $dateStat;
                                    $count[$dateStat]['serialize'][$cntUsr]['name'] = $user['surname'].' '.$user['name'].' '.$user['secondname'];
                                    $count[$dateStat]['serialize'][$cntUsr]['food'][$foodRowName] = true;
                                    //if ($check['id'] || $user['status'] == 1){
                                    //$e++;
                                    //} else {
                                    $c++;
                                    //}
                                }
                            }
                            //echo $report['week'] . ' ' . $dayRowName . ' ' . $foodRowName . ' ' . $c . '<br />'; "$day + $week week $year"
                            //date('d/m/Y', $week_number * 7 * 86400 + strtotime('1/1/' . $year) - date('w', strtotime('1/1/' . $year)) * 86400 + 86400*$i);
                            //date("d.m.Y", strtotime($dayRowName.' '.$weekGet[0].' week '.$weekGet[1], mktime(0, 0, 0, 1, 1, $weekGet[1])))
                            //$arrayCnt[$weekBD['week']][$dayRowName]['date'] = date('d.m.Y', $dateStat);
                            //$arrayCnt[$weekBD['week']][$dayRowName]['time'] = $dateStat;
                            //$arrayCnt[$weekBD]['week'][$dayRowName]['user'] = $user;
                            //$arrayCnt[$weekBD['week']][$dayRowName]['food'][$foodRowName] += $c;
                        }
                    }
                }
            }
            foreach ($count AS $dayArray){
                /*echo $dayArray['time'] .'<br/>';*/
                $checkBDstat = $mysqli -> query("SELECT * FROM `#__stat_secur` WHERE `time` = '".$dayArray['time']."'") -> fetch_assoc();
                if ($checkBDstat['id']){
                    $mysqli -> query("UPDATE `#__stat_secur` SET
                                        `foodstat` = '".serialize($dayArray['serialize'])."',
                                        `time` = '".$dayArray['time']."' WHERE `time` = '".$checkBDstat['time']."'");
                } else {
                    $mysqli -> query("INSERT INTO `#__stat_secur` SET
                                        `foodstat` = '".serialize($dayArray['serialize'])."',
                                        `time` = '".$dayArray['time']."'");
                }
            }
        }
        if (isset($_GET['dateIn']) and isset($_GET['dateOut'])){
            $dateIn = strtotime($var -> get('dateIn'));
            $dateOut = strtotime($var -> get('dateOut'));
            $statistic = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__stat_secur` WHERE `time` >= '".$dateIn."' and `time` <= '".$dateOut."' ORDER BY `time` ASC"));
        } else {
            $statistic = $mysqli -> cycle($mysqli -> query("SELECT * FROM `#__stat_secur` ORDER BY `time` ASC"));
        }
        $tpl -> assign(array(
            'statistic' => $statistic,
            'nameRUfood' => $nameRUfood
        ));
        $tpl -> display('statfoodsecur');
        break;
}
?>