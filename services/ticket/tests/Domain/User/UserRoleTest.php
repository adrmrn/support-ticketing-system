<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\User;

use Ticket\Domain\Exception\UnsupportedUserRole;
use Ticket\Domain\User\UserRole;
use Ticket\Tests\Support\TestCase;

class UserRoleTest extends TestCase
{
    public function testCreation_WantToCreateAdminRoleViaStaticMethod_CreatedUserRoleHasExpectedValue(): void
    {
        // act
        $role = UserRole::admin();

        // assert
        $expectedRoleAsString = 'admin';
        $this->assertSame($expectedRoleAsString, (string)$role);
    }

    public function testCreation_WantToCreateCustomerRoleViaStaticMethod_CreatedUserRoleHasExpectedValue(): void
    {
        // act
        $role = UserRole::customer();

        // assert
        $expectedRoleAsString = 'customer';
        $this->assertSame($expectedRoleAsString, (string)$role);
    }

    public function testEquals_CompareTwoDifferentUserRoles_ReturnsFalse(): void
    {
        // arrange
        $roleOne = UserRole::admin();
        $roleTwo = UserRole::customer();

        // act
        $equals = $roleOne->equals($roleTwo);

        // assert
        $this->assertFalse($equals);
    }

    public function testEquals_CompareTwoAdminUserRoles_ReturnsTrue(): void
    {
        // arrange
        $roleOne = UserRole::admin();
        $roleTwo = UserRole::admin();

        // act
        $equals = $roleOne->equals($roleTwo);

        // assert
        $this->assertTrue($equals);
    }

    public function testEquals_CompareTwoCustomerUserRoles_ReturnsTrue(): void
    {
        // arrange
        $roleOne = UserRole::customer();
        $roleTwo = UserRole::customer();

        // act
        $equals = $roleOne->equals($roleTwo);

        // assert
        $this->assertTrue($equals);
    }

    /**
     * @dataProvider validRolesProvider
     *
     * @param string $roleAsString
     */
    public function testFromString_HaveValidRoleAsString_RoleIsCreatedSuccessfully(string $roleAsString): void
    {
        // act
        $role = UserRole::fromString($roleAsString);

        // assert
        $this->assertSame($roleAsString, (string)$role);
    }

    /**
     * @dataProvider invalidRolesProvider
     *
     * @param string $roleAsString
     */
    public function testFromString_HaveInvalidRoleAsString_ThrowsException(string $roleAsString): void
    {
        // assert
        $this->expectException(UnsupportedUserRole::class);

        // act
        UserRole::fromString($roleAsString);
    }

    public function validRolesProvider(): array
    {
        return [
            ['admin'],
            ['customer']
        ];
    }

    public function invalidRolesProvider(): array
    {
        return [
            ['manager'],
            ['accountant']
        ];
    }
}