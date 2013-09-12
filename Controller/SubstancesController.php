<?php
App::uses('AppController', 'Controller');
/**
 * Substances Controller
 *
 * @property Substance $Substance
 */
class SubstancesController extends AppController {

  public $uses = array('Substance','Unit');

  public $paginate = array('Substance','Agent');
  public function beforeFilter() 
  {
    $this->helpers[] = 'Js';
  }

  public $autocomplete = true;

  public $layout = 'poison';

  public function search()  {
   
    if(isset($this->request->query['term']))
      $term = $this->request->query['term'];
    else
      $term = '';

    if(!empty($this->request->query['attachTo']))
      $this->set('attachTo',$this->request->query['attachTo']);

    $this->set('term',$term);


  }

  public function loadElement($name) 
  {
    $this->render('/Elements/substance/'.$name, 'ajax');
  }

  public function view($id=null)
  {
    $this->Substance->id = $id;
    if (!$this->Substance->exists()) {
      throw new NotFoundException(__('Invalid substance'));
    }
    $this->Substance->contain(array('Agent'=>array('PoisonGroup'),'PoisonGroup'));
    $this->set('substance', $this->Substance->read(null, $id));
    //$this->layout='ajax';
  }

  public function dashboard()
  {
    if(!empty($this->request->query['attachTo']))
      $this->set('attachTo',$this->request->query['attachTo']);
    
  }

