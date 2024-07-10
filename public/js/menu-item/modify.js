"use strict";
var variation_type_count = 0;
var options_type_count = 0;
var menuItemObj = menuItemObj;
var categoryObj = categoryObj;
function variationItemTypeDesign(type,typeName) {
    variation_type_count++;
    var markup = '';
    markup +=' <div class="variationOptionsCss mb-3" id="variationType'+type+'">';
    markup +='<h5 class="mb-3">'+typeName+'</h5>';
    markup += '<div class="table-responsive variationTypeTable"><input type="hidden" id="variationIsItem'+type+'" value="0"><input type="hidden" id="variationTypeTable'+type+'" value="'+type+'"><table class="table table-striped variationTypeTable'+type+'" ><thead><tr>';
    markup += '<th>'+LabelName+'</th>';
    markup += '<th>'+LabelPrice+'</th>';
    markup += '<th>'+LabelProductInfo+'</th>';
    markup += '<th>'+LabelActions+'<button class="btn btn-danger btn-sm float-right" onclick="removeVariationTypeBtn(event,'+type+')"><i class="fa fa-times-circle"></i></button></th>';
    markup += '</tr></thead> <tbody>';
    markup += '<tr>';
        markup += '<td>';
            markup += '<input type="text" id="variationName'+type+'" placeholder="Name" name="name" class="form-control form-control-sm">';
        markup +='</td>';
        markup +='<td>';
            markup += '<input type="number" step="0.01" id="variationPrice'+type+'"  placeholder="Price" class="form-control form-control-sm" value="">';
        markup += '</td>';
        markup +='<td>';
            markup += '<textarea id="variationProductInfo'+type+'"  placeholder="Product info" class="form-control form-control-sm summernote-simple variation-height-textarea "></textarea>';
        markup += '</td>';
        markup +='<td>';
            markup += '<button class="btn btn-primary btn-sm" onclick="return variationAdd(event,'+type+')">';
                markup += ' <i class="fa fa-plus"></i>';
            markup += '</button>';
        markup += '</td>';
    markup += '</tr>';
    markup += '</tbody></table></div></div>';
    return markup;
}

function variationItemTypeProductDesign(type,typeName) {
    variation_type_count++;
    var markup = '';
    markup +=' <div class="variationOptionsCss mb-3" id="variationType'+type+'">';
    markup +='<div class="row mb-3"><div class="col-sm-6"><h5 class="">'+typeName+'</h5></div><div class="col-sm-6"> <div class="custom-control custom-checkbox checkbox-xl float-right">\n' +
        '<input type="checkbox"  class="custom-control-input" id="checkbox-'+type+'" checked>\n' +
        '<label class="custom-control-label">is Item</label>\n' +
        '</div></div></div>';
    markup += '<div class="table-responsive variationTypeTable"><input type="hidden" id="variationIsItem'+type+'" value="1"><input type="hidden" id="variationTypeTable'+type+'" value="'+type+'"><table class="table table-striped variationTypeProductTable'+type+'"><thead><tr>';
    markup += '<th class="col-5">'+LabelCategory+'</th>';
    markup += '<th class="col-5">'+LabelMenuItem+'</th>';
    markup += '<th>'+LabelActions+'<button class="btn btn-danger btn-sm float-right" onclick="removeVariationTypeBtn(event,'+type+')"><i class="fa fa-times-circle"></i></button></th>';
    markup += '</tr></thead> <tbody>';
    markup += '<tr>';
    markup += '<td class="col-5">';
    markup += '<select  class="form-control form-control-sm" id="variation_category_id'+type+'" onChange="categoryProduct('+type+')">';
    if(categoryObj){
        markup += '<option value="">Select Category</option>';
        categoryObj.forEach(function(obj) {
            markup += '<option value="' + obj.id + '">' + obj.name + '</option>';
        });
    }

    markup +=   '</select>';
    markup +='</td>';
    markup += '<td class="col-5">';
    markup += '<select  class="form-control form-control-sm" id="variation_menuItem_id'+type+'">';
    if(menuItemObj){
        markup += '<option value="">Select Menu item</option>';
        menuItemObj.forEach(function(obj) {
            markup += '<option  value="' + obj.id + '">' + obj.name + ' ( '+obj.unit_price +' )'+'</option>';
        });
    }

    markup +=   '</select>';
    markup +='</td>';

    markup +='<td>';
    markup += '<button class="btn btn-primary btn-sm" onclick="return variationMenuItemAdd(event,'+type+')">';
    markup += ' <i class="fa fa-plus"></i>';
    markup += '</button>';
    markup += '</td>';
    markup += '</tr>';
    markup += '</tbody></table></div></div>';
    return markup;
}


