function getdata(data) {
    return $("#"+data).val().trim();
  }
function success(string) {
    return Swal.fire({
        icon: "success",
        title: "Başarılı",
        text: string,
        confirmButtonText: "Tamam",
        confirmButtonColor: "green"
    });
}
function error(string) {
    return Swal.fire({
        icon: "error",
        title: "Başarısız",
        text: string,
        confirmButtonText: "Tamam",
        confirmButtonColor: "red"
    });
}
function warning(string) {
    return Swal.fire({
        icon: "warn",
        title: "Uyarı",
        text: string,
        confirmButtonText: "Tamam",
        confirmButtonColor: "orange"
    });
}
$("#personel_add_form").submit(function () {
    var array = [$("#isim").val().trim(), $("#soyisim").val().trim(), $("#callintech_mail").val().trim(), $("#callintech_sifre").val().trim(), $("#mail_sender_nick").val().trim(), $("#mail_sender_sifre").val().trim(), $("#slack_mail").val().trim(), $("#rol").val().trim()];
    var jsonarray = JSON.stringify(array);
    if (array[0] != "" && array[1] != "" && array[6] != "" && array[7] != "") {
        $.ajax({
            type: "POST",
            url: "control/get.php",
            data: {personelarray: jsonarray},
            dataType: "JSON",
            success: function (response) {
              if(response.personel_basarili){
                success(response.personel_basarili);
              }
            }
        });
    } else {
        error("Lütfen zorunlu olması gereken yerleri doldurunuz!");
    }
});
$("#user_add_form").submit(function (e) {
    var inputs = [$("#name").val().trim(), $("#surname").val().trim(), $("#nickname").val().trim(), $("#password").val().trim(), $("#rol").val().trim()];
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i] == "") {
            error("Lütfen Tüm Alanları Doldurunuz!");
            return false;
        }

    }
    var jsonarray = JSON.stringify(inputs);
    jQuery.ajax({
        type: "POST",
        url: "control/get.php",
        data: { datalar: jsonarray },
        dataType: "JSON",
        success: function (response) {
            if (response.basarili_geldi) {
                success(response.basarili_geldi);
                setTimeout(() => {
                    window.window.location.href = 'system-user.php';
                }, 1500);
                
            }
            if (response.this_user_already) {
                error(response.this_user_already);
            }
        },
    });


});
$("#loginform").submit(function (e) {
    var inputArrays = [$("#loginNick").val().trim(), $("#loginPassword").val().trim()];
    for (let i = 0; i < inputArrays.length; i++) {
        if (inputArrays[i] == "") {
            error("Lütfen Boş alanları doldurunuz!");
            return false;
        }
    }
    jQuery.ajax({
        type: "POST",
        url: "control/get.php",
        data: { nickname: inputArrays[0], password: inputArrays[1] },
        dataType: "JSON",
        success: function (response) {
            if (response.login_error_kullanici_yok) {
                error(response.login_error_kullanici_yok);
            }
            if (response.login_success) {
                success(response.login_success);
                window.window.location.href = 'index.php';
            }
            if (response.login_error_password) {
                error(response.login_error_password);
            }
        }
    });

});

