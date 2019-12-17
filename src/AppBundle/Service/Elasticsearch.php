<?php

namespace AppBundle\Service;

use Elastica\Query\Match;
use Elastica\Query\MultiMatch;
use Elastica\Query\BoolQuery;
use Elastica\Query\Range;
use Elastica\Query\Nested;
use FOS\ElasticaBundle\Finder\FinderInterface;

class Elasticsearch
{
    const MIN_CHAR_MDR_CATEGORIE = 3;
    const LIMIT_MDR_CATEGORIE = 10;

    private $finderProject;

    public function __construct(FinderInterface $finderProject)
    {
        $this->finderProject = $finderProject;
    }


    public function getQueryForSearch($search, $date_filter, $user_filter, $icheck_filter)
    {
        $boolQuery = new BoolQuery();
        $fieldQuery = new Match();
        $multiFieldQuery = new MultiMatch();

        $multiFieldQuery->setQuery($search);
        $multiFieldQuery->setFields(['name', 'longname']);

        if( empty($search) )
            $multiFieldQuery->setZeroTermsQuery(\Elastica\Query\MultiMatch::ZERO_TERM_ALL);

        $boolQuery->addShould($multiFieldQuery);
        $boolQuery->addMust($multiFieldQuery);

        if( !empty($icheck_filter) ) {
            $fieldQuery->setFieldQuery('manager.id', $user_filter);

            $nestedManagerQuery = new Nested();
            $nestedManagerQuery->setPath('manager');
            $nestedManagerQuery->setQuery($fieldQuery);

            $boolQuery->addShould($nestedManagerQuery);
            $boolQuery->addMust($nestedManagerQuery);
        }

        if( !empty($date_filter) && null !== $date_filter ) {
            $rangeQuery = new Range();
            $date_range = explode(' - ', $date_filter);
            $dateFrom = new \DateTime($date_range[0]);
            $dateTo = new \DateTime($date_range[1]);

            $rangeQuery->addField('createdAt',
                array(
                    'gte' => \Elastica\Util::convertDateTimeObject($dateFrom, true),
                    'lte' => \Elastica\Util::convertDateTimeObject($dateTo, true)
                ));
            $boolQuery->addShould($rangeQuery);
            $boolQuery->addMust($rangeQuery);
        }

        return $boolQuery;
    }
    /**
     * @param string $search Valeur recherchée
     *
     * @return Project[]
     */
    public function searchProject($search, $date_filter, $user_filter, $icheck_filter)
    {
        $query  = $this->getQueryForSearch($search, $date_filter, $user_filter, $icheck_filter);//echo '<pre>';print_r($query);die;

        return $this->finderProject->find($query);
    }
}
