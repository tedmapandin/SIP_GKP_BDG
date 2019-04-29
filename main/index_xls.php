<? 
	session_start();
	set_time_limit(3600);
	include('../control/functions.php');
	include('../conn/conn.php'); 
	
	/** Include PHPExcel */
	require_once '../Classes/PHPExcel.php'; 
			 					
	include("../main"."/".$f."_xls.php");
		 
?>
	  