function variationItemDesign(name, price,productInfo,type) {
    menu_item_variation_count++;
    var markup = '';
    markup += '<tr class="mt-2" id="variation'+type+'">';
    markup += '<td>';
    markup += '<input type="text" name="variation['+type+']['+0+']['+menu_item_variation_count+'][name]" placeholder="Name" value="'+name+'" class="form-control form-control-sm">';
    markup +='</td>';
    markup +='<td>';
    markup += '<input type="number" name="variation['+type+']['+0+']['+menu_item_variation_count+'][price]" placeholder="Price" value="'+price+'"  class="form-control form-control-sm">';
    markup += '</td>';
    markup +='<td>';
    markup += '<textarea name="variation['+type+']['+0+']['+menu_item_variation_count+'][product_info]"  placeholder="Product info" class="form-control form-control-sm summernote-simple variation-height-textarea mt-2">'+productInfo+'</textarea>';
    markup += '</td>';
    markup +='<td>';
    markup += '<button class="btn btn-danger btn-sm removeBtn">'
    markup += '<i class="fa fa-trash"></i>';
    markup += '</button>';
    markup += '</td>';
    markup += '</tr>';
    return markup;
}

function variationMenuItemDesign(menuItemID, menuItemName) {
    menu_item_variation_count++;
    var markup = '';
    markup += '<tr class="mt-2">';
    markup += '<td colspan="2">';
    markup += '<input type="hidden" value="'+menuItemID+'"><input type="text" readonly name="variation['+menu_item_variation_count+'][name]" placeholder="Name" value="'+menuItemName+'" class="form-control form-control-sm">';
    markup +='</td>';

    markup +='<td>';
    markup += '<button class="btn btn-danger btn-sm removeBtn">';
    markup += '<i class="fa fa-trash"></i>';
    markup += '</button>';
    markup += '</td>';
    markup += '</tr>';
    return markup;
}


function variationAdd(e,type){
    e.preventDefault();
    const name =     $('#variationName'+type).val();
    const price =     $('#variationPrice'+type).val();
    const productInfo =     $('#variationProductInfo'+type).val();
    if(name){
        $('#variationName'+type).removeClass('is-invalid');
        $('#variationPrice'+type).removeClass('is-invalid');
        $('.variationTypeTable'+type+' tbody tr:last').after(variationItemDesign(name, price,productInfo,type));
        $('#variationName'+type).val('');
        $('#variationPrice'+type).val('');
        $('#variationProductInfo'+type).val('');
    }else{
        if(name){
            $('#variationName'+type).removeClass('is-invalid');

        }else{
            $('#variationName'+type).addClass('is-invalid');
        }
    }
}

function variationMenuItemAdd(e,type){
    e.preventDefault();
    var menuItemID      = $("select#variation_menuItem_id"+type+" option").filter(":selected").val();
    var menuItemName    = $("select#variation_menuItem_id"+type+" option").filter(":selected").text();
    if(menuItemID>0 && menuItemName) {
        $('#variation_menuItem_id').removeClass('is-invalid');
        $('.variationTypeProductTable'+type+' tbody tr:last').after(variationMenuItemDesign(menuItemID, menuItemName,type));

    }else {
        if(menuItemID>0){
            $('#variation_menuItem_id').removeClass('is-invalid');

        }else{
            $('#variation_menuItem_id').addClass('is-invalid');
        }
    }
}

