<?php
	if(is_array($_FILES)) {
		if(is_uploaded_file($_FILES['file']['tmp_name'])) {
			$sourcePath = $_FILES['file']['tmp_name'];
			$directory = '../respaldos_compras/xml/';
			$files = glob($directory . '*.*');
				if ( $files !== false )
					{ $filecount = count( $files );}
				else{$filecount = 0;}
			$sz = str_replace('application/','',str_replace('text/','',$_FILES['file']['type']));
			$targetPath = "../respaldos_compras/xml/".str_pad($filecount,8, "0", STR_PAD_LEFT).".".$sz;
			
				if(move_uploaded_file($sourcePath,$targetPath)) {
					echo json_encode(str_pad($filecount,8, "0", STR_PAD_LEFT).".".$sz);
				}
			}	
	}
?>