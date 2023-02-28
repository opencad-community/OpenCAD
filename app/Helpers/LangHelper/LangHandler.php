<?php

namespace Opencad\App\Helpers\LangHelper;

use Opencad\App\Helpers\Exceptions\Language\LanguageFileNotFoundException;
use Opencad\App\Helpers\Exceptions\Language\LanguageNotSupportedException;

class LangHandler
{
  // Class variables
  private static $default_instance;
  private $language_file;
  private $language;
  private static $languages = array();

  /**
   * Constructor for the LanguageFile class
   * 
   * @param string $language_code The language code to use for the language file
   * @throws LanguageNotSupportedException If the language code is not supported
   */
  public function __construct($language_code)
  {
    $languages = array('en', 'fr', 'es'); // Define a list of supported languages

    // If the selected language is not supported, display an error message and default to English
    if (!in_array($language_code, $languages)) {
      error_log("Unsupported language selected: $language_code");
      throw new LanguageNotSupportedException(
        "The language $language_code is not supported yet! Please open a request on the GitHub"
      );
    }

    $this->language_file = __DIR__ . "/../../../core/locale/$language_code.php";
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
      $this->language = include $this->language_file;
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
   * @param string|null $language_code The language code to use for the translation string
   * @return string The translation string for the given key and language code
   */
  public static function get($key, $language_code = null)
  {
    // If no language code is specified, check the user's preferred language
    if (!$language_code) {
      $language_code = isset($_COOKIE['user_language']) ? $_COOKIE['user_language'] : null;
    }

    // If no language code is specified or found, default to English
    if (!$language_code) {
      $language_code = DEFAULT_LANGUAGE;
    }

    $language_file = __DIR__ . "/../../../core/locale/$language_code.php";

    // If the language file exists, get the translation string for the given key and language code
    if (file_exists($language_file)) {
      $language = include $language_file;
      if (isset($language[$key])) {
        return $language[$key];
      }
    }

    // If the translation string is not found in the language file, check the static $languages array
    if (isset(self::$languages[$language_code][$key])) {
      return self::$languages[$language_code][$key];
    }

    error_log("Translation not found: $key ($language_code)");

    return $key;
  } /**
    * Gets the default language file instance
    * 
    * @return LangHandler The default language file instance
    */
  public static function getDefault()
  {
    if (!isset(self::$default_instance)) {
      self::$default_instance = new LangHandler(DEFAULT_LANGUAGE);
    }

    return self::$default_instance;
  }

  /**
   * Loads a language file from a specified language code
   * 
   * @param string $language_code The language code to use for the language file
   * @return array The loaded language file
   * @throws LanguageFileNotFoundException If the language file is not found
   */
  public static function loadFromFile($language_code)
  {
    $language_file = __DIR__ . "/../../../core/locale/$language_code.php";

    if (!file_exists($language_file)) {
      throw new LanguageFileNotFoundException("Language file not found: $language_file");
    }

    return include $language_file;
  }

  /**
   * Adds a translation string to the static $languages array
   * 
   * @param string $key The key for the translation string
   * @param string $value The translation string to add
   * @param string $language_code The language code to use for the translation string
   */
  public static function addTranslation($key, $value, $language_code = 'en')
  {
    if (!isset(self::$languages[$language_code])) {
      self::$languages[$language_code] = array();
    }

    self::$languages[$language_code][$key] = $value;
  }

  /**
   * Adds a plugin's translations to the static $languages array
   * 
   * @param string $plugin_name The name of the plugin
   * @param string $language_code The language code to use for the translations
   */
  public static function addPluginTranslations($plugin_name, $language_code = 'en')
  {
    if (!isset(self::$languages[$language_code])) {
      self::$languages[$language_code] = array();
    }

    $plugin_locale_file = __DIR__ . "/../../../plugins/$plugin_name/locale/$language_code.php";

    if (file_exists($plugin_locale_file)) {
      $plugin_locale = include $plugin_locale_file;
      self::$languages[$language_code] = array_merge(self::$languages[$language_code], $plugin_locale);
    }
  }

}
