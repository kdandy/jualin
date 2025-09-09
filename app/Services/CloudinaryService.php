<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Resize;
use Cloudinary\Transformation\Quality;
use Cloudinary\Transformation\Format;
use Illuminate\Http\UploadedFile;
use Exception;

class CloudinaryService
{
    protected $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key' => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
                'secure' => config('cloudinary.secure', true)
            ]
        ]);
    }

    /**
     * Upload file to Cloudinary
     *
     * @param UploadedFile $file
     * @param string|null $folder
     * @param array $options
     * @return array
     * @throws Exception
     */
    public function upload(UploadedFile $file, ?string $folder = null, array $options = []): array
    {
        try {
            $uploadOptions = array_merge([
                'folder' => $folder ?? config('cloudinary.folder'),
                'resource_type' => 'auto',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ], $options);

            $result = $this->cloudinary->uploadApi()->upload(
                $file->getPathname(),
                $uploadOptions
            );

            return [
                'success' => true,
                'public_id' => $result['public_id'],
                'url' => $result['secure_url'],
                'original_filename' => $file->getClientOriginalName(),
                'size' => $result['bytes'],
                'format' => $result['format'],
                'width' => $result['width'] ?? null,
                'height' => $result['height'] ?? null,
            ];
        } catch (Exception $e) {
            throw new Exception('Failed to upload file to Cloudinary: ' . $e->getMessage());
        }
    }

    /**
     * Upload multiple files to Cloudinary
     *
     * @param array $files
     * @param string|null $folder
     * @param array $options
     * @return array
     */
    public function uploadMultiple(array $files, ?string $folder = null, array $options = []): array
    {
        $results = [];
        $errors = [];

        foreach ($files as $file) {
            try {
                $results[] = $this->upload($file, $folder, $options);
            } catch (Exception $e) {
                $errors[] = [
                    'file' => $file->getClientOriginalName(),
                    'error' => $e->getMessage()
                ];
            }
        }

        return [
            'success' => empty($errors),
            'results' => $results,
            'errors' => $errors
        ];
    }

    /**
     * Delete file from Cloudinary
     *
     * @param string $publicId
     * @return array
     * @throws Exception
     */
    public function delete(string $publicId): array
    {
        try {
            $result = $this->cloudinary->uploadApi()->destroy($publicId);
            
            return [
                'success' => $result['result'] === 'ok',
                'result' => $result['result']
            ];
        } catch (Exception $e) {
            throw new Exception('Failed to delete file from Cloudinary: ' . $e->getMessage());
        }
    }

    /**
     * Get optimized URL for an image
     *
     * @param string $publicId
     * @param array $transformations
     * @return string
     */
    public function getOptimizedUrl(string $publicId, array $transformations = []): string
    {
        $defaultTransformations = [
            'quality' => 'auto',
            'fetch_format' => 'auto'
        ];

        $transformations = array_merge($defaultTransformations, $transformations);

        return $this->cloudinary->image($publicId)
            ->addTransformation($transformations)
            ->toUrl();
    }

    /**
     * Get resized image URL
     *
     * @param string $publicId
     * @param int $width
     * @param int|null $height
     * @param string $crop
     * @return string
     */
    public function getResizedUrl(string $publicId, int $width, ?int $height = null, string $crop = 'fill'): string
    {
        $transformations = [
            'width' => $width,
            'crop' => $crop,
            'quality' => 'auto',
            'fetch_format' => 'auto'
        ];

        if ($height) {
            $transformations['height'] = $height;
        }

        return $this->getOptimizedUrl($publicId, $transformations);
    }

    /**
     * Get thumbnail URL
     *
     * @param string $publicId
     * @param int $size
     * @return string
     */
    public function getThumbnailUrl(string $publicId, int $size = 150): string
    {
        return $this->getResizedUrl($publicId, $size, $size, 'thumb');
    }
}