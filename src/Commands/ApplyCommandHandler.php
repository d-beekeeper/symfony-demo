<?php

namespace App\Commands;

use App\Entity\Voucher;
use Doctrine\Persistence\ManagerRegistry;

class ApplyCommandHandler
{
    protected ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function __invoke(ApplyCommand $command)
    {
        $voucher = $this->doctrine->getRepository(Voucher::class)->findOneBy(['code' => $command->getCode()]);
        if (!$voucher) {
            throw new \Exception('specified voucher not found!');
        }
        return $command->getItems()->calculateDiscounts($voucher->getDiscount());
    }
}
