<?php
include_once __DIR__ . '/../config.php';

include_once "C:/xampp/htdocs/project/bar/index.php";
?><?php
include_once "C:/xampp/htdocs/project/st_data/time.php";
?>
<?php

require_once './conn/conn.php';
include_once "header.php";   
?>
<style>
h1{
    color:#076177;
}
    /* .img1  img  {
    width: 400px;
    height: 350px; */
        /* border-style: outset;border: 2px solid gray; */
/* border-radius: 5px;padding: 10px 30px;color: black;
    } */
   /* .img1  img:hover{width:30%;}
    
    img{
    width: 16%; 
    margin-right: 30px;
/*  box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.5);*/
    /* border-radius:20px;
    }
    
    img:hover{
    width: 15%%; 
    transition: 1s; */
    /* transition-timing-function: ease-out;
    will-change: transform;
          transform: translateY(-5px); */
  /* box-shadow: 0px 10px 20px 2px rgba(0, 0, 0, 0.25); */
    /* } */ */
  
     h1{text-align: center} 

</style>
<br>
<head>
<link rel="stylesheet" href="bar/style.css">
    <link rel="stylesheet" href="styles.css">


</head>

 
<h2>أدارة نـــــظــــــــام الطــــــــلاب</h2>
	<center>
        

  <div class="container">
  <h1>المدير</h1>  
        <a href="login.php?usertype=ADMIN">
        <img src="logo/admin.jpg">
    </a> 
  </div>
  <div class="container">
  <h1>المعلم</h1>  
  <a href="login.php?usertype=te">
  <img src="logo/teacher.jpg">
  </a> 
  </div>
  <div class="container">
  <h1>الطالب</h1>
          <a href="st_login.php">
        <img src="logo/student.jpg">
    </a>
  </div>
             
  
        </div>
		</center>  

</body>

</html>