<?php

namespace App\Services\Web\Classes;

use App\Services\Web\Exceptions\NotValidDomain;
use Illuminate\Support\Collection;
use App\Services\Web\Exceptions\UnableToParseDomain;

class BaseParser
{
    /**
     * Check if the Domain is Valid By Checking the DNS
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   string $urlOfDomain
     * @return  bool
     * @throws NotValidDomain
     **/
    protected function isValidDomain($urlOfDomain)
    {
        if (checkdnsrr( $urlOfDomain, 'ANY')) {
            return true;
        } else {
            throw new NotValidDomain("{$urlOfDomain} There is No Such Domain", 1);
        }
    }

    /**
     * @author       Manojkiran.A <manojkiran10031998@gmail.com>
     * @param        string  $urlWithLink
     * @version      1.0
     * @return string|null
     **/
    protected  function getDomainName($urlWithLink)
    {
        $strToLower = strtolower(trim($urlWithLink));
        //remove http from url
        $httpPregReplace = preg_replace('/^http:\/\//i', '', $strToLower);
        //remove https from url
        $httpsPregReplace = preg_replace('/^https:\/\//i', '', $httpPregReplace);
        //remove wwww from url
        $wwwPregReplace = preg_replace('/^www\./i', '', $httpsPregReplace);
        //exploding the url to array with /
        $explodeToArray = explode('/', $wwwPregReplace);
        //trimming the array and get the first part of array
        $finalDomainName = trim($explodeToArray[0]);

        if ( $finalDomainName === '' || $finalDomainName === null ) {
            throw new UnableToParseDomain("Unable To Parse the Url or Domain", 1);
        } elseif( checkdnsrr($finalDomainName, 'ANY')) {
            return $finalDomainName;
        }else {
            throw new NotValidDomain("{$finalDomainName} There is No Such Domain", 1);
        }
    }

    /**
     * Returns the new Collection instance
     *
     * @param array|mixed $value
     * @return Collection
     **/
    protected function asNewCollection($value)
    {
        return (new Collection($value));
    }

    /**
     * Explode the String on the Multiple Patterns
     *
     *
     * @param array|string $splitOn
     * @param array|string $searchTerm
     * @return array
     **/
    public function multiExploder( $splitOn, $searchTerm)
    {
        return explode(chr(1), str_replace($splitOn, chr(1), $searchTerm));
    }
}
