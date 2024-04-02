function updateImage(inputId, imageId) {
    const imageElement = document.getElementById(imageId);
    const fileInput = document.getElementById(inputId);

    fileInput?.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const imageUrl = URL.createObjectURL(file);
            imageElement.src = imageUrl;
        }
    });
}

updateImage('event_logo', 'eventLogo');
updateImage('event_banner', 'eventBanner');

$(document).ready(function () {
    // $('#candidate_container').hide();
    if ($('#num_judges').length && $('#num_judges').val().trim() == '') $('#judge_container').hide();

    if ($('#num_candidates').length && $('#num_candidates').val().trim() == '') $('#candidate_container').hide();

    if ($('#num_rounds').length && $('#num_rounds').val().trim() == '') $('#segment_container').hide();

    // Initialize an array to track selected chairman   
    var selectedChairman = [];

    $('#num_judges').on('propertychange input', function () {
        var numJudges = $(this).val();

        $('#judge_container').show();
        $('#dynamicFieldsContainer').empty();

        for (var i = 1; i <= numJudges; i++) {
            const judgeRow = $('<tr>');

            const judgeFirstNameCell = $('<td>');
            const judgeLastNameCell = $('<td>');
            const judgeTypeCell = $('<td>');

            const firstNameField = $('<input>')
                .attr('type', 'text')
                .addClass('form-control')
                .attr('name', `first_name${i}`)
                .attr('placeholder', 'First Name');

            const lastNameField = $('<input>')
                .attr('type', 'text')
                .addClass('form-control')
                .attr('name', `last_name${i}`)
                .attr('placeholder', 'Last Name');

            const selectJudgeType = $('<select>')
                .addClass('form-control')
                .attr('name', `is_chairman${i}`)
                .on('change', function () {
                    var selectedValue = $(this).val();

                    if (selectedValue === '0') { // If Chairman is selected
                        // Check if a chairman is already selected
                        if (selectedChairman.indexOf(i) !== -1) {
                            // Chairman already selected, revert selection
                            $(this).val('1'); // Set it back to "Judge"
                        } else {
                            selectedChairman.push(i); // Add this judge as Chairman
                        }
                    } else {
                        // If "Judge" is selected, remove this judge from the chairman list
                        var index = selectedChairman.indexOf(i);
                        if (index !== -1) {
                            selectedChairman.splice(index, 1);
                        }
                    }
                });

            const chairman = $('<option>')
                .attr('value', '0')
                .text('Chairman');
            const judge = $('<option>')
                .attr('value', '1')
                .text('Judge');

            selectJudgeType.append(judge, chairman);

            judgeFirstNameCell.append(firstNameField); // Append the first name field
            judgeLastNameCell.append(lastNameField); // Append the last name field
            judgeTypeCell.append(selectJudgeType);

            judgeRow.append(judgeFirstNameCell, judgeLastNameCell, judgeTypeCell);

            $('#dynamicFieldsContainer').append(judgeRow);
        }
    });




    $('#num_candidates').on('propertychange input', function () {
        var numCandidates = $(this).val();
    
        $('#candidate_container').show();
        $('#dynamicFieldsContainer1').empty();
    
        for (var i = 1; i <= numCandidates; i++) {
            const candidateRow = $('<tr>');
    
            const candidatePictureCell = $('<td>');
            const candidateNameCell = $('<td>');
            const candidateNumberCell = $('<td>');
            const candidateTypeCell = $('<td>');  // Add this line for the "Type" cell
            const candidateAddressCell = $('<td>');
    
            const candidatePictureField = $('<input>')
                .attr('type', 'file')
                .attr('class', 'form-control candidate_picture')
                .attr('name', `candidate_picture${i}`)
                .attr('accept', 'image/*');
    
            const candidateNameField = $('<input>')
                .attr('type', 'text')
                .attr('class', 'form-control candidate_name_field')
                .attr('name', `candidate_name${i}`)
                .attr('placeholder', '');
    
            const candidateNumberField = $('<input>')
                .attr('type', 'text')
                .attr('class', 'form-control candidate_number_field')
                .attr('name', `candidate_number${i}`)
                .attr('placeholder', '');
    
            const candidateTypeField = $('<select>')
                .attr('class', 'form-control candidate_type_field')
                .attr('name', `type${i}`)
                .append($('<option>').attr('value', '').text('Select Type').prop('disabled', true))
                .append($('<option>').attr('value', 'mr').text('Mr'))
                .append($('<option>').attr('value', 'ms').text('Ms'));
    
            const candidateAddressField = $('<input>')
                .attr('type', 'text')
                .attr('class', 'form-control candidate_address_field')
                .attr('name', `candidate_address${i}`)
                .attr('placeholder', '');
    
            candidatePictureCell.append(candidatePictureField);
            candidateNameCell.append(candidateNameField);
            candidateNumberCell.append(candidateNumberField);
            candidateTypeCell.append(candidateTypeField);  // Add this line for the "Type" cell
            candidateAddressCell.append(candidateAddressField);
    
            candidateRow.append(candidatePictureCell, candidateNameCell, candidateNumberCell, candidateTypeCell, candidateAddressCell);  // Modify this line to include the "Type" cell
    
            $('#dynamicFieldsContainer1').append(candidateRow);
        }
    });
    

    $('#num_rounds').on('propertychange input', function () {

        var numRounds = $(this).val();

        $('#segment_container').show();
        $('#dynamicFieldsContainer2').empty();

        for (var i = 1; i <= numRounds; i++) {
            const roundsRow = $('<tr>');

            const roundsNameCell = $('<td>');
            const roundsPercentageCell = $('<td>');

            const roundsNameField = $('<input>')
                .attr('type', 'text')
                .attr('class', 'form-control segment_field')
                .attr('name', `segment_name${i}`);

            const roundsPercentageField = $('<input>')
                .attr('type', 'text')
                .attr('class', 'form-control percent_field')
                .attr('name', `percentage${i}`);

            roundsNameCell.append(roundsNameField);
            roundsPercentageCell.append(roundsPercentageField);

            roundsRow.append(roundsNameCell, roundsPercentageCell);

            $('#dynamicFieldsContainer2').append(roundsRow);
        }
    });

    $('body').on('change input', '.percent_field', function () {
        let sum = 0;
        $('.percent_field').each(function () {
            let value = $(this).val();
            sum += value.trim() == null || value.trim() == '' || isNaN(value) ? 0 : parseInt(value);

        });
        if (sum > 100) {

            // alert('Percentages sum should not exceed to 100!');
        }
    })
});