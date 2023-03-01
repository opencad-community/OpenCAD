<?php
namespace Opencad\App\Helpers\OptionsResolver;

class OptionsResolver
{
    private $options = [];
    private $defaults = [];

    /**
     * Constructor for the options resolver.
     *
     * @param array $options An array of options to resolve.
     */
    public function __construct(array $options)
    {
        $this->defaults = $options;
        $this->options = $options;
    }

     /**
     * Adds an option to the options resolver.
     *
     * @param string   $name      The name of the option.
     * @param mixed    $default   The default value of the option.
     * @param callable $validator A callable function that validates the value of the option.
     */
    public function addOption(string $name, $default, callable $validator = null): void
    {
        $this->defaults[$name] = $default;
        $this->options[$name] = $default;

        if ($validator !== null) {
            $this->validateOption($name, $validator);
        }
    }

    /**
     * Gets the resolved options.
     *
     * @return array An array of resolved options.
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Validates an individual option.
     *
     * @param string   $name      The name of the option.
     * @param callable $validator A callable function that validates the value of the option.
     *
     * @throws \InvalidArgumentException If the option is invalid.
     */
    private function validateOption(string $name, callable $validator): void
    {
        if (!isset($this->options[$name])) {
            return;
        }

        $value = $this->options[$name];

        if (!$validator($value)) {
            throw new \InvalidArgumentException(sprintf('Option "%s" is invalid', $name));
        }
    }
}
