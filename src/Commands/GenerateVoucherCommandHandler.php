<?php

namespace App\Commands;

use App\Entity\Voucher;
use Doctrine\Persistence\ManagerRegistry;

class GenerateVoucherCommandHandler
{
    protected ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function __invoke(GenerateVoucherCommand $command): Voucher
    {
        $voucher = Voucher::generate($command->getDiscount());
        $em = $this->doctrine->getManager();
        $em->persist($voucher);
        $em->flush();
        return $voucher;
    }
}
