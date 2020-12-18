<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Voucher
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $discount;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected string $code;

    public static function generate(int $discount)
    {
        $code = self::generateCode(7);
        return new self($discount, $code);
    }

    public function __construct(int $discount, string $code)
    {
        $this->discount = $discount;
        $this->code = $code;
    }

    public function getDiscount(): int
    {
        return $this->discount;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getId()
    {
        return $this->id;
    }

    protected static function generateCode(int $length): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $length; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }
}
