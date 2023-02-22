<?php


namespace App\Components;


final class IntegrationFactory
{
    public static function make(string $className): ?Integration
    {
        $className = 'App\Components\\' . $className;
        if (class_exists($className)) {

            return new $className();
        }
        return null;
    }

    static function integrationList(): array
    {
        $dir = __DIR__;

        $files = scandir($dir);

        $integration = array_filter($files, function ($v, $k) {
            return preg_match('#^Integration[A-z]+\\.php$#', $v);
        }, ARRAY_FILTER_USE_BOTH);
        $response = [];
        foreach ($integration as $key => $value) {
            $value = preg_replace('#\\.php#', '', $value);
            if ($value !== 'IntegrationFactory') {
                $response[] = $value;
            }
        }
        return $response;
    }
}
