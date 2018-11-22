<?include_once "inc/header.php";?>
<?
$categoryInfo = $userSVC->categoryInfo();
$appList = $userSVC->appList();
?>

<script>
    $(document).ready(function(){
        $(".jView").click(function(){
            var id = $(this).attr("id");
            location.href = "<?=$CONST_URL_WEB?>/pages/appDetail.php?id=" + id;
        });
    });
</script>

<div class="container-fluid">

    <?if($_REQUEST["categoryId"] == "") {?>
        <?if($_REQUEST["searchTxt"] == ""){ ?>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">전체보기</li>
            </ol>
        <? }else{?>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">'<?=$_REQUEST["searchTxt"]?>'의 검색결과</li>
            </ol>
        <?}?>
    <?}else {?>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">소프트웨어</li>
            <li class="breadcrumb-item active">
                <a><?=$categoryInfo["data"]["desc"]?></a>
            </li>
        </ol>
    <?}?>

    <div class="row">

        <?foreach($appList["data"] as $item){?>
            <div class="col-xl-2 col-sm-3 mb-3">
                <div class="card text-dark bg-white o-hidden h-100">
                    <div class="card-body text-center p-0">
                        <img src="<?=$CONST_URL_WEB?>/img/PickleCode_logo.png" width="90%" height="50%"/>
                        <h5><?=$item["appTitle"]?></h5>
                        <p><?=$item["desc"]?></p>
                    </div>
                    <a class="card-footer text-dark clearfix small z-1 jView" id="<?=$item["id"]?>">
                        <span class="float-left">자세히 보기</span>
                        <span class="float-right"><i class="fas fa-angle-right"></i></span>
                    </a>
                </div>
            </div>
        <?}?>

    </div>
</div>
<?include_once $_SERVER["DOCUMENT_ROOT"] . $CONST_URL_WEB . "/inc/footer.php";?>
