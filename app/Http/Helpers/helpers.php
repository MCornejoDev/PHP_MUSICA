<?php
include __DIR__ . '/../../Models/Category.php';

if (! function_exists('__')) {
    function __(string $key)
    {
        setKey(getLanguage(), $key);
    }
}

if (! function_exists('setKey')) {
    function setKey(string $lang, string $key)
    {
        // Imprime el valor obtenido
        print(getKey($lang, $key));
    }
}

if (! function_exists('getKey')) {
    function getKey(string $lang, string $key)
    {
        $splits = explode('.', $key);
        $file = array_shift($splits);

        $path = __DIR__ . '/../../../lang/' . $lang . '/' . $file . '.php';

        if (file_exists($path)) {
            // Incluimos el archivo y obtenemos el array
            $keys = include $path;
        }

        // Utiliza array_reduce para obtener el valor final del array multidimensional
        // Utilizamos array_reduce para navegar por el array anidado
        return array_reduce($splits, function ($carry, $item) {
            return isset($carry[$item]) ? $carry[$item] : null;
        }, $keys);
    }
}

if (! function_exists('getLanguage')) {
    function getLanguage()
    {
        return htmlspecialchars(empty($_GET['lang']) ? 'es' : $_GET['lang']);
    }
}

if (! function_exists('initSession')) {
    function initSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            $_SESSION['errors'] = [];
            $_SESSION['messages'] = [];
        }
    }
}

if (! function_exists('addToBag')) {
    function addToBag(string $key, array $data)
    {
        $_SESSION[$key] = $data;
    }
}

if (! function_exists('existsKeyInBag')) {
    function existsKeyInBag(string $key, string $bag)
    {
        return array_key_exists($key, $_SESSION[$bag]);
    }
}

if (! function_exists('hasValuesInBag')) {
    function hasValuesInBag(string $bag)
    {
        return !empty($_SESSION[$bag]);
    }
}

if (! function_exists('getCategories')) {
    function getCategories()
    {
        return (new Category())->getAll();
    }
}

if (!function_exists('redirectTo')) {
    function redirectTo(string $url): void
    {
        print
            '<script>
                window.setTimeout(function() {
                    window.location = "' . $url . '";
                }, 1);
            </script>';
    }
}

if (!function_exists('identityIsEmpty')) {
    function identityIsEmpty(): bool
    {
        return empty($_SESSION['identity']);
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        return isset($_SESSION['identity']['role']) && $_SESSION['identity']['role'];
    }
}

if (!function_exists('makeDirectory')) {
    function makeDirectory(string $folder): bool
    {
        return is_dir($folder) || mkdir($folder, 0755, true);
    }
}
