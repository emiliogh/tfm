<?php
	if(is_array($_FILES)) {
		if(is_uploaded_file($_FILES['file']['tmp_name'])) {
			$sourcePath = $_FILES['file']['tmp_name'];
			$directory = '../facturaElectronica/firmaElectronica/';
			$files = glob($directory . '*.*');
				if ( $files !== false )
					{ $filecount = count( $files );}
				else{$filecount = 0;}
			//$sz = str_replace('application/','',str_replace('text/','',$_FILES['file']['type']));
			$targetPath = "../facturaElectronica/firmaElectronica/firmaElectronica".str_pad($filecount,2, "0", STR_PAD_LEFT).".p12";
			
				if(move_uploaded_file($sourcePath,$targetPath)) {
					echo json_encode("firmaElectronica".str_pad($filecount,2, "0", STR_PAD_LEFT).".p12");
				}
			}	
	}
?>