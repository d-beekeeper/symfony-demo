<?php

namespace App\Controller;

use App\Commands\ApplyCommand;
use App\Commands\ApplyCommandHandler;
use App\Commands\GenerateVoucherCommand;
use App\Commands\GenerateVoucherCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController
{
    /**
     * @Route("/generate", methods={"POST"})
     */
    public function generate(Request $request, GenerateVoucherCommandHandler $handler)
    {
        $body = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $command = GenerateVoucherCommand::fromJson($body);
        $voucher = $handler($command);
        return new JsonResponse(['code' => $voucher->getCode()]);
    }

    /**
     * @Route("/apply", methods={"POST"})
     */
    public function apply(Request $request, ApplyCommandHandler $handler)
    {
        $body = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $command = ApplyCommand::fromJson($body['items'], $body['code']);
        $discounts = $handler($command);
        $response = ['items' => [], 'code' => $command->getCode()];
        foreach ($discounts as $discount) {
            $response['items'][] = [
                'id' => $discount->getItem()->getId(),
                'price' => $discount->getItem()->getPrice(),
                'price_with_discount' => $discount->getPriceWithDiscount(),
            ];
        }
        return new JsonResponse($response);
    }
}
