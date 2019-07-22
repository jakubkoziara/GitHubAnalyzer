<?php
declare(strict_types=1);


namespace App\Exception;


class RepositoryValidNameException extends \Exception implements RepositoryExceptionInterface
{
    public static function invalidFormat()
    {
        return new self('Repository name or link has invalid format');
    }
}