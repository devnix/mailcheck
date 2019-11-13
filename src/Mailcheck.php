<?php

namespace Devnix\Mailcheck;

use Devnix\Mailcheck\Dictionary\DictionaryInterface;
use Devnix\Mailcheck\Dictionary\Standard;

class Mailcheck
{
    /**
     * @var DictionaryInterface
     */
    protected $dictionary;

    public function __construct(DictionaryInterface $dictionary = null)
    {
        if (empty($dictionary)) {
            $dictionary = new Standard();
        }

        $this->setDictionary($dictionary);
    }

    /**
     * @return DictionaryInterface
     */
    public function getDictionary()
    {
        return $this->dictionary;
    }

    /**
     * @return self
     */
    public function setDictionary(DictionaryInterface $dictionary)
    {
        $this->dictionary = $dictionary;

        return $this;
    }

    /**
     * Return an array of suggestions ordered by similarity.
     *
     * @param string $email     Email address
     * @param int    $limit     Limiting the result
     * @param int    $threshold Distance limit for the algorithm
     *
     * @return array
     */
    public function suggest(string $email, int $limit = 5, int $threshold = 3)
    {
        $suggestions = [];

        $parsedEmail = new Email($email);

        // If a domain suggestion is found use it
        $suggestionDomain = $this->findSuggestions($parsedEmail->getDomain(), $this->getDictionary()->getProviders(), $threshold);

        if (!empty($suggestionDomain)) {
            foreach ($suggestionDomain as $domain) {
                $suggestions[] = $parsedEmail->getLocal().'@'.$domain;
            }
        } else {
            // If not, try to suggest a TLD
            $parsedDomain = $parsedEmail->getDomain();

            // If there is not any suffix don't return suggestions
            if (empty($parsedDomain->getSuffix())) {
                return [];
            }

            $suggestionTld = $this->findSuggestions($parsedDomain->getSuffix(), $this->getDictionary()->getTlds(), $threshold);

            if (false !== $suggestionTld) {
                foreach ($suggestionTld as $tld) {
                    // FIXME: poner el punto sólo si hay subdominio
                    $suggestions[] = $parsedEmail->getLocal().'@'.$parsedDomain->getDomainWithoutSuffix().'.'.$tld;
                }
            }
        }

        if (empty($suggestions)) {
            return [];
        }

        return array_slice($suggestions, 0, $limit);
    }

    /**
     * Return the most accurate suggestion.
     *
     * @param string $email     Email address
     * @param int    $threshold Distance limit for the algorithm
     *
     * @return string|null
     */
    public function suggestOne(string $email, int $threshold = 3)
    {
        $return = $this->suggest($email, $threshold, 1);

        if (empty($return)) {
            return null;
        }

        return $return[0];
    }

    /**
     * @return array|bool
     */
    protected function findSuggestions(string $word, ParameterBag $list, int $threshold)
    {
        $ordered = [];

        // Levenshtein phase
        foreach ($list as $value) {
            $distance = levenshtein($word, $value);

            if (0 == $distance) {
                return [];
            }

            if ($distance <= $threshold) {
                $ordered[$distance][] = $value;
            }
        }

        return $this->sortFilteredSuggestions($ordered);
    }

    /**
     * @param array[] $filteredSuggestions
     *
     * @return array
     */
    protected function sortFilteredSuggestions(array $filteredSuggestions)
    {
        $result = [];

        ksort($filteredSuggestions);

        foreach ($filteredSuggestions as $suggestions) {
            foreach ($suggestions as $suggestion) {
                $result[] = $suggestion;
            }
        }

        return $result;
    }
}
