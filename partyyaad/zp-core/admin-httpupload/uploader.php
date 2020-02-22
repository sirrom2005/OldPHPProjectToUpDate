<?php
define('OFFSET_PATH', 3);
require_once(dirname(dirname(__FILE__)).'/admin-globals.php');

$_zp_loggedin = NULL;
if (isset($_POST['auth'])) {
	$hash = sanitize($_POST['auth']);
	$id = sanitize($_POST['id']);
	$_zp_loggedin = $_zp_authority->checkAuthorization($hash, $id);
}

admin_securityChecks(UPLOAD_RIGHTS, $return = currentRelativeURL(__FILE__));

/* handle posts */
$gallery = new Gallery();
$error = false;
if (isset($_POST['processed'])) {
	// sometimes things just go terribly wrong!
	// Check for files.
	if (isset($_FILES['files'])) {
		foreach($_FILES['files']['name'] as $key=>$name) {
			if (empty($name)) {
				// purge empty slots
				unset($_FILES['files']['name'][$key]);
				unset($_FILES['files']['type'][$key]);
				unset($_FILES['files']['tmp_name'][$key]);
				unset($_FILES['files']['error'][$key]);
				unset($_FILES['files']['size'][$key]);
			}
		}
	}
	$filecount = 0;

	$newAlbum = ((isset($_POST['existingfolder']) && $_POST['existingfolder'] == 'false') || isset($_POST['newalbum']));
	// Make sure the folder exists. If not, create it.
	if (isset($_POST['processed']) && !empty($_POST['folder'])) {
		$folder = zp_apply_filter('admin_upload_process',trim(sanitize_path($_POST['folder'])));
		$targetPath = ALBUM_FOLDER_SERVERPATH.internalToFilesystem($folder);
		$new = !is_dir($targetPath);
		if ($new) {
			$rightsalbum = new Album($gallery, dirname($folder));
		} else{
			$rightsalbum = new Album($gallery, $folder);
		}
		if (!$rightsalbum->isMyItem(UPLOAD_RIGHTS)) {
			if (!zp_apply_filter('admin_managed_albums_access',false, $return)) {
				$error = UPLOAD_ERR_CANT_WRITE;
			}
		}
		if (!$error) {
			if (!is_dir($targetPath)) {
				mkdir_recursive($targetPath, CHMOD_VALUE);
			}
			@chmod($targetPath, CHMOD_VALUE);
			$album = new Album($gallery, $folder);
			if ($album->exists) {
				$album->setShow((int) !empty($_POST['publishalbum']));
				$title = sanitize($_POST['albumtitle'], 2);
				if (!empty($title) && $newAlbum) {
					$album->setTitle($title);
				}
				$album->save();
			} else {
				$AlbumDirName = str_replace(SERVERPATH, '', $gallery->albumdir);
				zp_error(gettext("The album couldn't be created in the 'albums' folder. This is usually a permissions problem. Try setting the permissions on the albums and cache folders to be world-writable using a shell:")." <code>chmod 777 " . $AlbumDirName . '/'.CACHEFOLDER.'/' ."</code>, "
				. gettext("or use your FTP program to give everyone write permissions to those folders."));
			}

			foreach ($_FILES['files']['error'] as $key => $error) {
				$filecount++;
				if ($error == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES['files']['tmp_name'][$key];
					$name = trim($_FILES['files']['name'][$key]);
					$soename = seoFriendly($name);
					$error = zp_apply_filter('check_upload_quota', UPLOAD_ERR_OK, $tmp_name);
					if (!$error) {
						if (is_valid_image($name) || is_valid_other_type($name)) {
							if (strrpos($soename,'.')===0) $soename = md5($name).$soename; // soe stripped out all the name.
							if (!$error) {
								$uploadfile = $targetPath . '/' . internalToFilesystem($soename);
								if (file_exists($uploadfile)) {
									$append = '_'.time();
									$soename = stripSuffix($soename).$append.'.'.getSuffix($soename);
									$uploadfile = $targetPath . '/' . internalToFilesystem($soename);
								}
								move_uploaded_file($tmp_name, $uploadfile);
								@chmod($uploadfile, 0666 & CHMOD_VALUE);
								$image = newImage($album, $soename);
								if ($name != $soename) {
									$image->setTitle($name);
									$image->save();
								}
							}
						} else if (is_zip($name)) {
							unzip($tmp_name, $targetPath);
						} else {
							$error = UPLOAD_ERR_EXTENSION;	// invalid file uploaded
							break;
						}
					}
				} else {
					break;
				}
			}
			if ($error == UPLOAD_ERR_OK && ($filecount || isset($_POST['newalbum']))) {
				if ($album->albumSubRights() & MANAGED_OBJECT_RIGHTS_EDIT) {
					//	he has edit rights, allow new album creation
					header('Location: '.FULLWEBPATH.'/'.ZENFOLDER.'/admin-edit.php?page=edit&album='.pathurlencode($folder).'&uploaded&subpage=1&tab=imageinfo&albumimagesort=id_desc');
				} else {
					header('Location: '.FULLWEBPATH.'/'.ZENFOLDER.'/admin-upload.php?uploaded=1');
				}
				exit();
			}
		}
	}
}
// Handle the error and return to the upload page.
if (!isset($_POST['processed'])) {
	$errormsg = gettext("You've most likely exceeded the upload limits. Try uploading fewer files at a time, or use a ZIP file.");
} else if (!$filecount && !isset($_POST['newalbum'])) {
	$errormsg = gettext("You must upload at least one file.");
} else if (empty($_POST['folder'])) {
	$errormsg = gettext("You must enter a folder name for your new album.");
} else {
	switch ($error) {
		case UPLOAD_ERR_CANT_WRITE:
			$errormsg = gettext('You have attempted to upload to an album for which you do not have upload rights');
			break;
		case UPLOAD_ERR_EXTENSION:
			$errormsg = gettext('You have attempted to upload one or more files which are not Zenphoto supported file types');
			break;
		case UPLOAD_ERR_INI_SIZE:
		case UPLOAD_ERR_FORM_SIZE:
			$errormsg = gettext('You have attempted to upload too large a file');
			break;
		case UPLOAD_ERR_QUOTA:
			$errormsg = gettext('You have exceeded your upload quota');
			break;
		default:
			$errormsg = sprintf(gettext("The error %s was reported when submitting the form. Please try again. If this keeps happening, check your server and PHP configuration (make sure file uploads are enabled, and upload_max_filesize is set high enough.) If you think this is a bug, file a bug report. Thanks!"),$error);
		break;
	}
}
header('Location: '.FULLWEBPATH.'/'.ZENFOLDER.'/admin-upload.php?error='.$errormsg);
exit();

?>