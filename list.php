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
    
    try {
        $objects = $s3->listObjects([
            'Bucket' => $bucketName
        ]);
        foreach ($objects['Contents']  as $object) {
            echo $object['Key'] . "<br><br>";
        }
    } catch (S3Exception $e) {
        echo $e->getMessage() . PHP_EOL;
	}

?>
