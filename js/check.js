function formatDate(dateString) {
    let date = new Date(dateString);
    let options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
    let formattedDate = date.toLocaleDateString('tr-TR', options);
    return formattedDate;
}

// Örnek kullanım
console.log(formatDate('2024-03-19T16:04:49')); // Örnek tarih dizesi

function getdata(data) {
    return $("#" + data).val().trim();
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
        icon: "warning",
        title: "Uyarı",
        text: string,
        confirmButtonText: "Tamam",
        confirmButtonColor: "orange"
    });
}
$("#personel_add_form").submit(function () {
    var array = [$("#isim").val().trim(), $("#soyisim").val().trim(), $("#callintech_mail").val().trim(), $("#callintech_sifre").val().trim(), $("#mail_sender_nick").val().trim(), $("#mail_sender_sifre").val().trim(), $("#slack_mail").val().trim(), $("#rol").val().trim()];
    var jsonarray = JSON.stringify(array);
    if (array[2] == "") {
        array[2] = null;
    }
    else if (array[2] == "") {
        array[2] = null;
    }
    else if (array[3] == "") {
        array[3] = null;
    }
    else if (array[4] == "") {
        array[4] = null;
    }
    else if (array[5] == "") {
        array[5] = null;
    }
    if (array[0] != "" && array[1] != "" && array[6] != "" && array[7] != "") {
        $.ajax({
            type: "POST",
            url: "control/get.php",
            data: { personelarray: jsonarray },
            dataType: "JSON",
            success: function (response) {
                if (response.personel_basarili) {
                    success(response.personel_basarili);
                }
                if (response.yetki_error) {
                    json_parse = JSON.parse(response.yetki_error);
                    Swal.fire({
                        title: "Yetki Hatası",
                        icon: "error",
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                    });
                }
            }
        });
    } else {
        error("Lütfen zorunlu olması gereken yerleri doldurunuz!");
    }
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
        data: { login_nickname: inputArrays[0], login_password: inputArrays[1] },
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
                data: { sessionid },
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
    if (kategori_isim == "" || kategori_isim == null) {
        error("Kategori oluşturmak için kategori ismini girmeniz gerekmekte!");
    } else {
        $.ajax({
            type: "POST",
            url: "./control/get.php",
            data: { kategori_isim },
            dataType: "JSON",
            success: function (response) {
                if (response.kategori_basarili) {
                    success(response.kategori_basarili);
                }
                if (response.category_already_added) {
                    error(response.category_already_added);
                }
                if (response.yetki_error) {
                    json_parse = JSON.parse(response.yetki_error);
                    Swal.fire({
                        title: "Yetki Hatası",
                        icon: "error",
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                    });
                }
            }
        });
    }
});
$("#status_add_form").submit(function (e) {
    var status_isim = getdata("durum-isim");
    if (status_isim == "" || status_isim == null) {
        error("Bir durum oluşturmak için durum ismini girmeniz gerekmektedir!");
    } else {
        $.ajax({
            type: "POST",
            url: "control/get.php",
            data: { status_isim },
            dataType: "JSON",
            success: function (response) {
                if (response.status_basarili) {
                    success(response.status_basarili)
                }
                if (response.status_already_added) {
                    error(response.status_already_added);
                }
                if (response.yetki_error) {
                    json_parse = JSON.parse(response.yetki_error);
                    Swal.fire({
                        title: "Yetki Hatası",
                        icon: "error",
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                    });
                }
            }
        });
    }
});
$('.delete-button').click(function (e) {
    var categoryId = $(this).data('id');
    if (categoryId == "" || categoryId == null) {
        console.error("Category IDsi boş!");
    } else {
        $.ajax({
            type: "POST",
            url: "control/get.php",
            data: { categoryId },
            dataType: "JSON",
            success: function (response) {
                if (response.kategori_silme_basarili) {
                    success(response.kategori_silme_basarili);
                    setTimeout(() => {
                        location.reload();
                    }, 3000);

                }
                if (response.kategori_silme_basarisiz) {
                    error(response.kategori_silme_basarisiz);
                }
                if (response.yetki_error) {
                    json_parse = JSON.parse(response.yetki_error);
                    Swal.fire({
                        title: "Yetki Hatası",
                        icon: "error",
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                    });
                }
            }
        });
    }
});
$("#rol_add_form").submit(function () {
    var Roledata = $("#role-name").val();
    if (Roledata == "" || Roledata == null) {
        return error("İsim alanı boş bırakılamaz!");
    }
    else {
        Roledata = Roledata.trim();
        $.ajax({
            type: "POST",
            url: "./control/get.php",
            data: { Roledata },
            dataType: "JSON",
            success: function (response) {
                if (response.AddedRoleData) {
                    success(response.AddedRoleData);
                    $("#role-name").val("");
                }
                if (response.RoleError) {
                    error(response.RoleError);
                }
                if (response.alreadyRoleData) {
                    error(response.alreadyRoleData);
                }
                if (response.yetki_error) {
                    json_parse = JSON.parse(response.yetki_error);
                    Swal.fire({
                        title: "Yetki Hatası",
                        icon: "error",
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                    });
                }
            }
        });
    }
});