$('#variation-type-add').on('click', function(event) {
    var type = $("select#variation_type_id option").filter(":selected").val();
    var typeName = $("select#variation_type_id option").filter(":selected").text();
    var variationTypeID = $("#variationTypeTable"+type).val();
    event.preventDefault();
    const checkBox = document.getElementById("checkbox-variant");

    if(variationTypeID === type){
        iziToast.warning({
            title: 'Warning',
            message: 'The Item type already added',
            position: 'topRight',
        });
    }else {
        if (checkBox.checked == true){
            $('#variationTypeBody').append(variationItemTypeProductDesign(type,typeName));

        }else {
            $('#variationTypeBody').append(variationItemTypeDesign(type,typeName));
        }
    }
});

$('#variation-add').on('click', function(event) {
    event.preventDefault();
    $('#variationTbody').append(variationItemDesign());
});



function categoryProduct(type){
    var categoryID      = $("select#variation_category_id"+type+" option").filter(":selected").val();
    $.ajax({
        type : 'POST',
        url : categoryProductUrl,
        data : {'category_id': categoryID,'menuItemID':menuItemID},
        dataType : "html",
        success : function (data) {
            $('#variation_menuItem_id'+type).html(data);
        }
    });
}

function categoryMenuItem(type){
    var categoryID      = $("select#options_category_id"+type+" option").filter(":selected").val();
    $.ajax({
        type : 'POST',
        url : categoryProductUrl,
        data : {'category_id': categoryID,'menuItemID':menuItemID},
        dataType : "html",
        success : function (data) {
            $('#options_menuItem_id'+type).html(data);
        }
    });
}


function optionsItemTypeDesign(type,typeName) {
    options_type_count++;
    var markup = '';
    markup +=' <div class="variationOptionsCss mb-3"  id="optionsType'+type+'">';
    markup +='<h5 class="mb-3">'+typeName+'</h5>';
    markup += '<div class="table-responsive optionsTypeTable"><input type="hidden" id="optionsIsItem'+type+'" value="0"><input type="hidden" id="optionsTypeTable'+type+'" value="'+type+'"><table class="table table-striped optionsTypeTable'+type+'" ><thead><tr>';
    markup += '<th>'+LabelName+'</th>';
    markup += '<th>'+LabelPrice+'</th>';
    markup += '<th>'+LabelProductInfo+'</th>';
    markup += '<th>'+LabelActions+'<button class="btn btn-danger btn-sm float-right" onclick="removeTypeBtn(event,'+type+')"><i class="fa fa-times-circle"></i></button></th>';
    markup += '</tr></thead> <tbody>';
    markup += '<tr>';
    markup += '<td>';
    markup += '<input type="text" id="optionsName'+type+'" placeholder="Name" name="name" class="form-control form-control-sm">';
    markup +='</td>';
    markup +='<td>';
    markup += '<input type="number" step="0.01" id="optionsPrice'+type+'"  placeholder="Price" class="form-control form-control-sm" value="">';
    markup += '</td>';
    markup +='<td>';
    markup += '<textarea id="optionsProductInfo'+type+'"  placeholder="Product info" class="form-control form-control-sm summernote-simple variation-height-textarea"></textarea>';
    markup += '</td>';
    markup +='<td>';
    markup += '<button class="btn btn-primary btn-sm" onclick="return optionsAdd(event,'+type+')">';
    markup += ' <i class="fa fa-plus"></i>';
    markup += '</button>';
    markup += '</td>';
    markup += '</tr>';
    markup += '</tbody></table></div></div>';
    return markup;
}

