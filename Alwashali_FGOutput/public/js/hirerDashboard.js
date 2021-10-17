window.livewire.on('jobAdded',()=>{
    $('#addJobModal').modal('hide');
    setTimeout(function(){
        $('#successMsg').html('');
    }, 5000)
});
window.livewire.on('jobUpdated',()=>{
    $('#editJobModal').modal('hide');
    setTimeout(function(){
        $('#successMsg').html('');
    }, 5000)
});
window.livewire.on('jobDeleted',()=>{
    $('#Confirmation').modal('hide');
    setTimeout(function(){
        $('#successMsg').html('');
    }, 5000)
});