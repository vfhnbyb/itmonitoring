<?php $this -> display('head', array('title' => 'Главная'));?>

<style>
    .contact-form .button-box {
        margin-top: 25px;
    }
</style>

<header class="site-header">
    <div class="row header-wrap">
        <div class="col-sm-5 header-box">
            <div id="main-menu" class="main-menu">
                <ul>
                    <li>
                        <a href="#about">
							<span class="hidden-xs hidden-sm">
								<i class="hover-label">О нас</i>
								О нас
							</span>
                            <span class="hidden-md hidden-lg icon">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="//www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 25 25" enable-background="new 0 0 25 25" xml:space="preserve" width="25" height="25">
									<path fill="#333333" d="M12.5,25C5.6,25,0,19.4,0,12.5C0,5.6,5.6,0,12.5,0C19.4,0,25,5.6,25,12.5C25,19.4,19.4,25,12.5,25L12.5,25z
									M12.5,0.9C6.1,0.9,0.9,6.1,0.9,12.5c0,6.4,5.2,11.6,11.6,11.6c6.4,0,11.6-5.2,11.6-11.6C24.1,6.1,18.9,0.9,12.5,0.9L12.5,0.9z
									M11.6,20.2V9.3h1.8v10.9H11.6L11.6,20.2z M12.5,7.5c-0.8,0-1.4-0.6-1.4-1.4c0-0.8,0.6-1.4,1.4-1.4c0.8,0,1.4,0.6,1.4,1.4
									C13.9,6.9,13.3,7.5,12.5,7.5L12.5,7.5z"/>
								</svg>
							</span>
                        </a>
                    </li><!--
					--><li>
                        <a href="#contact">
							<span class="hidden-xs hidden-sm">
								<i class="hover-label">Контакты&nbsp;</i>
								Контакты
							</span>
                            <span class="hidden-md hidden-lg icon">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="//www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 29 18" enable-background="new 0 0 29 18" xml:space="preserve" width="29" height="18">
									<path fill="#333333" d="M26.4,0H2.6C1.2,0,0,1.2,0,2.6v12.9C0,16.8,1.2,18,2.6,18h23.7c1.5,0,2.6-1.1,2.6-2.6V2.6
									C29,1.2,27.8,0,26.4,0L26.4,0z M26.4,1c0.2,0,0.3,0,0.4,0.1l-12.3,9.5L2.2,1.1C2.3,1.1,2.5,1,2.6,1H26.4L26.4,1z M2.6,17
									c-0.2,0-0.3,0-0.4-0.1l8.4-6.5L9.8,9.7l-8.4,6.5c-0.2-0.2-0.3-0.5-0.3-0.8V2.6c0-0.3,0.1-0.6,0.3-0.8l13.2,10.2L27.7,1.7
									c0.2,0.2,0.3,0.5,0.3,0.8v12.9c0,0.3-0.1,0.6-0.3,0.8l-8.5-6.5l-0.8,0.7l8.4,6.5c-0.1,0-0.3,0.1-0.4,0.1H2.6L2.6,17z"/>
								</svg>
							</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div><!-- .header-box -->

        <div class="col-sm-2 header-box logo-box text-center">
            <a href="/"><img src="<?=$set['http']?><?=$set['them']?>img/logo.png" width="108" height="78" alt="#"></a>
        </div><!-- .header-box -->

        <div class="col-sm-5 header-box text-right hidden-xs">
            <!-- demonstration - //keith-wood.name/countdownRef.html -->
            <div class="countdown-box">
                <div class="countdown" data-date="2021, 10, 1"></div>
            </div>
        </div><!-- .header-box -->
    </div>
</header><!-- .site-header -->