function optionsItemTypeProductDesign(type,typeName) {
    options_type_count++;
    var markup = '';
    markup +=' <div class="variationOptionsCss mb-3"  id="optionsType'+type+'">';
    markup +='<div class="row mb-3"><div class="col-sm-6"><h5 class="">'+typeName+'</h5></div><div class="col-sm-6"> <div class="custom-control custom-checkbox checkbox-xl float-right">\n' +
        '<input type="checkbox"  class="custom-control-input" id="checkbox-'+type+'" checked>\n' +
        '<label class="custom-control-label">is Item</label>\n' +
        '</div></div></div>';
    markup += '<div class="table-responsive optionsTypeTable"><input type="hidden" id="optionsIsItem'+type+'" value="1"><input type="hidden" id="optionsTypeTable'+type+'" value="'+type+'"><table class="table table-striped optionsTypeProductTable'+type+'"><thead><tr>';
    markup += '<th class="col-5">'+LabelCategory+'</th>';
    markup += '<th class="col-5">'+LabelMenuItem+'</th>';
    markup += '<th>'+LabelActions+'<button class="btn btn-danger btn-sm float-right" onclick="removeTypeBtn(event,'+type+')"><i class="fa fa-times-circle"></i></button></th>';
    markup += '</tr></thead> <tbody>';
    markup += '<tr>';
    markup += '<td class="col-5">';
    markup += '<select  class="form-control form-control-sm" id="options_category_id'+type+'" onChange="categoryMenuItem('+type+')">';
    if(categoryObj){
        markup += '<option value="">Select Category</option>';
        categoryObj.forEach(function(obj) {
            markup += '<option value="' + obj.id + '">' + obj.name + '</option>';
        });
    }

    markup +=   '</select>';
    markup +='</td>';
    markup += '<td class="col-5">';
    markup += '<select  class="form-control form-control-sm" id="options_menuItem_id'+type+'">';
    if(menuItemObj){
        markup += '<option value="">Select Menu item</option>';
        menuItemObj.forEach(function(obj) {
            markup += '<option  value="' + obj.id + '">' + obj.name + ' ( '+obj.unit_price +' )'+'</option>';
        });
    }

    markup +=   '</select>';
    markup +='</td>';

    markup +='<td>';
    markup += '<button class="btn btn-primary btn-sm" onclick="return optionsMenuItemAdd(event,'+type+')">';
    markup += ' <i class="fa fa-plus"></i>';
    markup += '</button>';
    markup += '</td>';
    markup += '</tr>';
    markup += '</tbody></table></div></div>';
    return markup;
}

function optionsItemDesign(name, price,productInfo) {
    menu_item_options_count++;
    var markup = '';
    markup += '<tr class="mt-2">';
    markup += '<td>';
    markup += '<input type="text" name="options['+menu_item_options_count+'][name]" placeholder="Name" value="'+name+'" class="form-control form-control-sm">';
    markup +='</td>';
    markup +='<td>';
    markup += '<input type="number" name="options['+menu_item_options_count+'][price]" placeholder="Price" value="'+price+'"  class="form-control form-control-sm">';
    markup += '</td>';
    markup +='<td>';
    markup += '<textarea name="options['+menu_item_options_count+'][product_info]"  placeholder="Product info" class="form-control form-control-sm summernote-simple variation-height-textarea mt-2">'+productInfo+'</textarea>';
    markup += '</td>';
    markup +='<td>';
    markup += '<button class="btn btn-danger btn-sm removeBtn">'
    markup += '<i class="fa fa-trash"></i>';
    markup += '</button>';
    markup += '</td>';
    markup += '</tr>';
    return markup;
}

