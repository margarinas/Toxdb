<div class="row">
    <div class="span2" id="sidebar_nav">
        <ul class="nav nav-pills nav-stacked sidebar-nav affix" >
            <li class="event_main_section_link"><a href="#event_main">Kreipiasi</a></li>
            <li class="patient_section_link"><a href="#patient_info">Pacientas</a></li>
            <li class="patient_section_link"><a href="#patient_history">Lydinčios ligos/būklės</a></li>
            <li class="patient_section_link"><a href="#poison_attach_button">Pridėti medžiagą</a></li>
            <li class="patient_section_link"><a href="#substances_info">Produktai</a></li>
            <li class="patient_section_link"><a href="#agents_info">Toksinės medžiagos</a></li>
            <li class="patient_section_link"><a href="#evaluations">Situacijos įvertinimas</a></li>
            <li class="patient_section_link"><a href="#poisoning_cause">Apsinuodijimo pobūdis</a></li>
            <li class="patient_section_link"><a href="#treatment_place">Gydymo vieta</a></li>
            <li class="patient_section_link"><a href="#treatment">Gydymas</a></li>
            <li class="patient_section_link"><a href="#antidotes">Priešnuodžiai</a></li>
            <li class="patient_section_link"><a href="#final_evaluation">Galutinis įvertinimas</a></li>
            <li class="event_attr_section_link"><a href="#event_attributes">Atvejo duomenys</a></li>
            <li><br><button class="btn save-draft">Išsaugoti juodraštį</button></li>
        </ul>
        
    </div>
    <div class="span10 event_form">
        <?php //pr($this->data) ?>
        <?php echo $this->Form->create('Event',array('class'=>'form-horizontal')); ?>
        <fieldset id="event_main">
        <legend >Naujas atvejis</legend>
        <?php

        if (!empty($this->request->data['Event']['id']))
            echo $this->Form->input('Event.id'); 

        


        ?>
        <div class="row">
            <div class="span5">

            <?php
            if($this->Session->read('Auth.User.Group.name')=='admin')
                 echo $this->Form->input('Event.user_id',array('label'=>'Vartotojas','default'=>$this->Session->read('Auth.User.id')));
            else if(!empty($this->request->data['Event']['user_id']))
                 echo $this->Form->hidden('Event.user_id');
            echo $this->Form->input('requester_name', array('label' => 'Vardas pavardė','div'=>'control-group input-append','after'=>' <button class="btn unknown_value" type="button">Nežinoma</button>'));
            echo $this->Form->input('institution', array('label' => 'Įstaiga'));
            echo $this->Form->input('medical_request', array('label'=>'Kreipasi medikas?'));
            echo $this->Form->input('patient_request', array('label'=>'Kreipiasi pacientas?','type'=>'checkbox'));
            echo $this->Form->input('no_patient', array('label'=>'Nėra nukentėjusių?','type'=>'checkbox','class'=>'event_toggle_patient'));
            echo $this->Html->link("Ieškoti/pridėti medžiagą",
                array('controller'=>'substances','action'=>'dashboard','','?'=>array('attachTo'=>'Event')),
                array('class'=>'btn btn-primary add_substance add-event-substance '.(!empty($this->data['Event']['no_patient'])?:'hide'))
                );
            ?>
            </div>
            <div class="span5">
                <?php 
                echo $this->Form->input('address', array('label' => 'Adresas','placeholder'=>'Adresas'));
                echo $this->Form->input('city', array('label' => 'Miestas','placeholder'=>'Miestas'));
                echo $this->Form->input('phone', array('label' => 'Telefonas'));
                echo $this->Form->input('invalid_request', array('label'=>'Klaidingas skambutis','class'=>'event_toggle_patient event_invalid_request'));
                echo $this->Form->input('has_related_events', array('label'=>'Yra susijusių konsultacijų','type'=>'checkbox','class'=>'related-events-toggle'));
                
                ?>

                <div class="events-related <?php if(empty($this->data['RelatedEvent']['RelatedEvent']) && empty($this->data['RelatedEvent']['RelatedEvent'][0])) echo 'hide'; ?>">
                    <?php 
                    echo $this->Html->link("Ieškoti susijusių",'/events/index/?update=asd', array('class'=>'btn btn-primary add-related-event-btn'));

                    if(!empty($this->data['RelatedEvent']['RelatedEvent']) && !empty($this->data['RelatedEvent']['RelatedEvent'][0])) {
                        foreach ($this->data['RelatedEvent']['RelatedEvent'] as $related_event_key => $related_event) {
                           echo $this->Form->input('RelatedEvent.RelatedEvent.', array(
                            'label'=>false,'type'=>'text','placeholder'=>'Nr.',
                            'class'=>'input-mini event-related-input',
                            'div'=>false,
                            'value' => $related_event,
                            'after' => $this->Html->link('<i class="icon-zoom-in"></i>', array('action' => 'view', $related_event),array('class'=>'btn','escape'=>false,'target'=>'_blank')).'<br>',
                            'append'=>array('-', array('wrap' => 'a', 'class' => 'btn remove-related-event btn-warning', 'href'=>'#'))
                            )
                           );
                       }
                   } 
                    ?>
                </div>
            </div>
        </div>
    
    </fieldset>
        

        <div class="event-substances">
        <?php
        //pr($query_vars);
        //pr($this->data);
        if(!empty($this->data['Event']['no_patient'])): ?>
            <fieldset class="substances">

                <legend id="substances_info">Produktai</legend>
                <?php
                if(!empty($substances)) {
                    foreach ($substances as $key => $substance) {
                // echo $this->Form->hidden('Patient.0.Substance.',array('value'=>$key));
                //echo $this->Html->link($substance,array('controller'=>'substances', 'action'=>'view',$key),array('target'=>'_blank'));
                        echo $this->element('substance/attach_substance',array('substance'=>$substance,'hide'=>false,'selectAll'=>true,'attachTo'=>'Event'));
                    }

            // echo $this->Form->input('Patient.0.Substance',array('label'=>false,'div'=>false,'multiple'=>'checkbox','selected'=>array_keys($substances)));

                }

                ?>
            </fieldset>

            <hr>
            <fieldset class="agents">
                <legend id="agents_info">Pagrindinės nuodingosios medžiagos</legend>
                <?php
                if(!empty($agents)) {
                //echo $this->Form->input('Patient.0.Agent',array('label'=>false,'multiple'=>'checkbox','div'=>false));
                    foreach ($agents as $key => $agent) { 
                       echo $this->element('agent/attach_agent',array('key'=>$key,'agent'=>$agent, 'attachTo'=>'Event', 'hide'=>false,'selectAll'=>true));
                   }
               }
               ?>
           </fieldset>
           <hr>
        <?php endif; ?>
        </div>
        <div class="patient <?php if(!empty($this->request->data['Event']['no_patient'])) echo 'hide' ?>">
            <fieldset id="patient_info">
            <legend >Informacija apie pacientą</legend>

            <div class="row">
                <div class="span5">
                
                <?php
                echo $this->Form->input('Patient.0.id');
                //echo $this->Form->hidden('Patient.0.saving_all_fields',array('value'=>true));
                echo $this->Form->input('Patient.0.name',array('label'=>'Vardas, Pavardė','div'=>'control-group input-append','required'=>false,'after'=>' <button class="btn unknown_value" type="button">Nežinoma</button>'));
                // echo $this->Form->input('Patient.0.age',array('label'=>'Amžius', 'min'=>'1'));

                echo $this->Form->input('Patient.0.age_year',array(
                    'label'=>'Amžius',
                    'type'=>'number',
                    'min'=>'0',
                    'class'=>'input-mini patient-age-input',
                    'placeholder'=>'metai',
                    'after'=>$this->Form->input('Patient.0.age_month',array(
                        'label'=>false,
                        'type'=>'number',
                         'min'=>'0',
                         'max'=>'12',
                         'div'=>false,
                         'class'=>'input-small patient-age-input',
                         'placeholder'=>'mėnesiai'
                         )).
                        $this->Form->input('Patient.0.age_day',array(
                        'label'=>false,
                        'type'=>'number',
                         'min'=>'0',
                         'max'=>'365',
                         'div'=>false,
                         'class'=>'input-mini patient-age-input',
                         'placeholder'=>'dienos'
                         ))
                    ));
                echo $this->Form->input('Patient.0.age_group', array('label'=>'Amžiaus grupė','options'=>array('child'=>'Vaikas','adult'=>'Suaugęs',
                    'unknown'=>'Nežinoma'),'empty'=>'Pasirinkite...','class'=>'patient_age_group'));


                echo $this->Form->input('Patient.0.type',array('label'=>false,'type'=>'radio','options'=>array('vyr'=>'Vyras','mot'=>'Moteris','gyv'=>'Gyvūnas'),'wrapper'=>false,'label_class'=>'radio inline'));
                echo $this->Form->input('Patient.0.height',array('label'=>'Ūgis','min'=>'1','class'=>'decimal_input','append'=>'cm'));
                echo $this->Form->input('Patient.0.weight',array('label'=>'Svoris', 'min'=>'1','class'=>'decimal_input','append'=>'kg'));
                ?>
                </div>
                <div class="span5">
                <?php
                echo $this->Form->input('Patient.0.address',array('label'=>'Adresas','placeholder'=>'Adresas'));
                echo $this->Form->input('Patient.0.phone',array('label'=>'Telefonas'));

                echo $this->Form->input('Patient.0.pid',array('label'=>'Asmens kodas'));
                echo $this->Form->input('Patient.0.study_number',array('label'=>'Ligos ist./ amb. kortelės nr.'));
                ?>
                </div>
            </div>
            <?php echo $this->Form->input('Patient.0.poisoning_info', array('label'=>'Anamnezė, apsinuodijimo eiga, dabartinė būklė','class'=>'input-xxlarge','rows'=>8)); ?>
            </fieldset>
            <fieldset>
            <legend id="patient_history">Predisponuojantys faktoriai/gyvenimo anamnezė</legend>
            <?php
            $i =0;
            foreach ($patientAttributes as $group => $attributes): ?>

            <div class="patient_attribute clearfix <?php echo $group ?>">
             <?php 
             foreach ($attributes as $key => $attribute) {
                $i++;
                $attribute_value_id = false;
                $attribute_value = false;

                if(!empty($this->data['Patient'][0]['PatientAttributeValue'])) {
                    foreach ($this->data['Patient'][0]['PatientAttributeValue'] as $key => $value) {
                        if($value['patient_attribute_id']==$attribute['id']) {
                            $attribute_value_id = $value['id'];
                            $attribute_value = $value['value'];
                        }
                    }
                }

                echo $this->Form->hidden('Patient.0.PatientAttributeValue.'.$i.'.id',array('value'=>$attribute_value_id));
                echo $this->Form->input('Patient.0.PatientAttributeValue.'.$i.'.value',array('label'=>$attribute['name'],'type'=>$attribute['type'],'default'=>$attribute_value));
                echo $this->Form->hidden('Patient.0.PatientAttributeValue.'.$i.'.patient_attribute_id',array('value'=>$attribute['id']));

            }
            ?>
            </div>


            <?php endforeach; ?>
            <?php
            echo $this->Form->input('Patient.0.history',array('label'=>'Gyvenimo anamnezė','class'=>'input-xxlarge', 'rows'=>8));
            echo $this->Form->input('Patient.0.not_poisoning', array('label'=>'Gydymo konsultacija nesusijusi su apsinuodijimu'));

            ?>
            </fieldset>

            <fieldset>
                <legend id="poison_attach_button">Apsinuodijimą sukėlusios medžiagos</legend>
                <?php 

                echo $this->Html->link("Ieškoti/pridėti medžiagą",'/substances/dashboard', array('class'=>'btn btn-primary btn-large add_substance'));
                ?>
                <hr />

            </fieldset>
    

   <?php if(empty($this->request->data['Event']['no_patient'])): ?>
    <fieldset class="substances">
 
        <legend id="substances_info">Produktai</legend>
        <?php
        // pr($substances);
        if(!empty($substances)) {
        foreach ($substances as $key => $substance) {
            // echo $this->Form->hidden('Patient.0.Substance.',array('value'=>$key));
            //echo $this->Html->link($substance,array('controller'=>'substances', 'action'=>'view',$key),array('target'=>'_blank'));
            echo $this->element('substance/attach_substance',array('substance'=>!empty($substance['Substance'])?$substance['Substance']:$substance,'hide'=>false,'selectAll'=>true));
        }
       
        // echo $this->Form->input('Patient.0.Substance',array('label'=>false,'div'=>false,'multiple'=>'checkbox','selected'=>array_keys($substances)));

        }

        ?>
    </fieldset>

    <hr>
    <fieldset class="agents">
        <legend id="agents_info">Pagrindinės nuodingosios medžiagos</legend>
        <?php
        if(!empty($agents)) {
            //echo $this->Form->input('Patient.0.Agent',array('label'=>false,'multiple'=>'checkbox','div'=>false));
            foreach ($agents as $key => $agent) { 
             echo $this->element('agent/attach_agent',array('key'=>$key,'agent'=>$agent['Agent'],'units'=>$units,'hide'=>false,'selectAll'=>true,'showMainGroup'=>empty($substances)));
         }
     }
     ?>
    </fieldset>
    <hr>
    <?php endif; ?>

