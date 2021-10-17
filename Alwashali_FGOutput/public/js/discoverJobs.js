window.livewire.on('jobAdded',()=>{
    $('#Confirmation').modal('hide');
    setTimeout(function(){
        $('#successMsg').html('');
    }, 5000)
});