<div class="main">
    <section id="home" class="section active">
        <div class="section-wrap">
            <div class="section-content">
                <div class="container">
                    <div class="text-center">
                        <div class="clearfix"></div>
                        <h1 class="h1-section-title"
                            data-animation="fadeInDown"
                            data-out-animation="fadeOutUp"
                            data-out-animation-delay="300"><?=$page['home']['title']?></h1>

                        <div class="row section-description">
                            <div class="col-sm-8 col-sm-offset-2">
                                <p class="lead"
                                   data-animation="fadeInDown"
                                   data-animation-delay="300"
                                   data-out-animation="fadeOutUp"
                                   data-out-animation-delay="300"><?=$page['home']['description']?></p>
                            </div>
                        </div>

                        <a href="#"
                           class="btn btn-default"
                           data-hover="Подписаться"
                           data-animation="fadeInDown"
                           data-animation-delay="600"
                           data-out-animation="fadeOutUp"
                           data-out-animation-delay="600"
                           data-toggle="modal"
                           data-target="#notify-my"><span class="button-label">Подписаться&nbsp;&nbsp;</span></a>
                    </div>
                </div>
            </div><!-- .section-content -->
        </div><!-- .section-wrap -->
    </section><!-- #home.section -->

    <section id="about" class="section">
        <div class="section-wrap">
            <div class="section-content">
                <div class="container app-about">
                    <h2 class="text-center section-title"
                        data-animation="fadeInDown"
                        data-animation-delay="100"
                        data-out-animation="fadeOutUp"
                        data-out-animation-delay="900"><?=$page['about']['name']?></h2>

                    <div class="row">
                        <div class="col-sm-6 text-center">
                            <!--<a href="defendocs.com"
                               class="show-video"
                               data-toggle="modal"
                               data-target="#video"
                               data-animation="fadeInDown"
                               data-animation-delay="600"
                               data-out-animation="fadeOutUp"
                               data-out-animation-delay="600">
                                <img src="content/img/app-video.png" class="replace-2x" width="460" height="250" alt="484426293">
                                <span class="icon"><i class="fa fa-play"></i></span>
                            </a> -->
                            <iframe src="https://player.vimeo.com/video/484426293?title=0&byline=0&portrait=0" width="460" height="250" frameborder="0"></iframe>
                        </div>

                        <div class="col-sm-6 col-md-5 col-md-offset-1 xs-text-center description">
                            <h5 class="title"
                                data-animation="fadeInDown"
                                data-animation-delay="700"
                                data-out-animation="fadeOutUp"
                                data-out-animation-delay="300"><?=$page['about']['header']?>
                            </h5>

                            <p class="text"
                               data-animation="fadeInDown"
                               data-animation-delay="500"
                               data-out-animation="fadeOutUp"
                               data-out-animation-delay="500"><?=$page['about']['description']?>
                            </p>


                        </div>
                    </div>
                </div>
            </div><!-- .section-content -->
        </div><!-- .section-wrap -->
    </section><!-- #about.section -->

    <section id="contact" class="section">
        <div class="section-wrap">
            <div class="section-content">
                <div class="container">
                    <div class="contact-wrap relative">
                        <div class="row">
                            <div class="col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                                <h2 class="text-center section-title"
                                    data-animation="fadeInDown"
                                    data-animation-delay="900"
                                    data-out-animation="fadeOutUp"
                                    data-out-animation-delay="100">Контакты</h2>

                                <form class="contact-form" method="post">
                                    <div class="row">
                                        <div class="col-sm-6 form-group name">
                                            <input type="text"
                                                   class="form-control"
                                                   name="name"
                                                   placeholder="Имя"
                                                   data-animation="fadeInLeft"
                                                   data-animation-delay="100"
                                                   data-out-animation="fadeOutLeft"
                                                   data-out-animation-delay="900">
                                        </div>

                                        <div class="col-sm-6 form-group email">
                                            <input type="email"
                                                   class="form-control"
                                                   name="email"
                                                   placeholder="Email"
                                                   data-animation="fadeInLeft"
                                                   data-animation-delay="100"
                                                   data-out-animation="fadeOutLeft"
                                                   data-out-animation-delay="900">
                                        </div>
                                    </div>

                                    <div class="form-group comment">
										<textarea class="form-control"
                                                  name="comment"
                                                  placeholder="Сообщение"
                                                  data-animation="fadeInLeft"
                                                  data-animation-delay="100"
                                                  data-out-animation="fadeOutLeft"
                                                  data-out-animation-delay="900"></textarea>
                                    </div>

                                    <div class="button-box text-center">
                                        <button type="submit"
                                                data-hover="Отправить"
                                                class="btn btn-default progress-button btn-submit"
                                                data-animation="fadeInDown"
                                                data-animation-delay="900"
                                                data-out-animation="fadeOutUp"
                                                data-out-animation-delay="100">
                                            <span class="button-label">Отправить</span>
                                            <span class="success">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="//www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 29 23" enable-background="new 0 0 29 23" xml:space="preserve">
													<polyline fill="#FFFFFF" points="0.3,10.2 1.8,8.8 11.4,19.3 27.4,0.4 28.9,1.7 12.9,20.6 11.5,22.3 9.9,20.6 0.3,10.2 "/>
												</svg>
											</span>
                                            <span class="Ошибка"></span>
                                            <span class="Загрузка"></span>
                                        </button>
                                    </div>
                                </form>

                                <div class="row">
                                    <div class="col-sm-5 col-md-5">
                                        <div class="contacts-box xs-text-center"
                                             data-animation="fadeInDown"
                                             data-animation-delay="1000"
                                             data-out-animation="fadeOutUp"
                                             data-out-animation-delay="100">
                                            <div class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="//www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15 23" enable-background="new 0 0 15 23" xml:space="preserve" width="15" height="23">
													<path fill="#111111" d="M7.5,0C3.4,0,0,3.4,0,7.6c0,1.7,1.1,4.4,3.3,8.4c1.5,2.8,3.1,5.2,3.1,5.3L7.5,23l1.1-1.7
													c0.1-0.1,1.6-2.4,3.1-5.3c2.2-4,3.3-6.7,3.3-8.4C15,3.4,11.6,0,7.5,0L7.5,0z M7.5,11.5c-2.1,0-3.9-1.8-3.9-3.9
													c0-2.2,1.7-3.9,3.9-3.9c2.1,0,3.9,1.8,3.9,3.9C11.4,9.7,9.6,11.5,7.5,11.5L7.5,11.5z"/>
												</svg>
                                            </div>
                                            <div class="text">
                                                <a href="#map" class="map-show"><?=$page['contact']['address']?></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 col-md-3">
                                        <div class="contacts-box xs-text-center"
                                             data-animation="fadeInDown"
                                             data-animation-delay="1000"
                                             data-out-animation="fadeOutUp"
                                             data-out-animation-delay="100">
                                            <div class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="//www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 21" enable-background="new 0 0 20 21" xml:space="preserve" width="20" height="21">
													<path fill="#111111" d="M1.6,2.1c0.3-0.3,0.8-0.7,1.2-0.9C3.3,0.8,4,1,4.9,1.6c1.2,0.8,2.8,2.6,2.6,4.1c-0.1,0.6-0.4,1.2-1,1.8
													C6,8,5.4,8.4,4.9,8.7l7.4,7.3c0.3-0.5,0.7-1.1,1.2-1.7c0.6-0.6,1.2-0.9,1.8-0.9c1.5-0.1,3.4,1.7,4.2,3c0.5,0.8,0.6,1.4,0.3,1.8
													c-0.3,0.5-0.7,1-1.1,1.4c-2.6,2.6-6.3,1.4-8.1,0.2c-1-0.7-3.4-2.5-5.3-4.4c-2-2-3.5-4-4.3-5.1C0.4,9.1-1.2,4.8,1.6,2.1L1.6,2.1z"/>
												</svg>
                                            </div>
                                            <div class="text">
                                                <?=$page['contact']['phone']?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="contacts-box xs-text-center"
                                             data-animation="fadeInDown"
                                             data-animation-delay="1000"
                                             data-out-animation="fadeOutUp"
                                             data-out-animation-delay="100">
                                            <div class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="//www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 16" enable-background="new 0 0 24 16" xml:space="preserve" width="24" height="16">
													<path fill="#111111" d="M12,9.8L1.1,1.3C1.4,1.1,1.8,1,2.2,1h19.6c0.4,0,0.8,0.1,1.1,0.3L12,9.8L12,9.8z M23.6,15.1l-7.7-6l-0.7,0.5
													l7.7,6c-0.3,0.2-0.7,0.3-1.1,0.3H2.2c-0.4,0-0.8-0.1-1.1-0.3l7.7-6.1L8.1,9.1l-7.7,6C0.2,14.8,0,14.3,0,13.9V3.1
													c0-0.5,0.2-0.9,0.4-1.3l11.6,9l11.6-9C23.8,2.2,24,2.7,24,3.1v10.7C24,14.3,23.8,14.8,23.6,15.1L23.6,15.1z"/>
												</svg>
                                            </div>
                                            <div class="text">
                                                <?=$page['contact']['mails']?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div id="map" class="map-box">
                            <div class="map-wrap">
                                <a href="#" class="close">&times;</a>

                                <div
                                        class="map-canvas"
                                        data-zoom="6"
                                        data-lat="40.748441"
                                        data-lng="-73.985664"
                                        data-title="Bryant Park"
                                        data-content="New York, NY">
                                </div>
                            </div>
                        </div>
                    </div><!-- .contact-wrap -->
                </div>
            </div><!-- .section-content -->
        </div><!-- .section-wrap -->
    </section><!-- #contact.section -->
