<?php
require '../vendor/autoload.php';

putenv("GOOGLE_APPLICATION_CREDENTIALS=../webpatriot-ocr-37416d334d48.json");

use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\FaceAnnotation;
// use Google\Cloud\Language\LanguageClient;
use Google\Cloud\Vision\VisionClient;


if(isset($_FILES['file']) && $_FILES['file'] != '')
{
    
    try {
        
        $path = $_FILES['file']['tmp_name'];
        
        $image = file_get_contents($path);

            $vision = new VisionClient();

            $image = $vision->image($image, 
                [
                    'FACE_DETECTION', 'WEB_DETECTION','LABEL_DETECTION','TEXT_DETECTION','SAFE_SEARCH_DETECTION','OBJECT_LOCALIZATION'
                ],
                [
                    'maxResults' => ['LABEL_DETECTION' => 50,'OBJECT_LOCALIZATION' => 50]
                ]);
            
            $result = $vision->annotate($image);
            
            if($texts = $result->text())
            {
                foreach ($texts as $key => $val) {
                    $data['textresults'][] = $val->info();
                }
            }

            if($faces = $result->faces())
            {
                foreach ($faces as $key => $val) {
                    $data['faceresults'][] = $val->info();
                }
            }

            if($safesearch = $result->safeSearch())
            {
                $data['localizeObjectResults'] = $result->info()['localizedObjectAnnotations'];
            }

            if($safesearch = $result->safeSearch())
            {
                $data['safeSearchresults'] = $safesearch->info();
            }

            if($labels = $result->labels())
            {
                foreach ($labels as $key => $val) {
                    $data['labelresults'][] = $val->info();
                }
            }

            $data['webresults'] = $result->web()->info()['webEntities'];

            print_r(json_encode($data ?? 'No Data!'));

            
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}