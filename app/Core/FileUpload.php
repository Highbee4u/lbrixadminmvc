<?php
class FileUpload {
    private $file;
    private $uploadPath;
    private $allowedExtensions = [];
    private $maxSize = 10485760; // 10MB default
    private $minSize = 0; // 0 bytes default (no minimum)
    private $newFileName = null;
    private $errors = [];
    private $overwrite = false;
    private $chain = true; // Chain naming if file exists

    public function __construct($file, $uploadPath = 'images/') {
        $this->file = $file;
        // Always use public directory as base
        $publicPath = __DIR__ . '/../../public/';
        $this->uploadPath = $publicPath . rtrim($uploadPath, '/') . '/';
    }

    public function setAllowedExtensions($extensions) {
        $this->allowedExtensions = is_array($extensions) ? $extensions : [$extensions];
        return $this;
    }

    public function setMaxSize($size) {
        $this->maxSize = $size;
        return $this;
    }
    
    public function setMinSize($size) {
        $this->minSize = $size;
        return $this;
    }

    public function setFileName($name) {
        $this->newFileName = $name;
        return $this;
    }
    
    public function setOverwrite($overwrite) {
        $this->overwrite = $overwrite;
        return $this;
    }
    
    public function setChain($chain) {
        $this->chain = $chain;
        return $this;
    }
    
    /**
     * Legacy upload method compatible with old lbrix_admin uploadDoc
     * Simplified - just uses images/ folder directly
     * @param string $formName - The name attribute of file input
     * @param string $fileName - Base filename without extension (null = auto-generate)
     * @param string $targetDir - Target directory (null = default: public/images/)
     * @param bool $chain - Whether to chain filenames if exists
     * @param bool $overwrite - Whether to overwrite existing files
     * @param int $minSize - Minimum file size in bytes
     * @param int $maxSize - Maximum file size in bytes
     * @param array $allowedExtension - Array of allowed extensions (with dots)
     * @return string|int - Returns "images/filename.jpg" on success, error code on failure
     */
    public static function uploadDoc($formName, $fileName = null, $targetDir = null, $chain = true, $overwrite = false, $minSize = 0, $maxSize = 10485760, $allowedExtension = ['.jpg']) {
        // Handle null form name (PHP 8.1+ deprecation fix)
        if ($formName === null || !isset($_FILES[$formName]) || empty($_FILES[$formName]['name'])) {
            return -10; // No file provided
        }
        
        $file = $_FILES[$formName];
        $fileError = 0; // No error
        
        // Get file extension
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $extensionWithDot = '.' . $extension;
        
        // Check extension
        if (!in_array($extensionWithDot, $allowedExtension)) {
            return -1; // Invalid extension
        }
        
        // Check file size
        if ($file['size'] > $maxSize || $file['size'] < $minSize) {
            return -2; // Out of range file size
        }
        
        // Use default images/ directory if not specified
        if ($targetDir === null) {
            $targetDir = __DIR__ . '/../../public/images/';
        } else {
            // Add public path if relative
            if (strpos($targetDir, '/') !== 0) {
                $targetDir = __DIR__ . '/../../public/' . $targetDir;
            }
        }
        
        // Add forward slash at the end of target directory if not added
        if (substr($targetDir, strlen($targetDir) - 1, 1) != "/") {
            $targetDir .= "/";
        }
        
        // Create directory if it doesn't exist
        if (!is_dir($targetDir)) {
            $make = mkdir($targetDir, 0755, true);
            if (!$make) {
                return -9; // Upload process failed due to wrong directory
            }
        }
        
        // Generate filename like old system: random(10) + timestamp
        if ($fileName === null) {
            $fileName = str_pad(rand(0, 9999999), 10, '0', STR_PAD_LEFT) . time();
        }
        
        // Assign target filename
        $newFileName = $targetDir . $fileName . $extensionWithDot;
        
        // Handle existing file
        if (is_file($newFileName)) {
            if ($chain) {
                // Generate a new file name by appending an increment
                $i = 1;
                while (is_file($newFileName)) {
                    $newFileName = $targetDir . $fileName . $i . $extensionWithDot;
                    $i++;
                }
            } else if (!$overwrite) {
                return -3; // File with same name already exists
            }
        }
        
        // Process upload
        $upload = move_uploaded_file($file['tmp_name'], $newFileName);
        if ($upload) {
            // Return relative path like database expects: "images/filename.jpg"
            return 'images/' . basename($newFileName);
        } else {
            return -9; // Upload process failed
        }
    }

    public function upload() {
        if (!$this->validate()) {
            return false;
        }

        // Create upload directory if it doesn't exist
        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }

        // Generate filename
        $extension = $this->getExtension();
        
        // Use legacy naming format: random(10) + timestamp
        if (!$this->newFileName) {
            $this->newFileName = str_pad(rand(0, 9999999), 10, '0', STR_PAD_LEFT) . time();
        }
        
        $fileName = $this->newFileName . '.' . $extension;
        $destination = $this->uploadPath . $fileName;
        
