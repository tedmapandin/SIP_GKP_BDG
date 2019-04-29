<?php

/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';  
// Create new PHPExcel object
$objPHPExcel = new PHPExcel(); 
// Set document properties
$objPHPExcel->getProperties()->setCreator("Bayu Kristiadhi Muliasetia")
							 ->setLastModifiedBy("Bayu Kristiadhi Muliasetia")
							 ->setTitle("Dokumen SIP GKP Bandung")
							 ->setSubject("Rekap SIP GKP Bandung")
							 ->setDescription("Dokumen SIP GKP Bandung"); 

// Add some data


	$varDate = "b.OQDSDT";
	if ($bln=="" and $thn=="")	{
		$thn = date('Y');
		$bln = date('m');													
	}	else	{
		$queryBln= "SELECT * FROM variant_month  WHERE id='$bln'";
		$resultBln = odbc_exec($connSQLAddon, $queryBln); 
		odbc_fetch_row($resultBln); 
		$namaBlnVal  = odbc_result($resultBln,"description"); 													
	};
	if (($modelCari=="View Date"  OR $modelCari=="") AND $m3source!="true")	{ 
		if ($tglCari1=="")	{
			/*
			$tglCari1 = date('Ymd');
			$strTglCari1Date =strtotime($tglCari1);
			$seninVal = "false";
			$iStop=0;
			while ($seninVal=="false" AND $iStop<10)	{
				$iStop++;
				$strTglCari1Date = $strTglCari1Date - 86400;  
				$thedateCari1 = getdate($strTglCari1Date);  
				$hariVal = $thedateCari1[wday];
				 
				if ($hariVal=="1") {
					$tglDay = $thedateCari1[mday];
					$tglDayPjg = strlen($tglDay);
					if ($tglDayPjg=="1")	{
						$tglDay = "0".$tglDay;
					}; 
					$blnDay = $thedateCari1[mon];
					$blnDayPjg = strlen($blnDay);
					if ($blnDayPjg=="1")	{
						$blnDay = "0".$blnDay;
					};
					$tglCari1 =  $tglDay."-".$blnDay."-".$thedateCari1[year]; 
					$seninVal = "true";
				};
			}; 
			*/
			$tglCari1 = date('d-m-Y');
			$tglCari2 = date('d-m-Y'); 
		};
		$tglCari1Pecah = split("-",$tglCari1);
		$tglCari2Pecah = split("-",$tglCari2);
		$tglCari1Val = $tglCari1Pecah[2].$tglCari1Pecah[1].$tglCari1Pecah[0];
		$tglCari2Val = $tglCari2Pecah[2].$tglCari2Pecah[1].$tglCari2Pecah[0];
		if ($tglCari1Val > $tglCari2Val)	{
			$tglCariTemp = $tglCari1;
			$tglCari1 = $tglCari2;
			$tglCari2 = $tglCariTemp;
			$tglCari1Val = $tglCari1Pecah[2].$tglCari1Pecah[1].$tglCari1Pecah[0];
			$tglCari2Val = $tglCari2Pecah[2].$tglCari2Pecah[1].$tglCari2Pecah[0];
		};
		$strFilt = " AND $varDate >= $tglCari1Val AND $varDate <= $tglCari2Val";
		$strTglTit = " -> $tglCari1 s/d $tglCari2";
	}	else if ($modelCari=="View Month")	{
		if ($bln!="")	{
			$strFilt = " AND $varDate LIKE '$thn$bln%'";
		}	else	{
			$strFilt = " AND $varDate LIKE '$thn%'";
		}; 
		$strTglTit = " -> $namaBlnVal $strMonth $thn";
	}; 

