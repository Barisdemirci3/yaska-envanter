function success($string) {  
    return Swal.fire({
        icon: "success",
        title: "Başarılı",
        text: $string,
        confirmButtonText: "Tamam",
        confirmButtonColor: "green"
      });
}
function error($string) {  
    return Swal.fire({
        icon: "error",
        title: "Başarısız",
        text: $string,
        confirmButtonText: "Tamam",
        confirmButtonColor: "red"
      });
}
function warning($string) {  
    return Swal.fire({
        icon: "warn",
        title: "Uyarı",
        text: $string,
        confirmButtonText: "Tamam",
        confirmButtonColor: "orange"
      });
}
$("#personel_add_form").submit(function () { 
 var array = [$("#isim").val().trim(),$("#soyisim").val().trim(),$("#callintech_mail").val().trim(),$("#callintech_sifre").val().trim(),$("#mail_sender_nick").val().trim(),$("#mail_sender_sifre").val().trim(),$("#slack_mail").val().trim(),$("#rol").val().trim()];

if(array[0] != "" && array[1] != "" && array[6] != "" && array[7] != ""){
    $.ajax({
        type: "POST",
        url: "get.php",
        data: {array},
        dataType: "JSON",
        success: function (response) {
            
        }
    });
    $.ajax({
        type: "method",
        url: "url",
        data: "data",
        dataType: "dataType",
        success: function (response) {
            
        }
    });
}else{
    error("Lütfen zorunlu olması gereken yerleri doldurunuz!");
}
            
            
});