<?php
declare(strict_types=1);

namespace App\Models;

use App\Exceptions\UnsupportedAccountType;

final class AccountType
{
    private const ADMIN = 'admin';
    private const CUSTOMER = 'customer';

    private string $accountType;

    private function __construct(string $accountType)
    {
        $this->accountType = $accountType;
    }

    /**
     * @param string $accountType
     * @return AccountType
     * @throws UnsupportedAccountType
     */
    public static function fromString(string $accountType): AccountType
    {
        switch ($accountType) {
            case self::ADMIN:
                return new self(self::ADMIN);
                break;

            case self::CUSTOMER:
                return new self(self::CUSTOMER);
                break;
        }

        throw UnsupportedAccountType::withAccountType($accountType);
    }

    public function __toString(): string
    {
        return $this->accountType;
    }
}
