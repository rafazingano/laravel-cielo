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
use Illuminate\Support\Facades\Config;

class CieloService
{

    private $environment;
    private $merchant;
    private $cardNumber;
    private $expirationDate;
    private $brand;
    private $paymentValue;
    private $paymentType;
    private $securityCode;
    private $holder;
    private $saveCard;
    private $creditCard;
    private $cardToken;
    private $customerName;
    private $recurrentPayment;
    private $recurrentPaymentInterval;
    private $returnUrl;
    private $user;
    private $orderCode;

    private $identity;
    private $identityType;
    private $addressZipCode;
    private $addressCountry;
    private $addressState;
    private $addressCity;
    private $addressDistrict;
    private $addressStreet;
    private $addressNumber;
    private $boletoNumber;
    private $assignor;
    private $demonstrative;
    private $identification;
    private $instructions;

    public function __construct()
    {
        $this->environment = Config::get('app.env') == 'production' ?
            Environment::production() :
            Environment::sandbox();
        $this->merchant = new Merchant(
            Config::get('cw_cielo.merchant_id'),
            Config::get('cw_cielo.merchant_key')
        );
    }

    /**
     * @return Merchant
     */
    public function getMerchant(): Merchant
    {
        return $this->merchant;
    }

    /**
     * @param Merchant $merchant
     */
    public function setMerchant(Merchant $merchant)
    {
        $this->merchant = $merchant;
        return $this;
    }

