<?php
/* Get post details */
$post = isset($_POST) ? $_POST: array();
switch($post['cover-action']) {
	case 'save' :
	saveProfilePicTmp();
	break;
	default:
	changeProfileCoverPic();
}
/* Function to change profile picture */
function changeProfileCoverPic() {
	$post = isset($_POST) ? $_POST: array();
	$max_width = "500";
	$max_height = "350";
	$userId = isset($post['hdn-profile-id-cover']) ? intval($post['hdn-profile-id-cover']) : 0;
	//$path = 'images/tmp';
	$path = 'images/'.$userId;
	$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
	$name = $_FILES['profile-pic-cover']['name'];
	$size = $_FILES['profile-pic-cover']['size'];
	if(strlen($name)) {
		list($txt, $ext) = explode(".", $name);
		if(in_array($ext,$valid_formats)) {
			if($size<(1024*1024)) {
				//$actual_image_name = 'avatar' .'_'.$userId .'.'.$ext;
				$actual_image_name = 'large'.'.'.$ext;
				$filePath = $path .'/'.$actual_image_name;
				$tmp = $_FILES['profile-pic-cover']['tmp_name'];
				if(move_uploaded_file($tmp, $filePath)) {
					$width = getWidth($filePath);
					$height = getHeight($filePath);
					//Scale the image if it is greater than the width set above
					if ($height > $max_height){
						$scale = $max_height/$height;
						$uploaded = resizeImage($filePath,$width,$height,$scale);
					}else if ($width > $max_width){
						$scale = $max_width/$width;
						$uploaded = resizeImage($filePath,$width,$height,$scale);
					} else {
						$scale = 1;
						$uploaded = resizeImage($filePath,$width,$height,$scale);
					}
					$res = saveProfilePic(array(
					'userId' => isset($userId) ? intval($userId) : 0,
					'avatar' => isset($actual_image_name) ? $actual_image_name : '',
					));
					echo "<img id='photo-cover' file-name='".$actual_image_name."' src='".$filePath.'?'.time()."' class='preview'/>";
				}
				else
				echo "failed";
			}
			else
			echo "Image file size max 1 MB"; 
		}
		else
		echo "Invalid file format.."; 
	}
	else 
	echo "Please select image..!";
	exit;	
}
/* Function to handle save profile pic */
function saveProfilePic($options){
	//Handle profile picture update with MySQL update Query using $options array	
}
	
/* Function to update image */
 function saveProfilePicTmp() {
	$post = isset($_POST) ? $_POST: array();
	$userId = isset($post['id']) ? intval($post['id']) : 0;
	$path ='\\images\tmp';
	$t_width = 730; // Maximum thumbnail width
	$t_height = 300;    // Maximum thumbnail height	
	if(isset($_POST['t']) and $_POST['t'] == "ajax") {
		extract($_POST);//https://stackoverflow.com/questions/5306498/php-is-there-a-safe-way-to-extract-post
		$imagePath = 'images/tmp/'.$_POST['image_name'];
		$ratio = ($t_width/$w1); 
		$nw = ceil($w1 * $ratio);
		$nh = ceil($h1 * $ratio);
		$nimg = imagecreatetruecolor($nw,$nh);
		$im_src = imagecreatefromjpeg($imagePath);
		imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w1,$h1);
		imagejpeg($nimg,$imagePath,90);		
	}
	echo $imagePath.'?'.time();;
	exit(0);    
}    
/* Function  to resize image */
function resizeImage($image,$width,$height,$scale) {
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	//$source = imagecreatefromjpeg($image);
	$info = getimagesize($image);
    $mime = $info['mime'];
    switch ($mime) {
		case 'image/jpeg':
			$source = imagecreatefromjpeg($image);
			break;
		case 'image/png':
			$source = imagecreatefrompng($image);
			break;
		case 'image/gif':
			$source = imagecreatefromgif($image);
			break;
		default: 
			throw new Exception('Unknown image type.');
    }
	imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	imagejpeg($newImage,$image,90);
	chmod($image, 0777);
	return $image;
}
/*  Function to get image height. */
function getHeight($image) {
    $sizes = getimagesize($image);
    $height = $sizes[1];
    return $height;
}
/* Function to get image width */
function getWidth($image) {
    $sizes = getimagesize($image);
    $width = $sizes[0];
    return $width;
}
?>