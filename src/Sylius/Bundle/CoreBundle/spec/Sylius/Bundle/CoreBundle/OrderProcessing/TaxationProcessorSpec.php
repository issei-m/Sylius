<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\CoreBundle\OrderProcessing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Bundle\CoreBundle\Model\Order;

/**
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class TaxationProcessorSpec extends ObjectBehavior
{
    /**
     * @param Sylius\Component\Resource\Repository\RepositoryInterface    $adjustmentRepository
     * @param Sylius\Component\Taxation\Calculator\CalculatorInterface    $calculator
     * @param Sylius\Component\Taxation\Resolver\TaxRateResolverInterface $taxRateResolver
     * @param Sylius\Component\Addressing\Matcher\ZoneMatcherInterface    $zoneMatcher
     * @param Sylius\Component\Setting\Model\Settings                     $taxationSettings
     */
    function let($adjustmentRepository, $calculator, $taxRateResolver, $zoneMatcher, $taxationSettings)
    {
        $this->beConstructedWith($adjustmentRepository, $calculator, $taxRateResolver, $zoneMatcher, $taxationSettings);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\CoreBundle\OrderProcessing\TaxationProcessor');
    }

    function it_implements_Sylius_taxation_processor_interface()
    {
        $this->shouldImplement('Sylius\Bundle\CoreBundle\OrderProcessing\TaxationProcessorInterface');
    }

    /**
     * @param Sylius\Bundle\CoreBundle\Model\OrderInterface $order
     */
    function it_doesnt_apply_any_taxes_if_order_has_no_items($order)
    {
        $order->getItems()->willReturn(array());
        $order->removeTaxAdjustments()->shouldBeCalled();
        $order->addAdjustment(Argument::any())->shouldNotBeCalled();

        $this->applyTaxes($order);
    }

    /**
     * @param Sylius\Bundle\CoreBundle\Model\OrderInterface $order
     */
    function it_removes_existing_tax_adjustments($order)
    {
        $order->getItems()->willReturn(array());
        $order->removeTaxAdjustments()->shouldBeCalled();

        $this->applyTaxes($order);
    }
}
