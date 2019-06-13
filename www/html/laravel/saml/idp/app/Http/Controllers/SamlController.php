<?php

namespace App\Http\Controllers;

use App\Services\SAML\AuthNRequest;
use Illuminate\Http\Request;

class SamlController extends Controller
{
    public function login(Request $request)
    {
        $response = AuthNRequest::handle($request);
        $bindingFactory = new \LightSaml\Binding\BindingFactory();
        $postBinding = $bindingFactory->create(\LightSaml\SamlConstants::BINDING_SAML2_HTTP_POST);
        $messageContext = new \LightSaml\Context\Profile\MessageContext();
        $messageContext->setMessage($response)->asResponse();

        /** @var \Symfony\Component\HttpFoundation\Response $httpResponse */
        return $postBinding->send($messageContext);

    }

    public function logout()
    {

    }
}
