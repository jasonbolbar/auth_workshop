<?php

namespace App\Listeners;

use Aacotroneo\Saml2\Events\Saml2LoginEvent;
use App\User;
use Illuminate\Support\Facades\Auth;

class Saml2LoginListener
{

    /**
     * Handle the event.
     *
     * @param  Saml2LoginEvent  $event
     * @return void
     */
    public function handle(Saml2LoginEvent $event)
    {
        $user = $event->getSaml2User();
        $userData = [
            'id' => $user->getUserId(),
            'attributes' => $user->getAttributes(),
            'assertion' => $user->getRawSamlAssertion()
        ];
        $laravelUser = User::firstOrCreate($this->parseAttributes($userData['attributes']));
        //if it does not exist create it and go on  or show an error message
        Auth::login($laravelUser);
    }

    private function parseAttributes(array $attributes)
    {
        return [
            'name' => $attributes["http://schemas.xmlsoap.org/claims/CommonName"][0],
            'email' => $attributes["http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress"][0]
        ];
    }
}
