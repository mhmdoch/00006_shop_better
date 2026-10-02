<?php

    use App\Objects\S3Presign;
    use AsyncAws\S3\S3Client;
    use AsyncAws\S3\Enum\ObjectCannedACL;
    use AsyncAws\S3\Input\GetObjectRequest;
    use AsyncAws\S3\Input\PutObjectRequest;

    class S3Model extends z_model {

        private string $accessKey;
        private string $secretKey;
        private string $region;
        private string $endpoint;
        private string $bucket;
        private string $baseUrl;
        private string $schema;

        private S3Client $client;

        public function __construct(z_db $z_db, z_framework $booter) {
            parent::__construct($z_db, $booter);

            $this->accessKey = (string) $booter->req->getBooterSettings("s3_access_key");
            $this->secretKey = (string) $booter->req->getBooterSettings("s3_secret_key");
            $this->schema = (string) $booter->req->getBooterSettings("s3_schema");
            $this->endpoint = (string) $booter->req->getBooterSettings("s3_endpoint");
            $this->bucket = (string) $booter->req->getBooterSettings("s3_bucket");
            $this->region = (string) $booter->req->getBooterSettings("s3_region");

            $this->baseUrl = (string) $booter->req->getBooterSettings("s3_base_url");
            $this->baseUrl = rtrim($this->baseUrl, '\/') . "/";

            $this->client = new S3Client([
                'accessKeyId' => $this->accessKey,
                'accessKeySecret' => $this->secretKey,
                'region' => $this->region,
                'endpoint' => "{$this->schema}://{$this->endpoint}",
                'pathStyleEndpoint' => true,
            ]);
        }

        public function getFullUrl(string $path = "") {
            return $this->baseUrl . $path;
        }

        public function uploadObjectToPath($data, $path, $acl = "private", $mime = "image/jpeg", $name = null) {
            $putRequest = [
                'Bucket' => $this->bucket,
                'Key' => $path,
                'ACL' => $acl,
                'ContentType' => $mime,
                'Body' => $data,
            ];

            if(!is_null($name)) {
                $putRequest['ContentDisposition'] = 'inline; filename="'.rawurlencode($name).'"';
            }

            $this->client->putObject($putRequest);
            return $this->getFullUrl($path);
        }

        public function signUpload($path, $name, $sizeBytes, $mime = "image/jpeg", $acl = "private", $expires = 60) {
            $upload = new PutObjectRequest([
                'Bucket' => $this->bucket,
                'ContentType' => $mime,
                'ContentLength' => $sizeBytes,
                'Key' => $path,
                'ACL' => $acl,
                'ContentDisposition' => 'attachment; filename="'.rawurlencode($name).'"',
            ]);

            return $this->client->presign(
                $upload,
                new \DateTimeImmutable("+$expires min"),
            );
        }

        public function signGetRequest($path, $download = false, ?string $filename = null, $expires = 60) {
            $getRequest = [
                'Bucket' => $this->bucket,
                'Key' => $path,
            ];

            // Add a custom filename
            if(!empty($filename)) {
                $getRequest['ResponseContentDisposition'] = $this->contentDisposition(
                    $download ? 'attachment' : 'inline',
                    $filename,
                );
            }

            // Presign against the public base URL rather than the path-style
            // endpoint: a signature is only valid for the host it was signed for.
            $presign = new S3Presign($this->region, $this->accessKey, $this->secretKey, $this->baseUrl, $this->bucket);

            return $presign->presign(new GetObjectRequest($getRequest), $expires);
        }

        public function signGet($path, $filename = null, $expires = 60) {
            return $this->signGetRequest($path, false, $filename, $expires);
        }

        public function signDownload($path, $filename = null, $expires = 60) {
            return $this->signGetRequest($path, true, $filename, $expires);
        }

        // The quoted filename has to stay ASCII, so non-ASCII names travel in the
        // RFC 5987 filename* parameter. Percent-encoding the quoted form instead
        // makes clients save the file as "Some%20name.pdf".
        private function contentDisposition(string $disposition, string $filename): string {
            $ascii = preg_replace('/[^\x20-\x7E]/', '_', $filename);
            $ascii = str_replace(['\\', '"'], ['\\\\', '\\"'], $ascii);

            $header = "$disposition; filename=\"$ascii\"";
            if($ascii !== $filename) {
                $header .= "; filename*=UTF-8''" . rawurlencode($filename);
            }

            return $header;
        }

        public function deleteObject($path) {
            $this->client->deleteObject([
                'Bucket' => $this->bucket,
                'Key' => $path,
            ]);
        }

    }

?>