<?php $this -> display('head-admin', array('title' => 'Админка'));?>

<style>
    .navbar-rev {
        margin-bottom: 70px;
    }
    .content {
        margin-top: 25px;
    }
    .form-control {
        width: 440px;
    }
</style>

<script>
    $(window).load(function(){
        if(window.location.hash){
            $('a[href="'+window.location.hash+'"]').trigger('click');
        }
    });

    $(document).on('click', 'a[data-toggle="tab"]', function(){
        window.location.hash = $(this).attr('href');
    })
</script>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?=$set['site']?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?=$set['http']?>?action=exit&exit=add" class="btn btn-danger btn-sm">Выйти</a> </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div class="navbar-rev"></div>

<div class="bs-example bs-example-tabs">
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#home" data-toggle="tab">Главная</a>
        </li>
        <li>
            <a href="#about" data-toggle="tab">О нас</a>
        </li>
        <li>
            <a href="#contact" data-toggle="tab">Контакты</a>
        </li>
        <li>
            <a href="#subscribe" data-toggle="tab">Подписаться</a>
        </li>
        <li>
            <a href="#subscribe-mail" data-toggle="tab">Подписчики</a>
        </li>
    </ul>
    <div class="tab-content content">
        <div class="tab-pane fade in active" id="home">

                <div class="col-md-12">
                    <form method="POST">
                        <input type="text" name="page-name" value="home" hidden>
                        <div class="form-group">
                            <label>Заголовок</label>
                            <input type="text" name="title" class="form-control" value="<?=$page['home']['title']?>" placeholder="Заголовок">
                        </div>
                        <div class="form-group">
                            <label>Описание</label>
                            <input type="text" name="description" class="form-control" value="<?=$page['home']['description']?>" placeholder="Описание">
                        </div>
                        <button type="submit" class="btn btn-default">Применить</button>
                    </form>
                </div>

        </div>
        <div class="tab-pane fade" id="about">

            <div class="col-md-12">
                <form method="POST">
                    <input type="text" name="page-name" value="about" hidden>
                    <div class="form-group">
                        <label>Название</label>
                        <input type="text" name="name" class="form-control" value="<?=$page['about']['name']?>"  placeholder="Название">
                    </div>
                    <div class="form-group">
                        <label>Заголовок</label>
                        <input type="text" name="header" class="form-control" value="<?=$page['about']['header']?>" placeholder="Заголовок">
                    </div>
                    <div class="form-group">
                        <label>Описание
                            <textarea  rows="10" name="description" class="form-control"><?=$page['about']['description']?></textarea>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Применить</button>
                </form>
            </div>

        </div>

        <div class="tab-pane fade" id="contact">

            <div class="col-md-12">
                <form method="POST">
                    <input type="text" name="page-name" value="contact" hidden>
                    <div class="form-group">
                        <label>Адрес
                            <textarea name="address" class="form-control"><?=$page['contact']['address']?></textarea>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Телефоны
                            <textarea name="phone" class="form-control"><?=$page['contact']['phone']?></textarea>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Почта
                            <textarea name="mails" class="form-control"><?=$page['contact']['mails']?></textarea>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Применить</button>
                </form>
            </div>

        </div>

        <div class="tab-pane fade" id="subscribe">

            <div class="col-md-12">
                <form method="POST">
                    <input type="text" name="page-name" value="subscribe" hidden>
                    <div class="form-group">
                        <label>Заголовок</label>
                        <input type="text" name="title" class="form-control" value="<?=$page['subscribe']['title']?>" placeholder="Заголовок">
                    </div>
                    <div class="form-group">
                        <label>Описание
                            <textarea name="description" class="form-control"><?=$page['subscribe']['description']?></textarea>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Применить</button>
                </form>
            </div>

        </div>

        <div class="tab-pane fade" id="subscribe-mail">

            <div class="col-md-4">
                <?php if($subscribe) : ?>
                <ul class="list-group">
                    <?php foreach($subscribe AS $email) : ?>
                            <li class="list-group-item"><?=$email['emails']?></li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                    <p>Ничего нет</p>
                <?php endif;?>
            </div>

        </div>
    </div>
</div>

<?php $this -> display('foot-admin'); ?>