<?php 
echo $this->Form->input('Patient.0.time_of_exposure',array('label'=>'Apsinuodijimo laikas','class'=>'datetimepicker'));
echo $this->Form->input('Patient.0.exposition',array('label'=>'Ekspozicija','class'=>'timepicker'));
echo $this->Form->input('Patient.0.verified',array('label'=>'Laboratorinis patvirtinimas'));
//echo $this->Form->input('Patient.0.exposition',array('label'=>'Ekspozicija','type'=>'date'));
?>

<hr />
<div class="row" id="evaluations">
    <fieldset class="span5">
        <legend >Pradinis situacijos vertinimas</legend>
        <?php
        echo $this->Form->input('Patient.0.Evaluation.symptoms',array('label'=>'Simptomai, susiję su apsinuodijimu',
            'type'=>'radio',
            'options'=>$evaluations['symptoms'],
            'hiddenField'=>false
            ));
        echo $this->Form->input('Patient.0.Evaluation.risk',array('label'=>'Rizikos įvertinimas',
            'type'=>'radio',
            'options'=>$evaluations['risk'],
            'hiddenField'=>false
            ));

        echo $this->Form->input('Patient.0.Evaluation.grade',array('label'=>'Apsinuodijimo sunkumas (ASS)',
            'type'=>'radio',
            'options'=>$evaluations['grade'],
            'hiddenField'=>false
            ));

        echo $this->Form->input('Patient.0.Evaluation.dose',array('label'=>'Nuodingosios medžiagos kiekis',
            'type'=>'radio',
            'options'=>$evaluations['dose'],
            'hiddenField'=>false
            ));

            ?>
    </fieldset>
    <fieldset class="span5">
            <legend>Apsinuodijimo vieta</legend>
            <?php
            echo $this->Form->input('Patient.0.PoisoningAttribute.p_place',array(
                'label' => false,
                'type'=>'radio',
                'hiddenField'=>false,
                'options' => $poisoning_place['home']
                ));

            echo $this->Form->input('Patient.0.PoisoningAttribute.p_place',array(
                'label' => 'Darbovietė',
                'type'=>'radio',
                'hiddenField'=>false,
                'options' => $poisoning_place['workplace']
                ));
            echo $this->Form->input('Patient.0.PoisoningAttribute.p_place',array(
                'label' => 'Visuomeninė įstaiga',
                'type'=>'radio',
                'hiddenField'=>false,
                'options' => $poisoning_place['public']
                ));
                ?>

    </fieldset>
