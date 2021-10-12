<?php
// php関数ファイル

    /**
     * 「都道府県」　を取得
     */
    function getStateName($state_id, $state = array()) {
        if($state_id == 0 || isEmpty($state)) {
            return '未選択';
        }else{
            return $state[array_search($state_id, array_column($state, 'id'))]['name'];
        }
    }

    /**
     * 「担当パート」　もしくは　「業務領域」　を取得
     */
    function getPartOrWorkRow_from_array($user_id, $arr = array()) {
        if(isset($user_id) && !isEmpty($arr)) {
            return $arr[array_search($user_id, array_column($arr, 'user_id'))];
        }
        return array();
    }

    /**
     * ユーザIDをキーとして
     * 「担当パート文字列」（例："ギター、ドラム"）
     * もしくは
     * 「業務領域文字列」（例："作詞、レコーディング"）
     * を取得
     */
    function getPartAndWorkNames_By_userID($key, $arr1, $arr2) {
        if( isset($key) && !isEmpty($arr1) && !isEmpty($arr2) ) {
            $cMax = $arr1[array_search($key, array_column($arr1, 'p2_user_id'))]['p2_count'];
            if($cMax > 0) {
                $c = 0;
                foreach($arr2 as $a) {
                    $c++;
                    // $partCount++;
                    // $strPart .= $parts[array_search($p['part_id'], array_column($parts, 'id'))]['part'];
                    // $results['part_id'][$partCount] = $p['part_id'];
                    // if($partCount < $partMaxCount) {
                    //     $strPart .= '、';
                    // }
                }
            }
        }
    }

    /**
     * 「担当パート文字列」（例："ギター、ドラム"）
     * 「担当パートidの配列」
     * 「業務領域文字列」（例："作詞、レコーディング"）
     * 「業務領域idの配列」
     * を取得
     */
    function getPartAndWorkNames($part, $parts, $work, $works) {

        $result = null;

        // 担当パート文字列を取得
        $results['part'] = '未選択';
        $results['part_id'] = array();
        if(!isEmpty($part) && !isEmpty($parts) && count($part) > 0) {
            $strPart = "";
            $partMaxCount = count($part);
            $partCount= 0;
            foreach($part as $p) {
                $partCount++;
                $strPart .= $parts[array_search($p['part_id'], array_column($parts, 'id'))]['part'];
                $results['part_id'][$partCount] = $p['part_id'];
                if($partCount < $partMaxCount) {
                    $strPart .= '、';
                }
            }
            $results['part'] = $strPart;
        }

        // 業務領域を取得
        $results['work'] = '未選択';
        $results['work_id'] = array();
        if(!isEmpty($work) && !isEmpty($works) && count($work) > 0) {
            $strWork = "";
            $workMaxCount = count($works);
            $workCount= 0;
            foreach($work as $w) {
                $workCount++;
                $strWork .= $works[array_search($w['work_id'], array_column($works, 'id'))]['work'];
                $results['work_id'][$workCount] = $w['work_id'];
                if($workCount < $workMaxCount) {
                    $strWork .= '、';
                }
            }
            $results['work'] = $strWork;
        }

        return $results;
    }

    function getUserIconPath($userID, $extension = 'jpg') {

        //dirname($_SERVER['DOCUMENT_ROOT']); //C:/xampp/htdocs/littlehands
        $myIconPath = dirname($_SERVER['DOCUMENT_ROOT'])."/Views/img/".$userID."/my.".$extension;
        $generalIconPath = dirname($_SERVER['DOCUMENT_ROOT'])."/Views/img/user.".$extension;

        $arrIconPath = array();
        if (file_exists($myIconPath)) {
            $arrIconPath += array('iconFullPath' => $myIconPath, 'iconPath' => "img/".$userID."/my.".$extension);
            return $arrIconPath;
        }else{
            if (file_exists($generalIconPath)) {
                $arrIconPath += array('iconFullPath' => $generalIconPath, 'iconPath' => "img/user.".$extension);
                return $arrIconPath;
            }
        }
        return '';
    }



    // 住所情報から経度と緯度を取得
    function add_latlng(&$user_info, $user) {
        if( $user['a1_state'] != '' &&
            $user['a1_city'] != '' &&
            $user['a1_address1'] != '' &&
            $user['a1_address2'] != '' ) {
                $address = $user['a1_state'].$user['a1_city'].$user['a1_address1'].$user['a1_address2'];
                $latlng = getlatlng($address);
        }
            $latlng = getlatlng($address);
            if($latlng != null) { 
                $user_info += array('a1_address' => $address);
                $user_info += array('lat' => $latlng['lat']);
                $user_info += array('lng' => $latlng['lng']);
            }
    }

    // 住所情報から経度と緯度を取得
    function getlatlng($address) {
        $apiurl = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDcA-kXWyf1YGOUDChR6QJsCYr3fCyNAvc&address=";

        $json = json_decode(@file_get_contents($apiurl.$address), false);

        if($json != null && $json->status == 'OK') {
            $lat = $json->results[0]->geometry->location->lat;
            $lng = $json->results[0]->geometry->location->lng;
            $latlng = array('lat' => $lat, 'lng' => $lng);
            return $latlng;
        }else{
            return null;
        }
    }


    
    function getFileName() {//"login.php"
        return basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    }

    function getFileNameWithParams($url, $fileName) {//"login.php?id=1"
        $fileNameWithParams = basename($url);
        if($fileName != $fileNameWithParams) {
            return $fileNameWithParams;
        }
        return "";
    }

    // 現在のファイルのURLを取得//"http://localhost/login.php?id=1"
    function getUrl() {
        $url = '';
        if ( isset( $_SERVER[ 'HTTPS' ] ) ) {
            $url .= 'https://';
        } else {
            $url .= 'http://';
        }
        if ( isset( $_SERVER[ 'HTTP_HOST' ] ) ) {
            $url .= $_SERVER[ 'HTTP_HOST' ];
        }
        if ( isset( $_SERVER[ 'REQUEST_URI' ] ) ) {
            $url .= $_SERVER[ 'REQUEST_URI' ];
        }

        if(isCorrectUrl($url)){
            return $url;
        }else{
            return null;
        }
    }

    // 正しいURLであるかの判定
    function isCorrectUrl( $url ) {
        if ( $url === "" || strcmp( $url, "" ) == 0 ) {
            return false;
        }
        $pattern_https = '/https?:\/{2}[\w\/:%#\$&\?\(\)~\.=\+\-]+/';
        $pattern_http = '/http?:\/{2}[\w\/:%#\$&\?\(\)~\.=\+\-]+/';
        $result_https = preg_match( $pattern_https, $url );
        $result_http = preg_match( $pattern_http, $url );
        if ( $result_https || $result_http ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 配列に指定のキーが存在するかどうかのチェック
     * 
     * @param string $key キー
     * @param array $array 配列
     * @return boolean  true  ：  配列に指定のキーが存在する
     *                  false ：  配列に指定のキーが存在しない
     */
    function isExistsKeyInArray($key, $array) {
        if (!isEmpty($array)) {
            if (array_key_exists($key, $array) || isset($array[$key]) ) {
                return true;
            }
        }
        return false;
    }

    /**
     * 配列が空かどうかのチェック
     * 
     * @param array $array 配列
     * @return boolean  true  ：  配列が空である
     *                  false ：  配列が空ではない
     */
    function isEmpty($array) {
        if ( empty($array) || !isset($array) || count($array) == 0 ) {
            return true;
        }
        return false;
    }

    // XSS対策
    function h($key, $array) {
        if (!empty($array) || isset($array) || count($array) == 0) {
            if (array_key_exists($key, $array) || isset($array[$key])) {
                return htmlspecialchars($array[$key], ENT_QUOTES, 'UTF-8');
            }
        }
        return '';
    }

    /**
     * 文字列が「全角半角スペース」、「空文字」、「改行」のみかチェック
     *
     * @param string    $str  ：  チェック文字列
     * @return boolean  true  ：  文字列が「全角半角スペース」、「空文字」、「改行」のみである
     *                  false ：  文字列が「全角半角スペース」、「空文字」、「改行」のみではない
     */
    function isWhiteSpaceOrEmpty( $str ) {

        $str = preg_replace( '/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $str );

        // 文字列が空文字の場合
        if ( $str === "" || strcmp( $str, "" ) == 0 ) {
            return true;
        }
        return false;

    }

?>