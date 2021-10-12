-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3306
-- 生成日時: 2021 年 10 月 07 日 00:11
-- サーバのバージョン： 5.7.32
-- PHP のバージョン: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- データベース: `Musicrossing`
--

DROP DATABASE IF EXISTS `Musicrossing`;

CREATE DATABASE `Musicrossing` DEFAULT CHARACTER SET utf8;

USE `Musicrossing`;
--
-- データベース: `Musicrossing`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `exchanges`
--

CREATE TABLE `exchanges` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `host_user_id` int(11) NOT NULL COMMENT 'ホストユーザID',
  `guest_user_id` int(11) NOT NULL COMMENT 'ゲストユーザID',
  `body_host_id` int(11) NOT NULL COMMENT '本文ユーザID',
  `body` text NOT NULL COMMENT '本文',
  `group_name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `read_at` datetime DEFAULT NULL COMMENT '既読日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `exchanges`
--

INSERT INTO `exchanges` (`id`, `host_user_id`, `guest_user_id`, `body_host_id`, `body`, `group_name`, `created_at`, `read_at`) VALUES
(1, 22, 4, 22, 'こんにちは！', '4&22', '2021-10-04 18:53:37', NULL),
(2, 22, 4, 4, 'こんにちは、宜しくお願いします。', '4&22', '2021-10-04 18:54:27', NULL),
(3, 22, 4, 22, '私はギターが得意です！', '4&22', '2021-10-05 00:34:11', NULL),
(4, 22, 4, 22, 'たはらさんは何が得意ですか？', '4&22', '2021-10-05 00:34:40', NULL),
(5, 22, 23, 22, 'こんばんは、よろしければ仲良くしてください！', '22&23', '2021-10-05 01:57:09', NULL),
(6, 23, 22, 23, 'こんばんは！こちらこそお願いします！<br />\r\n得意なパートは何ですか？', '22&23', '2021-10-05 02:28:06', NULL),
(7, 23, 22, 23, '好きな音楽もおしえてください！', '22&23', '2021-10-05 02:28:37', NULL),
(8, 22, 23, 22, '得意なパートはピアノとギターです', '22&23', '2021-10-05 20:32:37', NULL),
(9, 22, 23, 22, '好きな音楽はジャズです！', '22&23', '2021-10-05 20:33:58', NULL),
(10, 22, 23, 22, '今度新宿で会いませんか？', '22&23', '2021-10-05 20:34:22', NULL),
(11, 23, 22, 23, 'いいよ！', '22&23', '2021-10-05 21:04:10', NULL),
(12, 23, 22, 23, '来週あおう！', '22&23', '2021-10-05 21:04:23', NULL),
(13, 23, 22, 23, '土曜日で良い？', '22&23', '2021-10-05 21:06:23', NULL),
(14, 23, 7, 23, 'こんばんは！<br />\r\nオトさん、ベースとギターできるんですね。<br />\r\n今度バンドをやろうと思っているのですが、一緒にやりませんか？', '7&23', '2021-10-06 03:19:31', NULL),
(15, 22, 23, 22, '土曜日OKです！<br />\r\n○○ライブハウスの前に待ち合わせでお願いします！', '22&23', '2021-10-06 17:17:38', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `host_user_id` int(11) NOT NULL COMMENT 'ホストユーザID',
  `guest_user_id` int(11) NOT NULL COMMENT 'ゲストユーザID',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `part`
--

CREATE TABLE `part` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザID',
  `part_id` int(11) NOT NULL COMMENT 'パートID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `part`
--

INSERT INTO `part` (`id`, `user_id`, `part_id`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 3, 2),
(4, 3, 4),
(5, 3, 5),
(6, 5, 1),
(7, 5, 3),
(8, 6, 2),
(9, 7, 3),
(10, 7, 4),
(11, 8, 3),
(12, 8, 4),
(13, 9, 3),
(14, 9, 4),
(15, 10, 3),
(16, 10, 4),
(17, 11, 2),
(18, 12, 1),
(19, 12, 2),
(20, 13, 3),
(21, 14, 3),
(22, 15, 3),
(23, 16, 3),
(24, 17, 3),
(25, 18, 3),
(26, 19, 3),
(27, 20, 3),
(28, 21, 5);

-- --------------------------------------------------------

--
-- テーブルの構造 `part_mst`
--

CREATE TABLE `part_mst` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `part` varchar(10) NOT NULL COMMENT 'パート名'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `part_mst`
--

INSERT INTO `part_mst` (`id`, `part`) VALUES
(1, 'ボーカル'),
(2, 'ギター'),
(3, 'ベース'),
(4, 'ドラム'),
(5, 'ピアノ');

-- --------------------------------------------------------

--
-- テーブルの構造 `state_mst`
--

CREATE TABLE `state_mst` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `state_mst`
--

INSERT INTO `state_mst` (`id`, `name`) VALUES
(1, '北海道'),
(2, '青森県'),
(3, '岩手県'),
(4, '宮城県'),
(5, '秋田県'),
(6, '山形県'),
(7, '福島県'),
(8, '茨城県'),
(9, '栃木県'),
(10, '群馬県'),
(11, '埼玉県'),
(12, '千葉県'),
(13, '東京都'),
(14, '神奈川県'),
(15, '新潟県'),
(16, '富山県'),
(17, '石川県'),
(18, '福井県'),
(19, '山梨県'),
(20, '長野県'),
(21, '岐阜県'),
(22, '静岡県'),
(23, '愛知県'),
(24, '三重県'),
(25, '滋賀県'),
(26, '京都府'),
(27, '大阪府'),
(28, '兵庫県'),
(29, '奈良県'),
(30, '和歌山県'),
(31, '鳥取県'),
(32, '島根県'),
(33, '岡山県'),
(34, '広島県'),
(35, '山口県'),
(36, '徳島県'),
(37, '香川県'),
(38, '愛媛県'),
(39, '高知県'),
(40, '福岡県'),
(41, '佐賀県'),
(42, '長崎県'),
(43, '熊本県'),
(44, '大分県'),
(45, '宮崎県'),
(46, '鹿児島県'),
(47, '沖縄県');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `nickname` varchar(50) DEFAULT NULL COMMENT 'ニックネーム',
  `gender` tinyint(4) NOT NULL DEFAULT '0' COMMENT '性別',
  `age` tinyint(4) DEFAULT NULL COMMENT '年代',
  `state_id` tinyint(4) DEFAULT NULL COMMENT '都道府県',
  `self_introduction` text COMMENT '自己紹介',
  `email` varchar(100) NOT NULL COMMENT 'メールアドレス',
  `password` varchar(100) NOT NULL COMMENT 'パスワード',
  `thumbnail_path` varchar(255) DEFAULT NULL COMMENT 'サムネイルパス',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録時間',
  `updated_at` datetime DEFAULT NULL COMMENT '更新時間',
  `del_flg` tinyint(1) NOT NULL COMMENT '論理削除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `nickname`, `gender`, `age`, `state_id`, `self_introduction`, `email`, `password`, `thumbnail_path`, `created_at`, `updated_at`, `del_flg`) VALUES
(1, 'マツモト', 2, 20, 1, 'oi', 'abcd1234@gmail.com', 'd3f4d9aeb7f44bf7a0627d51146abf94', NULL, '2021-09-27 19:11:48', NULL, 1),
(3, 'アロー', 1, 30, 1, 'o', 'qwer1234@gmail.com', '$2y$10$xVTyO5s.hswxqPjpWtG.u.foD0FBQg82w4QLix9QpihgktqpAOBwu', NULL, '2021-09-27 21:15:06', NULL, 1),
(4, 'たはら', 0, 0, 13, '', 'syk428@icloud.com', '$2y$10$SsZoODXmy3lwyzOWKV661uVf..mnJBNYPMXjDTKoK3JvH3/ebx.pO', 'fakepath', '2021-09-29 21:53:09', NULL, 0),
(5, '松本', 2, 0, 14, 'テストです', 'syk428@icloud.com', '$2y$10$b0dMC07pBMnoKCVZnFLQqe8nAkzjWtbr0zb2tOPs6HNCPO1Yele6O', 'fakepath', '2021-09-29 21:54:01', NULL, 0),
(6, 'ハナコ', 2, 20, 13, 'テストです', 'hnk@icloud.com', '$2y$10$xQe852dhL96HA7gDbYadK.FHTROXO1.Vza2ThCTSabIs0Spbsu1nW', 'fakepath', '2021-09-30 03:27:43', NULL, 0),
(7, 'オト', 1, 20, 7, 'オトです。よろしくお願いします^^', 'oto@gmail.com', 'f94487fbe22f97f62bd76a3e73e664c4', 'fakepath', '2021-09-30 04:10:28', NULL, 0),
(11, '歌丸', 1, 30, 6, '状況したてです　どうもー', 'uta@gmail.com', '5c04d53c23e881867ed63658d5388028', 'fakepath', '2021-09-30 04:17:51', NULL, 0),
(19, 'ロックマン', 1, 10, 11, 'ロックマンと申します！', 'qqq@gmail.com', '$2y$10$I1ZPqIRC/E..oAtZdQdHX.I482NBtM5QrzmdV1tMY2Q6iz08Or6ta', 'fakepath', '2021-09-30 05:10:37', NULL, 0),
(21, '根岸', 2, 20, 1, '歴13年です。好きなジャンルはジャズですがなんでも弾けます！\r\nよろしくお願いいたします。', 'ngs@gmail.com', '$2y$10$s1S1xm5/4xjqmFoAMezvn.d4aQbykkjPJfOlAYLuCpg/Y5nnd33nm', 'fakepath', '2021-09-30 14:51:39', NULL, 0),
(22, 'testes1', 0, 20, 4, 'testes1です。宜しくお願いいたします。', 'testes1@testes.ne.jp', '9c93fcc4685f3b5f78c57f5546b5ef7f', 'fakepath', '2021-10-04 17:00:45', '2021-10-06 17:26:01', 0),
(23, 'testes2', 1, 30, 7, 'testes2です。宜しくお願いいたします。', 'testes2@testes.ne.jp', '3e706f4a68d0ce75db5026e0c642900d', '', '2021-10-04 17:04:08', '2021-10-04 17:02:12', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `work`
--

CREATE TABLE `work` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザID',
  `work_id` int(11) NOT NULL COMMENT 'パートID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `work`
--

INSERT INTO `work` (`id`, `user_id`, `work_id`) VALUES
(1, 1, 1),
(2, 1, 6),
(3, 3, 2),
(4, 3, 3),
(5, 5, 2),
(6, 5, 3),
(7, 6, 2),
(8, 6, 4),
(9, 7, 2),
(10, 7, 4),
(11, 8, 2),
(12, 8, 4),
(13, 9, 2),
(14, 9, 4),
(15, 10, 2),
(16, 10, 4),
(17, 11, 2),
(18, 11, 3),
(19, 12, 1),
(20, 12, 2),
(21, 13, 4),
(22, 14, 4),
(23, 15, 4),
(24, 16, 4),
(25, 17, 4),
(26, 18, 4),
(27, 19, 4),
(28, 20, 4),
(29, 21, 2),
(30, 21, 4);

-- --------------------------------------------------------

--
-- テーブルの構造 `work_mst`
--

CREATE TABLE `work_mst` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `work` varchar(15) NOT NULL COMMENT '業務領域名'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `work_mst`
--

INSERT INTO `work_mst` (`id`, `work`) VALUES
(1, '作詞'),
(2, '作曲'),
(3, '編曲'),
(4, '演奏'),
(5, '仮歌'),
(6, '譜面作成'),
(7, 'レコーディング'),
(8, 'ミックス・マスタリング');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `exchanges`
--
ALTER TABLE `exchanges`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `part`
--
ALTER TABLE `part`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `part_mst`
--
ALTER TABLE `part_mst`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `state_mst`
--
ALTER TABLE `state_mst`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `work`
--
ALTER TABLE `work`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `work_mst`
--
ALTER TABLE `work_mst`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `exchanges`
--
ALTER TABLE `exchanges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=16;

--
-- テーブルの AUTO_INCREMENT `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- テーブルの AUTO_INCREMENT `part`
--
ALTER TABLE `part`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=29;

--
-- テーブルの AUTO_INCREMENT `part_mst`
--
ALTER TABLE `part_mst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=6;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=24;

--
-- テーブルの AUTO_INCREMENT `work`
--
ALTER TABLE `work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=31;

--
-- テーブルの AUTO_INCREMENT `work_mst`
--
ALTER TABLE `work_mst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=9;
