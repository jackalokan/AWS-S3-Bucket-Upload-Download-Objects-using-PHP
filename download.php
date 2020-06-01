<?php
	require '/vendor/autoload.php';			
	
	use Aws\S3\S3Client;
    use Aws\S3\Exception\S3Exception;

	$bucketName = ''; 		//Enter your S3 bucket name
	$IAM_KEY = '';			//Enter your IAM key
	$IAM_SECRET = '';		//Enter your IAM Secret key

	try {
		$s3 = S3Client::factory(
			array(
				'credentials' => array(
					'key' => $IAM_KEY,
					'secret' => $IAM_SECRET
				),
				'version' => 'latest',
				'region'  => 'ap-south-1'		//Enter your S3 bucket region name
			)
		);
	} catch (Exception $e) {
		
		die("Error: " . $e->getMessage());
    }
    
    $keyName =  $_POST["filetodownload"];
	$pathInS3 = 'https://s3.ap-south-1.amazonaws.com/' . $bucketName . '/' . $keyName;		//Enter your AWS S3 bucket URL
	$tempSave = '/var/www/html/'.$keyName;													//Enter the path where you want your file(s) to get downloaded
	try {

		$s3->getObject(
			array(
				'Bucket'=>$bucketName,
				'Key' =>  $keyName,

				'StorageClass' => 'REDUCED_REDUNDANCY',
				'SaveAs' => $tempSave
			)
		);
		chmod($keyName,0777);

	} catch (S3Exception $e) {
		die('Error:' . $e->getMessage());
	} catch (Exception $e) {
		die('Error:' . $e->getMessage());
	}
	
	echo 'Done';
?>
