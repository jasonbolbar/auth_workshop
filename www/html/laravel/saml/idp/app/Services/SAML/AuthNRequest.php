<?php


namespace App\Services\SAML;


use Illuminate\Http\Request;
use LightSaml\Model\Context\DeserializationContext;
use LightSaml\Model\Protocol\AuthnRequest as LightSamlAuthNRequest;
use LightSaml\Credential\{X509Certificate, KeyHelper};
use LightSaml\Model\Protocol\Response as LightSamlResponse;
use \LightSaml\Model\Assertion\{
    Assertion,
    Attribute,
    Issuer,
    Subject,
    NameID,
    SubjectConfirmation,
    SubjectConfirmationData,
    AudienceRestriction,
    Conditions,
    AttributeStatement,
    AuthnStatement,
    AuthnContext
};
use LightSaml\Helper as SamlHelper;
use LightSaml\Model\Protocol\{Status, StatusCode};
use LightSaml\Model\XmlDSig\SignatureWriter;
use Illuminate\Support\Facades\Auth;
use LightSaml\SamlConstants;
use LightSaml\ClaimTypes;
use DateTime;
use Ramsey\Uuid\Generator\RandomBytesGenerator;

class AuthNRequest
{

    public static function handle(Request $request): LightSamlResponse
    {
        if(isset($request['SAMLRequest'])){
            $SAML = $request->SAMLRequest;
            $decoded = base64_decode($SAML);
            $xml = gzinflate($decoded);
            $deserializationContext = new DeserializationContext();
            $deserializationContext->getDocument()->loadXML($xml);

            $authnRequest = new LightSamlAuthNRequest();

            $authnRequest->deserialize($deserializationContext->getDocument()->firstChild, $deserializationContext);

            return self::buildSAMLResponse($authnRequest);
        }
    }

    private static function buildSAMLResponse(LightSamlAuthNRequest $authnRequest): LightSamlResponse
    {
        $destination = $authnRequest->getAssertionConsumerServiceURL();
        $issuer = str_replace('https://','',config('app.url'));
        $cert = storage_path('saml.crt');
        $key = storage_path('saml.key');

        $certificate = X509Certificate::fromFile($cert);
        $privateKey = KeyHelper::createPrivateKey($key, 'password1', true);

        $response = new LightSamlResponse();
        $response
            ->addAssertion($assertion = new Assertion())
            ->setID(SamlHelper::generateID())
            ->setIssueInstant(new DateTime())
            ->setDestination($destination)
            ->setIssuer(new Issuer($issuer))
            ->setStatus(new Status(new StatusCode(SamlConstants::STATUS_SUCCESS)))
            ->setSignature(new SignatureWriter($certificate, $privateKey));
        self::buildAssertion($assertion,$authnRequest, $issuer);
        return $response;
    }

    private static function buildAssertion(Assertion $assertion, LightSamlAuthNRequest $authnRequest, $issuer)
    {
        $email= Auth::user()->email;
        $name = Auth::user()->name;
        $assertion
            ->setId(SamlHelper::generateID())
            ->setIssueInstant(new DateTime())
            ->setIssuer(new Issuer($issuer))
            ->setSubject(
                (new Subject())
                    ->setNameID(new NameID(
                        $email,
                        SamlConstants::NAME_ID_FORMAT_PERSISTENT
                    ))
                    ->addSubjectConfirmation(
                        (new SubjectConfirmation())
                            ->setMethod(SamlConstants::CONFIRMATION_METHOD_BEARER)
                            ->setSubjectConfirmationData(
                                (new SubjectConfirmationData())
                                    ->setInResponseTo($authnRequest->getId())
                                    ->setNotOnOrAfter(new DateTime('+1 MINUTE'))
                                    ->setRecipient($authnRequest->getAssertionConsumerServiceURL())
                            )
                    )
            )
            ->setConditions(
                (new Conditions())
                    ->setNotBefore(new DateTime())
                    ->setNotOnOrAfter(new DateTime('+1 MINUTE'))
                    ->addItem(
                        new AudienceRestriction([$authnRequest->getIssuer()->getValue()])
                    )
            )
            ->addItem(
                (new AttributeStatement())
                    ->addAttribute(new Attribute(
                        ClaimTypes::EMAIL_ADDRESS,
                        $email
                    ))
                    ->addAttribute(new Attribute(
                        ClaimTypes::COMMON_NAME,
                        $name
                    ))
            )
            ->addItem(
                (new AuthnStatement())
                    ->setAuthnInstant(new DateTime('-10 MINUTE'))
                    ->setSessionIndex(base64_encode(app()->make(RandomBytesGenerator::class)->generate(10)))
                    ->setAuthnContext(
                        (new AuthnContext())
                            ->setAuthnContextClassRef(SamlConstants::AUTHN_CONTEXT_PASSWORD_PROTECTED_TRANSPORT)
                    )
            )
        ;
    }


}