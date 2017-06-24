<?php
/**
  * 工  程：  Pregnant： php模版引擎
  * 文  件：  pregnant_compile.class.php
  * 文件包：  pregnant 
  * 功能  ：  编译模板的pregnant语法
 *
  * @ 网址：  51dream.club
  * @ 时间：  2017-6-20
  * @ 作者：  李杰
  * @ 版本：  1.0.0
***/

class PregnantCompile {

/**
  * 接受模板内容
***/
private $tplContent;

/**
  * 功能：  编译模板
 *
  * function :  public pregnant_compile($content)
  * return :    $this->tplContent 编译后的内容  
  * parameter : $content 接受模板内容
***/
public function pregnant_compile($content) {
  $this->tplContent = $content;
  $this->compileVar();
  $this->compileIf();
  $this->compileForeach();
  $this->compileNote();
  $this->compileInclude();
  return $this->tplContent;
}
/**
  * 功能：  编译变量
 *
  * function :  private compileVar()
  * return :    void
  * parameter : null
***/
private function compileVar() {
  $pregVar = '/\{\s*\$([a-zA-Z0-9_]+)([a-zA-Z0-9_\[\]\-\>\:]*)\s*\}/';
  $replaceVar = "<?php echo \$this->tplVar[\"$1\"]$2; ?>";
  if(preg_match($pregVar, $this->tplContent)) {
    $this->tplContent = preg_replace($pregVar, $replaceVar, $this->tplContent);
  }
}
/**
  * 功能：  编译注释
 *
  * function :  private compileNote()
  * return :    void
  * parameter : null
***/
private function compileNote() {
  $pregNote = '/\{\*(.*)\*\}/';
  $replaceNote = "<?php /* $1 */ ?>";
  if(preg_match($pregNote, $this->tplContent)) {
    $this->tplContent = preg_replace($pregNote, $replaceNote, $this->tplContent);
  }
}
/**
  * 功能：  编译if, else, elseif语句
 *
  * function :  private compileIf()
  * return :    void
  * parameter : null
***/
private function compileIf() {
  $pregIf = '/\{\s*if\s+\$([a-zA-Z0-9_]+)\s*\}/';
  $replaceIf = "<?php if(\$this->tplVar[\"$1\"]) {  ?>";
  $pregEndIf = '/\{\s*\/if\s*\}/';
  $replaceEndIf = '<?php } ?>';
  $pregElse = '/{\s*else\s*}/';
  $replaceElse = "<?php }else{ ?>";
  $pregElseIf = '/\{\s*elseif\s+\$([a-zA-Z0-9_]+)\s*}/';
  $replaceElseIf = "<?php }elseif(\$this->tplVar[\"$1\"]) {  ?>";
  if(preg_match($pregIf, $this->tplContent)
     && preg_match_all($pregEndIf,$this->tplContent)==preg_match_all($pregIf, $this->tplContent)
    ) {
    $this->tplContent = preg_replace($pregIf, $replaceIf, $this->tplContent);
    $this->tplContent = preg_replace($pregEndIf, $replaceEndIf, $this->tplContent);
    if(preg_match($pregElse, $this->tplContent)) {
      $this->tplContent = preg_replace($pregElse, $replaceElse, $this->tplContent);
    }
    if(preg_match($pregElseIf, $this->tplContent)) {
      $this->tplContent = preg_replace($pregElseIf, $replaceElseIf, $this->tplContent);
    }
  }
  else {
    exit('ERROR : if语句没有关闭');
  }
}
/**
  * 功能：  编译foreach语句
 *
  * function :  private compileForeach()
  * return :    void
  * parameter : null
***/
private function compileForeach() {
  $pregForeach = '/\{\s*foreach\s+\$([a-zA-Z0-9_]+)\s*\(\s*([a-zA-Z0-9_]+)\s*\,\s*([a-zA-Z0-9_]+)\s*\)\s*\}/';
  $replaceForeach = "<?php foreach(\$this->tplVar[\"$1\"] as \$$2=>\$$3) {  ?>";
  $pregEndForeach = '/\{\s*\/foreach\s*}/';
  $replaceEndForeach = "<?php }  ?>";
  $pregVar = '/\{\s*\@([a-zA-Z0-9_]+)([a-zA-Z0-9_\-\>\:]*)\s*\}/';
  $replaceVar = "<?php echo \$$1$2  ?>";
  if(preg_match($pregForeach, $this->tplContent)
     && preg_match_all($pregEndForeach, $this->tplContent)==preg_match_all($pregForeach, $this->tplContent)
   ) {
    $this->tplContent = preg_replace($pregForeach, $replaceForeach, $this->tplContent);  
    $this->tplContent = preg_replace($pregEndForeach, $replaceEndForeach, $this->tplContent);  
    $this->tplContent = preg_replace($pregVar, $replaceVar, $this->tplContent);  
  }
  else {
    exit('ERROR : foreach没有关闭语句！');
  }
}
/**
  * 功能：  编译include语句
 *
  * function :  private compileInclude()
  * return :    void
  * parameter : null
***/
private function compileInclude() {
  $pregInclude = '/\{\s*include\s+file\=\"([a-zA-Z0-9_\.\-\/]+)\"\s*\}/';
  $replaceInclude = "<?php include('$1') ?>";
  $file = null;
  if(preg_match($pregInclude, $this->tplContent, $file)) {
    if(!file_exists($file[1])) {
      exit("ERROR : {$file[1]}包含文件出错！");
    }
    $this->tplContent = preg_replace($pregInclude, $replaceInclude, $this->tplContent);
  }
}

}
