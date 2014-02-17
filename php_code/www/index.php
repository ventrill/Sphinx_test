<?php
// http://sphinxsearch.com/docs/current.html

function getSearchResult($results)
{
    $searchResult = array();
    if ( isset($results['matches']) && count($results['matches']) )
    {
        foreach ($results['matches'] as $resultRow)
        {
            if (isset($resultRow['attrs']) && count($resultRow['attrs']))
                $searchResult[] = $resultRow['attrs'];
        }

    }

    return $searchResult;
}

function print_var($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

function dump_var($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

require_once('SphinxSearch.php');
error_reporting('E_ALL');
ini_set('display_errors', 1);

$max_result = 100;
$SphinxClient = new SphinxClient();
$SphinxClient->setServer("localhost", 9312, $max_result);
$SphinxClient->setMatchMode(SPH_MATCH_ANY);
$SphinxClient->setMaxQueryTime(3);

// @link http://us2.php.net/manual/en/sphinxclient.status.php
//echo 'status'; dump_var($SphinxClient->status());

// @link http://us2.php.net/manual/en/sphinxclient.getlasterror.php
echo 'GetLastError'; dump_var($SphinxClient->getLastError());

// @link http://us2.php.net/manual/en/sphinxclient.setselect.php
//  id as documents_id
//$SphinxClient->SetSelect('*, id as document_id, group_id as document_group_id, date_added AS document_date_added, title as document_title, content as document_content');
$SphinxClient->SetSelect('*, id as document_id');

// in config
// sql_attr_uint		= group_id
// @link http://us2.php.net/manual/en/sphinxclient.setfilter.php
//$SphinxClient->SetFilter('group_id', array(2));
//$SphinxClient->SetFilter('group_id2', array(5,6,8));
//$SphinxClient->SetFilterRange('group_id2',5,7);
//$SphinxClient->SetFilterRange('group_id2',5,7, true);

// @link http://us2.php.net/manual/en/sphinxclient.query.php
$result = $SphinxClient->query("this is", 'test1');
//echo 'result'; print_var($result);
//echo 'result[matches]'; print_var($result['matches']);

$SearchResult = getSearchResult($result);
echo '<br />formatted results:<br />';
if (count($SearchResult) && isset($result['attrs']) )
{
    echo '<table>';
    if(count($result['attrs']))
    {
        echo '<th><tr>';
        foreach($result['attrs'] as $attrKey=>$attrOne)
        {
            echo '<td>'.$attrKey.'</td>';
        }
        echo '</tr></th>';
    }
    foreach($SearchResult as $searchRow)
    {
        echo '<tr>';
        foreach($searchRow as $rowElement)
        {
            echo '<td>'.$rowElement.'</td>';
        }
        echo '</tr>';
    }

    echo '</table>';
}

// @link http://us2.php.net/manual/en/sphinxclient.getlasterror.php
echo 'GetLastError'; dump_var($SphinxClient->GetLastError());

