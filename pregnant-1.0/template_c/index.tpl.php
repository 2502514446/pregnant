<!DOCTYPE html>
<html>
<head>
  <title>pregnant</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<?php /*   hello*    */ ?>
<br>
<?php include('./test.html') ?>
<br>
  <?php if($this->tplVar["webname"]) {  ?>
    <?php echo $this->tplVar["webname"]; ?>
    <?php if($this->tplVar["name"]) {  ?>
      <?php echo $this->tplVar["name"]; ?>
    <?php }else{ ?>
      <?php echo $this->tplVar["sex"]; ?>
    <?php } ?>
  <?php }elseif($this->tplVar["name"]) {  ?>
    <h1>PREGNANT</h1>
  <?php }else{ ?>
    <h2>LiJieLi</h2>
  <?php } ?>
<br>
  <?php foreach($this->tplVar["arr"] as $key=>$value) {  ?>
    <?php echo $key  ?>--<?php echo $value  ?><br>
  <?php foreach($this->tplVar["arr"] as $key=>$value) {  ?>
    ...<?php echo $key  ?>--<?php echo $value  ?><br>
  <?php }  ?>
  <?php }  ?>
<br>
  <?php foreach($this->tplVar["arrobj"] as $key=>$value) {  ?>
    <?php echo $key  ?>---<?php echo $value  ?><br>
  <?php }  ?>
<br>
  普通变量 : <?php echo $this->tplVar["webname"]; ?>
<br>
  对象的常量 : <?php echo $this->tplVar["obj"]::VERSION; ?>
<br>
  对象的变量 : <?php echo $this->tplVar["obj"]->tpl_Dir; ?>
<br>
  数组 : <?php echo $this->tplVar["arr"][1]; ?>
<br>

</body>
</html>
