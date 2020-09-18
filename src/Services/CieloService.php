<?php

namespace ConfrariaWeb\Cielo\Services;

use App\Models\User;
use Cielo\API30\Merchant;
use Cielo\API30\Ecommerce\Environment;
use Cielo\API30\Ecommerce\CreditCard;
use Cielo\API30\Ecommerce\CieloEcommerce;
use Cielo\API30\Ecommerce\Request\CieloRequestException;
use Cielo\API30\Ecommerce\Sale;
use Cielo\API30\Ecommerce\Payment;
use Illuminate\Support\Str;

class CieloService
{

    private $environment;
    private $merchant;
    private $user;
    private $cardNumber;
    private $expirationDate;
    private $brand;
    private $payment;
    private $paymentType;
    private $securityCode;
    private $holder;
    private $orderId;
    private $saveCard;
    private $creditCard;
    private $cardToken;
    private $customerName;

    public function __construct()
    {
        $this->environment = Environment::sandbox();
        $this->merchant = new Merchant(
            'adbd7c67-fc33-4c86-ac99-a974f5d346d1',
            'RAITRQJHXRPONLFYELALZZWPHHDMRMCJWHPDWTTF'
        );
    }

    /**
     * @return mixed
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * @param mixed $customerName
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardToken()
    {
        return $this->cardToken;
    }

    /**
     * @param mixed $cardToken
     */
    public function setCardToken($cardToken)
    {
        $this->cardToken = $cardToken;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreditCard()
    {
        return $this->creditCard;
    }

    /**
     * @param mixed $creditCard
     */
    public function setCreditCard($creditCard)
    {
        $this->creditCard = $creditCard;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param mixed $paymentType
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSaveCard()
    {
        return $this->saveCard ?? true;
    }

    /**
     * @param mixed $saveCard
     */
    public function setSaveCard($saveCard)
    {
        $this->saveCard = $saveCard;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId?? Str::random(10);
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHolder()
    {
        return $this->holder;
    }

    /**
     * @param mixed $holder
     */
    public function setHolder($holder)
    {
        $this->holder = $holder;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSecurityCode()
    {
        return $this->securityCode;
    }

    /**
     * @param mixed $securityCode
     */
    public function setSecurityCode($securityCode)
    {
        $this->securityCode = $securityCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param mixed $payment
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param mixed $expirationDate
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * @param mixed $cardNumber
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
        return $this;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function createSale()
    {
        $sale = new Sale($this->getOrderId());
        $customer = $sale->customer($this->getUser()->name);
        $payment = $sale->payment($this->getPayment());
        $payment->setType($this->getPaymentType())
            ->creditCard($this->getSecurityCode(), $this->getCreditCard())
            ->setCardToken($this->getCardToken());
        try {
            $sale = (new CieloEcommerce($this->merchant, $this->environment))->createSale($sale);
            $paymentId = $sale->getPayment()->getPaymentId();
            return $sale;
        } catch (CieloRequestException $e) {
            return $e->getCieloError();
        }
    }

    public function tokenizeCard(){
        $card = new CreditCard();
        $card->setCustomerName($this->getUser()->name);
        $card->setCardNumber($this->getCardNumber());
        $card->setHolder($this->getHolder());
        $card->setExpirationDate($this->getExpirationDate());
        $card->setBrand($this->getBrand());
        try {
            $card = (new CieloEcommerce($this->merchant, $this->environment))->tokenizeCard($card);
            return $card->getCardToken();
        } catch (CieloRequestException $e) {
            return $e->getCieloError();
        }
    }

}
