<?php
namespace CarApi;

class Cache {

    protected $cacheTime = 1200;
    protected $cacheDir = __DIR__ . '/../../cache/';

    public function __construct() {}

    protected function generateFilename ($requestName, $query) {
        return sha1($requestName . json_encode($query));
    }


    public function set ($requestName, $query, $content) {
        if (!$requestName) throw new \Exception('no requestName given');
        if (!$query) throw new \Exception('no query given');
        if (!$content) throw new \Exception('no content given');

        file_put_contents(
            $this->cacheDir . $this->generateFilename($requestName, $query),
            json_encode($content)
        );
    }

    public function get ($requestName, $query) {
        if (!$requestName) throw new \Exception('no requestName given');
        if (!$query) throw new \Exception('no query given');

        $fullCacheFilePath = $this->cacheDir . $this->generateFilename($requestName, $query);

        // no file found
        if (!file_exists($fullCacheFilePath)) {
            return false;
        }

        // if cache time is exceeded then remove cache file
        if (filemtime($fullCacheFilePath) + $this->cacheTime < time()) {
            unlink($fullCacheFilePath);
            return false;
        }

        // file available, get the content
        $jsonData = file_get_contents($fullCacheFilePath);

        // decode and check if everything is ok
        $data = json_decode($jsonData);
        $jsonError = json_last_error();
        if ($jsonError !== \JSON_ERROR_NONE) {
            throw new \Exception('fail to decode json data from cache: ' . $jsonError);
        }

        return $data;
    }
}