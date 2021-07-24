
function readURL(input) {
    if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
        $('#image').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

$("#imgInp").change(function() {
    readURL(this);
});//end of image reader


$(document).on("change", ".file_multi_video", function(evt) {
    var $source = $('#video_here');
    $source[0].src = URL.createObjectURL(this.files[0]);
    $source.parent()[0].load();
});//end of video reader


if(document.getElementById('success-alert')){
    var div = document.getElementById('success-alert');
    div.style.opacity='0';
    div.style.transition = 'opacity 5s ease-in-out';

    setTimeout(function(){
        document.getElementById('success-btn').click();
    },5100);
}//end of success alert


function deleteConfirmation(form, event){

    event.preventDefault();

    var alert_warning = document.getElementsByClassName('alert-delete-warning')[0];
    alert_warning.style.display = 'block';
    alert_warning.style.opacity = '1';

    var btn_no = document.getElementsByClassName('warning-close')[0];
    var btn_yes = document.getElementsByClassName('warning-continue')[0];

    btn_no.addEventListener('click',function(){
        alert_warning.style.opacity='0';
        alert_warning.style.transition = 'opacity 1s ease-in-out';
        setTimeout(function(){
            alert_warning.style.display = 'none';
        },1100);
    });

    btn_yes.addEventListener('click',function(){
        form.submit();
    });

}//end if delete confirmation

    if(innerWidth <= 770){
        document.getElementsByClassName('navbar-brand')[0].classList.remove("left-brand");
        for(let i=0; i < document.getElementsByClassName('dash-plans').length; i++){
            document.getElementsByClassName('dash-plans')[i].style.height = '85px';
            document.getElementsByClassName('dash-plans')[i].style.marginTop = '10px';
        }
    }
window.addEventListener('resize', function(){
    if(innerWidth <= 770){
        document.getElementsByClassName('navbar-brand')[0].classList.remove("left-brand");
        for(let i=0; i < document.getElementsByClassName('dash-plans').length; i++){
            document.getElementsByClassName('dash-plans')[i].style.height = '85px';
            document.getElementsByClassName('dash-plans')[i].style.marginTop = '10px';
        }
    }else{
        document.getElementsByClassName('navbar-brand')[0].classList.add("left-brand");
        for(let i=0; i < document.getElementsByClassName('dash-plans').length; i++){
            document.getElementsByClassName('dash-plans')[i].style.height = '';
            document.getElementsByClassName('dash-plans')[i].style.marginTop = '';
        }
    }
});//brand position fix


var btns = document.getElementsByClassName('show-more-btn');
for(let i = 0; i<btns.length; i++){
    if(innerWidth >= 770){
        btns[i].style.height = document.getElementsByClassName('widget-infoblock')[0].offsetHeight + 'px' ;
        btns[i].childNodes[0].style.top = '43%' ;
    }
    window.addEventListener('resize', function(){
        if(innerWidth >= 770){
            btns[i].style.height = document.getElementsByClassName('widget-infoblock')[0].offsetHeight + 'px' ;
            btns[i].childNodes[0].style.top = '43%' ;
        }else{
            btns[i].style.height = '';
            btns[i].childNodes[0].style.top = '' ;
        }
    });
    //end of btn-show-more position fixing

    btns[i].addEventListener('mouseover',function(){
        btns[i].childNodes[0].childNodes[0].style.color = '#FFFFFF';
    });

    btns[i].addEventListener('mouseleave',function(){
        btns[i].childNodes[0].childNodes[0].style.color = '';
    });
    //end of btn hover
}
