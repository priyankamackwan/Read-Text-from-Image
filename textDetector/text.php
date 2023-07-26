<?php
require '../vendor/autoload.php';

putenv("GOOGLE_APPLICATION_CREDENTIALS=../webpatriot-ocr-37416d334d48.json");

use Google\Cloud\Vision\V1\ImageAnnotatorClient;

if(isset($_FILES['file']) && $_FILES['file'] != '')
{
    try {
        
        $client = new ImageAnnotatorClient();
        
        $path = $_FILES['file']['tmp_name'];
        
        $image = file_get_contents($path);

        $response = $client->textDetection($image);
        
        $annotation = $response->getTextAnnotations();
        
        print_r(isset($annotation[0]) ? $annotation[0]->getDescription() : 'No Data!');
        
        $client->close();
        
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}