function optionsMenuItemDesign(menuItemID, menuItemName) {
    menu_item_options_count++;
    var markup = '';
    markup += '<tr class="mt-2">';
    markup += '<td colspan="2">';
    markup += '<input type="hidden" value="'+menuItemID+'"><input type="text" readonly name="options['+menu_item_options_count+'][name]" placeholder="Name" value="'+menuItemName+'" class="form-control form-control-sm">';
    markup +='</td>';

    markup +='<td>';
    markup += '<button class="btn btn-danger btn-sm removeBtn">'
    markup += '<i class="fa fa-trash"></i>';
    markup += '</button>';
    markup += '</td>';
    markup += '</tr>';
    return markup;
}

function optionsAdd(e,type){
    e.preventDefault();
    const name =     $('#optionsName'+type).val();
    const price =     $('#optionsPrice'+type).val();
    const productInfo =     $('#optionsProductInfo'+type).val();
    if(name) {
        $('#optionsName'+type).removeClass('is-invalid');
        $('#optionsPrice'+type).removeClass('is-invalid');
        $('.optionsTypeTable'+type+' tbody tr:last').after(optionsItemDesign(name, price,productInfo));
        $('#optionsName'+type).val('');
        $('#optionsPrice'+type).val('');
        $('#optionsProductInfo'+type).val('');
    }else {
        if(name){
            $('#optionsName'+type).removeClass('is-invalid');

        }else{
            $('#optionsName'+type).addClass('is-invalid');
        }
    }
}

function optionsMenuItemAdd(e,type){
    e.preventDefault();
    var menuItemID      = $("select#options_menuItem_id"+type+" option").filter(":selected").val();
    var menuItemName    = $("select#options_menuItem_id"+type+" option").filter(":selected").text();
    if(menuItemID>0 && menuItemName) {
        $('#options_menuItem_id').removeClass('is-invalid');
        $('.optionsTypeProductTable'+type+' tbody tr:last').after(optionsMenuItemDesign(menuItemID, menuItemName));

    }else {
        if(menuItemID>0){
            $('#options_menuItem_id').removeClass('is-invalid');

        }else{
            $('#options_menuItem_id').addClass('is-invalid');
        }
    }
}

$('#options-type-add').on('click', function(event) {
    var type = $("select#options_type_id option").filter(":selected").val();

    var typeName = $("select#options_type_id option").filter(":selected").text();
    var optionsTypeID = $("#optionsTypeTable"+type).val();

    event.preventDefault();
    const checkBox = document.getElementById("checkbox-options");

    if(optionsTypeID === type){
        iziToast.warning({
            title: 'Warning',
            message: 'The Item type already added',
            position: 'topRight',
        });
    }else {
        if (checkBox.checked == true){
            $('#optionsTypeBody').append(optionsItemTypeProductDesign(type,typeName));

        }else {
            $('#optionsTypeBody').append(optionsItemTypeDesign(type,typeName));
        }
    }
});

$('#options-add').on('click', function(event) {
    event.preventDefault();
    $('#optionsTbody').append(optionsItemDesign());
});




$(document).on('click','.removeBtn', function(event) {
    event.preventDefault();
    $(this).parent().parent().remove()
});


function removeTypeBtn(event,type){
    event.preventDefault();
    $('#optionsType'+type).remove();
}
function removeVariationTypeBtn(event,type){
    event.preventDefault();
    $('#variationType'+type).remove();
}

