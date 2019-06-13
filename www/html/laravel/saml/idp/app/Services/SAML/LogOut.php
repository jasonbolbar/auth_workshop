<?php


namespace App\Services\SAML;


use LightSaml\Model\Assertion\Issuer;
use LightSaml\Model\Protocol\LogoutResponse;
use LightSaml\Helper as SamlHelper;
use LightSaml\Model\Protocol\Status;
use LightSaml\Model\Protocol\StatusCode;
use LightSaml\SamlConstants;
use LightSaml\Binding\BindingFactory;
use LightSaml\Context\Profile\MessageContext;

class LogOut
{

    public static function doLogout(string $destination)
    {
        $response = new LogoutResponse();
        $response->setID(SamlHelper::generateID());
        $response->setDestination($destination);
        $response->setStatus(new Status(new StatusCode(SamlConstants::STATUS_SUCCESS)));
        $response->setIssuer(new Issuer(str_replace('https://','',config('app.url'))));
        $response->setIssueInstant(new \DateTime());
        $bindingFactory = new BindingFactory();
        $postBinding = $bindingFactory->create(SamlConstants::BINDING_SAML2_HTTP_REDIRECT);
        $messageContext = new MessageContext();
        $messageContext->setMessage($response)->asResponse();
        return $postBinding->send($messageContext);
    }

}