$("#showpasswordbutton").click(function (e) {
    var ButtonID = document.getElementById("showpasswordbutton");
    var PasswordID = document.getElementById("loginPassword");
    if (PasswordID.type == "password") {
        PasswordID.type = "text";
        ButtonID.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>'
    }
    else {
        PasswordID.type = "password";
        ButtonID.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>'
    }
});
$("#exitbutton").click(function () {
    Swal.fire({
        title: "Çıkış yapmak üzeresiniz.",
        text: "Çıkış butonunu seçerseniz güvenli bir şekilde çıkış yapılacaktır.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "red",
        cancelButtonColor: "green",
        confirmButtonText: "Çıkış Yap",
        cancelButtonText: "Çıkış yapma"
    }).then((result) => {
        if (result.isConfirmed) {
            var sessionid = $(this).val();
            jQuery.ajax({
                type: "POST",
                url: "control/get.php",
                data: {sessionid},
                dataType: "JSON",
                success: function (response) {
                    if (response.sessionid) {
                        success(response.sessionid);
                        window.window.location.href = 'login.php';
                    }
                }
            });
        }
        else {
            console.log("Çıkış yapmaktan vazgeçildi.")
        }
    });

});
$("#category_add_form").submit(function (e) { 
    var kategori_isim = $("#kategori-isim").val().trim();
    if(kategori_isim == "" || kategori_isim == null ){
        error("Kategori oluşturmak için kategori ismini girmeniz gerekmekte!");
    }else{
        $.ajax({
            type: "POST",
            url: "control/get.php",
            data: {kategori_isim},
            dataType: "JSON",
            success: function (response) {
                if(response.kategori_basarili){
                    success(response.kategori_basarili);
                }
                if(response.category_already_added){
                    error(response.category_already_added);
                }
            }
        });
    }
});
$("#status_add_form").submit(function (e) { 
    var status_isim = getdata("durum-isim");
    if(status_isim == "" || status_isim == null ){
        error("Bir durum oluşturmak için durum ismini girmeniz gerekmektedir!");
    }else{
        $.ajax({
            type: "POST",
            url: "control/get.php",
            data: {status_isim},
            dataType: "JSON",
            success: function (response) {
                if(response.status_basarili){
                    success(response.status_basarili)
                }
                if(response.status_already_added){
                    error(response.status_already_added);
                }
            }
        });
    }
});
$('.delete-button').click(function (e) { 
    var categoryId = $(this).data('id');
    if(categoryId == "" || categoryId == null){
        console.error("Category IDsi boş!");
    }else{
        $.ajax({
            type: "POST",
            url: "control/get.php",
            data: {categoryId},
            dataType: "JSON",
            success: function (response) {
                if(response.kategori_silme_basarili){
                    success(response.kategori_silme_basarili);
                    setTimeout(() => {
                        location.reload();    
                    }, 3000);
                    
                }
                if(response.kategori_silme_basarisiz){
                    error(response.kategori_silme_basarisiz);
                }
            }
        });
    }
});
$("#rol_add_form").submit(function () {  
    var Roledata = $("#role-name").val();
    if(Roledata == "" || Roledata == null ){
        return error("İsim alanı boş bırakılamaz!");
    }
    else{
        Roledata = Roledata.trim();
        $.ajax({
            type: "POST",
            url: "./control/get.php",
            data: {Roledata},
            dataType: "JSON",
            success: function (response) {
             if(response.AddedRoleData){
                success(response.AddedRoleData);
                $("#role-name").val("");          
            }
             if(response.RoleError){
                error(response.RoleError);
             }
             if(response.alreadyRoleData){
                error(response.alreadyRoleData);
             }   
            }
        });
    }
});

$(".delete-button-rol").click(function(){
    var rol_id = $(this).attr("data-id");
    rol_id = parseInt(rol_id);
    if(rol_id == "" || rol_id == null || Number.isInteger == false){
        error("Gelen Veri Hatalı!");
    }else{
        $.ajax({
            type: "POST",
            url: "./control/get.php",
            data: {rol_id},
            dataType: "JSON",
            success: function (response) {
                    if(response.rol_success_deleted){
                        success(response.rol_success_deleted);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }if(response.rol_error_deleted){
                        error(response.rol_error_deleted);
                    }
                    if(response.no_role){
                        error(response.no_role);
                    }
            }
        });
    }
    
});

