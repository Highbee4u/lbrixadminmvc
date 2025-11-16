<?php

/**
 * File Upload Helper Functions
 * 
 * These functions provide easy access to the FileUploadService
 * for handling file uploads with legacy URL fallback support.
 */

use App\Services\FileUploadService;

/**
 * Get the FileUploadService instance
 * 
 * @return FileUploadService
 */
function fileUploadService()
{
    static $instance = null;
    if ($instance === null) {
        $instance = new FileUploadService();
    }
    return $instance;
}

/**
 * Get the full URL for a file with automatic fallback to legacy URL
 * 
 * Usage:
 *   fileUrl('0003380001595713397.png', 'images')
 *   fileUrl($user->profile_picture, 'pictures')
 *   fileUrl($property->document, 'documents')
 * 
 * @param string|null $filename The filename (can be "images/file.jpg" or just "file.jpg")
 * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
 * @return string The full URL to the file
 */
function fileUrl($filename, $folderType)
{
    return fileUploadService()->getFileUrl($filename, $folderType);
}

/**
 * Get the URL for a profile picture
 * Uses pictures/ folder (itempics.picurl, iteminsppics.picurl)
 * 
 * @param string|null $filename
 * @return string
 */
function profilePictureUrl($filename)
{
    return fileUrl($filename, 'pictures');
}

/**
 * Get the URL for a property image  
 * Uses images/ folder (itemdocs.docurl for images, iteminspdocs.docurl)
 * 
 * @param string|null $filename
 * @return string
 */
function propertyImageUrl($filename)
{
    return fileUrl($filename, 'images');
}

/**
 * Get the URL for a document
 * Uses documents/ folder (inspectiontask.docurl, itemdocs.docurl, iteminspdocs.docurl)
 * 
 * @param string|null $filename
 * @return string
 */
function documentUrl($filename)
{
    return fileUrl($filename, 'documents');
}

/**
 * Get the URL for a video
 * Uses images/ folder but can handle video types (iteminspdocs.itemdocurl)
 * 
 * @param string|null $filename
 * @return string
 */
function videoUrl($filename)
{
    return fileUrl($filename, 'images'); // Videos stored in images folder
}

/**
 * Upload a file
 * 
 * Usage:
 *   $result = uploadFile($_FILES['profile_picture'], 'pictures');
 *   $result = uploadFile($_FILES['property_image'], 'images', 'custom-name');
 *   $result = uploadFile($_FILES['document'], 'documents');
 * 
 * @param array $file The $_FILES array element
 * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
 * @param string|null $customFilename Optional custom filename (without extension)
 * @return array ['success' => bool, 'filename' => string, 'path' => string, 'message' => string]
 */
function uploadFile($file, $folderType, $customFilename = null)
{
    return fileUploadService()->upload($file, $folderType, $customFilename);
}

/**
 * Delete a file
 * 
 * @param string $filename The filename
 * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
 * @return bool
 */
function deleteFile($filename, $folderType)
{
    return fileUploadService()->delete($filename, $folderType);
}

/**
 * Check if a file exists locally or on legacy server
 * 
 * @param string $filename The filename
 * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
 * @return array ['exists_locally' => bool, 'exists_legacy' => bool, 'url' => string]
 */
function checkFileExists($filename, $folderType)
{
    return fileUploadService()->checkFileExists($filename, $folderType);
}

/**
 * Get all files in a folder
 * 
 * @param string $folderType One of: 'pictures', 'images', 'documents', 'videos'
 * @return array
 */
function getUploadedFiles($folderType)
{
    return fileUploadService()->getFiles($folderType);
}

/**
 * Get upload configuration
 * 
 * @return array
 */
function uploadConfig()
{
    return fileUploadService()->getConfig();
}
