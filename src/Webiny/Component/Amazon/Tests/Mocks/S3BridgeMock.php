<?php
/**
 * Webiny Framework (http://www.webiny.com/framework)
 *
 * @copyright Copyright Webiny LTD
 */

namespace Webiny\Component\Amazon\Tests\Mocks;

use Webiny\Component\Amazon\S3\RuntimeException;
use Webiny\Component\Amazon\S3\S3ClientInterface;

/**
 * Amazon S3 Client Bridge
 *
 * @package Webiny\Component\Amazon\Tests\Mocks
 */
class S3BridgeMock extends \PHPUnit_Framework_TestCase implements S3ClientInterface
{
    private $instance;

    public function __construct($accessKeyId, $secretAccessKey)
    {
        $this->instance = $this->getMockBuilder('\Aws\S3\S3Client')
                     ->disableOriginalConstructor()
                     ->getMock();
        $this->instance->expects($this->any())->method('doesObjectExist')->will($this->onConsecutiveCalls(true, false));
        $this->instance->expects($this->any())->method('doesBucketExist')->will($this->onConsecutiveCalls(true, false));
    }


    /**
     * Get object identified by bucket and key
     *
     * @param string $bucket
     * @param string $key
     * @param array  $params
     *
     * @return mixed
     */
    public function getObject($bucket, $key, array $params = [])
    {
        return ['Body' => 'Component test'];
    }

    /**
     * Deletes the bucket.
     * All objects (including all object versions and Delete Markers) in the bucket must be deleted before the bucket itself can be deleted.
     *
     * @param $bucket
     *
     * @return mixed
     */
    public function deleteBucket($bucket)
    {
        return;
    }

    /**
     * Determines whether or not a bucket exists by name
     *
     * @param string $bucket    The name of the bucket
     * @param bool   $accept403 Set to true if 403s are acceptable
     * @param array  $params    Additional options to add to the executed command
     *
     * @return bool
     */
    public function doesBucketExist($bucket, $accept403 = true, array $params = [])
    {
        return $this->instance->doesBucketExist($bucket);
    }

    /**
     * Removes the null version (if there is one) of an object and inserts a delete marker, which becomes the latest version of the object.
     * If there isn't a null version, Amazon S3 does not remove any objects.
     *
     * @param string $bucket
     * @param string $key
     * @param array  $params
     *
     * @return mixed
     */
    public function deleteObject($bucket, $key, array $params = [])
    {
        return;
    }

    /**
     * Adds an object to a bucket.
     *
     * @param string $bucket
     * @param string $key
     * @param string $content
     * @param array  $params
     *
     * @return mixed
     */
    public function putObject($bucket, $key, $content, array $params = [])
    {
        return;
    }

    /**
     * Creates a new bucket.
     *
     * @param string $bucket
     * @param array  $params
     *
     * @return mixed
     */
    public function createBucket($bucket, array $params = [])
    {
        return;
    }

    /**
     * Determines whether or not an object exists by name
     *
     * @param string $bucket The name of the bucket
     * @param string $key    The key of the object
     * @param array  $params Additional options to add to the executed command
     *
     * @return bool
     */
    public function doesObjectExist($bucket, $key, array $params = [])
    {
        return $this->instance->doesObjectExist($bucket, $key);
    }

    /**
     * Get access control policy for the bucket
     *
     * @param string $bucket
     *
     * @return mixed
     */
    public function getBucketAcl($bucket)
    {
        // TODO: Implement getBucketAcl() method.
    }

    /**
     * Sets the permissions on a bucket using access control lists (ACL).
     *
     * @param string $bucket
     * @param string $acl private | public-read | public-read-write | authenticated-read
     *
     * @return mixed
     */
    public function putBucketAcl($bucket, $acl)
    {
        // TODO: Implement putBucketAcl() method.
    }

    /**
     * Get array of buckets
     * Available keys: Name, CreationDate
     *
     * @return mixed
     */
    public function getListBucketsIterator()
    {
        // TODO: Implement getListBucketsIterator() method.
    }

    /**
     * Set the access control list (ACL) permissions for an object that already exists in a bucket
     *
     * @param string $bucket
     * @param string $key
     * @param string $acl private | public-read | public-read-write | authenticated-read | bucket-owner-read | bucket-owner-full-control
     *
     * @return mixed
     */
    public function putObjectAcl($bucket, $key, $acl)
    {
        // TODO: Implement putObjectAcl() method.
    }

    /**
     * Deletes objects from Amazon S3 that match the result of a ListObjects operation. For example, this allows you
     * to do things like delete all objects that match a specific key prefix.
     *
     * @param string $bucket  Bucket that contains the object keys
     * @param string $prefix  Optionally delete only objects under this key prefix
     * @param string $regex   Delete only objects that match this regex
     * @param array  $options Options used when deleting the object:
     *                        - before_delete: Callback to invoke before each delete. The callback will receive a
     *                        Guzzle\Common\Event object with context.
     *
     * @see Aws\S3\S3Client::listObjects
     * @see Aws\S3\Model\ClearBucket For more options or customization
     * @return int Returns the number of deleted keys
     * @throws RuntimeException if no prefix and no regex is given
     */
    public function deleteMatchingObjects($bucket, $prefix = '', $regex = '', array $options = [])
    {
        // TODO: Implement deleteMatchingObjects() method.
    }

    /**
     * Returns the region the bucket resides in.
     *
     * @param string $bucket
     *
     * @return mixed
     */
    public function getBucketLocation($bucket)
    {
        // TODO: Implement getBucketLocation() method.
    }

