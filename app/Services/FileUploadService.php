<?php

namespace App\Services;

/**
 * FileUploadService - Wrapper around existing FileUpload class
 * Provides legacy URL fallback and folder-based upload management
 */
class FileUploadService
{
    private $config;
    private $publicPath;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../../config/app.php';
        $this->publicPath = __DIR__ . '/../../public';
    }

    /**
     * Upload a file to the specified folder using existing FileUpload class
     * 
     * @param array $file The $_FILES array element
     * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
     * @param string|null $customFilename Optional custom filename (without extension)
     * @return array ['success' => bool, 'filename' => string, 'path' => string, 'message' => string]
     */
    public function upload($file, $folderType, $customFilename = null)
    {
        // Validate folder type
        if (!isset($this->config['uploads']['folders'][$folderType])) {
            return [
                'success' => false,
                'message' => "Invalid folder type: {$folderType}. Valid types: " . implode(', ', array_keys($this->config['uploads']['folders']))
            ];
        }

        // Get folder path
        $folder = $this->config['uploads']['folders'][$folderType];
        
        // Get allowed extensions with dots (for FileUpload::uploadDoc compatibility)
        $allowedTypes = $this->config['uploads']['allowed_types'][$folderType] ?? [];
        $allowedExtensions = array_map(function($ext) {
            return '.' . $ext;
        }, $allowedTypes);
        
        // Get max size
        $maxSize = $this->config['uploads']['max_sizes'][$folderType] ?? 10485760;
        
        // Use FileUpload::uploadDoc for legacy compatibility
        $result = \FileUpload::uploadDoc(
            null, // We'll pass file directly
            $customFilename,
            $folder . '/',
            true,  // chain
            false, // overwrite
            0,     // minSize
            $maxSize,
            $allowedExtensions
        );
        
        // Since uploadDoc expects form name, we need to temporarily set it in $_FILES
        // Store original $_FILES
        $originalFiles = $_FILES;
        
        // Set our file
        $tempName = 'temp_upload_' . uniqid();
        $_FILES[$tempName] = $file;
        
        // Upload
        $result = \FileUpload::uploadDoc(
            $tempName,
            $customFilename,
            $folder . '/',
            true,  // chain
            false, // overwrite
            0,     // minSize
            $maxSize,
            $allowedExtensions
        );
        
        // Restore original $_FILES
        $_FILES = $originalFiles;
        
        // Handle result
        if (is_string($result)) {
            // Success - result is path like "images/filename.jpg"
            $filename = basename($result);
            return [
                'success' => true,
                'filename' => $filename,
                'path' => $result,
                'url' => $this->getFileUrl($filename, $folderType),
                'message' => 'File uploaded successfully'
            ];
        }
        
        // Error - result is error code
        $errorMessages = [
            -1 => 'Invalid file extension',
            -2 => 'File size out of range',
            -3 => 'File with same name already exists',
            -9 => 'Upload process failed',
            -10 => 'No file provided',
        ];
        
        return [
            'success' => false,
            'message' => $errorMessages[$result] ?? 'Upload failed with error code: ' . $result
        ];
    }

    /**
     * Get the full URL for a file with legacy fallback
     * Checks if file exists locally, if not, returns legacy URL
     * 
     * @param string $filename The filename or path (can be "images/file.jpg" or just "file.jpg")
     * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
     * @return string The full URL to the file
     */
    public function getFileUrl($filename, $folderType)
    {
        if (!$filename) {
            return $this->getDefaultImage($folderType);
        }

        // If filename already contains folder path (like "images/file.jpg"), extract just the filename
        if (strpos($filename, '/') !== false) {
            $filename = basename($filename);
        }

        $folder = $this->config['uploads']['folders'][$folderType] ?? $folderType;
        $localPath = $this->publicPath . '/' . $folder . '/' . $filename;

        // Check if file exists locally (in devadmin.lbrix.com)
        if (file_exists($localPath)) {
            return rtrim($this->config['uploads']['base_url'], '/') . '/' . $folder . '/' . $filename;
        }

        // Fallback to legacy URL (app.lbrix.com)
        return rtrim($this->config['uploads']['legacy_url'], '/') . '/' . $folder . '/' . $filename;
    }

    /**
     * Check if a file exists locally or on legacy server
     * 
     * @param string $filename The filename (can be "images/file.jpg" or just "file.jpg")
     * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
     * @return array ['exists_locally' => bool, 'exists_legacy' => bool, 'url' => string]
     */
    public function checkFileExists($filename, $folderType)
    {
        // If filename already contains folder path, extract just the filename
        if (strpos($filename, '/') !== false) {
            $filename = basename($filename);
        }
        
        $folder = $this->config['uploads']['folders'][$folderType] ?? $folderType;
        $localPath = $this->publicPath . '/' . $folder . '/' . $filename;
        $existsLocally = file_exists($localPath);

        $legacyUrl = rtrim($this->config['uploads']['legacy_url'], '/') . '/' . $folder . '/' . $filename;
        
        // Check if legacy file is accessible (optional, may slow down)
        // $existsLegacy = $this->checkRemoteFileExists($legacyUrl);
        
        return [
            'exists_locally' => $existsLocally,
            'exists_legacy' => !$existsLocally, // Assume legacy if not local
            'url' => $this->getFileUrl($filename, $folderType)
        ];
    }

    /**
     * Delete a file
     * 
     * @param string $filename The filename (can be "images/file.jpg" or just "file.jpg")
     * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
     * @return bool
     */
    public function delete($filename, $folderType)
    {
        // If filename already contains folder path, extract just the filename
        if (strpos($filename, '/') !== false) {
            $filename = basename($filename);
        }
        
        $folder = $this->config['uploads']['folders'][$folderType] ?? $folderType;
        $filePath = $this->publicPath . '/' . $folder . '/' . $filename;

        if (file_exists($filePath)) {
            return unlink($filePath);
        }

        return false;
    }

    /**
     * Get all files in a folder
     * 
     * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
     * @return array
     */
    public function getFiles($folderType)
    {
        $folder = $this->config['uploads']['folders'][$folderType] ?? $folderType;
        $folderPath = $this->publicPath . '/' . $folder;

        if (!is_dir($folderPath)) {
            return [];
        }

        $files = array_diff(scandir($folderPath), ['.', '..', '.gitignore', '.gitkeep']);
        return array_values($files);
    }

    /**
     * Generate a unique filename using timestamp and random number
     * Similar to legacy format: 0003380001595713397.png
     * 
     * @param string $extension File extension
     * @return string
     */
    private function generateUniqueFilename($extension)
    {
        $random = str_pad(mt_rand(0, 9999999), 7, '0', STR_PAD_LEFT);
        $timestamp = time();
        return $random . '00' . $timestamp . '.' . $extension;
    }

    /**
     * Get upload error message
     * 
     * @param int $errorCode
     * @return string
     */
    private function getUploadErrorMessage($errorCode)
    {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE directive in HTML form',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload',
        ];

        return $errors[$errorCode] ?? 'Unknown upload error';
    }

    /**
     * Format bytes to human readable format
     * 
     * @param int $bytes
     * @return string
     */
    private function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Check if a remote file exists
     * 
     * @param string $url
     * @return bool
     */
    private function checkRemoteFileExists($url)
    {
        $headers = @get_headers($url);
        return $headers && strpos($headers[0], '200') !== false;
    }

    /**
     * Get default image for a folder type
     * 
     * @param string $folderType
     * @return string
     */
    private function getDefaultImage($folderType)
    {
        $defaults = [
            'pictures' => '/img/default-profile.png',
            'images' => '/img/default-property.png',
            'documents' => '/img/default-document.png',
            'videos' => '/img/default-video.png',
        ];

        return $defaults[$folderType] ?? '/img/no-image.png';
    }

    /**
     * Get upload configuration
     * 
     * @return array
     */
    public function getConfig()
    {
        return $this->config['uploads'];
    }
}
