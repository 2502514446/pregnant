<?php
require_once('./Pregnant.class.php');
$pregnant = new Pregnant();
$pregnant->caching = 1;
$pregnant->cache('index.tpl');
$pregnant->assign('webname', '51dream');
$pregnant->assign('name', 'lijie');
$pregnant->assign('sex', '男');
$pregnant->assign('arr', array(1,2,3));
$pregnant->assign('arrobj', array('a', 'b', 'c'));
$pregnant->assign('obj', $pregnant);
$pregnant->display('index.tpl');
