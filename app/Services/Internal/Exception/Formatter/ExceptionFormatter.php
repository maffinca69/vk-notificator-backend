<?php

namespace App\Services\Internal\Exception\Formatter;

use Illuminate\Translation\Translator;

class ExceptionFormatter
{
    public const FILENAME = 'exception';

    public function __construct(private Translator $translator)
    {
    }

    /**
     * @param \Throwable $exception
     * @return string
     */
    public function format(\Throwable $exception): string
    {
        $key = get_class($exception);
        $key = sprintf('%s.%s', self::FILENAME, $key);
        if (!$this->translator->has($key)) {
            return $exception->getMessage() ?: 'Error';
        }

        $value = $this->translator->get($key);

        $context = $exception->getContext();
        if (!empty($context)) {
            $value = vsprintf($value, array_values($context));
        }

        return $value;
    }
}
