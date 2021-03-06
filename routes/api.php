<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('s3/buckets/all', 'AWS\AWSController@getAllBuckets');
Route::get('s3/buckets/{bucket}', 'AWS\AWSController@getBucketItems');
Route::post('s3/buckets/{bucket}/prefix', 'AWS\AWSController@getPrefixContent');
Route::post('s3/item', 'AWS\AWSController@getContentUri');

