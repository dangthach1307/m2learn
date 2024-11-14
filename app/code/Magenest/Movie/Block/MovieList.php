<?php
/*
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Thach The Dang.
 *
 */

namespace Magenest\Movie\Block;

use Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory;
use Magento\Framework\View\Element\Template;

class MovieList extends Template
{
    private $movieCollection;

    public function __construct(
        Template\Context $context,
        CollectionFactory $movieCollection,
        array $data = []
    ){
        $this->movieCollection = $movieCollection;
        parent::__construct($context, $data);
    }
    public function getMovies()
    {
        $collection = $this->movieCollection->create();
        $collection->addFieldToSelect('*');

        // Join the director table
        $collection->getSelect()->joinLeft(
            ['director_table' => $collection->getTable('magenest_director')],
            'main_table.director_id = director_table.director_id',
            ['director_name' => 'director_table.name']
        );
        // join Movie Actor table
        $collection->getSelect()->joinLeft(
            ['movie_actor_table' => $collection->getTable('magenest_movie_actor')],
            'main_table.movie_id = movie_actor_table.movie_id',
            []
        );
        //Join with Actor table to get list Actor
        $collection->getSelect()->joinLeft(
            ['actor_table' => $collection->getTable('magenest_actor')],
            'movie_actor_table.actor_id = actor_table.actor_id',
            ['actor_name' => 'GROUP_CONCAT(actor_table.name SEPARATOR ", ")']
        );
        // Group by movie ID to avoid duplicate movie entries
        $collection->getSelect()->group('main_table.movie_id');

        return $collection;
    }
}
