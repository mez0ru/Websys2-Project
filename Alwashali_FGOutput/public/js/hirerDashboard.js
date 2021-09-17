$(function() {
    // when modals closes:
$('#addJobModal').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
    var form = $('form'),
        errorList = $("ul.errorMessages", form);
    errorList.hide();
})

$('#confirmModal').on('hidden.bs.modal', function () {
    $(this).find('.message').removeClass('text-success text-danger');
})

// initiate delete action by showing confirmation first:
$('#confirmModal').on('show.bs.modal', function(event){
    let button = $(event.relatedTarget);
    if (button.hasClass('delete-btn')){
        let modal = $(this);
        modal.data('id', button.data('id'));
        modal.data('reqid', button.data('reqid'));
        let message = modal.find('.message');
        message.text('Are you sure you want to delete the post?\nYou cannot undo this action.');
        message.addClass('text-danger');
        modal.find('.modal-footer').show();
    }
});

// show modal when click new post:
$('#addJobModal').on('show.bs.modal', function(event){
    let button = $(event.relatedTarget);
    var modal = $(this);
    if (button.hasClass('edit-btn')){
    let id = button.data('id');
    let post = button.closest('.card');
    let title = post.find('.post-title').text();

    // numerical values:
    let apply_until = post.find('.apply-until').text().replace( /^\D+/g, '');
    let age = post.find('.age-dis').text().replace(/[^0-9]/g, '');
    let min_sal = post.find('.min-sal').text().replace(/[^0-9]/g, '');
    let max_sal = post.find('.max-sal').text().replace(/[^0-9]/g, '');
    let min_work_exp = post.find('.min-work-exp').text().replace(/[^0-9]/g, '');
    
    // let country = post.find('.country').text();
    let gender = post.find('.gender').html().substring(8);
    let description = post.find('.jobdescription').text();
    let socialmedia = post.find('.social-dis').text();
    let qualifications = post.find('.qualifications').text().substring(13);

    switch (gender) {
        case 'MALE':
            gender = 'val1';
            break;
            case 'FEMALE':
                gender = 'val2';
                break;
                case 'ANY':
                    gender = 'val3';
                    break;
    
        default:
            gender = 'val3';
            break;
    }

    modal.find('.modal-title').text('Edit job posting');
    modal.find('#titleInput').val(title);
    modal.find('#job-description').val(description);
    modal.find('#salary-from').val(min_sal);
    modal.find('#salary-to').val(max_sal);
    modal.find('#apply-until').val(apply_until);
    modal.find('#social-media-accounts').val(socialmedia);
    modal.find('#gender-select').val(gender);
    modal.find('#age').val(age);
    modal.find('#min-work-exp').val(min_work_exp);
    modal.find('#qualifications').val(qualifications);
    modal.find('#sendbutton').data('id', id);
    modal.find('#sendbutton').text('Save');
} else {
    modal.find('.modal-title').text('Create new job posting');
    modal.find('#sendbutton').removeData();
    modal.find('#sendbutton').text('Create');
}
});

// confirm deletion:
$(document).on('click', '#confirmactionbtn', function(){
    // send ajax
    let id = $('#confirmModal').data('id');
    let _url     = `/jobs/${id}`;
    let _token   = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: _url,
        type: 'DELETE',
        data: {
            _token: _token,
        },
        success: function(response){
            window.location.replace(response);
        },
        error: function(response){
            let confirmationModal = $("#confirmModal");
            confirmationModal.find('.modal-footer').hide();
            let message = confirmationModal.find('.message');
            message.text(`Failed to delete the post!\n${response}`);
        }
        });
});

