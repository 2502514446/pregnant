<?php
/**
  * 工  程：  Pregnant： php模版引擎
  * 文  件：  Pregnant.class.php
  * 文件包：  pregnant 
 *
  * @ 网址：  51dream.club
  * @ 时间：  2017-6-20
  * @ 作者：  李杰
  * @ 版本：  1.0.0
***/

class Pregnant {
/**
  * 版本
***/
const VERSION = '1.0';
/**
  * 存放模板变量数组
***/
private $tplVar = array();
/**
  * 模板路径
***/
public $tpl_Dir = './template';
/**
  * 模板编译路径
***/
public $tplCompile_Dir = './template_c';
/**
  * 缓存模板路径
***/
public $cache_Dir = './cache';
/**
  * 缓存开关
***/
public $caching = 0;

/**
  * 功能：  注入变量
 *
  * function :  public assign($varName, $varValue)
  * return :    void  
  * parameter : $varName   变量名 
  *             $varValue  变量值 
***/
public function assign($varName, $varValue) {
  // 判断变量名声明且不为空
  if(isset($varName) && (!empty($varName))) {
    $this->tplVar["$varName"] = $varValue;
  }
  else {
    exit('ERROR : 变量注入失败！');
  }
}

/**
  * 功能：  解析模板，缓存文件，向浏览器显示文件
 *
  * function :  public display()
  * return :    void  
  * parameter : null
***/
public function display($file) {
  $this->checkDir();
  //设置模板文件路径
  $tplFile = $this->tpl_Dir . '/' . $file;
  //检查模板文件是否存在
  if(!file_exists($tplFile)) {
    exit("ERROR : {$tplFile} 模板文件不存在！");
  }

  // 设置模板编译文件路径
  $tplCompileFile = $this->tplCompile_Dir . '/' . $file . '.php';
  // 设置模板缓存文件路径
  $cacheFile = $this->cache_Dir . '/' . $file . '.html';

  if(!file_exists($tplCompileFile) || filemtime($tplFile)>filemtime($tplCompileFile)) {
    if(!$contentT = file_get_contents($tplFile)) {
      exit('ERROR : 模板内容获取错误！请查看模板文件是否可读！');
    }
    // 模板解析
    require_once('./pregnant_compile.class.php');
    $compile = new PregnantCompile();
    $content = $compile->pregnant_compile($contentT);
    if(!file_put_contents($tplCompileFile, $content)) {
      exit('ERROR : 编译文件生成错误！请查看模板编译文件夹权限是否可写！');
    }
  }
  // 显示编译文件
  include($tplCompileFile);

  if($this->caching) {
    $content = ob_get_contents();
    file_put_contents($cacheFile, $content);
    ob_end_clean();
    include($cacheFile);
  }
}

/**
  * 功能： 缓冲 
 *
  * function :  public cache()
  * return :    void  
  * parameter : null
***/
public function cache($file) {
  //设置模板文件路径
  $tplFile = $this->tpl_Dir . '/' . $file;
  // 设置模板编译文件路径
  $tplCompileFile = $this->tplCompile_Dir . '/' . $file . '.php';
  // 设置模板缓存文件路径
  $cacheFile = $this->cache_Dir . '/' . $file . '.html';

  if($this->caching) {
    ob_start();
    if(file_exists($cacheFile) && file_exists($tplCompileFile)) {
      if(filemtime($tplCompileFile)>=filemtime($tplFile)
          && filemtime($cacheFile)>=filemtime($tplCompileFile)) {
        //include($cacheFile);
        $this->url($cacheFile);
        return 1;
      }
    }
  }
}

/**
  * 功能：  检查目录是否存在
 *
  * function :  private checkDir()
  * return :    void  
  * parameter : null
***/
public function checkDir() {
  if(!is_dir($this->tpl_Dir)) {
    exit('模板目录不存在，默认是template!');
  }
  if(!is_dir($this->tplCompile_Dir)) {
    exit('模板编译目录不存在，默认是template_c!');
  }
  if(!is_dir($this->cache_Dir)) {
    exit('模板缓存目录不存在，默认是cache!');
  }
}
/**
  * 功能：  页面跳转
 *
  * function :  private url()
  * return :    void  
  * parameter : $url  地址
***/
private function url($url) {
  header("Location:{$url}");
  exit();
}

}