$(".delete-button-rol").click(function () {
    var rol_id = $(this).attr("data-id");
    rol_id = parseInt(rol_id);
    if (rol_id == "" || rol_id == null || Number.isInteger == false) {
        error("Gelen Veri Hatalı!");
    } else {
        $.ajax({
            type: "POST",
            url: "./control/get.php",
            data: { rol_id },
            dataType: "JSON",
            success: function (response) {
                if (response.rol_success_deleted) {
                    success(response.rol_success_deleted);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } if (response.rol_error_deleted) {
                    error(response.rol_error_deleted);
                }
                if (response.no_role) {
                    error(response.no_role);
                }
                if (response.yetki_error) {
                    json_parse = JSON.parse(response.yetki_error);
                    Swal.fire({
                        title: "Yetki Hatası",
                        icon: "error",
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                    });
                }
            }
        });
    }

});

$(".delete-system-user").click(function () {
    var system_user_id = $(this).attr("data-id");
    system_user_id = parseInt(system_user_id);
    if (system_user_id == "" || system_user_id == null || Number.isInteger == false) {
        error("Gelen Veri Hatalı!");
    } else {
        $.ajax({
            type: "POST",
            url: "./control/get.php",
            data:  {system_user_id },
            dataType: "JSON",
            success: function (response) {
                if (response.feedback_success) {
                    success(response.feedback_success);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
                if (response.feedback_error) {
                    error(response.feedback_error);
                }
                if (response.yetki_error) {
                  var yetki_error_datas = JSON.parse(response.yetki_error);
                    Swal.fire({
                        title: "Yetki Hatası",
                        icon: "error",
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        html: `<b> Yetkiniz: <span style= "color: ${yetki_error_datas.color}"> ${yetki_error_datas.status} </span> olduğundan dolayı ${yetki_error_datas.aciklama}</b>`,
                    });
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
                    var personelOzellikleri = response.reviewbasarili;
                    Swal.fire({
                        title: 'Kullanıcı Bilgileri',
                        html: `
                        <p style="font-size:14pt"><b>Callintech Mail:</b> <span id="ClText">${personelOzellikleri.kullanici_callintech} </span><button name="copyButton" data-target="#ClText" class="btn btn-primary"><i class="fa-solid fa-clipboard"></i></button></p>
                        <p style="font-size:14pt"><b>Callintech Şifre:</b> <span id="ClPassword">${personelOzellikleri.kullanici_callintech_sifre}</span> <button name="copyButton" data-target="#ClPassword" title="Kopyala" class="btn btn-primary"><i class="fa-solid fa-clipboard"></i></button></p>
                        <p style="font-size:14pt"><b>Mail sender kullanıcı adı:</b> <span id="MailNick">${personelOzellikleri.kullanici_mailsender}</span> <button name="copyButton" data-target="#MailNick" title="Kopyala" class="btn btn-primary"><i class="fa-solid fa-clipboard"></i></button></p> 
                        <p style="font-size:14pt"><b>Mail sender şifre:</b> <span id="MailPassword">${personelOzellikleri.kullanici_mailsender_sifre}</span> <button name="copyButton" data-target="#MailPassword" title="Kopyala" class="btn btn-primary"><i class="fa-solid fa-clipboard"></i></button></p>
                        <p style="font-size:14pt"><b>Slack Mail:</b> <span id="SlackMail">${personelOzellikleri.kullanici_slack_mail}</span> <button name="copyButton" data-target="#SlackMail" title="Kopyala" class="btn btn-primary"><i class="fa-solid fa-clipboard"></i></button></p>
                        <p style="font-size:14pt"><b>Kullanıcı Rolü:</b> ${personelOzellikleri.kullanici_rol}</p>
                        <p style="font-size:14pt"><b>Eklenme Tarihi:</b> ${formatDate(personelOzellikleri.kullanici_eklenme_tarihi)}</p>
                    `,
                        showConfirmButton: true,
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        didOpen: () => {
                            $("button[name='copyButton']").click(function () {
                                var targetId = $(this).data("target");
                                var textToCopy = $(targetId).text();
                                navigator.clipboard.writeText(textToCopy).then(() => {
                                    toastr.success("Metin başarılı bir şekilde kopyalandı! Kopyalanan Metin: " + "<b>" + textToCopy + "</b>", "Başarılı!");
                                }).catch(err => {
                                    toastr.error("Hata!", err);
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
    if (personel_id == "" || personel_id == null) {
        console.error("ID is empty or null");
    } else {
        if (!Number.isInteger(personel_id)) {
            console.error("ID is not Integer");
        } else {
            $.ajax({
                type: "POST",
                url: "./control/get.php",
                data: { personel_id },
                dataType: "JSON",
                success: function (response) {
                    if (response.personel_delete_success) {
                        success(response.personel_delete_success);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                    if (response.personel_delete_error) {
                        error(response.personel_delete_error);
                    }
                    if (response.yetki_error) {
                        json_parse = JSON.parse(response.yetki_error);
                        Swal.fire({
                            title: "Yetki Hatası",
                            icon: "error",
                            confirmButtonText: "Tamam",
                            confirmButtonColor: "green",
                            html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                        });
                    }
                }
            });
        }
    }
});

$("#duyuru").submit(function (e) {
    var duyuru_text = $("#duyuru-isim").val().trim();
    if (duyuru_text.length > 90) {
        error("Duyuru uzunluğu 90 karakteri geçemez!");
    } else {
        $.ajax({
            type: "POST",
            url: "./control/get.php",
            data: { duyuru_text },
            dataType: "JSON",
            success: function (response) {
                if (response.duyuru_success) {
                    success(response.duyuru_success);
                }
                if (response.duyuru_error) {
                    success(response.duyuru_error);
                }
                if (response.yetki_error) {
                    json_parse = JSON.parse(response.yetki_error);
                    Swal.fire({
                        title: "Yetki Hatası",
                        icon: "error",
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                    });
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
        getdata("cihaz_zimmet_kisi"),
    ]
    for (var i = 0; i < Object_Properties_Array.length; i++) {
        if (Object_Properties_Array[i] == "" || Object_Properties_Array[i] == null) {
            return error("Zorunlu olan tüm alanları doldurunuz!");
        }
    }
    Object_Properties_Array = JSON.stringify(Object_Properties_Array);
    $.ajax({
        type: "POST",
        url: "./control/get.php",
        data: { Object_Properties_Array },
        dataType: "JSON",
        success: function (response) {
            if (response.object_success_added) {
                success(response.object_success_added);
            }
            if (response.object_error) {
                error(response.object_error);
            }
            if (response.object_id_empty) {
                error(response.object_id_empty);
            }
            if (response.yetki_error) {
                json_parse = JSON.parse(response.yetki_error);
                Swal.fire({
                    title: "Yetki Hatası",
                    icon: "error",
                    confirmButtonText: "Tamam",
                    confirmButtonColor: "green",
                    html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                });
            }
        }
    });
});
$("button[name='sil-status']").click(function (button_value) {
    button_value = $(this).attr("data-id");
    button_value = Number.parseInt(button_value);
    if (button_value == "" || button_value == null || !Number.isInteger(button_value)) {
        console.error("Gelen data hatalı!");
    } else {
        $.ajax({
            type: "POST",
            url: "./control/get.php",
            data: { button_value },
            dataType: "JSON",
            success: function (response) {
                if (response.durum_silme_basarili) {
                    success(response.durum_silme_basarili);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
                if (response.button_value_empty) {
                    error(response.button_value_empty);
                }
                if (response.durum_silme_basarisiz) {
                    error(response.durum_silme_basarisiz);
                }
                if (response.yetki_error) {
                    json_parse = JSON.parse(response.yetki_error);
                    Swal.fire({
                        title: "Yetki Hatası",
                        icon: "error",
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                    });
                }
            }
        });
    }
});
$("button[name='review-object']").click(function (button_value_object) {
    button_value_object = $(this).attr("data-id");
    button_value_object = Number.parseInt(button_value_object);
    if (button_value_object == "" || button_value_object == null || !Number.isInteger(button_value_object)) {
        console.error("Gelen data hatalı!");
    } else {
        $.ajax({
            type: "POST",
            url: "./control/get.php",
            data: { button_value_object },
            dataType: "JSON",
            success: function (response) {
                if (response.object_review_success) {
                    var object_properties = response.object_review_success;
                    for (let index = 0; index < object_properties.length; index++) {
                        if (object_properties[index] == null || object_properties[index] == "" || object_properties[index] == undefined || object_properties[index] == "undefined") {
                            object_properties[index] = "Bilinmiyor!";
                        }
                    }
                    Swal.fire({
                        title: 'Cihaz Bilgileri',
                        html: `
                        <p style="font-size:14pt; color: green;"><b>Cihaz Kategori:</b> ${object_properties.esya_kategori_name}</p>
                        <p style="font-size:14pt"><b>Cihaz Açıklama:</b> ${object_properties.esya_aciklama}</p>
                        <p style="font-size:14pt;color: red;"><b>Cihaz Durum:</b> ${object_properties.esya_durum_name}</p>
                        <p style="font-size:14pt; color:blue;"><b>Cihaz Ekleyen Kişi:</b> ${object_properties.esya_ekleyen_name}</p>
                        <p style="font-size:14pt; color:black;"><b>Cihazın zimmetlendiği kişi:</b> ${object_properties.esya_ait_personel_isim_soyisim}</p>
                        <p style="font-size:14pt"><b>Cihaz Eklenme Tarihi:</b> ${formatDate(object_properties.esya_eklenme_tarih)}</p>
                    `,
                        showConfirmButton: true,
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green"
                    });
                }
                if (response.object_review_error) {
                    error(response.object_review_error);
                }
                if (response.button_object_value_empty) {
                    error(response.button_object_value_empty);
                }
            }
        });
    }
});

$("button[name='delete-object']").click(function (button_delete_id) {
    button_delete_id = $(this).attr("data-id");
    button_delete_id = Number.parseInt(button_delete_id);
    if (button_delete_id == "" || button_delete_id == null) {
        console.error("Gelen data hatalı!");
    } else {
        $.ajax({
            type: "POST",
            url: "./control/get.php",
            data: { button_delete_id },
            dataType: "JSON",
            success: function (response) {
                if (response.object_delete_success) {
                    success(response.object_delete_success);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
                if (response.object_delete_error) {
                    error(response.object_delete_error);
                }
                if (response.yetki_error) {
                    json_parse = JSON.parse(response.yetki_error);
                    Swal.fire({
                        title: "Yetki Hatası",
                        icon: "error",
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                    });
                }
            }
        });
    }
});

$("#user_add_form").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this); // 'this' form elementini işaret eder
    formData.append('name', $("#name").val().trim());
    formData.append('surname', $("#surname").val().trim());
    formData.append('nickname', $("#nickname").val().trim());
    formData.append('password', $("#password").val().trim());
    formData.append('rol', $("#rol").val().trim());
    // Eğer dosya inputunuzun id'si file ise
    var fileInput = $('#file')[0].files[0]; // 'file' id'li inputtan dosyayı alın
    formData.append('file', fileInput); // Dosyayı FormData'ya ekleyin

    // Tüm alanları doldurulup doldurulmadığını kontrol et
    var emptyInputs = Array.from(formData.values()).some(val => val === "");
    if (emptyInputs) {
        error("Lütfen Tüm Alanları Doldurunuz!");
        return false;
    }
    jQuery.ajax({
        type: "POST",
        url: "control/get.php",
        data: formData,
        dataType: "JSON",
        contentType: false, // İçerik tipinin otomatik olarak ayarlanmasını engelleyin
        processData: false, // FormData nesnesini düz metne dönüştürmeyi engelleyin
        success: function (response) {
            if (response.basarili_geldi) {
                success(response.basarili_geldi);
                setTimeout(() => {
                    window.location.href = 'system-user.php';
                }, 2000);

            }
            if (response.this_user_already) {
                error(response.this_user_already);
            }
            if (response.image_error) {
                error(response.image_error);
            }
            if (response.yetki_error) {
                json_parse = JSON.parse(response.yetki_error);
                Swal.fire({
                    title: "Yetki Hatası",
                    icon: "error",
                    confirmButtonText: "Tamam",
                    confirmButtonColor: "green",
                    html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                });
            }
        },
    });
});
$("button[name='category_edit']").click(async function () {
    var category_edit_id = $(this).data("id");
    const { value: text_category } = await Swal.fire({
        icon: "warning",
        title: "Yeni Kategori ismini giriniz",
        input: "text",
        showCancelButton: true,
        cancelButtonText: "İptal",
        confirmButtonText: "Kaydet",
        inputValidator: (value) => {
            if (!value) {
                return "Kategori ismini değiştirmek için boş alanı doldurun!";
            }
        }
    });
    if (text_category) {
        $.ajax({
            type: "POST",
            url: "control/get.php",
            data: { text_category, category_edit_id },
            dataType: "JSON",
            success: function (response) {
                if (response.category_update_success) {
                    success(response.category_update_success);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
                if (response.category_update_error) {
                    error(response.category_update_error);
                }
                if (response.yetki_error) {
                    json_parse = JSON.parse(response.yetki_error);
                    Swal.fire({
                        title: "Yetki Hatası",
                        icon: "error",
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                    });
                }
            }
        });
    }
});
$("button[name='status_edit']").click(async function () {
    var status_edit_id = $(this).data("id");
    const { value: text_status } = await Swal.fire({
        icon: "warning",
        title: "Yeni Durum ismini giriniz",
        input: "text",
        showCancelButton: true,
        cancelButtonText: "İptal",
        confirmButtonText: "Kaydet",
        inputValidator: (value) => {
            if (!value) {
                return "Durum ismini değiştirmek için boş alanı doldurun!";
            }
        },

    })
    if (text_status) {
        $.ajax({
            type: "POST",
            url: "control/get.php",
            data: { text_status, status_edit_id },
            dataType: "JSON",
            success: function (response) {
                if (response.status_update_success) {
                    success(response.status_update_success);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
                if (response.status_update_error) {
                    error(response.status_update_error);
                }
                if (response.yetki_error) {
                    json_parse = JSON.parse(response.yetki_error);
                    Swal.fire({
                        title: "Yetki Hatası",
                        icon: "error",
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                    });
                }
            }
        });
    }
});
$("button[name='rol_edit']").click(async function () {
    var rol_edit_id = $(this).data("id");
    const { value: text_rol } = await Swal.fire({
        icon: "warning",
        title: "Yeni Rol ismini giriniz",
        input: "text",
        showCancelButton: true,
        cancelButtonText: "İptal",
        confirmButtonText: "Kaydet",
        inputValidator: (value) => {
            if (!value) {
                return "Rol ismini değiştirmek için boş alanı doldurun!";
            }
        },
    })
    if (text_rol) {
        $.ajax({
            type: "POST",
            url: "control/get.php",
            data: { text_rol, rol_edit_id },
            dataType: "JSON",
            success: function (response) {
                if (response.rol_update_success) {
                    success(response.rol_update_success);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
                if (response.rol_update_error) {
                    error(response.rol_update_error);
                }
                if (response.yetki_error) {
                    json_parse = JSON.parse(response.yetki_error);
                    Swal.fire({
                        title: "Yetki Hatası",
                        icon: "error",
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                    });
                }
            }
        });
    }
});

$("#user_update_password").submit(() => {
    var user_id = $("input[name='user_id']").val().trim();
    var user_password = getdata("user_password");
    if (user_id == "" || user_password == "") {
        error("Lütfen şifre alanını doldurunuz!");
    } else {
        $.ajax({
            type: "POST",
            url: "control/get.php",
            data: { user_id, user_password },
            dataType: "JSON",
            success: function (response) {
                if (response.user_password_success) {
                    success(response.user_password_success);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
                if (response.user_password_error) {
                    error(response.user_password_error);
                }
                if (response.yetki_error) {
                    json_parse = JSON.parse(response.yetki_error);
                    Swal.fire({
                        title: "Yetki Hatası",
                        icon: "error",
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                    });
                }
            }
        });
    }
});
$("#user_update_form").submit(function (e) {
    e.preventDefault();
    var formDataUpdate = new FormData(this); // 'this' form elementini işaret eder
    formDataUpdate.append('name', $("#name").val().trim());
    formDataUpdate.append('surname', $("#surname").val().trim());
    formDataUpdate.append('nickname', $("#nickname").val().trim());
    formDataUpdate.append('rol', $("#rol").val().trim());
    formDataUpdate.append('user_id', $("#user_id").val().trim());
    var fileInput = $('#file')[0].files[0];
    formDataUpdate.append('file', fileInput);

    // Tüm alanları doldurulup doldurulmadığını kontrol et
    var emptyInputs = Array.from(formDataUpdate.values()).some(val => val === "");
    if (emptyInputs) {
        error("Lütfen Tüm Alanları Doldurunuz!");
        return false;
    }
    jQuery.ajax({
        type: "POST",
        url: "control/get.php",
        data: formDataUpdate,
        dataType: "JSON",
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.user_update_success) {
                success(response.user_update_success);
                setTimeout(() => {
                    window.location.href = 'system-user.php?';
                }, 2000);
            }
            if (response.user_update_error) {
                error(response.user_update_error);
            }
            if (response.image_error) {
                error(response.image_error);
            }
            if (response.updated_self) {
                warning(response.updated_self);
                setTimeout(() => {
                    window.location.href = location.href;
                }, 5000);

            }
            if (response.yetki_error) {
                json_parse = JSON.parse(response.yetki_error);
                Swal.fire({
                    title: "Yetki Hatası",
                    icon: "error",
                    confirmButtonText: "Tamam",
                    confirmButtonColor: "green",
                    html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                });
            }
        },
    });
});
$("#object_update_form").submit(function (e) {
    e.preventDefault();
    var FormDataForObjects = new FormData(this);
    FormDataForObjects.append('cihaz_id', $("#cihaz_id").val());
    FormDataForObjects.append('cihaz_seri_no', $("#cihaz_seri_no").val().trim());
    FormDataForObjects.append('cihaz_kategori', $("#cihaz_kategori").val().trim());
    FormDataForObjects.append('cihaz_aciklama', $("#cihaz_aciklama").val().trim());
    FormDataForObjects.append('cihaz_durum', $("#cihaz_durum").val().trim());
    FormDataForObjects.append('cihaz_zimmet_kisi', $("#cihaz_zimmet_kisi").val().trim());
    var emptyInputs = Array.from(FormDataForObjects.values()).some(val => val === "");
    if (emptyInputs) {
        error("Lütfen tüm alanları doldurunuz!");
    }
    else {
        $.ajax({
            type: "POST",
            url: "control/get.php",
            data: FormDataForObjects,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.object_update_success) {
                    success(response.object_update_success);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
                if (response.object_update_error) {
                    error(response.object_update_error);
                }
                if (response.yetki_error) {
                    json_parse = JSON.parse(response.yetki_error);
                    Swal.fire({
                        title: "Yetki Hatası",
                        icon: "error",
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "green",
                        html: `<b> Yetkiniz: <span style= "color: ${json_parse.color}"> ${json_parse.status} </span> olduğundan dolayı ${json_parse.aciklama}</b>`
                    });
                }
            }
        });
    }

});
$("#personel_edit_form").submit(function () {
    var formdata = $(this).serializeArray();
    formdata.forEach(key => {
        var keyName = key.name;
        if ($("input[name='" + keyName + "']").attr("required")) {
            if (key.value == "" || key.value == null) {
                return false;
            }
        }
    });
    $.ajax({
        type: "POST",
        url: "control/get.php",
        data: formdata,
        dataType: "JSON",
        success: function (response) {
            if(response.user_update_success){
                success(response.user_update_success);
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
            if(response.user_update_error){
                error(response.user_update_error);
            }
        }
    });
});
window.addEventListener('offline', () => {
    error("İnternet bağlantınız koptu! Lütfen internet bağlantınızı kontrol edin!");
});