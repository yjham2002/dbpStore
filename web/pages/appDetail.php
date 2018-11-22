<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 31/10/2018
 * Time: 5:19 PM
 */
?>
<?include_once "../inc/header.php";?>
<?
    $appData = $userSVC->appInfo();

    $data = $appData["data"];
    $commentList = $appData["extra"];
?>
    <script src="<?=$CONST_URL_WEB?>/js/rater.js"></script>

    <script>
        $(document).ready(function(){
            var options = {
                max_value: 5,
                step_size: 0.1,
                selected_symbol_type: 'utf8_star',
                readonly: true
            }

            $(".rating").rate(options);

            $(".jLike").click(function(){
                var currentItem = $(this);
                var commentPId = $(this).attr("pid");
                var flag = $(this).attr("flag");
                var ajax = new AjaxSender("<?=$CONST_URL_SHARED?>/shared/public/route.php?F=UserSVC.setLike", false, "json",
                new sehoMap().put("commentPId", commentPId).put("flag", flag));
                ajax.send(function(data){
                    if(data.code === 1){
                        if(flag === "true"){
                            $(currentItem).removeClass("fas");
                            $(currentItem).addClass("far");
                            $(currentItem).attr("flag", "false");
                        }
                        else{
                            $(currentItem).removeClass("far");
                            $(currentItem).addClass("fas");
                            $(currentItem).attr("flag", "true");
                        }
                    }
                    else alert(data.message);
                });
            });

            $(".jWish").click(function(){
                var ajax = new AjaxSender("<?=$CONST_URL_SHARED?>/shared/public/route.php?F=UserSVC.setWishItem", false, "json",
                new sehoMap().put("appId", $("[name=appId]").val()));
                ajax.send(function(data){
                    if(data.code === 1){
                        alert("추가되었습니다.");
                    }
                    else{
                        alert(data.message);
                        location.reload();
                    }
                });
            });

            $(".jDownload").click(function(){
                //download function
            });
        });
    </script>

    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a><?=$categoryInfo["data"]["desc"]?></a>
            </li>
        </ol>

        <div class="row">
            <input type="hidden" name="appId" value="<?=$_REQUEST["id"]?>"/>
            <div class="col-xl-2 col-sm-3 mb-3">
                <div class="card text-dark bg-white o-hidden h-100 border-0">
                    <div class="card-body text-center p-0">
                        <img src="<?=$CONST_URL_WEB?>/img/PickleCode_logo.png" width="100%" height="100%"/>
                    </div>
                </div>
            </div>

            <div class="col">
                <div>
                    <h1><small><?=$data["appTitle"]?></small></h1>
                </div>

                <div>
                    <a href="#" class="mr-3"><u><?=$data["desc"]?></u></a> <?=$data["category"]?>
                    <div class="float-right">
                        <div class="rating h-auto mr-5" data-rate-value="<?=$data["average"]?>"></div>
                        <div class="float-right">
                            <?=$data["cnt"]?>
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>

                <div class="mt-4 float-right">
                    <button class="btn jWish">
                        <i class="fas fa-plus-square"></i>
                        <a>위시리스트에 추가</a>
                    </button>

                    <button class="btn btn-success jDownload">설치</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div id="carouselExampleIndicators" class="carousel slide h-25" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active" style="background-color:black"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1" style="background-color:black"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2" style="background-color:black"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="<?=$CONST_URL_WEB?>/img/PickleCode_logo.png" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="<?=$CONST_URL_WEB?>/img/PickleCode_logo.png" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="<?=$CONST_URL_WEB?>/img/PickleCode_logo.png" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <div class="row">
            <?foreach($commentList as $commentItem){?>
                <div class="container h-100 ml-5 mr-5 mt-2 mb-1">
                    <div class="row">
                        <div class="col-xl-2 col-sm-3 p-0">
                            <p class="mb-1">
                                <?=$commentItem["name"]?>
                                <a class="small font-weight-light ml-1"><?=$commentItem["regDate"]?></a>
                            </p>
                            <div class="rating mr-5" data-rate-value="<?=$commentItem["rate"]?>"></div>
                        </div>

                        <div class="col">
                            <div class="float-right h-100">
                                <i class="<?=$commentItem["likeFlag"] == 1 ? "fas" : "far"?> fa-thumbs-up jLike mr-3" pid="<?=$commentItem["commentPId"]?>" flag="<?=$commentItem["likeFlag"] == 1 ? "true" : "false"?>" style="font-size: 1.5em;"></i>
                                <i class="fa fa-ellipsis-v" data-toggle="dropdown"></i>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div>
                        <?=$commentItem["content"]?>
                    </div>
                </div>
            <?}?>
        </div>
    </div>
<?include_once $_SERVER["DOCUMENT_ROOT"] . $CONST_URL_WEB . "/inc/footer.php";
