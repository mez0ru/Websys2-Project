window.livewire.on('statusChange',()=>{
    $('#Confirmation').modal('hide');
    setTimeout(function(){
        $('#successMsg').html('');
    }, 8000)
});