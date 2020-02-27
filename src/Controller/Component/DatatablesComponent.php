<?php
// src/Controller/Component/DatatablesComponent.php
namespace App\Controller\Component;

use Cake\Controller\Component;

class DatatablesComponent extends Component
{

	public function make($data)
	{
        $conf = [];
		$source  = $data['source'];
		$allData = $data['source'];
		$searchAble = $data['searchAble'];
		$defaultSort = ! empty( $data[ 'defaultSort' ]) ? $data[ 'defaultSort' ] : 'ASC';
		$defaultField = ! empty( $data[ 'defaultField' ]) ? $data[ 'defaultField' ] : '';
        $defaultSearch = ! empty( $data[ 'defaultSearch' ]) ? $data[ 'defaultSearch' ] : '';
        if(!empty($data['contain'])){
            $conf['contain'] = $data['contain'];
        }
		if(! empty($defaultSearch))
		{
            $defaultWhere = [];
            $x = 0;
			foreach ($defaultSearch as $key => $condition) {
				if($key === "OR"){
					$defaultWhere[$x]['OR'] = [];
					foreach($condition as $keyOr => $conditionOr){
						$defaultWhere[$x]['OR'][] = [
		                    $conditionOr['keyField'].' '.$conditionOr['condition'] => $conditionOr['value']
		                ];
					}
				}else{
					$defaultWhere[$x] = [
	                    $condition['keyField'].' '.$condition['condition'] => $condition['value']
	                ];	
				}
                $x++;
            }
            if(!empty($defaultWhere))
            {
                $conf['searchConds'] = $defaultWhere;
            }
		}
		$request = $this->request->data;
		$datatable = ! empty( $request ) ? $request : array();
		// pr($request);;
		$datatable = array_merge( array( 'pagination' => array(), 'sort' => array(), 'query' => array() ), $datatable );

		$sort  = $defaultSort;

		$meta    = array();


		$metaData = $source->find('all',$conf);

		if(!empty($datatable['order'])){
			foreach($datatable['order'] as $sd => $or){
				$col_index = $or['column'];
				if($datatable['columns'][$col_index]['orderable'] == "true"){
					$metaData->order([$datatable['columns'][$col_index]['name'] => $or['dir']]);
				}
			}
		}
        $orWhere = []; 
		if($datatable['search']['value']) {
		//	dd($filter);
            foreach ($datatable['columns'] as $key => $value) {
				if($value['searchable'] == "true"){
					$orWhere['OR'][] = [$value['name'].' LIKE' => '%'.$datatable['search']['value'].'%'];
				}
			}
		}
		if(!empty($conf['searchConds'])){
			$metaData->where([
				$conf['searchConds'],
				'AND' => $orWhere
			]);
		}else{
			$metaData->orWhere($orWhere);
		}
		if(!empty($data['having'])){
            $metaData = $metaData->having($data['having']);
        }
		if(!empty($data['fields'])){
			foreach($data['fields'] as $r){
				$metaData->select($r);
			}
		}
		$dataResult = $metaData;
		$dataCount = $metaData;

		$pages = 1;
		if(isset($data['union'])){
			$total = 0;
		}else{
			$total 	 = $dataCount->count();
		}

		$start    	= $datatable[ 'start' ];
		$length 	= $datatable[ 'length' ];
		$dataResult = $dataResult->limit($length)->offset($start);

		//dd($datatable);
		// $request = $this->request->all();
		// dd($request);		
		$meta = array(
		);
		//pr($conf);
		$result = array(
			'meta' => $meta + array(
					'sql' => $dataResult->sql()
				),
			'aaData' => $dataResult,
			'iTotalRecords' => $total,
			'iTotalDisplayRecords' => $total,
			'sColumns' => "",
			'sEcho' => 0,
        );
		return $result;

	}

}

?>