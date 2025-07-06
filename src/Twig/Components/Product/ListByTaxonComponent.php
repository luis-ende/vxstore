<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);


namespace App\Twig\Components\Product;

use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Sylius\TwigHooks\Twig\Component\HookableComponentTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsTwigComponent]
class ListByTaxonComponent
{
    use HookableComponentTrait;

    public const DEFAULT_LIMIT = 8;

    public int $limit = self::DEFAULT_LIMIT;

    /** @param ProductRepositoryInterface<ProductInterface> $productRepository */
    public function __construct(
        protected readonly TaxonRepositoryInterface $taxonRepository,
        protected readonly ProductRepositoryInterface $productRepository,
        protected readonly LocaleContextInterface     $localeContext,
        protected readonly ChannelContextInterface    $channelContext,
    )
    {
    }

    /**
     * @return array<ProductInterface>
     */
    #[ExposeInTemplate(name: 'latest_products')]
    public function getLatestProducts(): array
    {
        $taxon = $this->taxonRepository->findOneBy([
            'code' => 'final_fantasy',
        ]);

        return $this->productRepository->findByTaxon($taxon);
    }
}
