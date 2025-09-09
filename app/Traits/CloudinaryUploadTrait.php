<?php

namespace App\Traits;

use App\Services\CloudinaryService;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Exception;

trait CloudinaryUploadTrait
{
    /**
     * Upload single file to Cloudinary
     *
     * @param UploadedFile $file
     * @param string|null $folder
     * @param array $options
     * @return array
     * @throws Exception
     */
    protected function uploadToCloudinary(UploadedFile $file, ?string $folder = null, array $options = []): array
    {
        $cloudinaryService = app(CloudinaryService::class);
        return $cloudinaryService->upload($file, $folder, $options);
    }

    /**
     * Upload multiple files to Cloudinary
     *
     * @param array $files
     * @param string|null $folder
     * @param array $options
     * @return array
     */
    protected function uploadMultipleToCloudinary(array $files, ?string $folder = null, array $options = []): array
    {
        $cloudinaryService = app(CloudinaryService::class);
        return $cloudinaryService->uploadMultiple($files, $folder, $options);
    }

    /**
     * Delete file from Cloudinary
     *
     * @param string $publicId
     * @return array
     * @throws Exception
     */
    protected function deleteFromCloudinary(string $publicId): array
    {
        $cloudinaryService = app(CloudinaryService::class);
        return $cloudinaryService->delete($publicId);
    }

    /**
     * Handle file upload from request
     *
     * @param Request $request
     * @param string $fieldName
     * @param string|null $folder
     * @param array $options
     * @return array|null
     * @throws Exception
     */
    protected function handleFileUpload(Request $request, string $fieldName, ?string $folder = null, array $options = []): ?array
    {
        if (!$request->hasFile($fieldName)) {
            return null;
        }

        $file = $request->file($fieldName);
        
        if (!$file->isValid()) {
            throw new Exception('Invalid file uploaded.');
        }

        return $this->uploadToCloudinary($file, $folder, $options);
    }

    /**
     * Handle multiple file uploads from request
     *
     * @param Request $request
     * @param string $fieldName
     * @param string|null $folder
     * @param array $options
     * @return array|null
     */
    protected function handleMultipleFileUpload(Request $request, string $fieldName, ?string $folder = null, array $options = []): ?array
    {
        if (!$request->hasFile($fieldName)) {
            return null;
        }

        $files = $request->file($fieldName);
        
        if (!is_array($files)) {
            $files = [$files];
        }

        // Validate all files
        foreach ($files as $file) {
            if (!$file->isValid()) {
                throw new Exception('One or more uploaded files are invalid.');
            }
        }

        return $this->uploadMultipleToCloudinary($files, $folder, $options);
    }

    /**
     * Get optimized image URL
     *
     * @param string $publicId
     * @param array $transformations
     * @return string
     */
    protected function getOptimizedImageUrl(string $publicId, array $transformations = []): string
    {
        $cloudinaryService = app(CloudinaryService::class);
        return $cloudinaryService->getOptimizedUrl($publicId, $transformations);
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
    protected function getResizedImageUrl(string $publicId, int $width, ?int $height = null, string $crop = 'fill'): string
    {
        $cloudinaryService = app(CloudinaryService::class);
        return $cloudinaryService->getResizedUrl($publicId, $width, $height, $crop);
    }

    /**
     * Get thumbnail URL
     *
     * @param string $publicId
     * @param int $size
     * @return string
     */
    protected function getThumbnailUrl(string $publicId, int $size = 150): string
    {
        $cloudinaryService = app(CloudinaryService::class);
        return $cloudinaryService->getThumbnailUrl($publicId, $size);
    }

    /**
     * Extract public ID from Cloudinary URL
     *
     * @param string $url
     * @return string|null
     */
    protected function extractPublicIdFromUrl(string $url): ?string
    {
        // Extract public ID from Cloudinary URL
        // Example: https://res.cloudinary.com/demo/image/upload/v1234567890/sample.jpg
        // Returns: sample
        
        $pattern = '/\/v\d+\/(.+?)\.[a-zA-Z]+$/';
        preg_match($pattern, $url, $matches);
        
        return $matches[1] ?? null;
    }
}