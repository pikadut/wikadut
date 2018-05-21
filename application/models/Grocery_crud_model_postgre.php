<?php

class grocery_CRUD_Model_postgre  extends grocery_CRUD_Model  {

	function get_field_types_basic_table()
    {
    	$db_field_types = array();
    	$schema = "public";
    	$query = "SELECT * FROM information_schema.columns WHERE table_schema = '$schema' AND table_name = '$this->table_name'";
    	$res = $this->db->query($query)->result();
    	print_r($res);
    	foreach($res as $db_field_type)
    	{
    		$type_f = $db_field_type->data_type;
    		$field = $db_field_type->column_name;
    		$nullable = $db_field_type->is_nullable;
    		$extra = $db_field_type->column_default;
    		$type = explode("(",$type_f);
    		$db_type = $type[0];

    		if(isset($type[1]))
    		{
    			if(substr($type[1],-1) == ')')
    			{
    				$length = substr($type[1],0,-1);
    			}
    			else
    			{
    				list($length) = explode(" ",$type[1]);
    				$length = substr($length,0,-1);
    			}
    		}
    		else
    		{
    			$length = '';
    		}
    		$db_field_types[$field]['db_max_length'] = $length;
    		$db_field_types[$field]['db_type'] = $db_type;
    		$db_field_types[$field]['db_null'] = $nullable == 'YES' ? true : false;
    		$db_field_types[$field]['db_extra'] = $extra;
    	}

    	$results = $this->db->field_data($this->table_name);
    	foreach($results as $num => $row)
    	{
    		$row = (array)$row;
    		$results[$num] = (object)( array_merge($row, $db_field_types[$row['name']])  );
    	}

    	return $results;
    }

     function get_list()
    {
    	if($this->table_name === null)
    		return false;

    	$select = "{$this->table_name}.*";

    	//set_relation special queries
    	if(!empty($this->relation))
    	{
    		foreach($this->relation as $relation)
    		{
    			list($field_name , $related_table , $related_field_title) = $relation;
    			$unique_join_name = $this->_unique_join_name($field_name);
    			$unique_field_name = $this->_unique_field_name($field_name);

				if(strstr($related_field_title,'{'))
				{
					$related_field_title = str_replace(" ","&nbsp;",$related_field_title);
    				$select .= ", CONCAT('".str_replace(array('{','}'),array("',COALESCE({$unique_join_name}.",", ''),'"),str_replace("'","\\'",$related_field_title))."') as $unique_field_name";
				}
    			else
    			{
    				$select .= ", $unique_join_name.$related_field_title AS $unique_field_name";
    			}

    			if($this->field_exists($related_field_title))
    				$select .= ", {$this->table_name}.$related_field_title AS '{$this->table_name}.$related_field_title'";
    		}
    	}

    	//set_relation_n_n special queries. We prefer sub queries from a simple join for the relation_n_n as it is faster and more stable on big tables.
    	if(!empty($this->relation_n_n))
    	{
			$select = $this->relation_n_n_queries($select);
    	}

    	$this->db->select($select, false);

    	$results = $this->db->get($this->table_name)->result();

    	return $results;
    }

}
