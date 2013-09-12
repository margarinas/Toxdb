<?php 
echo $this->Form->input("RelatedEvent.RelatedEvent.", array(
    "label"=>false,"type"=>"text","placeholder"=>"Nr.",
    "class"=>"input-mini event-related-input",
    "div"=>false,
    "append"=>array("-", array("wrap" => "a", "class" => "btn btn-warning remove-related-event margin-right", "href"=>"#"))
    )
);
?>