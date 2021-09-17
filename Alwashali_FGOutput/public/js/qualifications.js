$(function () {

    $('#confirmModal').on('hidden.bs.modal', function () {
        $(this).find('.message').removeClass('text-danger text-success');
    })

    // initiate delete action by showing confirmation first:
    $('#confirmModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let modal = $(this);
        modal.data('id', button.data('id'));

        let message = modal.find('.message');
        console.log('delete');
        message.text('Are you sure you want to delete this qualification?\nYou cannot undo this action.');
        message.addClass('text-danger');

        modal.find('.modal-footer').show();
    });

    // confirm deletion:
    $(document).on('click', '#confirmactionbtn', function () {
        // send ajax
        let confirmationModal = $("#confirmModal");
        confirmationModal.find('.modal-footer').hide();
        let message = confirmationModal.find('.message');
        let id = confirmationModal.data('id');
        let tr = $(`.delete[data-id="${id}"]`).closest('tr');
        console.log(id);

        $.ajax({
            url: 'server.php',
            type: 'POST',
            data: {
                'removeQualification': 1,
                'id': id,
            },
            success: function (response) {
                console.log('wow it worked');
                if (response == 'success') {
                    message.text('deleted successfully!');
                    message.removeClass('text-danger');
                    message.addClass('text-success');
                    tr.hide('slow', function () { tr.remove(); 
                        $('tbody > tr > th').each(function(index){
                            $(this).text(index+1);
                        });
                    });

                    
                } else {
                    message.text(`Failed to perform the action!\n${response}`);
                }
            },
            error: function (response) {
                console.log('wow it failed');
                message.text(`Failed to perform the action!\n${response}`);
            }
        });
    });
});