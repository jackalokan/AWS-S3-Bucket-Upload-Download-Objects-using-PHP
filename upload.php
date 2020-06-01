<?php
	require '/vendor/autoload.php';			
	
	use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;

	$bucketName = '';		//Enter your S3 bucket name
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
	
	$keyName = basename($_FILES["filetoupload"]['name']);
	$pathInS3 = 'https://s3.ap-south-1.amazonaws.com/' . $bucketName . '/' . $keyName;		//Enter your AWS S3 bucket URL 


	try {
		$file = $_FILES["filetoupload"]['tmp_name'];

		$s3->putObject(
			array(
				'Bucket'=>$bucketName,
				'Key' =>  $keyName,
				'SourceFile' => $file,
				'StorageClass' => 'REDUCED_REDUNDANCY'
			)
		);

	} catch (S3Exception $e) {
		die('Error:' . $e->getMessage());
	} catch (Exception $e) {
		die('Error:' . $e->getMessage());
	}

	echo 'Done';
?>
