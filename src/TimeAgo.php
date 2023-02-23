<?php

/**
 * TimeAgo Class
 *
 * A simple class to convert a given date/time to a human-readable format
 * using the "time ago" format (e.g. "3 hours ago", "2 days ago").
 *
 * @package    TimeAgo
 * @category   Utility
 * @author     Ramazan Çetinkaya
 * @license    MIT License
 * @version    1.0
 * @link       https://github.com/ramazancetinkaya/TimeAgo
 */
class TimeAgo {
    
    /**
     * The default locale to use for formatting the time ago string.
     *
     * @var string
     */
    private static $defaultLocale = 'en_US';
    
    /**
     * The number of seconds in each time interval.
     *
     * @var array
     */
    private static $intervals = array(
        'year'   => 31536000,
        'month'  => 2592000,
        'week'   => 604800,
        'day'    => 86400,
        'hour'   => 3600,
        'minute' => 60,
        'second' => 1,
    );
    
    /**
     * The translations for each supported locale.
     *
     * @var array
     */
    private static $translations = array(
        'en_US' => array(
            'year'   => 'year',
            'month'  => 'month',
            'week'   => 'week',
            'day'    => 'day',
            'hour'   => 'hour',
            'minute' => 'minute',
            'second' => 'second',
        ),
        'tr_TR' => array(
            'year'   => 'yıl',
            'month'  => 'ay',
            'week'   => 'hafta',
            'day'    => 'gün',
            'hour'   => 'saat',
            'minute' => 'dakika',
            'second' => 'saniye',
        ),
    );
    
    /**
     * Generate a human-readable time ago string from a Unix timestamp.
     *
     * @param int $timestamp The Unix timestamp to generate the time ago string for.
     * @param string $locale The locale to use for formatting the time ago string.
     * @return string The human-readable time ago string.
     */
    public static function generate($timestamp, $locale = null) {
        $locale = $locale ?: self::$defaultLocale;
        $delta = time() - $timestamp;
        if ($delta < 0) {
            return '';
        }
        foreach (self::$intervals as $interval => $seconds) {
            $count = floor($delta / $seconds);
            if ($count != 0) {
                break;
            }
        }
        $suffix = ($count == 1) ? '' : 's';
        $intervalString = $count . ' ' . self::translateInterval($interval, $locale) . $suffix;
        return sprintf('%s ago', $intervalString);
    }
    
    /**
     * Set the default locale to use for formatting the time ago string.
     *
     * @param string $locale The locale to set as the default.
     */
    public static function setDefaultLocale($locale) {
        self::$defaultLocale = $locale;
    }
    
    /**
     * Translate the given interval to the target language.
     *
     * @param string $interval The interval to translate.
     * @param string $locale The locale to translate to.
     * @return string The translated interval.
     */
    private static function translateInterval($interval, $locale) {
        $translations = self::$translations[$locale];
        return $translations[$interval] ?? $interval;
    }
    
}
