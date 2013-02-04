<?php

require "config.php"; /* Include Configuration File */
require $FB_PHP_SDK_URL.'/facebook.php'; /* Include Facebook PHP API Class file */

/* Invoke Facebook PHP API Class and create an Object */
$facebook = new Facebook(array(
  'appId'  => $FB_APP_ID,
  'secret' => $FB_APP_SECRET,
));

$user = $facebook->getUser(); /* Get the FB User ID for the logged in user */

$user_disp_name = json_decode(file_get_contents('http://graph.facebook.com/'.$user))->first_name;

$access_token_Ref = $facebook->getAccessToken(); /* Get the access token for user requests */

/* If this Facebook application is not installed, Request for App Installation - START */

if(!$user) {
	$dialog_url = "http://www.facebook.com/dialog/oauth?client_id=".$FB_APP_ID."&redirect_uri=" . urlencode("$FB_APP_URL") . "&scope=publish_stream&state=". $_SESSION['state'];
	echo("<script> top.location.href='" . $dialog_url . "'</script>");
	exit;
}

/* If this Facebook application is not installed, Request for App Installation - END */

$up_sel=' id="sel" ';$my_sel='';$msg='';

if(isset($_POST['page_ref'])){
	$page_ref = $_POST['page_ref'];

	require_once $AWS_PHP_SDK_URL.'/sdk.class.php'; /* Include AWS PHP API Class file */

	/* Create an AWS S3's Class Object */
	$s3 = new AmazonS3($AWS_ACCESS_KEY,$AWS_SECRET_KEY);
	
	/* File Upload Section */
	if($page_ref == 'up') {
		if(isset($_POST['Upload'])){
            if($_FILES['upfile']['name']!=''){
				$fileName = $_FILES['upfile']['name'];  /* Get the name of the file to be uploaded to S3 bucket */
				$fileTempName = $_FILES['upfile']['tmp_name']; 
				
				/* Upload the file to S3 bucket (w.r.t this logged-in FB user) and set the permission to ACL_PUBLIC */
				$s3->create_object($S3_BUCKET_NAME, $user."_".$fileName, array(
								'fileUpload' => $fileTempName,'acl' => AmazonS3::ACL_PUBLIC )); 
				
				$msg = "File <b>$fileName</b> Uploaded Successfully!";
				
				/* Get the S3 public URL for this uploaded file */
				$s3_pub_url = $s3->get_object_url($S3_BUCKET_NAME, $user."_".$fileName);
				
				/* Facebook wall post for this uploaded file */
				try {
					$facebook->api('/me/feed/', 'post', array('access_token' => $access_token_Ref, 'message' => 'has shared a file! Check it out.','picture'=>'http://d36cz9buwru1tt.cloudfront.net/logo_aws.gif','name'=>$fileName,'link'=>$s3_pub_url,'caption'=>'Click the above link to download file.'));

				}catch(Exception $err){
					$msg .= "<br> Wall Post was not done.<br> ";
				}
			}
		}
	} else if($page_ref == 'dwn') { /* File View/Download Section */
		$my_sel=' id="sel" '; $up_sel='';$del_msg='';
		if(isset($_POST['delRef'])){
		    $del_msg='<b>The following file(s) are deleted Successfully!</b><ul>';	
		    
			/* Iterate the files requested for removal (w.r.t this logged-in FB user) from S3 bucket */
			foreach($_POST['delRef'] as $file_ref) {
				$s3->delete_object($S3_BUCKET_NAME, $user."_".$file_ref); /* Remove file from S3 bucket */
				$del_msg.="<li> $file_ref </li>";
		    }
			$del_msg.="</ul>";
		}
		
		/* Get the list of files (w.r.t this logged-in FB user) from the S3 bucket */
		$response = $s3->get_object_list($S3_BUCKET_NAME, array(
			'pcre' => '/'.$user.'_/i'
		));

		$MY_FILES='';
		$chk_files = 0;

		foreach ($response as $val)
		{
			$s3_pub_url = $s3->get_object_url($S3_BUCKET_NAME,$val); /* Get the S3 public URL for this uploaded file */
			
			$val = preg_replace('/'.$user.'_/','',$val); /* Remove the logged-in FB user reference from the filename */
			
			/* Build the file view section */
			$MY_FILES .="<li><div id='f_cont'><div style='float:left;'><input type='checkbox' name='delRef[]' value='".$val."' /></div><div style='float:left;padding-right:10px;'><span>". $val ."</span></div><div id='del-icon'  style='float:left;'></div><div id='del-txt'><a href='".$s3_pub_url."'>download</a></div></div></li>";
			$chk_files=1;
		}

		if(!$chk_files) { $msg = "<b>No Files Shared Yet</b>!"; }
	}
}

?>
