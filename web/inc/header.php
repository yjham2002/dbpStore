<?
    //TODO modify include PATH
    include_once $_SERVER["DOCUMENT_ROOT"] . "/shared/public/innerRoute.php";
//    include_once $_SERVER["DOCUMENT_ROOT"] . "/AppStore/shared/public/innerRoute.php";
    $introProcess = new innerRoute();
?>

<?
    $userSVC = new UserSVC($_REQUEST);
    $list = $userSVC->categoryList();

    $CONST_URL_WEB = $introProcess->PF_URL_PATH_WEB;
    $CONST_URL_SHARED = $introProcess->PF_URL_PATH_SHARED;

    $CONST_PROJECT_NAME = "DBP 앱스토어";

    $user = $userSVC->currentUserInfo();
?>
<!DOCTYPE html>
<html lang="ko">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$CONST_PROJECT_NAME?></title>
    <link href="<?=$CONST_URL_WEB?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=$CONST_URL_WEB?>/css/sb-admin.css" rel="stylesheet">
    <link href="<?=$CONST_URL_WEB?>/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">

    <script src="<?=$CONST_URL_WEB?>/js/jquery.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script src="<?=$CONST_URL_WEB?>/js/bootstrap.bundle.js"></script>

    <script type="text/javascript" src="<?=$CONST_URL_SHARED?>/shared/modules/ajaxCall/ajaxClass.js"></script>
    <script type="text/javascript" src="<?=$CONST_URL_SHARED?>/shared/modules/sehoMap/sehoMap.js"></script>
    <script type="text/javascript" src="<?=$CONST_URL_SHARED?>/shared/modules/utils/PValidation.js"></script>
    <script type="text/javascript" src="<?=$CONST_URL_SHARED?>/shared/modules/valueSetter/sayhoValueSetter.js"></script>
</head>

<script>
    $.fn.enterHandle = function(object){
        $(this).bind("keypress", function(e){
            if(e.keyCode === 13) object.trigger("click");
        })
    };

    function verifyEmail(email){
        var regExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
        if (email.match(regExp) != null) return true;
        else return false;
    }

    $(document).ready(function(){
        $(".searchBtn").click(function(){
            location.href="<?=$CONST_URL_SHARED?>/web/index.php?searchTxt=" + encodeURI($(".jSearchTxt").val());
        });
    });

</script>

<body id="page-top">

<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="<?=$CONST_URL_WEB?>"><?=$CONST_PROJECT_NAME?></a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-5">
        <div class="input-group">
            <input type="text" class="form-control jSearchTxt" name="searchTxt" placeholder="검색">
            <div class="input-group-append">
                <button class="btn btn-primary searchBtn" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Navbar -->
    <div class="ml-auto">
        <ul class="navbar-nav float-right mr-0">
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle fa-fw"></i>
                    <?=$user != "" ? $user->name . "(" . $user->email . ") 님" : ""?>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <?if($user  == ""){?>
                        <a class="dropdown-item jToLogin" data-toggle="modal" data-target="#loginModal">로그인</a>
                        <a class="dropdown-item jToJoin" data-toggle="modal" data-target="#joinModal">회원가입</a>
                    <?}else{?>
                        <a class="dropdown-item jLogout">로그아웃</a>
                    <?}?>
                </div>
            </li>
        </ul>
    </div>
</nav>

<div id="wrapper">
    <ul class="sidebar navbar-nav">
        <?foreach($list["data"] as $item){?>
            <li class="nav-item active">
                <a class="nav-link" href="<?=$CONST_URL_WEB?>/index.php?categoryId=<?=$item["id"]?>">
                    <i class="fas fa-fw <?=$item["fa-icon"]?>"></i>
                    <span>&nbsp;<?=$item["desc"]?>&nbsp;</span>
                </a>
            </li>
        <?}?>
    </ul>

    <div id="content-wrapper">