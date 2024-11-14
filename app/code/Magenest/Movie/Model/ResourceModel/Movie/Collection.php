<?php

namespace Magenest\Movie\Model\ResourceModel\Movie;

use Magenest\Movie\Model\Movie as Model;
use Magenest\Movie\Model\ResourceModel\Movie as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'movie_id';
    /**
     * @var string
     */
    protected $_eventPrefix = 'magenest_movie_collection';
    /**
     * @var string
     */
    protected $_eventObject = 'movie_collection';
    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
    public function _initSelect()
    {
        $this->joinDirector();
        return parent::_initSelect();
    }
    /**
     * @return $this
     */
    public function joinDirector()
    {
        $this->getSelect()
            ->join(
                ['director_table'=>$this->getTable('magenest_director')],
                'main_table.director_id = director_table.director_id',
                ['director_name' => 'director_table.name']
            )
            ->group('main_table.movie_id');
        $this->addFilterToMap('director_name', 'director_table.name');
        return $this;
    }
//
//    /**
//     * @return $this
//     */
//    public function joinDirectorAndActors()
//    {
//        $this->getSelect()
//            ->join(
//                ['director_table'=>$this->getTable('magenest_director')],
//                'main_table.director_id = director_table.director_id',
//                ['director_name' => 'director_table.name']
//            )
//            ->join(
//                ['movie_actor_table'=>$this->getTable('magenest_movie_actor')],
//                'main_table.movie_id=movie_actor_table.movie_id',
//                []
//            )
//            ->joinLeft(
//                ['actor_table'=>$this->getTable('magenest_actor')],
//                'movie_actor_table.actor_id = actor_table.actor_id',
//                ['actor_name' => 'GROUP_CONCAT(actor_table.name SEPARATOR ", ")']
//            )
//            ->group('main_table.movie_id');
//        return $this;
//    }
}
