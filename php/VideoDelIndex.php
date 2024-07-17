
<?php  
   include_once('../_lib/Mobile_Detect.php');
   $detect = new Mobile_Detect();
?>

<?php if ($_SESSION['VideoCargado'] == 0 && $detect->isMobile()==false) { ?>
  <video  id="VideoCity" autoplay >
    <source src="videos/Web_city_3249.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video> 
  
<?php } 
$_SESSION['VideoCargado'] = 1; 
?>