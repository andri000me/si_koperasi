<div class="modal" id="confirmPopup">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pesan Konfirmasi</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <a href="" class="btn btn-success yes">Ya</a>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
      </div>
    </div>
  </div>
</div>

<script>
$(".open-confirm").click(function (e) {
  e.preventDefault()
  $("#confirmPopup").modal("show")
  $("#confirmPopup .modal-body").html($(this).data("msg"))
  $("#confirmPopup .yes").attr("href", $(this).attr("href"))
  $("#confirmPopup .yes").focus()
 })
</script>