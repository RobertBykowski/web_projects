<?php 
/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2005 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * "Support Open Source software. What about a donation today?"
 * 
 * File Name: commands.php
 * 	This is the File Manager Connector for PHP.
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 *		Kae Verens (kae@verens.com) - Delete File, RenameFile, RotateFile, CreateThumbnail, abstraction and other minor edits
 */


function CreateThumbNail($sServerDir,$sFile,$isIcon=0){
	CreateServerFolder($sServerDir.'_thumbs');
	if($isIcon)$newname=$sServerDir.'_thumbs/icon_'.$sFile;
	else $newname=$sServerDir.'_thumbs/'.$sFile;
	$maxsize=$isIcon?32:64;
	if(file_exists($newname))unlink($newname);
	$info=getimagesize($sServerDir.$sFile);
	if($info){
		$type=0;
		switch($info[2]){
			case 2: $type = 'jpeg'; break;
			case 3: $type = 'png'; break;
		}
		if($type){
			$load='imagecreatefrom'.$type;
			$save='image'.$type;
			if(!function_exists($load)||!function_exists($save))return;
			if($info[0]>1024||$info[1]>1024)return;
			$im=imagecreatetruecolor($info[0],$info[1]);
			imagecopyresized($im,$load($sServerDir.$sFile),0,0,0,0,$info[0],$info[1],$info[0],$info[1]);
			if($info[0]>$maxsize||$info[1]>$maxsize){
				$x=$maxsize/$info[0];
				$y=$maxsize/$info[1];
				$multiply=$x>$y?$y:$x;
				$newx=(int)$info[0]*$multiply;
				$newy=(int)$info[1]*$multiply;
				$imresized=imagecreatetruecolor($newx,$newy);
				imagecopyresampled($imresized,$im,0,0,0,0,$newx,$newy,$info[0],$info[1]);
				$im=$imresized;
				$imresized=null;
			}
			$save($im,$newname,100);
			@chmod( $newname, 0777 ) ;			
			$im=null;
			if(!$isIcon)CreateThumbNail($sServerDir,$sFile,1);
		}
	}
}
function ResizeFile($resourceType,$currentFolder,$sFile,$newx,$newy) {
	if(preg_match('/\/|\.\./',$sFile))return;
	$sServerDir=ServerMapFolder($resourceType,$currentFolder) ;
	$info=getimagesize($sServerDir.$sFile);
	if($info){
		$type=0;
		switch($info[2]){
			case 2: $type = 'jpeg'; break;
			case 3: $type = 'png'; break;
		}
		$newx=round($newx);
		$newy=round($newy);	
			
		if($type&&!empty($newx)&&!empty($newy)){
			$load='imagecreatefrom'.$type;
			$save='image'.$type;
			$imfile=$load($sServerDir.$sFile);
			$im=imagecreatetruecolor($info[0],$info[1]);
			imagecopyresized($im,$imfile,0,0,0,0,$info[0],$info[1],$info[0],$info[1]);
			$imresized=imagecreatetruecolor($newx,$newy);
			imagecopyresampled($imresized,$im,0,0,0,0,$newx,$newy,$info[0],$info[1]);
			$save($imresized,$sServerDir.$sFile,100);
			@chmod( $sServerDir.$sFile, 0777 ) ;	
			CreateThumbNail($sServerDir,$sFile);
		}
	}
}

function RotateFile($resourceType,$currentFolder,$sFile,$angle) {
	if(preg_match('/\/|\.\./',$sFile))return;
	$sServerDir=ServerMapFolder($resourceType,$currentFolder) ;
	$info=getimagesize($sServerDir.$sFile);
	if($info){
		$type=0;
		switch($info[2]){
			case 2: $type = 'jpeg'; break;
			case 3: $type = 'png'; break;
		}
		if($type&&function_exists("imagerotate")){
			$load='imagecreatefrom'.$type;
			$save='image'.$type;
			if(!function_exists($load)&&!function_exists($save))return;
			$imfile=$load($sServerDir.$sFile);
			$im=imagecreatetruecolor($info[0],$info[1]);
			imagecopyresized($im,$imfile,0,0,0,0,$info[0],$info[1],$info[0],$info[1]);
			$im=imagerotate($im,$angle,0);
			$save($im,$sServerDir.$sFile,100);
			@chmod( $sServerDir.$sFile, 0777 ) ;	
			CreateThumbNail($sServerDir,$sFile);
		}
	}
}

