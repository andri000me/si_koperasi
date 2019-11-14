$(document).ready(function(){
  $('.select2_').select2({
      theme: 'bootstrap4',
  });
});

$(".ym").change(function(){
  var thisVal = $(this).val()
  var target = $(this).data("target")
  var thisUrl = $(this).data("url")

  $.ajax({
    type : "post",
    data : {"date" : thisVal},
    url : thisUrl,
    success: function(data){
      $(target).each(function(x,y){
        if($(y).prop("tagName")=="INPUT"){
          $(this).val(data.nomor)
        }
        else{
          $(this).html(data.nomor)
        }
      })
      $("#ym").html(data.ym)
      console.log(data)
    }
  })
})

function getKode(param){
  var dataVal = param.data("val")
  var url = param.data("url")
  var dataPost = {};
  
  $(dataVal).each(function(i,val){
     var field = val.substr(1);
    var getVal = $(val).val()
    dataPost[field] = getVal
  })

  $.ajax({
    url : url,
    type : "post",
    data : dataPost,
    success : function(data){
      for(var key in data){
        if($(key).prop("tagName")=="INPUT"){
          $(key).val(data[key])
        }
        else{
          $(key).html(data[key])
        }
      }
      console.log(data)
    }
  })
 }

 $(".getKode").change(function(){
  getKode($(this))
 })
 $(".getKodeKeyUp").keyup(function(){
  getKode($(this))
 })

//  $(".open-confirm").click(function (e) {
//   e.preventDefault()
//   $("#confirmPopup").modal("show")
//   $("#confirmPopup .modal-body").html($(this).data("msg"))
//   $("#confirmPopup .yes").attr("href", $(this).attr("href"))
//   $("#confirmPopup .yes").focus()
//  })