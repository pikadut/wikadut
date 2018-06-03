<?php 

  $view = 'administration/admin_tools/hierarchy_position/hierarchy_position_view_v';
 
  $data = array(

      'jumlah' =>1,
      'hieMenu' => $this->Administration_m->getHieMenu(),

    );

  $this->template($view,"Hierarchy Position",$data);