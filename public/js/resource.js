$(document).ready(function () {


    $('#category').change(function () {
        var categoryId = $('#category').val();

        $.ajax({
            url:'resource/'+ categoryId,
            method:'POST',
            data:'categoryId=' + categoryId,
            success:function(data) {
                $('#course').empty();

                data = JSON.parse(data);
                $('#course').append('<option selected disabled>'+ "Kursu secin" +'</option>');
                data.forEach(function (datas) {
                    $('#course').append('<option id='+ datas.training_id + '  value='+ datas.training_id + '>'+ datas.training_name +'</option>')
                })
            }
        }).done(function (trainings) {

        })
    })

    $('#course').change(function () {
        var categoryId = $('#category').val();
        var courseId = $('#course').val();
        $.ajax({
            url:'resource/'+ categoryId + '/'+ courseId,
            method:'POST',
            data:'courseId=' + courseId,
            success:function(data) {

                console.log(data);
                $('#search-section').empty();
                data = JSON.parse(data);
                data.forEach(function (datas) {
                    $('#search-section').append('<p id='+datas.material_id + '  value='+datas.material_id+'><a href="#">'+datas.material_title+'</a></p>')
                    // /resource/'+datas.material_id+ '
                })
            },
            error:function () {
                console.log("error");
            }
        }).done(function (trainings) {
            console.log("done");
        })
    })





    $("a").tooltip(); // for tooltips

    // dependent select options
    $department = $("select[name='dep']");
    $cname = $("select[name='cname']");

    $department.change(function () {

        if ($(this).val() == "Elektron Hökumət") {
            $("select[name='cname'] option").remove();
            $("<option>Sahibkarlar və mühasiblər üçün e-hökumət</option>").appendTo($cname);
            $("<option>Elektron hökumətin əsasları</option>").appendTo($cname);
        }

        if ($(this).val() == "Kompüter bilikləri və ofis proqramları") {
            $("select[name='cname'] option").remove();
            $("<option>Ümumi kompüter hazırlığı</option>").appendTo($cname);
            $("<option>Microsoft Office proqramları</option>").appendTo($cname);
            $("<option>Peşəkar Microsoft Excel</option>").appendTo($cname);
            $("<option>1C proqramı</option>").appendTo($cname);
            $("<option>Microsoft Project</option>").appendTo($cname);
        }

        if ($(this).val() == "İT-nin əsasları") {
            $("select[name='cname'] option").remove();
            $("<option>İT texnikliyi</option>").appendTo($cname);
            $("<option>İT təhlükəsizliyinin əsasları</option>").appendTo($cname);
        }

        if ($(this).val() == "Şəbəkə və sistem inzibatçılığı") {
            $("select[name='cname'] option").remove();
            $("<option>Şəbəkə inzibatçılığının əsasları</option>").appendTo($cname);
            $("<option>Peşəkar şəbəkə inzibatçılığı</option>").appendTo($cname);
            $("<option>Sistem inzibatçılığının əsasları</option>").appendTo($cname);
        }

        if ($(this).val() == "Qrafik dizayn") {
            $("select[name='cname'] option").remove();
            $("<option>2D qrafika</option>").appendTo($cname);
            $("<option>3D qrafika</option>").appendTo($cname);
        }

        if ($(this).val() == "Proqramlaşdırma və kodlaşdırma") {
            $("select[name='cname'] option").remove();
            $("<option>Veb layihələrin hazırlanması</option>").appendTo($cname);
            $("<option>Java proqramlaşdırma</option>").appendTo($cname);
            $("<option>Python proqramlaşdırma</option>").appendTo($cname);
            $("<option>C++ proqramlaşdırma</option>").appendTo($cname);
            $("<option>Uşaqlar üçün Scratch proqramlaşdırma</option>").appendTo($cname);
        }

        if ($(this).val() == "Biznes və menecment") {
            $("select[name='cname'] option").remove();
            $("<option>Rəqəmli marketinq</option>").appendTo($cname);
            $("<option>Layihələrin idarəedilməsi</option>").appendTo($cname);
            $("<option>Peşəkar insan resursları</option>").appendTo($cname);
        }

        if ($(this).val() == "Fərdi inkişaf") {
            $("select[name='cname'] option").remove();
            $("<option>Danışıq ingilis dili</option>").appendTo($cname);
            $("<option>Ümumi ingilis dili</option>").appendTo($cname);
            $("<option>Rus dili</option>").appendTo($cname);
            $("<option>Yumşaq bacarıqlar</option>").appendTo($cname);
            $("<option>Dövlət qulluğuna hazırlıq</option>").appendTo($cname);
            $("<option>Magistratura hazırlığı</option>").appendTo($cname);
        }

        if ($(this).val() == "İstiqaməti seçin") {
            $("select[name='cname'] option").remove();
            $("<option>Kursu seçin</option>").appendTo($cname);
        }

    });

});