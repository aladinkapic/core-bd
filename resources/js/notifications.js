

/**************************************** KREIRAJMO NOTIFIKACIJU ******************************************************/

// function create_not(i, h, b, l, b_w, color = null){     // treba kreirati animaciju !!
//     var wrapper = document.getElementById("notification_w");
//     var notific = document.getElementsByClassName("notification")[0];
//     var icon    = document.getElementById("notification_icon");
//     var header  = document.getElementById("notification_h");
//     var body    = document.getElementById("notification_b");
//     var link    = document.getElementById("notification_link");
//     var button  = document.getElementById("notification_button");
//     var but_w   = document.getElementsByClassName("not_button")[0];
//
//     if(color){
//         header.style.color      = color;
//         icon.style.color        = color;
//         but_w.style.background = color;
//     }
//
//
//     wrapper.style.left    = '0px';
//     icon.className        = i;
//     header.innerHTML      = h;
//     body.innerHTML        = b;
//     link.href             = l;
//     button.innerHTML      = b_w;
//
//     notific.className = "notification notification2";
//
// }


function delete_not(){
    var wrapper = document.getElementById("notification_w");
    var notific = document.getElementsByClassName("notification")[0];

    wrapper.style.left  = -window.innerWidth + 'px';
    notific.className   = "notification";
}