        // Handle existing file with chain or overwrite logic
        if (file_exists($destination)) {
            if ($this->chain && !$this->overwrite) {
                // Generate a new file name by appending an increment
                $i = 1;
                while (file_exists($this->uploadPath . $this->newFileName . $i . '.' . $extension)) {
                    $i++;
                }
                $fileName = $this->newFileName . $i . '.' . $extension;
                $destination = $this->uploadPath . $fileName;
            } else if (!$this->overwrite) {
                $this->errors[] = 'File with same name already exists';
                return false;
            }
        }

        // Upload file
        if (move_uploaded_file($this->file['tmp_name'], $destination)) {
            // Get relative path from public directory
            $relativePath = str_replace(__DIR__ . '/../../public/', '', $destination);
            
            return [
                'success' => true,
                'filename' => $fileName,
                'path' => $relativePath, // e.g., "images/0001234567890.jpg"
                'url' => '/' . $relativePath,
                'size' => $this->file['size'],
                'extension' => $extension,
                'mime_type' => $this->file['type']
            ];
        }

        $this->errors[] = 'Failed to upload file';
        return false;
    }

    public function uploadImage($width = null, $height = null) {
        if (!$this->isImage()) {
            $this->errors[] = 'File must be an image';
            return false;
        }

        $result = $this->upload();
        
        if ($result && ($width || $height)) {
            $this->resizeImage($result['path'], $width, $height);
        }

        return $result;
    }

    private function validate() {
        // Check if file exists
        if (!isset($this->file['tmp_name']) || empty($this->file['tmp_name'])) {
            $this->errors[] = 'No file uploaded';
            return false;
        }

        // Check for upload errors
        if ($this->file['error'] !== UPLOAD_ERR_OK) {
            $this->errors[] = $this->getUploadError($this->file['error']);
            return false;
        }

        // Check file size (both min and max)
        if ($this->file['size'] > $this->maxSize) {
            $this->errors[] = 'File size exceeds maximum allowed size of ' . $this->formatBytes($this->maxSize);
            return false;
        }
        
        if ($this->file['size'] < $this->minSize) {
            $this->errors[] = 'File size is below minimum required size of ' . $this->formatBytes($this->minSize);
            return false;
        }

        // Check extension
        if (!empty($this->allowedExtensions)) {
            $extension = $this->getExtension();
            if (!in_array(strtolower($extension), array_map('strtolower', $this->allowedExtensions))) {
                $this->errors[] = 'File type not allowed. Allowed types: ' . implode(', ', $this->allowedExtensions);
                return false;
            }
        }

        return true;
    }

    private function isImage() {
        $imageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        return in_array($this->file['type'], $imageTypes);
    }

    private function getExtension() {
        return strtolower(pathinfo($this->file['name'], PATHINFO_EXTENSION));
    }

    private function generateFileName($extension) {
        return uniqid() . '_' . time() . '.' . $extension;
    }

    private function getUrl($fileName) {
        $baseUrl = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] : '';
        // Return relative path that matches database format
        return $baseUrl . '/images/' . $fileName;
    }

    private function getUploadError($code) {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE directive in HTML form',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload'
        ];

        return $errors[$code] ?? 'Unknown upload error';
    }

    private function formatBytes($bytes) {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    private function resizeImage($imagePath, $newWidth = null, $newHeight = null) {
        list($width, $height, $type) = getimagesize($imagePath);

        // Calculate new dimensions maintaining aspect ratio
        if ($newWidth && !$newHeight) {
            $newHeight = ($height / $width) * $newWidth;
        } elseif ($newHeight && !$newWidth) {
            $newWidth = ($width / $height) * $newHeight;
        } elseif (!$newWidth && !$newHeight) {
            return;
        }

        $newWidth = (int) $newWidth;
        $newHeight = (int) $newHeight;

        // Create image resource from file
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($imagePath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($imagePath);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($imagePath);
                break;
            case IMAGETYPE_WEBP:
                $source = imagecreatefromwebp($imagePath);
                break;
            default:
                return;
        }

        // Create new image
        $thumb = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG and GIF
        if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
            $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
            imagefilledrectangle($thumb, 0, 0, $newWidth, $newHeight, $transparent);
        }

        // Resize
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Save resized image
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($thumb, $imagePath, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($thumb, $imagePath, 9);
                break;
            case IMAGETYPE_GIF:
                imagegif($thumb, $imagePath);
                break;
            case IMAGETYPE_WEBP:
                imagewebp($thumb, $imagePath, 90);
                break;
        }

        // Free memory
        imagedestroy($source);
        imagedestroy($thumb);
    }

    public function delete($filePath) {
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }

    public static function make($file, $uploadPath = 'images/') {
        return new self($file, $uploadPath);
    }

    public static function uploadMultiple($files, $uploadPath = 'images/') {
        $results = [];
        
        // Reorganize $_FILES array for multiple uploads
        $fileArray = [];
        foreach ($files as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $fileArray[$k][$key] = $v;
                }
            }
        }

        foreach ($fileArray as $file) {
            $upload = new self($file, $uploadPath);
            $result = $upload->upload();
            if ($result) {
                $results[] = $result;
            }
        }

        return $results;
    }
}