function DeleteFile($resourceType,$currentFolder,$file) {
	if(preg_match('/\/|\.\./',$file)) return;
	
	$sServerDir = ServerMapFolder( $resourceType, $currentFolder ) ;
	if(is_dir($sServerDir.$file)){
		if(is_dir($sServerDir.$file.'/_thumbs')){		
			rmdir($sServerDir.$file.'/_thumbs');		
		}	
		rmdir($sServerDir.$file);
	} else {
		unlink($sServerDir.$file);
		unlink($sServerDir.'_thumbs/'.$file);
		unlink($sServerDir.'_thumbs/icon_'.$file);		
		unlink($sServerDir.'_thumbs/caption_'.$file);			
	}

}

function RecaptionFile($resourceType,$currentFolder,$file,$caption){
	$sServerDir=ServerMapFolder($resourceType,$currentFolder).'/';
	exec('echo "'.str_replace('"','\\"',($caption)).'" > "'.$sServerDir.'_thumbs/caption_'.$file.'"');
}

function RenameFile($resourceType,$currentFolder,$from,$to){
	foreach(array($to,$from) as $a)if(preg_match('/\/|\.\./',$a))return;
	
	$to=tekstForm::usunPl($to);
	$to=str_replace(" ","_",$to);				
	
	$sServerDir=ServerMapFolder($resourceType,$currentFolder).'/';
	if(!is_dir($sServerDir.$from)&&$from!=$to){
		unlink($sServerDir.'_thumbs/'.$from);
		unlink($sServerDir.'_thumbs/icon_'.$from);		
		unlink($sServerDir.'_thumbs/caption_'.$from);			
	}	
	rename($sServerDir.$from,$sServerDir.$to);
	
}

function GetFolders($resourceType,$currentFolder){
	GetFoldersAndFiles($resourceType,$currentFolder,0);
}

function GetFoldersAndFiles($resourceType,$currentFolder,$showFiles=1){
	{ # variables
		$sServerDir=ServerMapFolder($resourceType,$currentFolder);
		$aFolders=array();
		$aFiles	=array();
		$oCurrentFolder=opendir($sServerDir);
	}
	while($sFile=readdir($oCurrentFolder)){
		if ( $sFile != '.' && $sFile != '..' && $sFile!='_thumbs')
		{
			if(is_dir($sServerDir.$sFile))$aFolders[]='<Folder name="'.ConvertToXmlAttribute($sFile).'" />';
			else if($showFiles){
				$FileInfo=array();
				{ # file size
					$iFileSize=filesize($sServerDir.$sFile);
					if($iFileSize>0){
						$iFileSize=round($iFileSize/1024);
						if($iFileSize<1)$iFileSize=1;
					}
					$FileInfo[]='size="'.$iFileSize.'"';
				}
				{ # if this is an image, get the info for it and generate a thumbnail
					$info=getimagesize($sServerDir.$sFile);
					if($info){
						if(!file_exists($sServerDir.'_thumbs/'.$sFile)||!file_exists($sServerDir.'_thumbs/icon_'.$sFile))CreateThumbNail($sServerDir,$sFile);
						if(file_exists($sServerDir.'_thumbs/'.$sFile))$thumb=1;
						else $thumb=0;
						if(!file_exists($sServerDir.'_thumbs/caption_'.$sFile))system('touch "'.$sServerDir.'_thumbs/caption_'.$sFile.'"');
						$caption=join('',file($sServerDir.'_thumbs/caption_'.$sFile));
						$FileInfo[]='imagedata="'.htmlspecialchars($thumb.'|'.join('|',$info).'|'.$caption).'"';
					}
				}
				$aFiles[]='<File name="'.ConvertToXmlAttribute($sFile).'" '.join(' ',$FileInfo).' />';
			}
		}
	}
	{ # Send the folders
		natcasesort($aFolders);
		echo '<Folders>'.join('',$aFolders).'</Folders>';
	}
	{ # Send the files
		natcasesort($aFiles);
		if($showFiles)echo '<Files>'.join('',$aFiles).'</Files>';
	}
}

