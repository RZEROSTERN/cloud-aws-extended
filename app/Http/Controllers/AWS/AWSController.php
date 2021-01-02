<?php
namespace App\Http\Controllers\AWS;

use Aws\S3\S3MultiRegionClient;
use App\Http\Controllers\Controller;

class AWSController extends Controller
{
    public $successStatus = 200;

    public function getAllBuckets() {
        $s3Client = new S3MultiRegionClient([
            'region' => env('MIX_AWS_REGION'),
            'version' => env('MIX_AWS_APIVERSION'),
            'credentials' => [
                'key' => env('MIX_AWS_KEY'),
                'secret' => env('MIX_AWS_SECRET')
            ],
        ]);

        $result = $s3Client->listBuckets();

        return response()->json(['success' => true, 'data' => $result['Buckets']], $this->successStatus);
    }

    public function getBucketItems($bucket) {
        $s3Client = new S3MultiRegionClient([
            'region' => env('MIX_AWS_REGION'),
            'version' => env('MIX_AWS_APIVERSION'),
            'credentials' => [
                'key' => env('MIX_AWS_KEY'),
                'secret' => env('MIX_AWS_SECRET')
            ],
        ]);

        try {
            $delimitersArr = [];

            $delimiters = $s3Client->getPaginator('ListObjects', [
                'Bucket' => $bucket,
                'Delimiter' => '/'
            ]);

            foreach ($delimiters as $delimiter) {
                if(null !== $delimiter['CommonPrefixes']){
                    foreach($delimiter['CommonPrefixes'] as $commonPrefix) {
                        $delimitersArr[] = $commonPrefix['Prefix'];
                    }
                }
                
                if(null !== $delimiter['Contents']){
                    foreach($delimiter['Contents'] as $content) {
                        $delimitersArr[] = $content['Key'];
                    }
                }
            }

            return response()->json(['success' => true, 'data' => $delimitersArr], $this->successStatus);
        } catch(S3Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al mostrar los elementos', 'stack' => $e]);
        }
    }

    public function getFolderItems($bucket, $prefix) {
        // AQUI ME QUEDÉ, FELIZ AÑO NUEVO !!!!
        $s3Client = new S3MultiRegionClient([
            'region' => env('MIX_AWS_REGION'),
            'version' => env('MIX_AWS_APIVERSION'),
            'credentials' => [
                'key' => env('MIX_AWS_KEY'),
                'secret' => env('MIX_AWS_SECRET')
            ],
        ]);

        try {
            $items = [];
            $objects = $s3->getPaginator('ListObjects', [
                'Bucket' => $bucket,
                'Delimiter' => '/',
                'Prefix' => $prefix
            ]);

            return response()->json(['success' => true, 'data' => $items], $this->successStatus);
        } catch(S3Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al mostrar los elementos', 'stack' => $e]);
        }
    }
}