</div>

    <fieldset>
    <legend id="poisoning_cause">Apsinuodijimo pobūdis</legend>
        <?php

        echo $this->Form->input('Patient.0.PoisoningAttribute.p_type',array(
            'label' => false,
            'type'=>'radio',
            'hiddenField'=>false,
            'div'=>'pull-left',
            'options' => $poisoning_attributes['p_type'],
            ));

        echo $this->Form->input('Patient.0.PoisoningAttribute.p_route',array(
            'label' => false,
            'multiple'=>'checkbox',
            'hiddenField'=>false,
            'div'=>'pull-left',
            'options' => $poisoning_attributes['p_route'],
            ));
        echo '<div class="clearfix"></div>';

        $routes_n = count($poisoning_attributes['p_route']);
        echo $this->Form->input('Patient.0.PoisoningAttribute.p_cause.main',array(
            'label' => false,
            'type'=>'radio',
            'hiddenField'=>false,
            'class'=>'p_type_main',
            'label_class'=>'radio inline',
            'options' => $poisoning_cause['main']
            ));

        echo $this->Form->input('Patient.0.PoisoningAttribute.p_cause.intentional',array(
            'label' => 'Tikslinis',
            'type'=>'radio',
            'hiddenField'=>false,
            'div'=>'control-group hide p_cause',
            'options' => $poisoning_cause['intentional']
            ));

        echo $this->Form->input('Patient.0.PoisoningAttribute.p_cause.accidental',array(
            'label' => 'Atsitiktinis',
            'type'=>'radio',
            'hiddenField'=>false,
            'div'=>'control-group hide p_cause',
            'options' => $poisoning_cause['accidental']
            ));

        echo $this->Form->input('Patient.0.PoisoningAttribute.p_cause.main',array(
            'label' => false,
            'type'=>'radio',
            'hiddenField'=>false,
            'class'=>'p_type_main',
            'options' => $poisoning_cause['other']
            ));

        echo $this->Form->input('Patient.0.extra',array('label'=>'Specialios žymos'));

        ?>
        </fieldset>

        <fieldset>
        <legend id="treatment_place">Gydymo vieta</legend>
        <div class="row">
            <div class="span5">
                <?php 
                echo $this->Form->input('Patient.0.TreatmentPlaceBefore', array(
                    'label'=>'Iki kreipimosi',
                    'multiple'=>'checkbox',
                    'options'=>$treatment_places,
                    ));
                    ?>
             </div>
            <div class="span5">
                <?php
                echo $this->Form->input('Patient.0.TreatmentPlaceRecommended', array(
                    'label'=>'Rekomenduota',
                    'multiple'=>'checkbox',
                    'options'=>$treatment_places
                    ));  ?>
            </div>
        </div>
        </fieldset>

        <fieldset>
        <legend id="treatment">Gydymas</legend>

        <div class="row">
            <div class="span5">
                <?php echo $this->Form->input('Patient.0.TreatmentBefore',array('label'=>'Iki Kreipimosi','multiple'=>'checkbox','options'=>$treatments)); ?>
            </div>
            <div class="span5">
                <?php echo $this->Form->input('Patient.0.TreatmentRecommended',array('label'=>'Rekomenduotas','multiple'=>'checkbox','options'=>$treatments)); ?>
            </div>
        </div>
        </fieldset>
        <fieldset>
        <legend id="antidotes">Gydymas priešnuodžiais</legend>

        <div class="input-append">
            <input type="text" id="antidote_search_term">
            <button class="btn search_antidote" type="button">Ieškoti priešnuodžio</button>
            <button id="antidote_to_patient" class="btn btn-primary pull-right hide" type="button">Pasirintki</button>
        </div>
        <hr>
        <div class="antidote_search_results"></div>
        <div class="antidotes_attached margin-bottom">
            <?php
            if(!empty($antidotes)) {
                foreach ($antidotes as $key => $antidote) { 
                 echo $this->element('antidote/attach_antidote',array('key'=>$key,'antidote'=>$antidote['Antidote'],'units'=>$units['conc'],'hide'=>false,'selectAll'=>true));
             }
         }
         ?>
        </div>
        <hr>


        <?php echo $this->Form->input('Patient.0.additional_treatment', array('label'=>'Papildomas gydymas','class'=>'input-xxlarge','rows'=>8));  ?>
        </fieldset>
        <fieldset>
             <legend id="final_evaluation">Galutinis Apsinuodijimo sunkumo įvertinimas (ASS)</legend>
             <?php
             
             echo $this->Form->input('Patient.0.Evaluation.final_grade',array('label'=>false,
                'type'=>'radio',
                'options'=>$evaluations['final_grade'],
                'hiddenField'=>false
                ));
             echo $this->Form->input('feedback', array('label' => 'Užklausimas dėl apsinuodijimo baigties')); 
                ?>
        </fieldset>

    </div><!--  patient end -->

    <fieldset class="event_attributes <?php if(!empty($this->data['Event']['invalid_request'])) echo 'hide' ?>">
        <legend id="event_attributes">Informacija apie atvejį</legend>

            <div class="row">
                <div class="span5">
                <?php 
                

                echo $this->Form->input('request_type', array(
                'options' => array('Urgentinis' => 'Urgentinis', 'Ne' => 'Ne', 'Nežinoma' => 'Nežinoma'),
                'label' => 'Įvykio apibūdinimas',
                'type'=>'radio',
                'required'=>false,
                'default' => 'Urgentinis',
                'label_class'=>'radio inline'
                ));


                // EVENT ATTRIBUTES
                echo $this->Form->input('Event.EventAttribute',array('label'=>'Užklausimo būdas',
                    'multiple'=>'checkbox',
                    'options'=>$eventAttributes['request_type'],
                    'default'=>array_search('Telefonu',$eventAttributes['request_type']),
                    'hiddenField'=>false
                    ));

                echo $this->Form->input('Event.EventAttribute',array('label'=>'Atsakymo būdas',
                    'multiple'=>'checkbox',
                    'options'=>$eventAttributes['answer_type'],
                    'default'=>array_search('Telefonu',$eventAttributes['answer_type']),
                    'hiddenField'=>false));

                echo $this->Form->input('Event.EventAttribute',array('label'=>'Kreipimosi priežastis',
                    'options'=>$eventTypes['main'],
                    'multiple'=>'checkbox inline',
                    'hiddenField'=>false
                    ));

                echo $this->Form->input('Event.EventAttribute',array('label'=>false,
                    'multiple'=>'checkbox',
                    'options'=>$eventTypes[0],
                    'hiddenField'=>false));

                 ?>

                </div>
                <div class="span5">
                    <?php 
                    if($this->Session->read('Auth.User.Group.name')=='admin')
                    echo $this->Html->link("Ieškoti konsultacijos įrašo",'/calls/', array('class'=>'btn btn-primary add-call-btn'));
                    ?>
                    
                    <div class="calls-attached margin-top">
                        <?php
                        //pr($this->data['Call']);
                        if(!empty($this->data['Call'])) {
                            foreach ($this->data['Call'] as $key => $call) {
                                echo $this->element('call/attach_call',array('call'=>$call,'key'=>$key,'hide'=>false));
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            
            
    </fieldset>
    <?php echo $this->Form->input('Event.extra', array('label'=>'PASTABOS')); ?>
    <?php echo $this->Form->input('Event.created', array('label'=>'Data','type'=>'text','class'=>'datetimepicker')); ?>
    <div class="form-actions">
        <?php echo $this->Form->submit('Pateikti', array(
            'div' => false,
            'class' => 'btn btn-primary submit_event_form',
            ));

        echo $this->Html->link("Atšaukti",array('action'=>'index'),array('class'=>'btn pull-right'),'ar tikrai norite atšaukti?');

        ?>
        <!-- <button class="btn">Cancel</button> -->
    </div>
    <?php echo $this->Form->end(); ?>
    </div>
</div>

<?php
$this->assign('modalId', 'add_substance');
$this->assign('modalTitle', 'Ieškoti nuodingosios medžiagos');
$this->start('modalFooter');?>
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>   
<button class="btn btn-primary disabled attach_substance">Priskirti medžiagą pacientui</button>   
<?php
$this->end();
echo $this->element('modal', array(), array('plugin' => 'TwitterBootstrap')); 
?>

<?php
$this->assign('modalId', 'add-related-event');
$this->assign('modalTitle', 'Ieškoti atvejo');
$this->assign('modalFooter', '');
echo $this->element('modal', array(), array('plugin' => 'TwitterBootstrap')); 
?>

<?php
$this->assign('modalId', 'add_call');
$this->assign('modalTitle', 'Ieškoti konsultacijos įrašo');
$this->start('modalFooter');?>
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>   
<button class="btn btn-primary disabled attach_call">Priskirti įrašą</button>   
<?php
$this->end();
echo $this->element('modal', array(), array('plugin' => 'TwitterBootstrap')); 
?>


<?php //echo $this->element('modal', array(), array('plugin' => 'TwitterBootstrap')); ?>

<?php $this->Html->script('event/add',array('inline'=>false)); ?>
<!-- 
<script type="text/javascript">
    //require(["event/add"]);
</script>
 -->