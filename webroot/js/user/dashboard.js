$('#SubstanceTerm').typeahead({
    minLength: 3,
    source: function (query, process) {

        return $.getJSON(
            baseUrl+'substances/find_poison/',
            { term: query },
            function (data) {
                return process(data);
            });
    }

});

$('#SubstanceSearchForm').submit(function(){

    $('#add_substance .modal-body').load(baseUrl+'substances/search','term='+$('#SubstanceTerm').val());
    $('#add_substance').modal('show');
    return false;
});