$(".delete-system-user").click(function(){
    var system_user_id = $(this).attr("data-id");
    system_user_id = parseInt(system_user_id);
    if(system_user_id == "" || system_user_id == null || Number.isInteger == false){
        error("Gelen Veri Hatalı!");
    }else{
        $.ajax({
            type: "POST",
            url: "./control/get.php",
            data: {system_user_id},
            dataType: "JSON",
            success: function (response) {
                    if(response.rol_success_deleted){
                        success(response.rol_success_deleted);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }if(response.rol_error_deleted){
                        error(response.rol_error_deleted);
                    }
                    if(response.no_role){
                        error(response.no_role);
                    }
            }
        });
    }
    
});
$("button[name='review']").click(function (e) {
    var reviewid = $(this).attr("data-id");
    if (!Number.isInteger(reviewid)) {
        reviewid = parseInt(reviewid);
        $.ajax({
            type: "POST",
            url: "./control/get.php",
            data: { reviewid },
            dataType: "JSON",
            success: function (response) {
                if (response.reviewbasarili) {
                    var personelOzellikleri = response.reviewbasarili[0];
                    Swal.fire({
                        title: 'Kullanıcı Bilgileri',
                        html: `
                        <p style="font-size:14pt"><b>Callintech Mail:</b> <span id="ClText">${personelOzellikleri.kullanici_callintech} </span><button name="copyButton" data-target="#ClText" class="btn btn-primary"><i class="fa-solid fa-clipboard"></i></button></p>
                        <p style="font-size:14pt"><b>Callintech Şifre:</b> <span id="ClPassword">${personelOzellikleri.kullanici_callintech_sifre}</span> <button name="copyButton" data-target="#ClPassword" title="Kopyala" class="btn btn-primary"><i class="fa-solid fa-clipboard"></i></button></p>
                        <p style="font-size:14pt"><b>Mail sender kullanıcı adı:</b> <span id="MailNick">${personelOzellikleri.kullanici_mailsender}</span> <button name="copyButton" data-target="#MailNick" title="Kopyala" class="btn btn-primary"><i class="fa-solid fa-clipboard"></i></button></p> 
                        <p style="font-size:14pt"><b>Mail sender şifre:</b> <span id="MailPassword">${personelOzellikleri.kullanici_mailsender_sifre}</span> <button name="copyButton" data-target="#MailPassword" title="Kopyala" class="btn btn-primary"><i class="fa-solid fa-clipboard"></i></button></p>
                        <p style="font-size:14pt"><b>Slack Mail:</b> <span id="SlackMail">${personelOzellikleri.kullanici_slack_mail}</span> <button name="copyButton" data-target="#SlackMail" title="Kopyala" class="btn btn-primary"><i class="fa-solid fa-clipboard"></i></button></p>
                        <p style="font-size:14pt"><b>Kullanıcı Rolü:</b> ${personelOzellikleri.kullanici_rol}</p>
                        <p style="font-size:14pt"><b>Eklenme Tarihi:</b> ${personelOzellikleri.kullanici_eklenme_tarihi}</p>
                    `,
                        showConfirmButton: true,
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        didOpen: () => {
                            $("button[name='copyButton']").click(function() {
                                var targetId = $(this).data("target");
                                var textToCopy = $(targetId).text();
                                
                                navigator.clipboard.writeText(textToCopy).then(() => {
                                    toastr.success("Metin başarılı bir şekilde kopyalandı! Kopyalanan Metin: "+"<b>"+textToCopy+"</b>" , "Başarılı!");
                                }).catch(err => {
                                    toastr.error("Hata!",err);
                                });
                            });
                        }
                    });
                }
            }
        });
    }
});

$("button[name='delete-personel'").click(function (e) { 
    var personel_id = parseInt($(this).attr("data-id"));
    if(personel_id == "" || personel_id == null){
        console.error("ID is empty or null");
    }else{
    if(!Number.isInteger(personel_id)){
        console.error("ID is not Integer"); 
    }else{
        $.ajax({
            type: "POST",
            url: "./control/get.php",
            data: {personel_id},
            dataType: "JSON",
            success: function (response) {
                if(response.personel_delete_success){
                    success(response.personel_delete_success);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
                if(response.personel_delete_error){
                    error(response.personel_delete_error);
                }
            }
        });
    }
}
});

$("#duyuru").submit(function (e) { 
    var duyuru_text = $("#duyuru-isim").val().trim();
    if(duyuru_text.length > 90){
        error("Duyuru uzunluğu 90 karakteri geçemez!");
    }else{
    $.ajax({
        type: "POST",
        url: "./control/get.php",
        data: {duyuru_text},
        dataType: "JSON",
        success: function (response) {
            if(response.duyuru_success){
                success(response.duyuru_success);
            }
            if(response.duyuru_error){
                success(response.duyuru_error);
            }
        }
    });
}
});
$("#object_add_form").submit(function (e) { 
    var Object_Properties_Array = [ 
        getdata("cihaz_seri_no"),
        getdata("cihaz_kategori"),
        getdata("cihaz_aciklama"),
        getdata("cihaz_durum"),
        getdata("cihaz_ekleyen_kisi"),
    ]
    for(var i = 0; i < Object_Properties_Array.length; i++){
        if(Object_Properties_Array[i] == "" || Object_Properties_Array[i] == null){
           return error("Zorunlu olan tüm alanları doldurunuz!");
        }
    }
    Object_Properties_Array = JSON.stringify(Object_Properties_Array);
    $.ajax({
        type: "POST",
        url: "./control/get.php",
        data: {Object_Properties_Array},
        dataType: "JSON",
        success: function (response) {
            if(response.object_basarili){
                success(response.object_basarili);
            }
        }
    });
});


  