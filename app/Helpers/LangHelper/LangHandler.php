<?php

namespace Opencad\App\Helpers\LangHelper;

use Opencad\App\Helpers\Exceptions\Language\LanguageFileNotFoundException;
use Opencad\App\Helpers\Exceptions\Language\LanguageNotSupportedException;

class LangHandler
{
  // Class variables
  private static $defaultInstance;
  private $languageFile;
  private $language;
  private static $languages = array();

  /**
   * Constructor for the LanguageFile class
   *
   * @param string $languageCode The language code to use for the language file
   * @throws LanguageNotSupportedException If the language code is not supported
   */
  public function __construct($languageCode)
  {
    $languages = array('en', 'fr', 'es'); // Define a list of supported languages

    // If the selected language is not supported, display an error message and default to English
    if (!in_array($languageCode, $languages)) {
      error_log("Unsupported language selected: $languageCode");
      throw new LanguageNotSupportedException(
        "The language $languageCode is not supported yet! Please open a request on the GitHub"
      );
    }

    $this->languageFile = __DIR__ . "/../../../core/locale/$languageCode.php";
    $this->load();
  }

  /**
   * Loads the language file
   *
   * @throws LanguageFileNotFoundException If the language file is not found
   */
  public function load()
  {
    try {
      $this->language = include $this->languageFile;
    } catch (LanguageFileNotFoundException $e) {
      error_log("Error loading language file: " . $e->getMessage());
      $this->language = array();
      throw new LanguageFileNotFoundException("Error loading language file: " . $e->getMessage());
    }
  }

  /**
   * Reloads the language file
   */
  public function reload()
  {
    $this->load();
  }

  /**
   * Gets a translation string for the given key and language code
   *
   * @param string $key The key for the translation string
   * @param string|null $languageCode The language code to use for the translation string
   * @return string The translation string for the given key and language code
   */
  public static function get($key, $languageCode = null)
  {
    // If no language code is specified, check the user's preferred language
    if (!$languageCode) {
      $languageCode = htmlspecialchars(isset($_COOKIE['user_language']) ? $_COOKIE['user_language'] : null);
    }

    // If no language code is specified or found, default to English
    if (!$languageCode) {
      $languageCode = DEFAULT_LANGUAGE;
    }

    $languageCode = htmlspecialchars($languageCode);
    $languageFile = __DIR__ . "/../../../core/locale/$languageCode.php";

    // If the language file exists, get the translation string for the given key and language code
    if (file_exists($languageFile)) {
      $language = include $languageFile;
      if (isset($language[$key])) {
        return $language[$key];
      }
    }

    // If the translation string is not found in the language file, check the static $languages array
    if (isset(self::$languages[$languageCode][$key])) {
      return self::$languages[$languageCode][$key];
    }

    error_log("Translation not found: $key ($languageCode)");

    return $key;
  } /**
    * Gets the default language file instance
    *
    * @return LangHandler The default language file instance
    */
  public static function getDefault()
  {
    if (!isset(self::$defaultInstance)) {
      self::$defaultInstance = new LangHandler(DEFAULT_LANGUAGE);
    }

    return self::$defaultInstance;
  }

  /**
   * Loads a language file from a specified language code
   *
   * @param string $languageCode The language code to use for the language file
   * @return array The loaded language file
   * @throws LanguageFileNotFoundException If the language file is not found
   */
  public static function loadFromFile($languageCode)
  {
    $languageFile = __DIR__ . "/../../../core/locale/$languageCode.php";

    if (!file_exists($languageFile)) {
      throw new LanguageFileNotFoundException("Language file not found: $languageFile");
    }

    return include $languageFile;
  }

  /**
   * Adds a translation string to the static $languages array
   *
   * @param string $key The key for the translation string
   * @param string $value The translation string to add
   * @param string $languageCode The language code to use for the translation string
   */
  public static function addTranslation($key, $value, $languageCode = 'en')
  {
    if (!isset(self::$languages[$languageCode])) {
      self::$languages[$languageCode] = array();
    }

    self::$languages[$languageCode][$key] = $value;
  }

  /**
   * Adds a plugin's translations to the static $languages array
   *
   * @param string $plugin_name The name of the plugin
   * @param string $languageCode The language code to use for the translations
   */
  public static function addPluginTranslations($plugin_name, $languageCode = 'en')
  {
    if (!isset(self::$languages[$languageCode])) {
      self::$languages[$languageCode] = array();
    }

    $plugin_locale_file = __DIR__ . "/../../../plugins/$plugin_name/locale/$languageCode.php";

    if (file_exists($plugin_locale_file)) {
      $plugin_locale = include $plugin_locale_file;
      self::$languages[$languageCode] = array_merge(self::$languages[$languageCode], $plugin_locale);
    }
  }
}
