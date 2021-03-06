<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/application/js/jquery-ui-1.12.1.custom/jquery-ui.css">
        <link rel="stylesheet" href="/application/js/jquery-ui-1.12.1.custom/jquery-ui.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/application/js/star-rating-svg-master/src/css/star-rating-svg.css">
        <link rel="stylesheet" href="/application/js/rater/styles/styles.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/application/js/dist/summernote.css">
        <link rel="stylesheet" href="/application/js/dist/summernote.min.css">
        <link rel="stylesheet" href="/application/js/dist/summernote-bs4.css">
        <link rel="stylesheet" href="/application/js/dist/summernote-bs4.min.css">
        <link rel="stylesheet" href="/application/js/dist/summernote-lite.css">
        <link rel="stylesheet" href="/application/js/dist/summernote-lite.min.css">
        <link rel="stylesheet" href="/application/css/site2.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" />
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="/application/css/css.css">
        <link rel="stylesheet" href="/application/css/footer.css">
        <script src="https://code.jquery.com/jquery-1.9.0.js" integrity="sha256-TXsBwvYEO87oOjPQ9ifcb7wn3IrrW91dhj6EMEtRLvM=" crossorigin="anonymous"></script>
        <script src="/application/js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
        <script src="/application/js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
        <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript"  src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="/application/js/jcarousellite_1.1.js"></script>
        <script src="/application/js/popper/popper.js"></script>
        <script src="/application/js/popper/popper.min.js"></script>
        <script src="/application/js/popper/tooltip.js"></script>
        <script src="/application/js/popper/tooltip.min.js"></script>
        <script src="/application/js/dist/summernote.js"></script>
        <script src="/application/js/dist/summernote.min.js"></script>
        <script src="/application/js/dist/summernote-bs4.js"></script>
        <script src="/application/js/dist/summernote-bs4.min.js"></script>
        <script src="/application/js/dist/summernote-lite.js"></script>
        <script src="/application/js/dist/summernote-lite.min.js"></script>
        <script src="/application/js/star-rating-svg-master/src/jquery.star-rating-svg.js"></script>
    </head>
    <body>
        <?php
        $ip_address = file_get_contents('https://api.ipify.org');
        if($_SESSION['email'] != ''){
            $get_cart = new \Application\models\Cart();
            $res_get_carts = $get_cart->get_cart_by_ip_address_Session_email($ip_address,$_SESSION['email']);
            $res_get_carts->execute(array($ip_address,$_SESSION['email']));
        }else{
            $get_cart = new \Application\models\Cart();
            $email = 0;
            $res_get_carts = $get_cart->get_cart_by_ip_address_Session_email($ip_address,$email);
            $res_get_carts->execute(array($ip_address,$email));
        }
        foreach ($res_get_carts as $res_get_cart){}?>
        <div id="head-index">
            <ul id="head-list-my" class="list-group">
                <li class="list-group-item"><a href="/main/index">Main</a></li>
                <li class="dropdown list-group-item ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Products <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/main/SpecialOffers/?page=1">Special offers</a></li>
                        <li><a href="/main/Discount/?page=1">Discounts</a></li>
                        <li><a href="/main/Promotion/?page=1">Promotions</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/main/index">All products</a></li>
                    </ul>
                </li>
                <li class="list-group-item"><a href="/main/about">About us</a></li>
                <?php
                if (session_status() != PHP_SESSION_NONE) {
                    if ($_SESSION['loggedin'] == 1) { ?>
                        <li class="list-group-item logout-main-index"><a href="#"><?= $_SESSION['name'] ?> (Выйти)</a></li>
                    <?php }else{?>
                        <li class="list-group-item"><a href="/main/Signup">Sign up</a></li>
                        <li class="list-group-item"><a href="/main/Login">Login</a></li>
                   <?php }
                    if($_SESSION['name'] == 'admin'){?>
                        <li class="list-group-item login-into-adminka-main-index"><a href="/admin/adminka">Войти в админку</a></li>
                    <?php } ?>
                    <?php
                }else{?>
                <?php }?>
                <li class="list-group-item mycart"><a href="#"><?= $res_get_cart['total'];?> <span class="glyphicon glyphicon-shopping-cart"></span></a></li>
            </ul>
            <br>
            <br>
            <hr >
        </div>
    </body>
</html>
<script src="/application/js/head.js"></script>

