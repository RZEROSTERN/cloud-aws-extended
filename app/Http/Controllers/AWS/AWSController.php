<?php
namespace App\Http\Controllers\AWS;

use Aws\S3\S3Client;
use App\Http\Controllers\Controller;

class AWSController extends Controller
{
    public $successStatus = 200;

    public function getAllBuckets() {
        $s3Client = new S3Client([
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
        $s3Client = new S3Client([
            'region' => env('MIX_AWS_REGION'),
            'version' => env('MIX_AWS_APIVERSION'),
            'credentials' => [
                'key' => env('MIX_AWS_KEY'),
                'secret' => env('MIX_AWS_SECRET')
            ],
        ]);

        try {
            $results = $s3Client->getPaginator('ListObjects', [
                'Bucket' => $bucket,
                'Delimiter' => '/'
            ]);


            foreach ($results as $result) {
                /// AQUI ME QUEDE, FELIZ NAVIDAD :D
                var_dump($result['CommonPrefixes']);
                // foreach ($result['Contents'] as $object) {
                    //var_dump($object);
                // }
            }

            // return response()->json(['success' => true, 'data' => $results], $this->successStatus);
        } catch(S3Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al mostrar los elementos', 'stack' => $e]);
        }
    }
}