    /**
     * Restores an archived copy of an object back into Amazon S3
     *
     * @param string $bucket
     * @param string $key
     * @param int    $days
     *
     * @internal param array $args
     *
     * @return mixed
     */
    public function restoreObject($bucket, $key, $days)
    {
        // TODO: Implement restoreObject() method.
    }

    /**
     * Get objects iterator
     *
     * @param string $bucket
     *
     * @param array  $params
     *
     * @return mixed
     */
    public function getListObjectsIterator($bucket, array $params = [])
    {
        // TODO: Implement getListObjectsIterator() method.
    }

    /**
     * Returns some or all (up to 1000) of the objects in a bucket.
     * You can use the request parameters as selection criteria to return a subset of the objects in a bucket.
     *
     * @param string $bucket
     *
     * @param array  $params
     *
     * @return mixed
     */
    public function listObjects($bucket, array $params = [])
    {
        // TODO: Implement listObjects() method.
    }

    /**
     * Helper used to clear the contents of a bucket. Use the {@see ClearBucket} object directly
     * for more advanced options and control.
     *
     * @param string $bucket Name of the bucket to clear.
     *
     * @return int Returns the number of deleted keys
     */
    public function clearBucket($bucket)
    {
        // TODO: Implement clearBucket() method.
    }

    /**
     * Recursively uploads all files in a given directory to a given bucket.
     *
     * @param string $directory Full path to a directory to upload
     * @param string $bucket    Name of the bucket
     * @param string $keyPrefix Virtual directory key prefix to add to each upload
     * @param array  $options   Associative array of upload options
     *                          - params: Array of parameters to use with each PutObject operation performed during the transfer
     *                          - base_dir: Base directory to remove from each object key
     *                          - force: Set to true to upload every file, even if the file is already in Amazon S3 and has not changed
     *                          - concurrency: Maximum number of parallel uploads (defaults to 10)
     *                          - debug: Set to true or an fopen resource to enable debug mode to print information about each upload
     *                          - multipart_upload_size: When the size of a file exceeds this value, the file will be uploaded using a
     *                          multipart upload.
     *
     * @see Aws\S3\S3Sync\S3Sync for more options and customization
     */
    public function uploadDirectory($directory, $bucket, $keyPrefix = null, array $options = [])
    {
        // TODO: Implement uploadDirectory() method.
    }

    /**
     * Creates a copy of an object that is already stored in Amazon S3.
     *
     * @param string $sourceBucket
     * @param string $sourceKey
     * @param string $targetBucket
     * @param string $targetKey
     * @param array  $params
     *
     * @return mixed
     */
    public function copyObject($sourceBucket, $sourceKey, $targetBucket, $targetKey, array $params = [])
    {
        // TODO: Implement copyObject() method.
    }

    /**
     * Returns the policy of a specified bucket.
     *
     * @param string $bucket
     *
     * @return mixed
     */
    public function getBucketPolicy($bucket)
    {
        // TODO: Implement getBucketPolicy() method.
    }

    /**
     * Returns the access control list (ACL) of an object.
     *
     * @param $bucket
     * @param $key
     *
     * @return mixed
     */
    public function getObjectAcl($bucket, $key)
    {
        // TODO: Implement getObjectAcl() method.
    }

    /**
     * This operation enables you to delete multiple objects from a bucket using a single HTTP request.
     * You may specify up to 1000 keys.
     *
     * @param string $bucket
     * @param array  $objects
     *
     * @return mixed
     */
    public function deleteObjects($bucket, array $objects)
    {
        // TODO: Implement deleteObjects() method.
    }

    /**
     * Returns a list of all buckets owned by the authenticated sender of the request.
     * Available keys: Name, CreationDate
     * @return mixed
     */
    public function listBuckets()
    {
        // TODO: Implement listBuckets() method.
    }

    /**
     * Returns the URL to an object identified by its bucket and key. If an expiration time is provided, the URL will
     * be signed and set to expire at the provided time.
     *
     * @param string $bucket  The name of the bucket where the object is located
     * @param string $key     The key of the object
     * @param mixed  $expires The time at which the URL should expire
     * @param array  $args    Arguments to the GetObject command. Additionally you can specify a "Scheme" if you would
     *                        like the URL to use a different scheme than what the client is configured to use
     *
     * @return string The URL to the object
     */
    public function getObjectUrl($bucket, $key, $expires = null, array $args = [])
    {
        // TODO: Implement getObjectUrl() method.
    }

    /**
     * Downloads a bucket to the local filesystem
     *
     * @param string $directory Directory to download to
     * @param string $bucket    Bucket to download from
     * @param string $keyPrefix Only download objects that use this key prefix
     * @param array  $options   Associative array of download options
     *                          - params: Array of parameters to use with each GetObject operation performed during the transfer
     *                          - base_dir: Base directory to remove from each object key when storing in the local filesystem
     *                          - force: Set to true to download every file, even if the file is already on the local filesystem and has not
     *                          changed
     *                          - concurrency: Maximum number of parallel downloads (defaults to 10)
     *                          - debug: Set to true or a fopen resource to enable debug mode to print information about each download
     *                          - allow_resumable: Set to true to allow previously interrupted downloads to be resumed using a Range GET
     */
    public function downloadBucket($directory, $bucket, $keyPrefix = '', array $options = [])
    {
        // TODO: Implement downloadBucket() method.
    }
}