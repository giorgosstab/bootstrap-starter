<?php

namespace App\Libraries;

class TranslatorManager
{
    /**
     * Get translator initialized instance
     *
     * @var $instance
     */
    private static $instance;

    /**
     * The locale used by the translator.
     *
     * @var string
     */
    protected $locale;

    /**
     * The fallback locale used by the translator.
     *
     * @var string
     */
    protected $fallback;

    private array $loaded = [];

    /**
     * Create a new translator instance.
     *
     * @param string $locale
     * @return void
     */
    public function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    public static function getInstance($locale): TranslatorManager
    {
        if (!self::$instance) {
            self::$instance = new self($locale);
        }

        return self::$instance;
    }

    /**
     * Load the specified language group.
     *
     * @param string $group
     * @param string $locale
     * @return void
     */
    public function load(string $group, string $locale): void
    {
        if ($this->isLoaded($group, $locale)) return;

        $lang = lang_path($locale . '/' . $group . '.php');

        if (file_exists($lang)) {
            $lines = require $lang;
        } else {
            $lines = require lang_path($this->fallback . '/' . $group . '.php');;
        }

        $this->loaded[$group][$locale] = $lines;
    }

    /**
     * Determine if the given group has been loaded.
     *
     * @param string $group
     * @param string $locale
     * @return bool
     */
    protected function isLoaded(string $group, string $locale): bool
    {
        return isset($this->loaded[$group][$locale]);
    }

    /**
     * Get the translation for the given key.
     *
     * @param string $key
     * @param string|null $locale
     * @return string
     */
    public function get(string $key, string $locale = null): string
    {
        [$group, $item] = $this->parseKey($key);

        foreach ($this->parseLocale($locale) as $locale) {
            $this->load($group, $locale);

            $line = $this->getLine(
                $group, $locale, $item
            );

            if (!is_null($line)) break;
        }

        // If the line doesn't exist, we will return back the key which was requested as
        // that will be quick to spot in the UI if language keys are wrong or missing
        // from the application's language files. Otherwise we can return the line.
        if (!isset($line)) return $key;

        return $line;
    }

    /**
     * Retrieve a language line out the loaded array.
     *
     * @param string $group
     * @param string $locale
     * @param string $item
     * @return string|null
     */
    protected function getLine(string $group, string $locale, string $item): ?string
    {
        return array_get($this->loaded[$group][$locale], $item);
    }

//    public static function get($key, $locale = null)
//    {
//        if ($locale === null) {
//            $locale = config('app.locale', 'el');
//        }
//
//        if (!isset(self::$loaded[$locale])) {
//            self::load($locale);
//        }
//
//        list($file, $name) = explode('.', $key, 2);
////
////        return self::$translations[$locale][$file][$name] ?? $default;
//
//        dd(self::$loaded[$locale][$file][$name]);
//
////        [$group, $name] = explode('.', $key, 2);
////
////        return self::$loaded[$locale][$group][$name] ?? $default;
//
//        return self::parseValue(self::$loaded[$locale], $key);
//    }
//
    /**
     * Parse a key into group, and item.
     *
     * @param string $key
     * @return array
     */
    public function parseKey(string $key): array
    {
        $segments = explode('.', $key);

        return $this->parseBasicSegments($segments);
    }

    /**
     * Get the array of locales to be checked.
     *
     * @param string|null $locale
     * @return array
     */
    protected function parseLocale(?string $locale): array
    {
        if (!is_null($locale)) {
            return array_filter([$locale, $this->fallback]);
        }

        return array_filter([$this->locale, $this->fallback]);
    }

    /**
     * Parse an array of basic segments.
     *
     * @param array $segments
     * @return array
     */
    protected function parseBasicSegments(array $segments): array
    {
        $group = $segments[0];

        if (count($segments) == 1) {
            return [$group, null];
        } else {
            $item = implode('.', array_slice($segments, 1));

            return [$group, $item];
        }
    }

    /**
     * Get the default locale being used.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * Set the default locale.
     *
     * @param string $locale
     * @return void
     */
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * Get the fallback locale being used.
     *
     * @return string
     */
    public function getFallback(): string
    {
        return $this->fallback;
    }

    /**
     * Set the fallback locale being used.
     *
     * @param string $fallback
     * @return void
     */
    public function setFallback(string $fallback): void
    {
        $this->fallback = $fallback;
    }
}