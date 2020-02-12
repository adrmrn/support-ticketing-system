<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Exception;

use Ticket\Domain\DomainException;
use Ticket\Domain\Exception\UnsupportedUserRole;
use Ticket\Tests\Support\TestCase;

class UnsupportedUserRoleTest extends TestCase
{
    public function testCreation_HaveRoleThatIsNotSupported_ReturnedExceptionHasExpectedValues(): void
    {
        // arrange
        $expectedRole = 'Unsupported role';

        // act
        $exception = UnsupportedUserRole::withRole($expectedRole);

        // assert
        $this->assertInstanceOf(DomainException::class, $exception);
        $this->assertInstanceOf(UnsupportedUserRole::class, $exception);
        $expectedMessage = sprintf('Unsupported user role. Role: %s', $expectedRole);
        $this->assertSame($expectedMessage, $exception->getMessage());
    }
}