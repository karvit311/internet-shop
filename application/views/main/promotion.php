<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Promotion</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <?php
        $products_pagination = new \Application\models\Promotion();
        $res_products_pagination = $products_pagination->get_total_by_promotion();
        foreach($res_products_pagination as $res_product_pagination) {
            $total = $res_product_pagination['total'];
            $adjacents = 3;
            $page = $_GET['page'];
            $targetpage = "/main/Promotion/?"; //your file name
            $limit =4; //how many items to show per page
            if (isset($_GET['page'])) {
                $start = ($page - 1) * $limit; //first item to display on this page
            } else {
                $start = 0;
            }
            /* Setup page vars for display. */
            if ($page == 0) $page = 1; //if no page var is given, default to 1.
            $prev = $page - 1; //previous page is current page - 1
            $next = $page + 1; //next page is current page + 1
            $lastpage = ceil($total / $limit); //lastpage.
            $lpm1 = $lastpage - 1; //last page minus 1
            $today = date("Y-m-d");
            $products = new \Application\models\Promotion();
            $res_promotions = $products->get_promotions_actual($today,$limit,$start);
            $res_promotions->execute();
            include("pagination.php"); ?>
            <div class="container">
                <div class="row">
                    <div id="breadcrumbs-products">
                        <ul>
                            <li><a class="btn btn-default come_back"  href="/main/menu" role="button"><span class="glyphicon glyphicon-arrow-left"></span>  Вернуться</a></li>
                            <li><a class="btn btn-light" href="/main/about" role="button">AllPAN</a></li>
                            <li class="greater-sign"> ></li>
                            <li> <a class="btn btn-light" href="#" role="button">Promotion </a></li>
                        </ul>
                    </div>
                    <!-- DELETING SUCCESS-->
                    <div class="alert alert-success deleting_product alert-dismissable" style="display: none;" id="flash-msg-deleting-promotion">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <h4><i class="icon fa fa-check"></i>Success!</h4><p>Promotion've  successfully deleted!</p>
                    </div>
                    <div class="wrapper">
                        <!-- Sidebar -->
                        <nav id="sidebar">
                            <div class="sidebar-header">
                                <h3>Other adjustments</h3>
                            </div>
                            <ul class="list-unstyled components">
                                <li>
                                    <a href="/main/BeOver/?page=1" >Will soon be over  </a>
                                </li>
                                <li>
                                    <a href="/main/News/?page=1">New products</a>
                                </li>
                                <li>
                                    <a href="/main/Popular/?page=1">Popular products</a>
                                </li>
                                <li>
                                    <a href="/main/Discount/?page=1">Discounts</a>
                                </li>
                                <li>
                                    <a href="/main/SpecialOffers/?page=1">Special Offers</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Video -->
                    <div class="video_left_block">
                        <iframe class="" src="https://www.youtube.com/embed/vlDzYIIOYmM" allowfullscreen width="265px"></iframe>
                    </div>
                    <div id="all_promotion" >
                        <?php foreach ($res_promotions as $res_promotion){
                            $date = date_create($res_promotion['end_date']);
                            $end_date =  date_format($date,'d F');
                           ?>
                            <div class="promotion">
                                <?php if($res_promotion['type'] == 'Максимальная скидка' || $res_promotion['type'] == 'Только у нас'){?>
                                    <div class="left_block"><?= $res_promotion['left_block'];?></div>
                                <?php }else{?>
                                    <div class="left_block_img"><img src="/application/photo/icons/<?= $res_promotion['left_block'];?>" width="100px" height="100px"></div>
                                <?php }?>
                                <div class="main_body">
                                    <button class="btn btn-success main_body_button"><?= $res_promotion['type'];?></button>
                                    <p class="main_body_title"><?= $res_promotion['title'];?></p>
                                    <p class="main_body_essence"><?= $res_promotion['value_promotion']; ?></p>
                                </div>
                                <div class="addition_type_promotion"><button promotion_id="<?=  $res_promotion['id'];?>" class="btn btn-primary"><a href="/main/promotionsProducts/?promotion_id=<?=  $res_promotion['id'];?>&page=1">Воспользоваться</a></button><p >Истекает <?= $end_date;?></p></div>
                            </div>
                        <?php }?>
                    </div>
                </div>
                <?php
                    echo $pagination;
                ?>
            </div>
        <?php }?>
    </body>
</html>
<script src="/application/js/promotion-index.js"></script>