    /**
     * @return Environment
     */
    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    /**
     * @param Environment $environment
     */
    public function setEnvironment(Environment $environment)
    {
        $this->environment = $environment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @param mixed $identity
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdentityType()
    {
        return $this->identityType;
    }

    /**
     * @param mixed $identityType
     */
    public function setIdentityType($identityType)
    {
        $this->identityType = $identityType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressZipCode()
    {
        return $this->addressZipCode;
    }

    /**
     * @param mixed $addressZipCode
     */
    public function setAddressZipCode($addressZipCode)
    {
        $this->addressZipCode = $addressZipCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressCountry()
    {
        return $this->addressCountry;
    }

    /**
     * @param mixed $addressCountry
     */
    public function setAddressCountry($addressCountry)
    {
        $this->addressCountry = $addressCountry;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressState()
    {
        return $this->addressState;
    }

    /**
     * @param mixed $addressState
     */
    public function setAddressState($addressState)
    {
        $this->addressState = $addressState;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressCity()
    {
        return $this->addressCity;
    }

    /**
     * @param mixed $addressCity
     */
    public function setAddressCity($addressCity)
    {
        $this->addressCity = $addressCity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressDistrict()
    {
        return $this->addressDistrict;
    }

    /**
     * @param mixed $addressDistrict
     */
    public function setAddressDistrict($addressDistrict)
    {
        $this->addressDistrict = $addressDistrict;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressStreet()
    {
        return $this->addressStreet;
    }

    /**
     * @param mixed $addressStreet
     */
    public function setAddressStreet($addressStreet)
    {
        $this->addressStreet = $addressStreet;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressNumber()
    {
        return $this->addressNumber;
    }

    /**
     * @param mixed $addressNumber
     */
    public function setAddressNumber($addressNumber)
    {
        $this->addressNumber = $addressNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBoletoNumber()
    {
        return $this->boletoNumber;
    }

    /**
     * @param mixed $boletoNumber
     */
    public function setBoletoNumber($boletoNumber)
    {
        $this->boletoNumber = $boletoNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAssignor()
    {
        return $this->assignor;
    }

    /**
     * @param mixed $assignor
     */
    public function setAssignor($assignor)
    {
        $this->assignor = $assignor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDemonstrative()
    {
        return $this->demonstrative;
    }

    /**
     * @param mixed $demonstrative
     */
    public function setDemonstrative($demonstrative)
    {
        $this->demonstrative = $demonstrative;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * @param mixed $identification
     */
    public function setIdentification($identification)
    {
        $this->identification = $identification;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * @param mixed $instructions
     */
    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * @param mixed $returnUrl
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRecurrentPayment()
    {
        return $this->recurrentPayment;
    }

    /**
     * @param mixed $recurrentPayment
     */
    public function setRecurrentPayment($recurrentPayment)
    {
        $this->recurrentPayment = $recurrentPayment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRecurrentPaymentInterval()
    {
        return $this->recurrentPaymentInterval;
    }

    /**
     * @param mixed $recurrentPaymentInterval
     */
    public function setRecurrentPaymentInterval($recurrentPaymentInterval)
    {
        $this->recurrentPaymentInterval = $recurrentPaymentInterval;
        return $this;
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

    public function hasCardToken()
    {
        return isset($this->cardToken);
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
        return $this->saveCard ?? false;
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
    public function getOrderCode()
    {
        return $this->orderCode;
    }

    /**
     * @param mixed $orderCode
     */
    public function setOrderCode($orderCode)
    {
        $this->orderCode = $orderCode;
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
    public function getPaymentValue()
    {
        return $this->paymentValue;
    }

    /**
     * @param mixed $paymentValue
     */
    public function setPaymentValue($paymentValue)
    {
        $this->paymentValue = $paymentValue;
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

    public function payment()
    {
        switch ($this->getPaymentType()) {
            case 'boleto':
                return $this->boletoPayment();
                break;
            case 'debitcard':
                return $this->debitCardPayment();
                break;
            case 'creditcard':
                return $this->creditCardPayment();
                break;
            default:
                return $this->creditCardPayment();
        }
    }

    /**
     * Criando uma venda com Boleto
     * @return array
     */
    public function boletoPayment()
    {
        $sale = new Sale($this->getOrderCode());
        $customer = $sale->customer($this->getCustomerName())
            ->setIdentity($this->getIdentity())
            ->setIdentityType($this->getIdentityType())
            ->address()
            ->setZipCode($this->getAddressZipCode())
            ->setCountry($this->getAddressCountry())
            ->setState($this->getAddressState())
            ->setCity($this->getAddressCity())
            ->setDistrict($this->getAddressDistrict())
            ->setStreet($this->getAddressStreet())
            ->setNumber($this->getAddressNumber());
        $payment = $sale->payment($this->getPaymentValue())
            ->setType(Payment::PAYMENTTYPE_BOLETO)
            ->setAddress($this->getAddressStreet())
            ->setBoletoNumber($this->getBoletoNumber())
            ->setAssignor($this->getAssignor())
            ->setDemonstrative($this->getDemonstrative())
            ->setExpirationDate($this->getExpirationDate())
            ->setIdentification($this->getIdentification())
            ->setInstructions($this->getInstructions());
        try {
            $sale = (new CieloEcommerce($this->getMerchant(), $this->getEnvironment()))->createSale($sale);
            $paymentId = $sale->getPayment()->getPaymentId();
            $boletoURL = $sale->getPayment()->getUrl();
            return [
                'error' => false,
                'paymentId' => $paymentId,
                'boletoURL' => $boletoURL,
                'return' => $sale
            ];
        } catch (CieloRequestException $e) {
            return $this->errorReturn($e->getCieloError());
        }
    }

    /**
     * Criando transações com cartão de débito
     * @return array
     */
    public function debitCardPayment()
    {
        $sale = new Sale($this->getOrderCode());
        $customer = $sale->customer($this->getCustomerName());
        $payment = $sale->payment($this->getPaymentValue());
        $payment->setReturnUrl($this->getReturnUrl());
        $payment->debitCard($this->getSecurityCode(), $this->getBrand())
            ->setExpirationDate($this->getExpirationDate())
            ->setCardNumber($this->getCardNumber())
            ->setHolder($this->getHolder());
        try {
            $sale = (new CieloEcommerce($this->getMerchant(), $this->getEnvironment()))->createSale($sale);
            $paymentId = $sale->getPayment()->getPaymentId();
            $authenticationUrl = $sale->getPayment()->getAuthenticationUrl();
            return [
                'error' => false,
                'paymentId' => $paymentId,
                'authenticationUrl' => $authenticationUrl,
                'return' => $sale
            ];
        } catch (CieloRequestException $e) {
            return $this->errorReturn($e->getCieloError());
        }
    }

    /**
     * Criando um pagamento com cartão de crédito
     * Criando um pagamento e gerando o token do cartão de crédito
     * Criando um pagamento com cartão de crédito tokenizado
     * Criando um pagamento recorrente
     * Normal: Precisa de todos os dados do cartão
     * Tokenizado: "CardToken", "SecurityCode" e "Brand"
     * Recorrente: "getRecurrentPayment" e "getRecurrentPaymentInterval"
     * getOrderCode
     * getCustomerName
     * getPaymentValue
     * getSecurityCode
     * getBrand
     * getCardToken
     * getExpirationDate
     * getCardNumber
     * getHolder
     * getSaveCard
     * getRecurrentPayment
     * getRecurrentPaymentInterval
     * @return array
     */
    public function creditCardPayment()
    {
        $sale = new Sale($this->getOrderCode());
        $customer = $sale->customer($this->getCustomerName());
        $payment = $sale->payment($this->getPaymentValue());
        $payment = $payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
            ->creditCard($this->getSecurityCode(), $this->getBrand());
        if ($this->hasCardToken()) {
            $payment = $payment->setCardToken($this->getCardToken());
        } else {
            $payment = $payment->setExpirationDate($this->getExpirationDate())
                ->setCardNumber($this->getCardNumber())
                ->setHolder($this->getHolder())
                ->setSaveCard($this->getSaveCard());
        }
        if ($this->getRecurrentPayment()) {
            $payment = $payment->recurrentPayment($this->getRecurrentPayment())
                ->setInterval($this->getRecurrentPaymentInterval());
        }
        try {
            $sale = (new CieloEcommerce($this->getMerchant(), $this->getEnvironment()))->createSale($sale);
            $paymentId = $sale->getPayment()->getPaymentId();
            $cardToken = ($this->getSaveCard()) ? $sale->getPayment()->getCreditCard()->getCardToken() : NULL;
            $type = $sale->getPayment()->getType();
            $returnCode = $sale->getPayment()->getReturnCode();
            $returnMessage = $sale->getPayment()->getReturnMessage();
            return [
                'error' => !in_array($returnCode, [4, 6]),
                'paymentId' => $paymentId,
                'cardToken' => $cardToken,
                'return' => $sale,
                'type' => $type,
                'returnCode' => $returnCode,
                'returnMessage' => $returnMessage
            ];
        } catch (CieloRequestException $e) {
            return $this->errorReturn($e->getCieloError());
        }
    }

    /**
     * Tokenizando um cartão
     * @return array
     */
    public function tokenizeCard()
    {
        $card = new CreditCard();
        $card->setCustomerName($this->getCustomerName());
        $card->setCardNumber($this->getCardNumber());
        $card->setHolder($this->getHolder());
        $card->setExpirationDate($this->getExpirationDate());
        $card->setBrand($this->getBrand());
        try {
            $card = (new CieloEcommerce($this->getMerchant(), $this->getEnvironment()))->tokenizeCard($card);
            $cardToken = $card->getCardToken();
            return [
                'error' => false,
                'cardToken' => $cardToken,
                'return' => $card
            ];
        } catch (CieloRequestException $e) {
            return $this->errorReturn($e->getCieloError());
        }
    }

    /**
     * @param $error
     * @return array
     */
    function errorReturn($error)
    {
        return [
            'error' => true,
            'code' => isset($error) ? $error->getCode() : NULL,
            'message' => isset($error) ? $error->getMessage() : NULL
        ];
    }

    public function listCreditCardBrands()
    {
        return collect([
            CreditCard::AMEX => CreditCard::AMEX,
            CreditCard::AURA => CreditCard::AURA,
            CreditCard::DINERS => CreditCard::DINERS,
            CreditCard::DISCOVER => CreditCard::DISCOVER,
            CreditCard::ELO => CreditCard::ELO,
            CreditCard::HIPERCARD => CreditCard::HIPERCARD,
            CreditCard::JCB => CreditCard::JCB,
            CreditCard::MASTERCARD => CreditCard::MASTERCARD,
            CreditCard::VISA => CreditCard::VISA,
        ]);
    }

}
