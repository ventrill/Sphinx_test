<?php

class SphinxSearch
{
    private $_sphinx;
    private $_config;

    private $_ready = FALSE;

    public function __construct()
    {
        if( class_exists('SphinxClient') !== FALSE ) {

            //Sphinx configuration
            $this->_config = array(
                'host' => 'localhost',
                'port' => 9312,
                'max_results' => 100
            );

            /*
            * PHP Sphinx - PECL package
            * @link 	http://pecl.php.net/package/sphinx
            * @link 	https://gist.github.com/3824335
            * @link 	http://us3.php.net/sphinx
            */
            $this->_sphinx = new SphinxClient();

            $this->_sphinx->setServer($this->_config['host'], $this->_config['port']);

            $this->_sphinx->setMatchMode(SPH_MATCH_ANY);
            $this->_sphinx->setMaxQueryTime(3);

            $this->_status = $this->_sphinx->status();
        }
    }

    /**
     * Search sphinx indeces
     *
     * @param string 	 The search query
     * @param string 	 The index to search. Use constants
     * @param string 	 Wild cards - '*$query' vs '$query*' vs '*$query*' - Similar to LIKE search in mysql. Use constants.
     * @param int 		 Limit of results. Max of max_results config
     * @param int 		 Offset, for pagination in conjunction with limit
     * @return array|bool Array of results, or FALSE
     */
    public function search($query, $index='*', $star=self::SPHINX_STAR_BOTH, $limit=20, $offset=0, $filters=FALSE) {

        if( $this->isReady() === FALSE )
        {
            return FALSE;
        }

        /*
        * Pagination, with required max_results from config
        * @link 	http://stage2.sphinxsearch.com/docs/2.0.4/api-func-setlimits.html
        * @link 	http://us2.php.net/manual/en/sphinxclient.setlimits.php
        */
//        $this->_sphinx->setLimits($offset, $limit, $this->_config['max_results']);

        /*
        * Filters 	(Note that $filter[values] should be an array)
        * @link 	http://sphinxsearch.com/docs/2.0.4/api-func-setfilter.html
        * @link 	http://us2.php.net/manual/en/sphinxclient.setfilter.php
        */
//        if( is_array($filters) )
//        {
//            foreach( $filters as $filter )
//            {
//                $exclude = isset($filter['exclude']) ? $filter['exclude'] : FALSE;
//                $this->_sphinx->setFilter($filter['attribute'], $filter['values'], $exclude);
//            }
//        }

        //$this->_sphinx->SetSelect("post_id, post_type_id, user_identity_id");

        //Ensure proper index used
//        switch( $index ) {
//
//            case self::SPHINX_INDEX_USERS :
//                $this->_index = self::SPHINX_INDEX_USERS;
//                break;
//
//            case self::SPHINX_INDEX_POSTS :
//                $this->_index = self::SPHINX_INDEX_POSTS;
//                break;
//
//            default :
//                $this->_index = '*';
//                break;
//
//        }

        $this->_results = FALSE; //fallback
//        $this->_raw_results = $this->_sphinx->query($query, $this->_index);
        $this->_raw_results = $this->_sphinx->query($query);

        dump_var($this->_raw_results);

        if( $this->_raw_results ) {

            //Make a more sensible (for our data) return array
            $this->_results = $this->processResults($this->_raw_results);

        }

        return $this->_results;

    }

    /**
     * Create a more sensible return object
     *
     * @param array 	Results array from SphinxClient::query() call
     * @return array Result attr items for each result (aka the data we care about)
     */
    private function processResults($results) {

        if( $results['error'] != '' || isset($results['matches']) !== TRUE )
        {
            return FALSE;
        }

        $processed = array();

        //Only grab the important data
        foreach( $results['matches'] as $match )
        {
            $processed[] = $match['attrs'];
        }
        return $processed;
    }

    /**
     * Test if Sphinx is connected
     *
     * @return bool If Sphinx status is OK
     */
    public function isReady()
    {
        if( $this->_status === FALSE )
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }



} 