if ($whsId!="")	{
	$sqlList = "SELECT MWWHLO,MWWHNM FROM M3FDBPRD.MITWHL WHERE MWCONO='$cmpIdDef' AND MWFACI='$idFac' AND MWWHLO='$whsId' ";  
	//echo "$strsql";
	$resultList = odbc_exec($connSQL, $sqlList);															
	odbc_fetch_row($resultList);
	$list_whs_code  = odbc_result($resultList,"MWWHLO");
	$whs_code  = odbc_result($resultList,"MWWHLO");
	$list_whs_name  = odbc_result($resultList,"MWWHNM");
	$whs_name  = odbc_result($resultList,"MWWHNM"); 
	$whs_name = trim($whs_name);
};

$titFull = " REPORT -> LISTING -> SURAT JALAN";  /*$whs_name $strDetailRec $strTglTit $strSortTit";*/  

/*$iRow++;
$objPHPExcel->setActiveSheetIndex($iSheet); 
			->setCellValue('A'.$iRow, $titFull);*/
			
$iSheet=0;
$iRow=0;
$iRow++;
$objPHPExcel->setActiveSheetIndex($iSheet)
			->setCellValue('A'.$iRow, 'No')
			->setCellValue('B'.$iRow, 'Tgl SJ')
			->setCellValue('C'.$iRow, 'No SJ')
			->setCellValue('D'.$iRow, 'No CO')
			->setCellValue('E'.$iRow, 'Whs')
			->setCellValue('F'.$iRow, 'ID LGN')
			->setCellValue('G'.$iRow, 'Nama LGN')
			->setCellValue('H'.$iRow, 'Nominal Nett')
			->setCellValue('I'.$iRow, 'PPN');
			
	$objPHPExcel->getActiveSheet()->getStyle('A'.$iRow.':'.'I'.$iRow)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(45);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
	
	$objPHPExcel->getActiveSheet()->getStyle('A'.$iRow.':'.'I'.$iRow)->applyFromArray(
	array('fill' 	=> array(
								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
								'color'		=> array('argb' => 'FFFFFF00')
							),
		'borders' => array(
								'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
							)
		 )
	);
	
	$i=0;  
	if ($whsId!="")	{
		$strFilt = "$strFilt  AND a.UAWHLO='$whsId'";
	};
	 
							$myFilt = '';
							
							if ($fltPJSJ == 'pj'){
								$myFilt = 'where a.QTY > 0';
							}

							if ($fltPJSJ == 'rj'){
								$myFilt = 'where a.QTY < 0';
							}
							
							
							//echo $whsId;
							$strsql = "select
												  a.*
												from 
												  (
												    select
												      DISTINCT a.UAWHLO,b.OQDSDT,a.UACONO,a.UADLIX,a.UADIVI,a.UAORNO,a.UACUNO, a.UAORNO, 
												      sum(c.URTRQT) QTY
												    FROM M3FDBPRD.ODHEAD a 
												      JOIN M3FDBPRD.MHDISH b ON a.UACONO=b.OQCONO AND a.UADLIX=b.OQDLIX AND a.UACUNO=b.OQCONA
												      left join M3FDBPRD.MHDISL c on c.URDLIX = a.UADLIX
														WHERE a.UACONO='$cmpIdDef'  AND a.UAFACI='$idFac' $strFilt
														group by
														  a.UAWHLO,b.OQDSDT,a.UACONO,a.UADLIX,a.UADIVI,a.UAORNO,a.UACUNO, a.UAORNO							
															ORDER BY a.UADLIX ASC,b.OQDSDT ASC
												  ) a $myFilt 
												order by
												   a.UADLIX,a.OQDSDT,a.UACONO,a.UAWHLO
												  ";
	 
	/* 
	$strsql = "SELECT DISTINCT a.UAWHLO,b.OQDSDT,a.UACONO,a.UADLIX,a.UADIVI,a.UAORNO,a.UACUNO
			FROM M3FDBPRD.ODHEAD a JOIN M3FDBPRD.MHDISH b ON a.UACONO=b.OQCONO AND a.UADLIX=b.OQDLIX AND a.UACUNO=b.OQCONA
				WHERE a.UACONO='$cmpIdDef'  AND a.UAFACI='$idFac' $strFilt
			ORDER BY b.OQDSDT ASC,a.UADLIX ASC";
			*/
	//echo "$strsql";
	$result = odbc_exec($connSQL, $strsql);															
	while (odbc_fetch_row($result))	
	{  
		$i++;
		$do_no  = odbc_result($result,"UADLIX");
		$co_no  = odbc_result($result,"UAORNO");   
		$comp_no  = odbc_result($result,"UACONO"); 
		$div_id  = odbc_result($result,"UADIVI"); 
		$doDateVal  = odbc_result($result,"OQDSDT"); 
		$whs  = odbc_result($result,"UAWHLO");
		
		/*
		$whsSql = "SELECT b.MWWHNM FROM M3FDBPRD.MITWHL b WHERE b.MWWHLO='$whs' AND b.MWCONO='$cmpIdDef'";
		//echo "$whsSql <br>";
		$resultWhs = odbc_exec($connSQL, $whsSql);															
		odbc_fetch_row($resultWhs); 
		$whs_name  = odbc_result($resultWhs,"MWWHNM");
		*/
		
		$cust_id  = odbc_result($result,"UACUNO");
		$cust_order_no  = odbc_result($result,"UAORNO"); 
		
		$custSql = "SELECT b.OKCUA1,b.OKCUA2,b.OKCUA3,b.OKCUA4,b.OKCUNM,b.OKCUNO,b.OKVRNO	  
					FROM M3FDBPRD.OCUSMA b WHERE b.OKCUNO='$cust_id'";
		//echo "$strsql <br>";
		$resultCust = odbc_exec($connSQL, $custSql);															
		odbc_fetch_row($resultCust); 
		$cust_name  = odbc_result($resultCust,"OKCUNM");


		$get_net = "SELECT 
					    a.URDLIX,
					    --b.OBNEPR, 
					    SUM(a.URTRQT*b.OBNEPR) Net 
					FROM M3FDBPRD.MHDISL a LEFT JOIN M3FDBPRD.OOLINE b 
					ON a.URRIDN = b.OBORNO AND b.OBITNO=a.URITNO AND a.URRIDL=b.OBPONR
					WHERE a.URDLIX = '$do_no'
					GROUP BY a.URDLIX";
		//echo $get_net;
		$exec_net = odbc_exec($connSQL, $get_net);
		odbc_fetch_row($exec_net);
		$nominal_net = odbc_result($exec_net,"Net");	  

		$get_ppn_head = "SELECT 
							a.OATXAP 
						 FROM M3FDBPRD.OOHEAD a LEFT JOIN M3FDBPRD.ODHEAD b
						 						ON a.OAORNO = b.UAORNO
						 WHERE b.UADLIX = '$do_no'";
		$exec_ppn_head = odbc_exec($connSQL, $get_ppn_head);
		odbc_fetch_row($exec_ppn_head);
		$ppn_head_stat = odbc_result($exec_ppn_head,"OATXAP");

		$ppn="";
		if($ppn_head_stat == '1')
		{
			$ppn = $nominal_net * 0.1;
		}
		else if($ppn_head_stat=='' || $ppn_head_stat="0")
		{
			$ppn = "";
		}  
		 
		$iRow++;
		$objPHPExcel->setActiveSheetIndex($iSheet) 
		->setCellValue('A'.$iRow, $i)
		->setCellValue('B'.$iRow, DisplayDateYYMMDD($doDateVal))
		->setCellValue('C'.$iRow, $do_no)
		->setCellValue('D'.$iRow, $co_no)
		->setCellValue('E'.$iRow, $whs)
		->setCellValue('F'.$iRow, $cust_id)
		->setCellValue('G'.$iRow, $cust_name)
		->setCellValue('H'.$iRow, $nominal_net) 
		->setCellValue('I'.$iRow, $ppn);
	};
 
 
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Data'); 
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);  
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="RptSjListing.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1'); 
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
  

?>