$(document).on('click', '#addVariationOptions', function(e) {
    var variationTypes= [];
    var optionsTypes= [];
    var variationNameError = false;
    var optionsNameError = false;
    $('.variationTypeTable').each(function(){
        let isItem = $(this).children().eq(0).val();
        let typeID = $(this).children().eq(1).val();
     
        if(isItem == 0){
            if(!variationNameError){
                $('.variationTypeTable'+typeID+' tr').each(function(i)  {
                    if (i != 0 && i != 1) {
                        let name = $(this).children().eq(0).children().eq(0).val();
                        let price = $(this).children().eq(1).children().eq(0).val();
                        let productInfo = $(this).children().eq(2).children().eq(0).val();
                        if(name==''){
                            $('#variationError').text('Menu Item Variation Name field required!');
                            $('#variationError').addClass('is-invalid');
                            variationNameError = true;
                            e.preventDefault();
                        }
                        variationTypes.push({'menuItemID':menuItemID,'typeID':typeID,'type':0,'name': name, 'price': price, 'productInfo': productInfo,'variationMenuItemID':null});
                    }

                });
            }
        }else{
            $('.variationTypeProductTable'+typeID+' tr').each(function(i)  {
                if (i != 0 && i != 1) {
                    let variationMenuItemID = $(this).children().eq(0).children().eq(0).val();
                    variationTypes.push({'menuItemID':menuItemID,'typeID':typeID,'type':1,'name': null, 'price': null, 'productInfo': null,'variationMenuItemID':variationMenuItemID});
                }

            });
        }
    });

    $('.optionsTypeTable').each(function(){
        let isItem = $(this).children().eq(0).val();
        let typeID = $(this).children().eq(1).val();
        
        if(isItem == 0){
            if(!optionsNameError){
                $('.optionsTypeTable'+typeID+' tr').each(function(i)  {
                    if (i != 0 && i != 1) {
                        let name = $(this).children().eq(0).children().eq(0).val();
                        let price = $(this).children().eq(1).children().eq(0).val();
                        let productInfo = $(this).children().eq(2).children().eq(0).val();
                        if(name==''){
                            $('#optionError').text('Menu Item Options Name field required!');
                             $('#optionError').addClass('is-invalid');
                            optionsNameError = true;
                            e.preventDefault();
                        }
                        optionsTypes.push({'menuItemID':menuItemID,'typeID':typeID,'type':0,'name': name, 'price': price, 'productInfo': productInfo,'optionsMenuItemID':null});
                    }

                });
            }
        }else{
            $('.optionsTypeProductTable'+typeID+' tr').each(function(i)  {
                if (i != 0 && i != 1) {
                    let optionsMenuItemID = $(this).children().eq(0).children().eq(0).val();
                    optionsTypes.push({'menuItemID':menuItemID,'typeID':typeID,'type':1,'name': null, 'price': null, 'productInfo': null,'optionsMenuItemID':optionsMenuItemID});
                }

            });
        }
    });
if(optionsNameError==false && variationNameError==false){


    if(menuItemVariationCount == 0 && menuItemOptionsCount == 0){
        if (variationTypes.length <= 0 && optionsTypes.length <= 0 ) {
            iziToast.error({
                title: 'Error',
                message: 'The menu item variation/option required.',
                position: 'topRight'
            });

        }else {
            $.ajax({
                type: 'POST',
                url: variationOptionsAddUrl,
                data: {'variations':variationTypes,'options':optionsTypes,'type':'add'},
                success: function(data) {
                    if(data){
                        iziToast.success({
                            title: 'Success',
                            message: 'The data updated successfully!',
                            position: 'topRight'
                        });
                        window.location = menuItemsUrl;
                    }
                }
            });
        }
    }else {
        if (variationTypes.length <= 0 || optionsTypes.length <= 0 ) {
            $.ajax({
                type: 'POST',
                url: variationOptionsAddUrl,
                data: {'variations':variationTypes,'options':optionsTypes,'type':'delete'},
                success: function(data) {
                    if(data){
                        iziToast.success({
                            title: 'Success',
                            message: 'The data updated successfully!',
                            position: 'topRight'
                        });
                        window.location = menuItemsUrl;
                    }
                }
            });
        }else {
            $.ajax({
                type: 'POST',
                url: variationOptionsAddUrl,
                data: {'variations':variationTypes,'options':optionsTypes,'type':'update'},
                success: function(data) {
                    if(data){
                        iziToast.success({
                            title: 'Success',
                            message: 'The data updated successfully!',
                            position: 'topRight'
                        });
                        window.location = menuItemsUrl;
                    }
                }
            });
        }
    }
}


});