</div><!-- .main -->

<footer class="site-footer">
    <div class="container-fluid text-center">
        <div class="copyright"><br>
            ©  2020. Defendocs</div>
        <div class="social">
            <a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
            <a href="https://www.linkedin.cn/"><i class="fa fa-linkedin"></i></a>
        </div>
    </div>
</footer><!-- .site-footer -->

<div class="modal fade text-center notify-my" id="notify-my" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <div class="modal-body">
                <h4 class="modal-title"><?=$page['subscribe']['title']?></h4>
                <p><?=$page['subscribe']['description']?></p>

                <form class="under-construction" method="post">
                    <div class="form-group email">
                        <input class="form-control email" type="email" name="email" placeholder="введите адрес e-mail">
                    </div>
                    <button data-hover="отправить" class="btn btn-default btn-block progress-button send-email">
                        <span class="button-label">Отправить</span>
                        <span class="success">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="//www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 29 23" enable-background="new 0 0 29 23" xml:space="preserve">
								<polyline fill="#FFFFFF" points="0.3,10.2 1.8,8.8 11.4,19.3 27.4,0.4 28.9,1.7 12.9,20.6 11.5,22.3 9.9,20.6 0.3,10.2 "/>
							</svg>
						</span>
                        <span class="ошибка"></span>
                        <span class="заргузка"></span>
                    </button>
                </form>

                <!-- MailChimp -->
                <!--<form action="" method="post" name="mc-embedded-subscribe-form" class="validate mailchimp" target="_blank" novalidate>
                    <div id="mc_embed_signup_scroll">
                    <div class="mc-field-group form-group">
                        <label for="mce-EMAIL">Email Address  <span class="asterisk">*</span></label>
                        <input type="email" value="" name="EMAIL" class="required email form-control" id="mce-EMAIL">
                    </div>
                    <div id="mce-responses" class="clear">
                        <div class="response" id="mce-error-response" style="display:none"></div>
                        <div class="response" id="mce-success-response" style="display:none"></div>
                    </div>
                    <div style="position: absolute; left: -5000px;">
                        <input type="text" name="b_69007f000c70b89e124b9308d_1225ba8aee" tabindex="-1" value="">
                    </div>
                    <div class="clearfix">
                        <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button btn btn-default">
                    </div>
                    </div>
                </form>-->
            </div>
        </div>
    </div>
</div><!-- .notify-my -->

<div class="modal fade full-modal" id="video" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>

    <div class="modal-dialog">
        <div class="container modal-content">
            <div class="content-wrap">
                <div class="content-align">
                    <div class="video-box vimeo-video text-center" data-autoplay="true">
                        <iframe src="//player.vimeo.com/video/102553634" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- .full-modal -->

<?php $this -> display('foot'); ?>