  public function add()
  {


    if ($this->request->is('post')) {
      $this->Substance->create();

      $this->request->data['Substance']['user_id'] = $this->Auth->user('id');
      $this->Substance->set($this->data['Substance']);
      if(isset($this->request->data['Substance']['poison_subgroup_id'])) {
        $substance_poison_subgroups = $this->Substance->Agent->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>$this->request->data['Substance']['poison_group_id'])));
        $this->set('substance_poison_subgroups',$substance_poison_subgroups);
      }
      $substanceValitadion = $this->Substance->validates();
      
      $agentValidation = false;
      $agentNoSave = false;

      if(!empty($this->request->data['Patient'])) {
        $attached_agents = $this->Substance->Agent->find('list',array('conditions'=>array('id'=>$this->request->data['Patient'][0]['Agent'])));
        $this->set('attached_agents',$attached_agents);
        $this->request->data['Substance']['Agent'] = $this->request->data['Patient'][0]['Agent'];
        if(!Hash::check(Hash::filter($this->data['Agent']),'{n}.name')) {
          $agentValidation = true;
          $agentNoSave =true;
        }
          
      } elseif ($this->request->data['Substance']['noagents']) {
        $agentValidation = true;
      } 

      if(!$agentValidation) {
        $agent_poison_subgroups = array();
        foreach ($this->request->data['Agent'] as $key => $agent) {
          if(isset($this->request->data['Agent'][$key]['poison_subgroup_id']))
            $agent_poison_subgroups[$key] = $this->Substance->Agent->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>$this->request->data['Agent'][$key]['poison_group_id'])));
        }
        $this->set('agent_poison_subgroups',$agent_poison_subgroups);
        $agentValidation = $this->Substance->Agent->saveAll($this->request->data['Agent'],array('validate' => 'only'));
      }    

      
      $substanceSave = false;
      $agentSave = false;  

      if($substanceValitadion && $agentValidation) {
        $substanceSave = $this->Substance->saveAll($this->request->data['Substance']);
        $this->request->data['Substance']['id'] = $this->Substance->id;

        if(!empty($attached_agents) && $agentNoSave) {
          $agentSave = true;
        } elseif ($this->request->data['Substance']['noagents']) {
            $agentSave = true;
        } else {
          
          foreach ($this->request->data['Agent'] as $key => $agent) {
            $this->request->data['Agent'][$key]['Substance']['id'] = $this->Substance->id;
            $this->request->data['Agent'][$key]['user_id'] = $this->Auth->user('id');
          }
          
          $agentSave = $this->Substance->Agent->saveAll($this->request->data['Agent']);
        }
        

      }
      if($substanceSave && $agentSave) {
        
        $this->set('units',$this->Unit->find('list',array('id','name','group')));

        $this->Session->setFlash(__('Įrašas išsaugotas'),'success');
        if($this->RequestHandler->isAjax() && $this->data['redirectTo'] == "dashboard") {
          $this->Substance->Agent->bindModel(array('hasOne' => array('AgentsSubstance')));
          $savedAgents = $this->Substance->Agent->find('all',array(
            'conditions'=>array(
              'AgentsSubstance.substance_id'=>$this->Substance->id
              ),'recursive'=>1
            ));

          $this->set('savedAgents',$savedAgents);
          $this->render('dashboard');
        }
          
        else
          $this->redirect(array('action' => 'index'));

      } else {
        $this->Session->setFlash('Negalėjome išsaugoti irašo bandykite dar kartą','failure');
      }
    }

    $this->set('poison_groups', $this->Substance->Agent->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>null),'order'=>'PoisonGroup.order ASC')));
    $this->set('units', $this->Unit->find('list',array('fields'=>array('id','name','group'))));
  }


  public function edit($id = null)
  {
    //$this->Substance->bindModel(array('hasOne' => array('AgentsSubstance')));
    $this->Substance->id = $id;
    $this->Substance->contain(array(
      'Agent'
      )
    );
    if (!$this->Substance->exists()) {
      throw new NotFoundException(__('Invalid event'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {

      $this->Substance->set($this->data['Substance']);
      $substanceValitadion = $this->Substance->validates();
      $agentValidation = false;

      if(!empty($this->request->data['Patient'])) {
        $attached_agents = $this->Substance->Agent->find('list',array('conditions'=>array('id'=>$this->request->data['Patient'][0]['Agent'])));
        $this->set('attached_agents',$attached_agents);
        $this->request->data['Substance']['Agent'] = $this->request->data['Patient'][0]['Agent'];
        if(!Hash::check(Hash::filter($this->data['Agent']),'{n}.name'))
          $agentValidation = true;
      } elseif ($this->request->data['Substance']['noagents']) {
        $agentValidation = true;
        unset($this->request->data['Agent']);
      } 

      if(!$agentValidation) {
        
        $agentValidation = $this->Substance->Agent->saveAll($this->request->data['Agent'],array('validate' => 'only'));
      }  


      if($substanceValitadion && $agentValidation) {
        $this->Substance->save($this->request->data['Substance']);
        if(!empty($this->request->data['Agent'])) {
           foreach ($this->request->data['Agent'] as $key => $agent) {
            $this->request->data['Agent'][$key]['user_id'] = $this->Auth->user('id');
          }
          $this->Substance->Agent->saveAll($this->request->data['Agent']);
        }
          
        $this->Session->setFlash(__('Įrašas išsaugotas'),'success');
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The event could not be saved. Please, try again.'),'failure');
      }
    } else {
      $this->request->data = $this->Substance->read(null,$id);

    }

    $this->set('poison_groups', $this->Substance->Agent->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>null))));


    $agent_poison_subgroups = array();
    if(empty($this->request->data['Agent']))
      $this->request->data['Substance']['noagents'] = true;
    else {


      foreach ($this->request->data['Agent'] as $key => $agent) {
        if(isset($this->request->data['Agent'][$key]['poison_subgroup_id']))
          $agent_poison_subgroups[$key] = $this->Substance->Agent->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>$this->request->data['Agent'][$key]['poison_group_id'])));
      }
    }

    // pr($this->request->data);
    if(isset($this->request->data['Substance']['poison_subgroup_id'])) {
      $substance_poison_subgroups = $this->Substance->Agent->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>$this->request->data['Substance']['poison_group_id'])));
      $this->set('substance_poison_subgroups',$substance_poison_subgroups);
    }
    
    
    $this->set('agent_poison_subgroups',$agent_poison_subgroups);
    $this->set('units', $this->Unit->find('list',array('fields'=>array('id','name','group'))));
    $this->render('add');
    // pr($this->request->data);

  }


  public function index() {
    
    if(isset($this->request->query['term']))
      $this->request->data['term'] = $this->request->query['term'];
    if(isset($this->request->data['term']))
      $term = $this->request->data['term'];


    if(!empty($this->request->query['limit']))
      $this->paginate['Substance']['limit']=$this->request->query['limit'];
    else if($this->request->is('ajax'))
      $this->paginate['Substance']['limit']=25;

    $conditions = array();
    if(!empty($term)) {
      $conditions = array(
        'OR' => array(
          'Substance.name LIKE' => '%'.$term.'%',
          'Substance.generic_name LIKE' => '%'.$term.'%'
          )
        );
    }

    if($this->Auth->user('Group.name') != 'admin') {
       $conditions['AND']['OR']['Substance.default']=true;
       $conditions['AND']['OR']['Substance.user_id']=$this->Auth->user('id');
     }

    $this->paginate['Substance']['contain']=array('Agent','PoisonGroup');
    $this->paginate['Substance']['order']='default ASC, Substance.name ASC';
    //$this->Substance->recursive = 0;
    $this->set('substances', $this->paginate('Substance',$conditions));
    $this->set('units', $this->Unit->find('list',array('fields'=>array('id','name','group'))));
  }

  public function find_poison()  {
    $results = array();
    if(!empty($_GET['term']))
      $results = $this->Substance->find_poison($_GET['term']);
    
    return new CakeResponse(array('body' => json_encode(array_values($results))));
  }


  public function delete($id = null) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException();
    }
    $this->Substance->id = $id;
    if (!$this->Substance->exists()) {
      throw new NotFoundException(__('Invalid substance'));
    }
    $substance = $this->Substance->read(array('default','user_id'));
    if(!$substance['Substance']['default'] && $substance['Substance']['user_id'] == $this->Auth->user('id') || $this->Auth->user('Group.name')=='admin') {

      if ($this->Substance->delete()) {
        $this->Session->setFlash('Produktas ištrintas','success');
        $this->redirect(array('action' => 'index'));
      }
      $this->Session->setFlash(__('Produktas nebuvo ištrintas'),'failure');
      $this->redirect(array('action' => 'index'));
    } else {
      $this->Session->setFlash(__('Neturite privilegijų ištrinti šį produktą'),'failure');
      $this->redirect(array('action' => 'index'));
    }
    
  }


  // public function deleteAssocAgents()  {
  //   if (!$this->request->is('post')) {
  //     throw new MethodNotAllowedException();
  //   }
  //   if(!$substance['Substance']['default'] && $substance['Substance']['user_id'] == $this->Auth->user('id') || $this->Auth->user('Group.name')=='admin') {
  //     pr($this->data);
  //   }

  // }


}
