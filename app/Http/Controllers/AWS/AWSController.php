<?php
namespace App\Http\Controllers\AWS;

use Aws\S3\S3MultiRegionClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    public function getPrefixContent($bucket, Request $request) {
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
            $objects = $s3Client->getPaginator('ListObjects', [
                'Bucket' => $bucket,
                'Delimiter' => '/',
                'Prefix' => $request->post('prefix')
            ]);

            foreach($objects as $object) {
                foreach($object['Contents'] as $content) {
                    $val = str_replace($request->post('prefix'), "", $content['Key']);

                    if($val !== "") {
                        $items[] = $val;
                    }
                }
            }

            return response()->json(['success' => true, 'data' => $items], $this->successStatus);
        } catch(S3Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al mostrar los elementos', 'stack' => $e]);
        }
    }

    public function getContentUri(Request $request) {
        $responseArray = [];

        $s3Client = new S3MultiRegionClient([
            'region' => env('MIX_AWS_REGION'),
            'version' => env('MIX_AWS_APIVERSION'),
            'credentials' => [
                'key' => env('MIX_AWS_KEY'),
                'secret' => env('MIX_AWS_SECRET')
            ],
        ]);

        $cmd = $s3Client->getCommand('GetObject', [
            'Bucket' => $request->post('bucket'),
            'Key' => $request->post('uri')
        ]);

        $request = $s3Client->createPresignedRequest($cmd, '+1 hours');
        $mainUri = $request->getUri();

        $responseArray['success'] = true;
        $responseArray["path"] = $mainUri->getScheme() . "://" . $mainUri->getHost() . $mainUri->getPath() . "?" . $mainUri->getQuery();

        return response()->json($responseArray, $this->successStatus);
    }
}