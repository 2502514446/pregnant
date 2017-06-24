<!DOCTYPE html>
<html>
<head>
  <title>pregnant</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

{*  hello*   *}
<br>
{ include file="./test.html"   }
<br>
  {if $webname }
    { $webname   }
    {if $name}
      {$name}
    {else}
      {$sex}
    {/if}
  {elseif $name}
    <h1>PREGNANT</h1>
  {else}
    <h2>LiJieLi</h2>
  {/if}
<br>
  { foreach $arr ( key,value ) }
    {@key}--{@value}<br>
  { foreach $arr ( key,value ) }
    ...{@key}--{@value}<br>
  {/foreach}
  {/foreach}
<br>
  {foreach $arrobj(key,value)}
    {@key}---{@value}<br>
  {/foreach}
<br>
  普通变量 : {$webname}
<br>
  对象的常量 : {$obj::VERSION}
<br>
  对象的变量 : {$obj->tpl_Dir}
<br>
  数组 : {$arr[1]}
<br>

</body>
</html>