function CreateFolder( $resourceType, $currentFolder )
{
	$sErrorNumber	= '0' ;
	$sErrorMsg		= '' ;

	if ( isset( $_GET['NewFolderName'] ) )
	{
		$sNewFolderName = $_GET['NewFolderName'] ;
		$sNewFolderName=tekstForm::usunPl($sNewFolderName);			
		$sNewFolderName=str_replace(" ","_",$sNewFolderName);			
			
		if ( strpos( $sNewFolderName, '..' ) !== FALSE )
			$sErrorNumber = '102' ;		// Invalid folder name.
		else
		{
			// Map the virtual path to the local server path of the current folder.
			$sServerDir = ServerMapFolder( $resourceType, $currentFolder ) ;

			if ( is_writable( $sServerDir ) )
			{
				$sServerDir .= $sNewFolderName ;

				$sErrorMsg = CreateServerFolder( $sServerDir ) ;

				switch ( $sErrorMsg )
				{
					case '' :
						$sErrorNumber = '0' ;
						break ;
					case 'Invalid argument' :
					case 'No such file or directory' :
						$sErrorNumber = '102' ;		// Path too long.
						break ;
					default :
						$sErrorNumber = '110' ;
						break ;
				}
			}
			else
				$sErrorNumber = '103' ;
		}
	}
	else
		$sErrorNumber = '102' ;

	// Create the "Error" node.
	echo '<Error number="' . $sErrorNumber . '" originalDescription="' . ConvertToXmlAttribute( $sErrorMsg ) . '" />' ;
}

function FileUpload( $resourceType, $currentFolder ) 
{
	$sErrorNumber = '0' ;
	$sFileName = '' ;

	if ( isset( $_FILES['NewFile'] ) && !is_null( $_FILES['NewFile']['tmp_name'] ) )
	{
		global $Config ;
			
		$oFile = $_FILES['NewFile'] ;

		// Map the virtual path to the local server path.
		$sServerDir = ServerMapFolder( $resourceType, $currentFolder ) ;

		// Get the uploaded file name.
		$sFileName = $oFile['name'] ;
		$sFileName=tekstForm::usunPl($sFileName);		
		$sFileName=str_replace(" ","_",$sFileName);				
		
		// Replace dots in the name with underscores (only one dot can be there... security issue).
		if ( $Config['ForceSingleExtension'] )
			$sFileName = preg_replace( '/\\.(?![^.]*$)/', '_', $sFileName ) ;

		$sOriginalFileName = $sFileName ;

		// Get the extension.
		$sExtension = substr( $sFileName, ( strrpos($sFileName, '.') + 1 ) ) ;
		$sExtension = strtolower( $sExtension ) ;

		$arAllowed	= $Config['AllowedExtensions'][$resourceType] ;
		$arDenied	= $Config['DeniedExtensions'][$resourceType] ;

		if ( ( count($arAllowed) == 0 || in_array( $sExtension, $arAllowed ) ) && ( count($arDenied) == 0 || !in_array( $sExtension, $arDenied ) ) )
		{
			$iCounter = 0 ;

			while ( true )
			{
				$sFilePath = $sServerDir . $sFileName ;

				if ( is_file( $sFilePath ) )
				{
					$iCounter++ ;
					$sFileName = RemoveExtension( $sOriginalFileName ) . '(' . $iCounter . ').' . $sExtension ;
					$sErrorNumber = '201' ;
				}
				else
				{
					move_uploaded_file( $oFile['tmp_name'], $sFilePath ) ;

					if ( is_file( $sFilePath ) )
					{
						$oldumask = umask(0) ;
						chmod( $sFilePath, 0777 ) ;
						umask( $oldumask ) ;
					}

					break ;
				}
			}
		}
		else
			$sErrorNumber = '202' ;
	}
	else
		$sErrorNumber = '202' ;

	echo '<script type="text/javascript">' ;
	echo 'window.parent.frames["frmUpload"].OnUploadCompleted(' . $sErrorNumber . ',"' . str_replace( '"', '\\"', $sFileName ) . '") ;' ;
	echo '</script>' ;

	exit ;
}
?>