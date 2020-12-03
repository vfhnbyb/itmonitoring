<?php $this -> display('head-admin', array('title' => 'Авторизация'));?>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <form role="form" action="<?=$set['http']?>admin/" class="form" method="GET">
            <input type="text" name="go" value="1" hidden>
            <div class="form-group">
                <label>Логин</label>
                <input type="text" name="login" class="form-control input-lg" placeholder="Логин">
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" class="form-control input-lg" placeholder="Пароль">
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Войти</button>
        </form>
    </div>
</div>
<?php $this -> display('foot-admin'); ?>