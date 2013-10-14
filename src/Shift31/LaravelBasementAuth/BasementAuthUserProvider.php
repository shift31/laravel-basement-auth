<?php namespace Shift31\LaravelBasementAuth;

use Illuminate\Auth;
use Hash;
use Cb;

/**
 * Class to build array to send to GenericUser
 * This allows the fields in the array to be
 * accessed through the Auth::user() method
 */
class BasementAuthUserProvider implements Auth\UserProviderInterface
{

    /**
     * Retrieve a user by their unique idenetifier.
     *
     * @param  mixed  $identifier
     * @return Auth\GenericUser|null
     */
    public function retrieveByID($identifier)
    {
        $options['doc'] = Cb::findByKey($identifier, array('first' => true))->doc();
        return new BasementUser($options);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return Auth\GenericUser|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $arrayQuery = array(
            'reduce' => 'false',
            'include_docs' => 'true',
            'key' => $credentials['username']
        );
        $documents = Cb::findByView('user', 'byUsername', $arrayQuery)->get();

        $options['doc'] = $documents[0]->doc();
        return new BasementUser($options);
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  Auth\UserInterface  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(Auth\UserInterface $user, array $credentials)
    {
        return Hash::check($credentials['password'], $user->getAuthPassword());
    }

}
