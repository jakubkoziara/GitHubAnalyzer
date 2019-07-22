<?php
declare(strict_types=1);


namespace App\Exception;


class RepositoryNotFoundException extends \Exception implements RepositoryExceptionInterface
{
    public static function notFound()
    {
        return new self('One or both Repositories not found');
    }
}