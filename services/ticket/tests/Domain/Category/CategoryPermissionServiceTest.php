<?php
declare(strict_types=1);

namespace Ticket\Tests\Domain\Category;

use PHPUnit\Framework\TestCase;
use Ticket\Domain\Category\CategoryPermissionService;
use Ticket\Tests\Support\MotherObject\Domain\User\UserMother;

class CategoryPermissionServiceTest extends TestCase
{
    public function testCanUserManageCategory_UserIsAnAdmin_ReturnsTrue(): void
    {
        // arrange
        $user = UserMother::createAdmin();
        $permissionService = $this->categoryPermissionService();

        // act
        $canUserManageCategory = $permissionService->canUserManageCategory($user);

        // assert
        $this->assertTrue($canUserManageCategory);
    }

    public function testCanUserManageCategory_UserIsNotAnAdmin_ReturnsFalse(): void
    {
        // arrange
        $user = UserMother::createCustomer();
        $permissionService = $this->categoryPermissionService();

        // act
        $canUserManageCategory = $permissionService->canUserManageCategory($user);

        // assert
        $this->assertFalse($canUserManageCategory);
    }

    private function categoryPermissionService(): CategoryPermissionService
    {
        return new CategoryPermissionService();
    }
}