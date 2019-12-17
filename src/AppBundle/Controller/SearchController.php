<?php

namespace AppBundle\Controller;

use AppBundle\Service\Elasticsearch;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/**
 * Search controller.
 *
 * @Route("search")
 */
class SearchController extends Controller
{
    /**
     * search index.
     *
     * @Route("/", name="search_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('search/index.html.twig');
    }

    /**
     *
     * @param String $search
     * @param String $date_filter
     */
    public function searchProjectFormAction($search = null, $date_filter = null, $icheck_filter = null)
    {
        $params = array();
        if( null !== $search && null !== $date_filter )
            $params = array('search' => ($search == 'Tous')? '' : $search, 'date_filter' => $date_filter, 'icheck_filter' => $icheck_filter);

        //Get Typologie AND Technologie Tags
        $em = $this->getDoctrine()->getManager();
        $params['typologie'] = $em->getRepository('AppBundle:TypologieTag')->findAll();
        $params['technologie'] = $em->getRepository('AppBundle:TechnologieTag')->findAll();

        return $this->render(':search:search-form.html.twig', $params);
    }

    /**
     * @Route("/projects", name="search_project")
     * @Method("GET")
     *
     * @param Request $request Instance de Request
     *
     * @return JsonResponse
     */
    public function searchAction(Request $request)
    {
        $search_service = $this->get('app.elastic_search');
        $search = $request->query->get('search', 'all');
        $date_filter = $request->query->get('date_filter', '');
        $user_filter = $request->query->get('user_id', '');
        $icheck_filter = $request->query->get('icheck_user', '');

        $projects = $search_service->searchProject($search, $date_filter, $user_filter, $icheck_filter);

        // Creating pagnination
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $projects,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render(':search:search-list.html.twig', array(
            'projects' => $pagination,
            'search' => empty($search)? 'Tous' : $search,
            'date_filter' => $date_filter,
            'icheck_filter' => $icheck_filter
        ));
    }
}
