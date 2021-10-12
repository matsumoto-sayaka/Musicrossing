<?php 
function getAllUsers() {

    $allUsers = null;

    $allUsers[] = array(
        // ユーザ
        "u1_id" => "11",
        "u1_nickname" => "ユーザ11",
        "u1_gender" => "2",
        "u1_age" => "20",
        "u1_state_id" => "28",
        "u1_self_introduction" => "はじめまして。ユーザ11です。",
        "u1_email" => "user11@gmail.com",
        "u1_password" => "",
        "u1_thumbnail_path" => "img/11",
        "u1_created_at" => "2021/09/29 13:01:00",
        "u1_updated_at" => "2021/09/29 13:02:00",
        "u1_del_flg" => "0",
        // 都道府県
        "ms1_id" => "28",
        "ms1_name" => "兵庫県",
    );

    $allUsers[] = array(
        // ユーザ
        "u1_id" => "12",
        "u1_nickname" => "ユーザ12",
        "u1_gender" => "1",
        "u1_age" => "30",
        "u1_state_id" => "1",
        "u1_self_introduction" => "はじめまして。ユーザ12です。",
        "u1_email" => "user12@gmail.com",
        "u1_password" => "",
        "u1_thumbnail_path" => "img/12",
        "u1_created_at" => "2021/09/29 13:01:00",
        "u1_updated_at" => "2021/09/29 13:02:00",
        "u1_del_flg" => "0",
        // 都道府県
        "ms1_id" => "1",
        "ms1_name" => "北海道",
    );

    $allUsers[] = array(
        // ユーザ
        "u1_id" => "13",
        "u1_nickname" => "ユーザ13",
        "u1_gender" => "2",
        "u1_age" => "40",
        "u1_state_id" => "13",
        "u1_self_introduction" => "はじめまして。ユーザ13です。",
        "u1_email" => "user11@gmail.com",
        "u1_password" => "",
        "u1_thumbnail_path" => "img/11",
        "u1_created_at" => "2021/09/29 13:01:00",
        "u1_updated_at" => "2021/09/29 13:02:00",
        "u1_del_flg" => "0",
        // 都道府県
        "ms1_id" => "13",
        "ms1_name" => "東京都",
    );

    return $allUsers;
}
?>