<?php
class Validator {
    private $data;
    private $rules;
    private $errors = [];
    private $customMessages = [];

    public function __construct($data, $rules, $customMessages = []) {
        $this->data = $data;
        $this->rules = $rules;
        $this->customMessages = $customMessages;
    }

    public function validate() {
        foreach ($this->rules as $field => $rules) {
            $rulesArray = is_string($rules) ? explode('|', $rules) : $rules;
            
            foreach ($rulesArray as $rule) {
                $this->applyRule($field, $rule);
            }
        }

        if (!empty($this->errors)) {
            Session::flash('errors', $this->errors);
            Session::setOld($this->data);
            return false;
        }

        Session::clearOld();
        return true;
    }

    private function applyRule($field, $rule) {
        $params = [];
        
        if (strpos($rule, ':') !== false) {
            list($rule, $paramString) = explode(':', $rule, 2);
            $params = explode(',', $paramString);
        }

        $value = $this->data[$field] ?? null;
        $method = 'validate' . ucfirst($rule);

        if (method_exists($this, $method)) {
            $this->$method($field, $value, $params);
        }
    }

    private function validateRequired($field, $value, $params) {
        if (empty($value) && $value !== '0') {
            $this->addError($field, 'required', 'The ' . $field . ' field is required.');
        }
    }