$(document).on('click', '#sendbutton', function(){
    var id = $(this).data('id');
    let modal = $(this).closest('.modal-content');

    let _url     = `/jobs`;
    let _token   = $('meta[name="csrf-token"]').attr('content');

    // get content
    let titlein = modal.find('#titleInput');
    let descriptionin = modal.find('#job-description');
    let salary_fromin = modal.find('#salary-from');
    let salary_toin = modal.find('#salary-to');
    let apply_untilin = modal.find('#apply-until');
    let social_medin = modal.find('#social-media-accounts');
    let genderin = modal.find('#gender-select');
    let agein = modal.find('#age');
    let min_worin = modal.find('#min-work-exp');
    let qualin = modal.find('#qualifications');

    let title = titlein.val();
    let description = descriptionin.val();
    let salary_from = salary_fromin.val();
    let salary_to = salary_toin.val();
    let apply_until = apply_untilin.val();
    let social_med = social_medin.val();
    let gender = genderin.val();
    let age = agein.val();
    let min_wor = min_worin.val();
    let qual = qualin.val();

    switch (gender) {
        case 'val1':
            gender = 'Male';
            break;
            case 'val2':
                gender = 'Female';
                break;
                case 'val3':
                    gender = 'Both';
                    break;
    
        default:
            gender = 'Both';
            break;
    }

    // validate input
    var form = $('form'),
        errorList = $("ul.errorMessages", form);

    let errors = [];

    var showAllErrorMessages = function() { errorList.empty();

        // Find all invalid fields within the form.
        var invalidFields = form.find( ":invalid" ).each( function( index, node ) {
            errors.push(node);
            // Find the field's corresponding label
            var label = $( "label[for=" + node.id + "] "),
                // Opera incorrectly does not fill the validationMessage property.
                message = node.validationMessage || 'Invalid value.';

            errorList
                .show()
                .append( "<li><span>" + label.html() + "</span> " + message + "</li>" );
        });

        let dateInput = form.find('#apply-until');
        if (isNaN(Date.parse(dateInput.val()))){
            errors.push(dateInput);
            // Find the field's corresponding label
            var label = $( "label[for=" + dateInput.attr('id') + "] "),
                // Opera incorrectly does not fill the validationMessage property.
                message = 'date entered is invalid.';

            errorList
                .show()
                .append( "<li><span>" + label.html() + "</span> " + message + "</li>" );
        }
    };
    
    showAllErrorMessages();

    if (errors.length > 0)
        return;

    if (id){ // initiate edit

    // get info related to the card selected
    let btn = $(`.edit-btn[data-id="${id}"]`);
    let card = btn.closest('.card');
    let activePage = $('.page-item.active span').text();
    let date_posted = card.find('.date-posted').text().replace( /^\D+/g, '');
    let reqid = btn.data('reqid');

    // send ajax
    $.ajax({
    url: _url,
    type: 'POST',
    data: {
        'id': id,
        'reqid': reqid,
        'title': title,
            'job_description': description,
            'salary_from': salary_from,
            'salary_to': salary_to,
            'apply_until': apply_until,
            'social_media_accounts': social_med,
            'gender': gender,
            'age': age,
            'min_work_experience': min_wor,
            'min_work_experience_range_type': 'Year',
            'qualifications': qual,
            'active_page': activePage,
            _token: _token,
    },
    success: function(response){
        $("#addJobModal").modal('hide');
        let confirmationModal = $("#confirmModal");
        confirmationModal.find('.modal-footer').hide();
        let message = confirmationModal.find('.message');
        if(response.code == 200) {
            message.text('Your post has been updated successfully!');
            message.addClass('text-success');
            confirmationModal.modal('show');
            $('.cards').html(response.html);
            $(".addalert").attr("hidden",true);
                $(".editalert").attr("hidden",false);
                $(".deletealert").attr("hidden",true);
        } else {
            message.text(`Failed to update the post!\n${response.data}`);
        message.addClass('text-danger');
        confirmationModal.modal('show');
        }
    },
    error: function(response){
        $("#addJobModal").modal('hide');
        let confirmationModal = $("#confirmModal");
        confirmationModal.find('.modal-footer').hide();
        let message = confirmationModal.find('.message');
        message.text(`Failed to update the post!\n${response.data}`);
        message.addClass('text-danger');
        confirmationModal.modal('show');
        console.log(response);
    }
    });
} else{ // initiate new post
    user_id = $('.cards').data('userid');
    let activePage = 1;

    $.ajax({
        url: _url,
        type: 'POST',
        data: {
            'id': '',
            'reqid': '',
            'title': title,
            'job_description': description,
            'salary_from': salary_from,
            'salary_to': salary_to,
            'apply_until': apply_until,
            'social_media_accounts': social_med,
            'gender': gender,
            'age': age,
            'min_work_experience': min_wor,
            'min_work_experience_range_type': 'Year',
            'qualifications': qual,
            'active_page': activePage,
            _token: _token,
            // 'user_id': user_id
        },

        success: function(response){
            if(response.code == 200) {
            $("#addJobModal").modal('hide');
            let confirmationModal = $("#confirmModal");
            let message = confirmationModal.find('.message');
            confirmationModal.find('.modal-footer').hide();
            message.text('Your post has been created successfully!');
                message.addClass('text-success');
                confirmationModal.modal('show');
                $('.cards').html(response.html);
                $('.post-count').text(`You have ${response.count} job posting(s)`);
                $(".addalert").attr("hidden",false);
                $(".editalert").attr("hidden",true);
                $(".deletealert").attr("hidden",true);
            } else{
            message.text(`Failed to create the post!\n${response.data}`);
            message.addClass('text-danger');
            confirmationModal.modal('show');
            }
        },
        error: function(response){
            console.log(response);
            $("#addJobModal").modal('hide');
            let confirmationModal = $("#confirmModal");
            confirmationModal.find('.modal-footer').hide();
            let message = confirmationModal.find('.message');
            message.text(`Failed to create the post!\n${response.data}`);
            message.addClass('text-danger');
            confirmationModal.modal('show');
        }
        });
}
});
});