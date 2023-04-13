<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Application\UseCase\CalculateCommission\BinProvider;

final class BinListNetProvider implements BinProvider
{
    // todo in future could be moved to some AbstractBinProvider to implement common things
    private string $url = 'https://lookup.binlist.net/';

    public function getCountry(int $bin): string
    {
        $bin = file_get_contents(sprintf('%s%d', $this->url, $bin));

        if (!$bin) {
            throw new BinNotFoundException();
        }

        $bin = json_decode($bin);

        return $bin->country->alpha2;
    }
}