    private function validateEmail($field, $value, $params) {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, 'email', 'The ' . $field . ' must be a valid email address.');
        }
    }

    private function validateMin($field, $value, $params) {
        $min = $params[0] ?? 0;
        
        if (is_numeric($value)) {
            if ($value < $min) {
                $this->addError($field, 'min', 'The ' . $field . ' must be at least ' . $min . '.');
            }
        } else {
            if (strlen($value) < $min) {
                $this->addError($field, 'min', 'The ' . $field . ' must be at least ' . $min . ' characters.');
            }
        }
    }

    private function validateMax($field, $value, $params) {
        $max = $params[0] ?? 0;
        
        if (is_numeric($value)) {
            if ($value > $max) {
                $this->addError($field, 'max', 'The ' . $field . ' may not be greater than ' . $max . '.');
            }
        } else {
            if (strlen($value) > $max) {
                $this->addError($field, 'max', 'The ' . $field . ' may not be greater than ' . $max . ' characters.');
            }
        }
    }

    private function validateNumeric($field, $value, $params) {
        if (!empty($value) && !is_numeric($value)) {
            $this->addError($field, 'numeric', 'The ' . $field . ' must be a number.');
        }
    }

    private function validateInteger($field, $value, $params) {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_INT)) {
            $this->addError($field, 'integer', 'The ' . $field . ' must be an integer.');
        }
    }

    private function validateString($field, $value, $params) {
        if (!empty($value) && !is_string($value)) {
            $this->addError($field, 'string', 'The ' . $field . ' must be a string.');
        }
    }

    private function validateIn($field, $value, $params) {
        if (!empty($value) && !in_array($value, $params)) {
            $this->addError($field, 'in', 'The selected ' . $field . ' is invalid.');
        }
    }

    private function validateUnique($field, $value, $params) {
        if (empty($value)) return;

        $table = $params[0] ?? null;
        $column = $params[1] ?? $field;
        $ignoreId = $params[2] ?? null;

        if (!$table) return;

        $db = Database::getInstance();
        $sql = "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = ?";
        $sqlParams = [$value];

        if ($ignoreId) {
            $sql .= " AND id != ?";
            $sqlParams[] = $ignoreId;
        }

        $result = $db->selectOne($sql, $sqlParams);
        
        if ($result && $result['count'] > 0) {
            $this->addError($field, 'unique', 'The ' . $field . ' has already been taken.');
        }
    }

    private function validateConfirmed($field, $value, $params) {
        $confirmField = $field . '_confirmation';
        $confirmValue = $this->data[$confirmField] ?? null;

        if ($value !== $confirmValue) {
            $this->addError($field, 'confirmed', 'The ' . $field . ' confirmation does not match.');
        }
    }

    private function validateSame($field, $value, $params) {
        $otherField = $params[0] ?? null;
        $otherValue = $this->data[$otherField] ?? null;

        if ($value !== $otherValue) {
            $this->addError($field, 'same', 'The ' . $field . ' and ' . $otherField . ' must match.');
        }
    }

    private function validateDifferent($field, $value, $params) {
        $otherField = $params[0] ?? null;
        $otherValue = $this->data[$otherField] ?? null;

        if ($value === $otherValue) {
            $this->addError($field, 'different', 'The ' . $field . ' and ' . $otherField . ' must be different.');
        }
    }

    private function validateDate($field, $value, $params) {
        if (!empty($value) && strtotime($value) === false) {
            $this->addError($field, 'date', 'The ' . $field . ' is not a valid date.');
        }
    }

    private function validateBefore($field, $value, $params) {
        $date = $params[0] ?? null;
        
        if (!empty($value) && !empty($date)) {
            if (strtotime($value) >= strtotime($date)) {
                $this->addError($field, 'before', 'The ' . $field . ' must be a date before ' . $date . '.');
            }
        }
    }

    private function validateAfter($field, $value, $params) {
        $date = $params[0] ?? null;
        
        if (!empty($value) && !empty($date)) {
            if (strtotime($value) <= strtotime($date)) {
                $this->addError($field, 'after', 'The ' . $field . ' must be a date after ' . $date . '.');
            }
        }
    }

    private function validateAlpha($field, $value, $params) {
        if (!empty($value) && !ctype_alpha($value)) {
            $this->addError($field, 'alpha', 'The ' . $field . ' may only contain letters.');
        }
    }

    private function validateAlphaNum($field, $value, $params) {
        if (!empty($value) && !ctype_alnum($value)) {
            $this->addError($field, 'alpha_num', 'The ' . $field . ' may only contain letters and numbers.');
        }
    }

    private function validateAlphaDash($field, $value, $params) {
        if (!empty($value) && !preg_match('/^[a-zA-Z0-9_-]+$/', $value)) {
            $this->addError($field, 'alpha_dash', 'The ' . $field . ' may only contain letters, numbers, dashes and underscores.');
        }
    }

    private function validateUrl($field, $value, $params) {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
            $this->addError($field, 'url', 'The ' . $field . ' format is invalid.');
        }
    }

    private function validateIp($field, $value, $params) {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_IP)) {
            $this->addError($field, 'ip', 'The ' . $field . ' must be a valid IP address.');
        }
    }

    private function validateFile($field, $value, $params) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
                $this->addError($field, 'file', 'The ' . $field . ' upload failed.');
            }
        }
    }

    private function validateImage($field, $value, $params) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $fileType = $_FILES[$field]['type'];
            
            if (!in_array($fileType, $allowedTypes)) {
                $this->addError($field, 'image', 'The ' . $field . ' must be an image.');
            }
        }
    }

    private function validateMimes($field, $value, $params) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $extension = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
            
            if (!in_array($extension, $params)) {
                $this->addError($field, 'mimes', 'The ' . $field . ' must be a file of type: ' . implode(', ', $params) . '.');
            }
        }
    }

    private function validateSize($field, $value, $params) {
        $maxSize = ($params[0] ?? 2048) * 1024; // Convert KB to bytes
        
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            if ($_FILES[$field]['size'] > $maxSize) {
                $this->addError($field, 'size', 'The ' . $field . ' may not be greater than ' . ($maxSize / 1024) . ' kilobytes.');
            }
        }
    }

    private function validateBoolean($field, $value, $params) {
        $acceptable = [true, false, 0, 1, '0', '1'];
        
        if (!in_array($value, $acceptable, true)) {
            $this->addError($field, 'boolean', 'The ' . $field . ' field must be true or false.');
        }
    }

    private function validateArray($field, $value, $params) {
        if (!is_array($value)) {
            $this->addError($field, 'array', 'The ' . $field . ' must be an array.');
        }
    }

    private function addError($field, $rule, $message) {
        $customKey = $field . '.' . $rule;
        
        if (isset($this->customMessages[$customKey])) {
            $message = $this->customMessages[$customKey];
        }
        
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        
        $this->errors[$field][] = $message;
    }

    public function errors() {
        return $this->errors;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }

    public function firstError($field) {
        return $this->errors[$field][0] ?? null;
    }

    public static function make($data, $rules, $customMessages = []) {
        $validator = new self($data, $rules, $customMessages);
        $validator->validate();
        return $validator;
    }
}
