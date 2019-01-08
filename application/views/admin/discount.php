<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Discount</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <?php
        $products_pagination = new \Application\models\Product();
        $res_products_pagination = $products_pagination->get_total_by_discount();
        foreach($res_products_pagination as $res_product_pagination) {
            $total = $res_product_pagination['total'];
            $adjacents = 3;
            $page = $_GET['page'];
            $targetpage = "/admin/Discount/?"; //your file name
            $limit = 8; //how many items to show per page
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
            $products = new \Application\models\Product();
            $res_products = $products->get_prices_by_discount($limit,$start);
            $res_products->execute();
            include("pagination.php"); ?>
            <div class="container">
                <div class="row">
                    <div id="breadcrumbs-products">
                        <ul>
                            <li><a class="btn btn-default come_back " href="/admin/index"  role="button"><span class="glyphicon glyphicon-arrow-left"></span>  Вернуться</a></li>
                            <li><a class="btn btn-light" href="/admin/about" role="button">AllPAN</a></li>
                            <li class="greater-sign"> ></li>
                            <li> <a class="btn btn-light" href="#" role="button">Discount </a></li>
                        </ul>
                    </div>
                    <!-- DELETING SUCCESS-->
                    <div class="alert alert-success deleting_product alert-dismissable" style="display: none;" id="flash-msg-deleting-product">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <h4><i class="icon fa fa-check"></i>Success!</h4><p>Product've  successfully deleted!</p>
                    </div>
                    <div id="computers" >
                        <?php foreach ($res_products as $res_product){
                            $old_price = $res_product['price'];
                            $discount = ($res_product['price']*$res_product['value_discount'])/100;
                            $new_price = $res_product['price'] - $discount;
                            $date = date_create($res_product['end_date']);
                            $end_date =  date_format($date,'d F');
                           ?>
                            <div  class="column-admin <?= $res_product['brand'];?> <?= $res_product['colour'];?>" data-price="<?= $res_product['price']; ?>"  price="<?= $res_product['price']?>" >
                                <div class="column-div">
                                    <img src="/application/photo/<?= $res_product['department_id'];?>/<?= $res_product['photo'];?>" alt="<?= $res_product['name'];?>" align=left  width=215px height=215px>
                                </div>
                                <div class="info_for_phone">
                                    <ul>
                                        <li>
                                            <p class="info_name_product"><?= $res_product['name'];?></p>
                                        </li>
                                        <li>
                                            <div class="sale-count"><span><?= '-'.$res_product['value_discount'].'%'; ?></span></div>
                                            <p class="price_products"  price="<?= $res_product['price']?>"><?= $res_product['price'].' грн';?></p>
                                            <p class="new_price_products"  price="<?= $new_price?>"><?= $new_price.' грн';?></p>
                                            <p>Истекает <?= $end_date;?></p>
                                        </li>
                                    </ul>
                                </div>
                                <button type="submit" iid="<?= $res_product['id']?>" price="<?= $res_product['price']?>" name="<?= $res_product['name']?>" class="btn-default button-edit">Edit</button>
                                <button type="submit" iid="<?= $res_product['id']?>" price="<?= $res_product['price']?>" name="<?= $res_product['name']?>"  class="btn-danger button-delete">Delete</button>
                            </div>
                        <?php }?>
                    </div>
                    <!-- Modal confirm -->
                    <div class="modal" id="confirmModal" style="display: none; z-index: 1050;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body" id="confirmMessage">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" id="confirmOk">Ok</button>
                                    <button type="button" class="btn btn-default" id="confirmCancel">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="edit_product"  class="modal">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h3 class="modal-title">Edition of discount</h3>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <form method="post" enctype="multipart/form-data" class="feedback">
                                    <div class="modal-body edit_modal">
                                        <div id="modal_edit_about_images">
                                            <div class="modal_main_image_block">
                                                <h4>MAIN IMAGE</h4>
                                                <div class="image_modal_edit">
                                                    <img width=215px height=215px>
                                                </div>
                                                <div >
                                                    <input type="file" id="file" name="file"/>
                                                </div>
                                            </div>
                                            <div class="small_images">
                                                <h4>SMALL IMAGES</h4>
                                                <div class="small_images_modal_edit">
                                                </div>
                                                <div class="modal_small_img_uploads">
                                                </div>
                                                <label class="stylelabel">Галлерея картинок</label>
                                                <div id="objects">
                                                    <div id="addimage0" class="addimage">
                                                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
                                                        <input type="file" class="file" name="file[]" multiple/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="info_for_phone_modal">
                                            <ul>
                                                <li>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">ID</span>
                                                        </div>
                                                        <input type="text" class="form-control id-modal" name="id" disabled>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Name</span>
                                                        </div>
                                                        <input type="text" class="form-control name_modal_edit" name="name">
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Brand</span>
                                                        </div>
                                                        <input type="text" class="form-control brand_modal_edit" name="brand">
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Colour</span>
                                                        </div>
                                                        <input type="text" class="form-control colour_modal_edit" name="colour">
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Price</span>
                                                        </div>
                                                        <input type="text" class="form-control price_edit" name="price">
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Description</span>
                                                        </div>
                                                        <textarea class="form-control big_description" cols="54" name="big_description" ></textarea>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Adding info</span>
                                                        </div>
                                                        <textarea  class="form-control adding_info" cols="54" name="adding_info"></textarea>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Quantity</span>
                                                        </div>
                                                        <input type="number" class="form-control quantity" name="quantity" min="1"/>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group" id="checkboxes">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Discount</span>
                                                        </div>
                                                        <input id="discount" class="discount_edit" type="checkbox" name="discount" value="1"/>
                                                        <div class="discount_input">
                                                            <input type="number" placeholder="Введите скидку" class="form-control quantity_discount" disabled min="1"><br><br>
                                                            <div class='input-group date' id='datetimepicker6'>
                                                                <input type='text' class="form-control" id="bday" disabled name="bday"/>
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Promotion</span>
                                                        </div>
                                                        <input id="popular" type="checkbox" name="promotion" value="1"/>
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Popular</span>
                                                        </div>
                                                        <input id="popular" type="checkbox" name="popular" value="1"/>
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">New</span>
                                                        </div>
                                                        <input id="new_product" type="checkbox" name="new_product" value="1"/>
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Special Offer</span>
                                                        </div>
                                                        <input id="special_offer" type="checkbox" name="special_offer" value="1"/>
                                                        <div class="special_offer_input">
                                                            <textarea  placeholder="Опишите акцию" class="form-control description_special_offer" disabled ></textarea><br><br>
                                                            <div class='input-group date' id='datetimepicker8'>
                                                                <input type='text' class="form-control" id="bday_special_offer" disabled name="bday"/>
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <p><input type="submit" id="submit_form_edit" name="submit_add" value="Сохранить товар"/></p>
                                    </div>
                                </form>
                                <!-- Modal footer -->
                                <div class="modal-footer"></div>
                            </div>
                        </div>
                    </div> <!-- end edit modal -->
                </div>
                <?php
                    echo $pagination;
                ?>
            </div>
        <?php }?>
    </body>
</html>
<script src="/application/js/admin.js"></script>
<script>
    $(document).ready(function () {

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });
</script>
<script>
    $( ".column-admin .button-delete" ).each(function(index) {
        $(this).on("click", function(e){
            var iid = $(this).attr('iid');
            var YOUR_MESSAGE_STRING_CONST = "Are you sure to Delete this product?";
            confirmDialog(YOUR_MESSAGE_STRING_CONST, function(){
                $.ajax({
                    type: "POST",
                    url: "/admin/DeleteProduct",
                    data: "iid=" + iid ,
                    success: function (response) {
                        if(response == 1) {
                            $("#flash-msg-deleting-product").show();
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function () {
                        alert("Error");
                    }
                });
                console.log("deleted!");
            });
            function confirmDialog(message, onConfirm){
                var fClose = function(){
                    modal.modal("hide");
                };
                var modal = $("#confirmModal");
                modal.modal("show");
                $("#confirmMessage").empty().append(message);
                $("#confirmOk").unbind().one('click', onConfirm).one('click', fClose);
                $("#confirmCancel").unbind().one("click", fClose);
            }
        });
    });
    $('#edit_product').on("hidden.bs.modal", function() {
        location.reload();
    });
</script>
