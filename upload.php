	<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/storage/README.md
 */
require 'vendor/autoload.php';
use Google\Cloud\Speech\SpeechClient;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Core\ExponentialBackoff;

function upload_object($bucketName, $objectName, $source,$language)
{
	$transcript=""; 
	$options = ['encoding' => 'FLAC' ];
		$storage = new StorageClient([
 'keyFile' => json_decode(file_get_contents('elango-211007-55b68546e0a9.json'), true)]);
    $file = fopen($source, 'r');
    $bucket = $storage->bucket($bucketName);
    $object = $bucket->upload($file, [
        'name' => $objectName
    ]);


/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/speech/api/README.md
 */

# [START speech_transcribe_async_gcs]

/**
 * Transcribe an audio file using Google Cloud Speech API
 * Example:
 * ```.
 *
 * @param string $bucketName The Cloud Storage bucket name.
 * @param string $objectName The Cloud Storage object name.
 * @param string $languageCode The Cloud Storage
 *     be recognized. Accepts BCP-47 (e.g., `"en-US"`, `"es-ES"`).
 * @param array $options configuration options.
 *
 * @return string the text transcription
 */
 
   // Create the speech client
    $speech = new SpeechClient([
        'languageCode' => $language,
'keyFile' => json_decode(file_get_contents('elango-211007-55b68546e0a9.json'), true),
 'enableSpeakerDiarization' =>true,
        'diarizationSpeakerCount'=> 2,
        'model'=>"phone" 
  ]);
    // Fetch the storage object
    $storage = new StorageClient();
    $object = $storage->bucket($bucketName)->object($objectName);
    // Create the asyncronous recognize operation
    $operation = $speech->beginRecognizeOperation(
        $object,
        $options
    );
    // Wait for the operation to complete
    $backoff = new ExponentialBackoff(10);
    $backoff->execute(function () use ($operation) 
	{
        $operation->reload();
        if (!$operation->isComplete()) 
		{
            throw new Exception('Job has not yet completed', 500);
        }
    });
	
    // Print the results
    if ($operation->isComplete()) {
        $results = $operation->results();
        foreach ($results as $result) {
            $alternative = $result->alternatives()[0];
            	$transcript=$transcript.$alternative['transcript'];
            }
    }
	
  $storage = new StorageClient([
 'keyFile' => json_decode(file_get_contents('elango-211007-55b68546e0a9.json'), true)]);
    $bucket = $storage->bucket($bucketName);
    $object = $bucket->object($objectName);
    $object->delete();
	return $transcript;
}

# [END speech_transcribe_async_gcs]
?>