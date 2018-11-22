<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 10. 15.
 * Time: PM 2:43
 */
include_once  "Routable.php";
class UserSVC extends Routable{

    function categoryList(){
        $sql = "
            SELECT * FROM tblCategory ORDER BY `id` ASC;
        ";
        return $this->response(1, "succ", $this->getArray($sql));
    }

    function categoryInfo(){
        $sql = "
            SELECT * FROM tblCategory WHERE `id` = '{$_REQUEST["categoryId"]}' LIMIT 1
        ";
        return $this->response(1, "succ", $this->getRow($sql));
    }

    function appList(){
        $where = "1=1";
        if($_REQUEST["categoryId"] != "") $where .= " AND categoryId = '{$_REQUEST["categoryId"]}'";
        if($_REQUEST["searchTxt"] != "")
            $where .= " AND (`appTitle` LIKE '%{$_REQUEST["searchTxt"]}%' OR C.desc LIKE '%{$_REQUEST["searchTxt"]}%')";

        $sql = "
            SELECT * 
            FROM tblApp A JOIN tblCorporation C ON A.corporationId = C.id 
            WHERE {$where} 
            ORDER BY A.regDate DESC
        ";

        return $this->response(1, "succ", $this->getArray($sql));
    }

    function userJoin(){
        $password = $this->encryptAES($_REQUEST["password"]);
        $sql = "
            INSERT INTO tblUser(email, password, name, phone, addr, addrDetail, regDate)
            VALUES(
              '{$_REQUEST["email"]}',
              '{$password}',
              '{$_REQUEST["name"]}',
              '{$_REQUEST["phone"]}',
              '{$_REQUEST["addr"]}',
              '{$_REQUEST["addrDetail"]}',
              NOW()
            )
        ";
        $this->update($sql);

        $sql = "SELECT * FROM tblUser WHERE email = '{$_REQUEST["email"]}' LIMIT 1";
        $info = $this->getRow($sql);

        PrefUtil::setPreference("pickleUser", $info);
        return $this->response(1, "가입되었습니다.");
    }

    function appInfo(){
        $user = PrefUtil::getPreference("pickleUser");

        $sql = "
            SELECT 
              *, 
              A.regDate AS appRegDate,
              (SELECT `desc` FROM tblCategory WHERE id = A.categoryId) AS category,
              (
                SELECT (SUM(rate) / COUNT(*))
                FROM tblCommentParent CP JOIN tblUser U ON CP.userId = U.id 
                JOIN tblApp A ON CP.appId = A.id JOIN tblComment C ON C.commentPid = CP.id
                WHERE appId = '1' AND C.id = (SELECT MAX(id) FROM tblComment WHERE commentPid = CP.id LIMIT 1)
              ) AS average,
              (
                SELECT COUNT(*)
                FROM tblCommentParent CP JOIN tblUser U ON CP.userId = U.id 
                JOIN tblApp A ON CP.appId = A.id JOIN tblComment C ON C.commentPid = CP.id
                WHERE appId = '1' AND C.id = (SELECT MAX(id) FROM tblComment WHERE commentPid = CP.id LIMIT 1)
              ) AS cnt
            FROM tblApp A JOIN tblCorporation C ON A.corporationId = C.id
            WHERE A.id = '{$_REQUEST["id"]}' LIMIT 1
        ";
        $appData = $this->getRow($sql);

        $sql = "
            SELECT 
              *,
              CASE WHEN (SELECT COUNT(*) FROM tblLike WHERE userId = '{$user->id}' AND commentPId = CP.id) > 0 THEN 1
              ELSE 0
              END AS likeFlag
            FROM tblCommentParent CP JOIN tblUser U ON CP.userId = U.id 
            JOIN tblApp A ON CP.appId = A.id JOIN tblComment C ON C.commentPid = CP.id
            WHERE appId = '1' AND C.id = (SELECT MAX(id) FROM tblComment WHERE commentPid = CP.id LIMIT 1)
        ";
        $commentList = $this->getArray($sql);

        return $this->response(1, "succ", $appData, $commentList);
    }

    function checkEmail(){
        $sql = "
            SELECT COUNT(*) cnt FROM tblUser WHERE email = '{$_REQUEST["email"]}' AND status != 0 LIMIT 1
        ";
        $cnt = $this->getValue($sql, "cnt");

        if($cnt < 1) return $this->response(1, "사용 가능한 이메일입니다.");
        else return $this->response(-1, "이미 사용중인 이메일입니다.");
    }

    function userLogin(){
        $password = $this->encryptAES($_REQUEST["password"]);
        $sql = "
            SELECT * FROM tblUser WHERE `email` = '{$_REQUEST["email"]}' AND password = '{$password}' AND status = 1 LIMIT 1 
        ";
        $row = $this->getRow($sql);
        if($row != ""){
            PrefUtil::setPreference("pickleUser", $row);
            return $this->response(1, "succ");
        }else return $this->response(-1, "failed");
    }

    function currentUserInfo(){
        return PrefUtil::getPreference("pickleUser");
    }

    function userLogout(){
        PrefUtil::emptyPreference("pickleUser");
        return $this->response(1, "succ");
    }

    function setWishItem(){
        $user = PrefUtil::getPreference("pickleUser");

        if($user == "" || $user == null) return $this->response(-1, "로그인 후 이용해 주시기 바랍니다.");
        $sql = "
            INSERT INTO tblWishList(userId, appId, regDate)
            VALUES(
              '{$user->id}',
              '{$_REQUEST["appId"]}',
              NOW()
            )
            ON DUPLICATE KEY UPDATE
              regDate = NOW()
        ";
        $this->update($sql);
        return $this->response(1, "succ");
    }

    function downloadApp(){

    }

    function setLike(){
        $user = PrefUtil::getPreference("pickleUser");
        if($user == "" || $user == null) return $this->response(-1, "로그인 후 이용해 주시기 바랍니다.");
        if($_REQUEST["flag"] == "false"){
            $sql = "
              INSERT INTO tblLike(userId, commentPId, regDate)
              VALUES(
                '{$user->id}',
                '{$_REQUEST["commentPId"]}',
                NOW()
              )
              ON DUPLICATE KEY UPDATE
              regDate = NOW()
            ";
        }
        else{
            $sql = "
                DELETE FROM tblLike
                WHERE userId = '{$user->id}' AND commentPId = '{$_REQUEST["commentPId"]}'
            ";
        }

        $this->update($sql);
        return $this->response(1, "succ");
    }

    function test(){
        $str = "test111";
        $encrypted = $this->encryptAES($str);
        echo "encrypted : " . $encrypted . "\n";

        $decrypted = $this->decryptAES($encrypted);
        echo "decrypted : " . $decrypted . "\n";
    }

}