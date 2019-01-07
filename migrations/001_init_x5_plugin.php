<?php

class InitX5Plugin extends Migration
{
    public function up()
    {
        DBManager::get()->query("CREATE TABLE IF NOT EXISTS `x5_lists` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `range_id` varchar(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
            `position` int(10) unsigned NOT NULL,
            `mkdate` int(11) NOT NULL DEFAULT '0',
            `chdate` int(11) NOT NULL DEFAULT '0',
            `visible` boolean NOT NULL,
            PRIMARY KEY (`id`)
        );");

        DBManager::get()->query("CREATE TABLE IF NOT EXISTS `x5_items` (
            `item_id` varchar(32) NOT NULL,
            `mkdate` int(11) NOT NULL DEFAULT '0',
            `chdate` int(11) NOT NULL DEFAULT '0',
            `likes` int(11) NOT NULL DEFAULT '0',
            PRIMARY KEY (`item_id`)
        );");

        DBManager::get()->query("CREATE TABLE IF NOT EXISTS `x5_list_items` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `position` int(10) unsigned NOT NULL,
            `mkdate` int(11) NOT NULL DEFAULT '0',
            `chdate` int(11) NOT NULL DEFAULT '0',
            `item_id` varchar(32) NOT NULL,
            `list_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
        );");
    }

    public function down()
    {
        DBManager::get()->query('DROP TABLE IF EXISTS `x5_lists`, `x5_list_items`;');
    }
}
