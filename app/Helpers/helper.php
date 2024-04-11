<?php

use App\Libraries\ConfigManager;
use App\Libraries\Env;
use App\Libraries\HtmlPicture;
use App\Libraries\TranslatorManager;
use JetBrains\PhpStorm\NoReturn;

if (!function_exists('array_get')) {
    /**
     * Get application name based on localization
     *
     * @return string
     */
    function app_name(): string
    {
        return current_locale() === config('app.fallback_locale')
            ? config('app.name')
            : config('app.name_' . current_locale());
    }
}

if (!function_exists('array_get')) {
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param array $array
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    function array_get(array $array, string $key, mixed $default = null): mixed
    {
        if (is_null($key)) return $array;

        if (isset($array[$key])) return $array[$key];

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return value($default);
            }

            $array = $array[$segment];
        }

        return $array;
    }
}

if (!function_exists('asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @return string
     */
    function asset(string $path): string
    {
        return env('APP_URL') . $path;
    }
}

if (!function_exists('base_path')) {
    /**
     * Get the path to the base of the installation.
     *
     * @param string $path
     *
     * @return string
     */
    function base_path(string $path = ''): string
    {
        return FCPATH . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('clean_html')) {
    /**
     * Clean all html characters from given text.
     *
     * @param string|null $text
     * @param bool $allowed_tags
     * @return string
     */
    function clean_html(string $text = null, bool $allowed_tags = false): string
    {
        if (empty($text) || $text == '') {
            return '';
        }

        if(!$allowed_tags) {
            return trim(stripcslashes(strip_tags($text)));
        }

        return $text;
    }
}

if (!function_exists('component')) {
    /**
     * Get the path to the public folder.
     *
     * @param string $path
     * @return string
     */
    function component(string $path = ''): string
    {
        return base_path('resources/views/components' . ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }
}

if (!function_exists('config')) {
    /**
     * Get the specified configuration value.
     *
     * @param string $key
     * @param string|null $default
     * @return string|array
     */
    function config(string $key, string $default = null): string|array
    {
        return ConfigManager::get($key, $default);
    }
}

if (!function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param string $path
     * @return string
     */
    function config_path(string $path = ''): string
    {
        return base_path('config' . ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }
}

if (! function_exists('copyrights')) {
    function copyrights($year = 'auto')
    {
        $copy = '&copy ';
        $company = ' ' . config('app.name');

        if (intval($year) == 'auto') {
            return $copy . date('Y') . $company;
        }
        if (intval($year) == date('Y')) {
            return $copy . intval($year) . $company;
        }
        if (intval($year) < date('Y')) {
            return $copy . intval($year) . ' - ' . date('Y') . $company;
        }
        if (intval($year) > date('Y')) {
            return $copy . date('Y') . $company;
        }
    }
}

if (!function_exists('current_locale')) {
    /**
     * Get the current language locale.
     *
     * @return string
     */
    function current_locale(): string
    {
        $locale = config('app.locale', 'el');

        if (isset($_GET['route'])) {
            $route = explode('/', $_GET['route']);

            return count($route) === 2 ? $route[0] : $locale;
        }

        return $locale;
    }
}

if (!function_exists('current_url')) {
    /**
     * Get the full URL (including segments) of the page
     *
     * @param null $locale
     * @return string
     */
    function current_url($locale = null): string
    {
        $page = 'index';

        if (isset($_GET['route'])) {
            $route = explode('/', $_GET['route']);

            $page = count($route) === 2
                ? rtrim($route[1], '/')
                : rtrim($route[0], '/');
        }

        if ($locale === config('app.fallback_locale')) {
            return $page === 'index' ? url() : url($page);
        }

        return url(($locale ?? current_locale()) . '/' . $page);
    }
}

if (!function_exists('dd')) {
    #[NoReturn] function dd(...$vars): void
    {
        if (!in_array(\PHP_SAPI, ['cli', 'phpdbg'], true) && !headers_sent()) {
            header('HTTP/1.1 500 Internal Server Error');
        }

        echo '<pre>';

        $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT | DEBUG_BACKTRACE_IGNORE_ARGS, 20);

        $file = $trace[0]['file'] ?? null;
        $line = $trace[0]['line'] ?? null;

        echo "// $file:$line\n";

        dump($vars);

        echo '</pre>';

        exit(1);
    }
}

if (!function_exists('dump')) {
    function dump(...$vars): void
    {
        foreach ($vars as $v) {
            print_r($v);
            echo '<br />';
        }
    }
}

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param string $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    function env(string $key, $default = null): mixed
    {
        return Env::get($key, $default);
    }
}

if (!function_exists('get_data')) {
    /**
     * Return selected tag based on key search
     *
     * @param object|array $array
     * @param array $pairs
     * @return false|mixed
     */
    function get_data(object|array $array, array $pairs): mixed
    {
        $found = [];
        foreach ($array as $aVal) {
            $coincidences = 0;
            foreach ($pairs as $pKey => $pVal) {
                if (isset($aVal->$pKey) && $aVal->$pKey == $pVal) {
                    $coincidences++;
                }
            }

            if ($coincidences == count($pairs)) {
                $found[] = $aVal;
            }
        }

        return isset($found[1]) ? $found : ($found[0] ?? $found);
    }
}

if (!function_exists('lang_path')) {
    /**
     * Get the path to the language folder.
     *
     * @param string $path
     * @return string
     */
    function lang_path(string $path = ''): string
    {
        return base_path('lang' . ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }
}

if (!function_exists('mix')) {
    /**
     * Get the path to a versioned Mix file.
     *
     * @param string $path
     * @param string $manifestDirectory
     *
     * @return string
     *
     * @throws Exception
     */
    function mix(string $path, string $manifestDirectory = ''): string
    {
        static $manifests = [];

        if (!str_starts_with($path, '/')) {
            $path = "/{$path}";
        }

        if ($manifestDirectory && !str_starts_with($manifestDirectory, '/')) {
            $manifestDirectory = "/{$manifestDirectory}";
        }

        $manifestPath = public_path($manifestDirectory . '/build/mix-manifest.json');

        if (!isset($manifests[$manifestPath])) {
            if (!is_file($manifestPath)) {
                throw new Exception('The Mix manifest does not exist.');
            }

            $manifests[$manifestPath] = json_decode(file_get_contents($manifestPath), true);
        }

        $manifest = $manifests[$manifestPath];

        if (!isset($manifest[$path])) {
            throw new Exception("Unable to locate Mix file: {$path}.");
        }

        return asset($manifestDirectory . 'build' . $manifest[$path]);
    }
}

if (!function_exists('picture_tag')) {
    /**
     * Get picture tag from image
     *
     * @param string $path
     * @param array $attributes
     * @param array|bool $sourceTypes
     * @return string
     */
    function picture_tag(string $path, array $attributes = [], array|bool $sourceTypes = false): string
    {
        return HtmlPicture::get($path, $attributes, $sourceTypes);
    }
}

if (!function_exists('public_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param string $path
     * @return string
     */
    function public_path(string $path = ''): string
    {
        return base_path('public' . DIRECTORY_SEPARATOR . ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }
}

if (!function_exists('resource_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param string $path
     * @return string
     */
    function resource_path(string $path = ''): string
    {
        return base_path('resources' . ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }
}

if (!function_exists('storage_path')) {
    /**
     * Get the path to the storage folder.
     *
     * @param string $path
     * @return string
     */
    function storage_path(string $path = ''): string
    {
        return base_path('storage' . ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }
}

if (!function_exists('str_limit')) {
    /**
     * Limit the number of characters in a string.
     *
     * @param string $value
     * @param int $limit
     * @param string $end
     * @return string
     */
    function str_limit(string $value, int $limit = 100, string $end = '...'): string
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }

        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $end;
    }
}

if (!function_exists('trans')) {
    /**
     * Translate the given message.
     *
     * @param string $key
     * @return string
     */
    function trans(string $key): string
    {
        if (!isset($_GET['route'])) {
            $locale = config('app.locale');
        } else {
            $route = explode('/', $_GET['route']);

            $locale = count($route) !== 2
                ? config('app.locale')
                : $route[0];
        }

        $trans = TranslatorManager::getInstance($locale);

        $trans->setFallback(config('app.fallback_locale'));

        return $trans->get($key);
    }
}

if (!function_exists('url')) {
    /**
     * Generate an url path for the application.
     *
     * @param string $path
     * @return string
     */
    function url(string $path = ''): string
    {
        return env('APP_URL') . $path;
    }
}

if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param mixed $value
     * @return mixed
     */
    function value(mixed $value): mixed
    {
        return $value instanceof Closure ? $value() : $value;
    }
}