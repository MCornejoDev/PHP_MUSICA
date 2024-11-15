<?php

namespace App\Http\Requests;

use App\Database;
use Exception;
use InvalidArgumentException;
use PDO;

class BaseRequest
{
    /**TODO: IMPLEMENT GET AND SET REQUEST PARAMETERS*/

    /**
     * Check if a field is required.
     * @param mixed $value 
     * @param mixed $field 
     * @return string 
     */
    public static function isRequired($value, $field): ?string
    {
        $trans = getKey('global.rules.required');
        $transField = getKey('user.' . $field);

        if (isset($value) && is_string($value) && trim($value) === '') {
            return $transField . ' ' . $trans;
        }

        return null;
    }

    /**
     * Check if a field is unique.
     * @param string $table 
     * @param string $column 
     * @param string $value 
     * @return string 
     */
    public static function isUnique(string $table, string $column, string $value): ?string
    {
        $trans = getKey('global.rules.unique');
        $transField = getKey('user.' . $column);

        if (self::checkUnique($table, $column, $value)) {
            return $transField . ' ' . $trans;
        }

        return null;
    }

    /**
     * Check if a field has a minimum length.
     * @param mixed $value 
     * @param mixed $minLength 
     * @param mixed $field 
     * @return string 
     */
    public static function minLength($value, $minLength, $field): ?string
    {
        $min = $minLength == 1 ? getKey('global.rules.min.one') : getKey('global.rules.min.other');

        $trans = str_replace(':min', $minLength, $min);
        $transField = getKey('user.' . $field);

        if (strlen($value) < $minLength) {
            return $transField . ' ' . $trans;
        }

        return null;
    }

    /**
     * Check if a field has a maximum length.
     * @param mixed $value 
     * @param mixed $maxLength 
     * @param mixed $field 
     * @return string 
     */
    public static function maxLength($value, $maxLength, $field): ?string
    {
        $max = $maxLength == 1 ? getKey('global.rules.max.one') : getKey('global.rules.max.other');

        $trans = str_replace(':max', $maxLength, $max);
        $transField = getKey('user.' . $field);

        if (strlen($value) >= $maxLength) {
            return $transField . ' ' . $trans;
        }

        return null;
    }

    /**
     * Check if a field is a valid email.
     * @param mixed $value 
     * @param string $field 
     * @return string|null
     */
    public static function isEmail($value, string $field): ?string
    {
        // Traducciones para los mensajes
        $trans = getKey('global.rules.email'); // Ejemplo: "is not a valid email"
        $transField = getKey('user.' . $field); // Ejemplo: "Email"

        // Asegúrate de que el valor sea una cadena válida
        $value = is_string($value) ? trim($value) : '';

        // Validación del email
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            // Si no es válido, devuelve el mensaje de error
            return $transField . ' ' . $trans;
        }

        // Devuelve null si la validación es exitosa
        return null;
    }


    public static function applyRule($rule, $value, $key)
    {
        return match ($rule[0]) {
            'required' => self::isRequired($value, $key),
            'email' => self::isEmail($value, $key),
            'unique' => self::isUnique($rule[1], $key, $value),
            'min' => self::minLength($value, $rule[1], $key),
            'max' => self::maxLength($value, $rule[1], $key),
            default => null,
        };
    }

    public static function handleErrors(array $errors): bool
    {
        $hasErrors = !empty($errors);

        if ($hasErrors) {
            addToBag('errors', $errors);
        }

        return $hasErrors;
    }

    /**
     * Split rules into an array.
     * @param mixed $rules 
     * @return array 
     */
    public static function splitRules($rules): array
    {
        $rules = explode('|', $rules);

        foreach ($rules as $key => $rule) {
            $rules[$key] = explode(':', $rule);
        }

        return $rules;
    }

    /**
     * Check if a value in a field is unique in the database.
     * @param string $table 
     * @param string $column 
     * @param string $value 
     * @return bool 
     */
    public static function checkUnique(string $table, string $column, string $value): bool
    {
        try {
            // Validar que los nombres de tabla y columna solo contengan caracteres válidos
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $table) || !preg_match('/^[a-zA-Z0-9_]+$/', $column)) {
                throw new InvalidArgumentException("Invalid table or column name.");
            }

            $db = (new Database())->getConnection();

            // Preparar la consulta usando mysqli
            $stmt = $db->prepare("SELECT 1 FROM $table WHERE $column = :value LIMIT 1");

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $db->errorInfo());
            }

            $stmt->bindParam(':value', $value, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (Exception $e) {
            // Registra el error
            error_log($e->getMessage());
            return false; // También devolver null en caso de error
        }
    }
}
