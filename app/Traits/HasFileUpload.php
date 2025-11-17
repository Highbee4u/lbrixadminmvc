<?php

namespace App\Traits;

use App\Services\FileUploadService;

/**
 * HasFileUpload Trait
 * 
 * Provides easy file upload functionality for controllers
 * by wrapping the FileUploadService in controller-friendly methods
 */
trait HasFileUpload
{
    /**
     * @var FileUploadService
     */
    protected $fileUploadService;

    /**
     * Get the FileUploadService instance
     * Creates it on first call, then reuses the same instance
     * 
     * @return FileUploadService
     */
    protected function fileUploadService()
    {
        if (!$this->fileUploadService) {
            $this->fileUploadService = new FileUploadService();
        }
        return $this->fileUploadService;
    }

    /**
     * Upload a file using the file upload service
     * 
     * @param array $file The $_FILES array element
     * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
     * @param string|null $customFilename Optional custom filename (without extension)
     * @return array ['success' => bool, 'filename' => string, 'path' => string, 'message' => string]
     */
    protected function uploadFile($file, $folderType, $customFilename = null)
    {
        return $this->fileUploadService()->upload($file, $folderType, $customFilename);
    }

    /**
     * Get file URL with legacy fallback support
     * 
     * @param string $filename The filename (can be "images/file.jpg" or just "file.jpg")
     * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
     * @return string The full URL to the file
     */
    protected function getFileUrl($filename, $folderType)
    {
        return $this->fileUploadService()->getFileUrl($filename, $folderType);
    }

    /**
     * Get profile picture URL (uses pictures/ folder)
     * 
     * @param string|null $filename
     * @return string
     */
    protected function getProfilePictureUrl($filename)
    {
        return $this->getFileUrl($filename, 'pictures');
    }

    /**
     * Get property image URL (uses images/ folder)
     * 
     * @param string|null $filename
     * @return string
     */
    protected function getPropertyImageUrl($filename)
    {
        return $this->getFileUrl($filename, 'images');
    }

    /**
     * Get document URL (uses documents/ folder)
     * 
     * @param string|null $filename
     * @return string
     */
    protected function getDocumentUrl($filename)
    {
        return $this->getFileUrl($filename, 'documents');
    }

    /**
     * Check if a file exists locally or on legacy server
     * 
     * @param string $filename The filename (can be "images/file.jpg" or just "file.jpg")
     * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
     * @return array ['exists_locally' => bool, 'exists_legacy' => bool, 'url' => string]
     */
    protected function checkFileExists($filename, $folderType)
    {
        return $this->fileUploadService()->checkFileExists($filename, $folderType);
    }

    /**
     * Delete a file
     * 
     * @param string $filename The filename (can be "images/file.jpg" or just "file.jpg")
     * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
     * @return bool
     */
    protected function deleteFile($filename, $folderType)
    {
        return $this->fileUploadService()->delete($filename, $folderType);
    }

    /**
     * Get all files in a folder
     * 
     * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
     * @return array
     */
    protected function getUploadedFiles($folderType)
    {
        return $this->fileUploadService()->getFiles($folderType);
    }

    /**
     * Get upload configuration
     * 
     * @return array
     */
    protected function getUploadConfig()
    {
        return $this->fileUploadService()->getConfig();
    }

    /**
     * Handle file upload from Request object
     * This method is specifically designed to work with the custom Request class
     * 
     * @param string $inputName The name of the file input field
     * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
     * @param string|null $customFilename Optional custom filename (without extension)
     * @return array ['success' => bool, 'filename' => string, 'path' => string, 'message' => string]
     */
    protected function handleFileUpload($inputName, $folderType, $customFilename = null)
    {
        $request = \Request::getInstance();
        
        if ($request->hasFile($inputName)) {
            return $this->uploadFile($request->file($inputName), $folderType, $customFilename);
        }
        
        return [
            'success' => false,
            'message' => 'No file was uploaded'
        ];
    }

    /**
     * Upload multiple files from Request object
     * 
     * @param string $inputName The name of the file input field (must support multiple files)
     * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
     * @param string|null $customPrefix Optional prefix for custom filenames
     * @return array ['success' => bool, 'files' => array, 'errors' => array]
     */
    protected function handleMultipleFileUpload($inputName, $folderType, $customPrefix = null)
    {
        $request = \Request::getInstance();
        
        if (!$request->hasFile($inputName)) {
            return [
                'success' => false,
                'files' => [],
                'errors' => ['No files were uploaded']
            ];
        }

        $files = $request->file($inputName);
        $uploadedFiles = [];
        $errors = [];

        // Handle single file (non-array) vs multiple files (array)
        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $index => $file) {
            $customFilename = $customPrefix ? $customPrefix . '_' . $index : null;
            $result = $this->uploadFile($file, $folderType, $customFilename);
            
            if ($result['success']) {
                $uploadedFiles[] = $result;
            } else {
                $errors[] = "File {$index}: {$result['message']}";
            }
        }

        return [
            'success' => count($uploadedFiles) > 0,
            'files' => $uploadedFiles,
            'errors' => $errors
        ];
    }
}
